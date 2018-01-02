<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Course;
use App\Instructor;
use App\Institution;
use App\Student;
use App\Role;
use App\Rules\Roles;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

class UserController extends Controller
{
    
    public function signup(Request $request){

        //validate data
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'role' => ['required', new Roles]
        ]);

        //create data to insert
        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);

        //save user
        $user->save();

        //get role
        $role = Role::select('id', 'label')
                    ->where('label', $request->input('role'))
                    ->first();


        //save role
        $user->roles()->save($role);

        //save user type
        if($role->label == 'student'){
            $student = new Student;
            $student->user_id = $user->id;
            $student->save();
        }
        else if($role->label == 'instructor'){
            $instructor = new Instructor;
            $instructor->user_id = $user->id;
            $instructor->save();
        }
        else if($role->label == 'institution'){
            $institution = new Institution;
            $institution->user_id = $user->id;
            $institution->save();
        }

        //return success message
        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

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

        //if token exists
        if($user = JWTAuth::parseToken()->authenticate()){

            //get student
            $student = Student::find($user->id);

            //find course
            $course = Course::find($request->input('course_id'));

            //if course is found, save it to student
            if($course){

                //save course
                $student->courses()->save($course);
            }
        }

        //send emails
        Mail::send('emails.booking', $data, function ($message) {

            $message->from('booking@shrpr.co', 'Shrpr Bookings');
            $message->to('carlthenimrod@gmail.com');
            $message->subject('Shrpr: Course Booked!');
        });

        return response()->json([
            'message' => 'Course Booked!'
        ], 201);
    }
}
