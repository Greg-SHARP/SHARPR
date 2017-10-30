<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Dislike;
use App\Like;
use JWTAuth;

class CourseController extends Controller
{
    public function postCourse(Request $request){

    	$course = new Course();

    	$course->name          = $request->input('name');
    	$course->instructor_id = $request->input('instructor_id');
    	$course->amount        = $request->input('amount');
    	$course->availability  = $request->input('availability');

    	$course->save();

    	return response()->json(['course' => $course], 201);
    }
    public function getCourses(){

        $courses = Course::whereHas('semesters', function ($query){

            $query->where('availability', 'open');
        })
        ->with('group')
        ->with('instructor:id,name,email')
        ->with('semesters:id,course_id,amount,availability,primary_img')
        ->with('semesters.addresses')
        ->with('categories', 'tags')
        ->get();

    	$response = [
    		'courses' => $courses
    	];

    	return response()->json($response, 200);
    }
    public function getCourse($id){

        $course = Course::whereHas('semesters', function ($query){

            $query->where('availability', 'open');
        })
        ->with('group')
        ->with('instructor:id,name,email')
        ->with('categories', 'tags', 'semesters', 'semesters.addresses', 'ratings')
        ->with('semesters.meetings')
        ->find($id);


    	if(!$course){

    		return response()->json(['message' => 'Course not found'], 404);
    	}

    	return response()->json($course, 200);
    }
    public function putCourse(Request $request, $id){

    	$course = Course::find($id);

    	if(!$course){

    		return response()->json(['message' => 'Course not found'], 404);
    	}
    	
    	$course->name          = $request->input('name');
    	$course->instructor_id = $request->input('instructor_id');
    	$course->address       = $request->input('address');
    	$course->city          = $request->input('city');
    	$course->state         = $request->input('state');
    	$course->zip           = $request->input('zip');
    	$course->amount        = $request->input('amount');
    	$course->availability  = $request->input('availability');

    	$course->save();

    	return response()->json(['course' => $course], 200);
    }
    public function deleteCourse($id){

    	$course = Course::find($id);

    	$course->delete();

    	return response()->json(['message' => 'Course deleted'], 200);
    }

    public function likeCourse($id){

        //get user
        $user = JWTAuth::parseToken()->authenticate();

        //get course
        $course = Course::with('categories', 'tags')->find($id);

        //if course found
        if($course){

            //create new like
            $like = Like::updateOrCreate([
                'user_id' => $user->id,
                'likeable_id' => $course->id,
                'likeable_type' => 'courses']);

            //save like for each category
            foreach ($course->categories as $category){
                $like = Like::updateOrCreate([
                    'user_id' => $user->id,
                    'likeable_id' => $category->id,
                    'likeable_type' => 'categories']);
            }

            //save like for each tag
            foreach ($course->tags as $tag){
                $like = Like::updateOrCreate([
                    'user_id' => $user->id,
                    'likeable_id' => $tag->id,
                    'likeable_type' => 'tags']);
            }

            return response()->json(['message' => 'Likes saved!'], 201);
        }
        else{
            return response()->json(['message' => 'Error: Course Not Found!'], 404);
        }
    }

    public function dislikeCourse($id){

        //get user
        $user = JWTAuth::parseToken()->authenticate();

        //get course
        $course = Course::with('categories', 'tags')->find($id);

        //if course found
        if($course){

            //create new dislike
            $like = Dislike::updateOrCreate([
                'user_id' => $user->id,
                'dislikeable_id' => $course->id,
                'dislikeable_type' => 'courses']);

            //save dislike for each category
            foreach ($course->categories as $category){
                $like = Dislike::updateOrCreate([
                    'user_id' => $user->id,
                    'dislikeable_id' => $category->id,
                    'dislikeable_type' => 'categories']);
            }

            //save dislike for each tag
            foreach ($course->tags as $tag){
                $like = Dislike::updateOrCreate([
                    'user_id' => $user->id,
                    'dislikeable_id' => $tag->id,
                    'dislikeable_type' => 'tags']);
            }

            return response()->json(['message' => 'Dislikes saved!'], 201);
        }
        else{
            return response()->json(['message' => 'Error: Course Not Found!'], 404);
        }
    }
}