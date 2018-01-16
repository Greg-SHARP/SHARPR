<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use App\User;
use App\Course;
use App\Instructor;
use App\Institution;
use App\Student;
use Tymon\JWTAuth\Exceptions\JWTException;
use Mail;
use JWTAuth;

class UserController extends Controller
{
    public function getUsers(){

    	$users = User::all();

    	$response = [
    		'users' => $users
    	];

    	return response()->json($response, 200);
    }

    public function getUser(Request $request, $id){

    	$user = User::find($id);

        //get likes
        if($request->input('likes') == true){

            $user->likes();

            $likes = $user->likes->mapToGroups(function($item, $key){

                return [$item['likeable_type'] => $item['likeable_id']];
            });

            unset($user->likes);

            $user->likes = $likes;
        }

        //get dislikes
        if($request->input('dislikes') == true){

            $user->dislikes();

            $dislikes = $user->dislikes->mapToGroups(function($item, $key){

                return [$item['dislikeable_type'] => $item['dislikeable_id']];
            });

            unset($user->dislikes);

            $user->dislikes = $dislikes;
        }

    	if(!$user){

    		return response()->json(['message' => 'User not found'], 404);
    	}

    	return response()->json($user, 200);
    }
    
    public function checkEmail(Request $request){

        if(User::where('email', '=', $request->input('email'))->exists()) {

            return response()->json([
                'message' => 'Email taken!'
            ], 409);
        }
        else{

            return response()->json([
                'message' => 'Email valid!'
            ], 201);
        }
    }

    public function book(Request $request){

        //if course is found, find it
        if($request->input('course_id')){

            //get course
            $course = Course::find($request->input('course_id'));

            //create data
            $data = [
                'course' => $course,
                'contactselect' => $request->input('contactselect'),
                'drivinguber' => $request->input('drivinguber'),
                'drivingrating' => $request->input('drivingrating')
            ];

            //check to see if we are including a token
            if(JWTAuth::getToken()){

                //get user
                if($user = JWTAuth::parseToken()->authenticate()){

                    //get student
                    $student = Student::find($user->id);

                    //save course
                    $student->courses()->save($course);

                    //add more data
                    $data['name'] = $user->name;
                    $data['email'] = $user->email;
                    $data['phone'] = $student->phone;
                }
            }
            else{

                //add more data
                $data['name'] = $request->input('name');
                $data['email'] = $request->input('email');
                $data['phone'] = $request->input('phone');
            }

            if(!App::environment('local')) {

                //send emails
                Mail::send('emails.booking', $data, function ($message) {

                    $message->from('booking@shrpr.co', 'Shrpr Bookings');
                    $message->to('bd@shrpr.co')->cc('mike@shrpr.co');
                    $message->subject('Shrpr: Course Booked!');
                });
            }

            return response()->json([
                'message' => 'Course Booked!'
            ], 201);
        }
        else{

            return response()->json([
                'error' => 'Course not found!'
            ], 404);
        }
    }
}