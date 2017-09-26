<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;

class CourseController extends Controller
{
    public function postCourse(Request $request){

    	$course = new Course();

    	$course->name          = $request->input('name');
    	$course->instructor_id = $request->input('instructor_id');
    	$course->address       = $request->input('address');
    	$course->city          = $request->input('city');
    	$course->state         = $request->input('state');
    	$course->zip           = $request->input('zip');
    	$course->amount        = $request->input('amount');
    	$course->availability  = $request->input('availability');

    	$course->save();

    	return response()->json(['course' => $course], 201);
    }
    public function getCourses(){

    	$courses = Course::all();

    	$response = [
    		'courses' => $courses
    	];

    	return response()->json($response, 200);
    }
    public function getCourse($id){

    	$course = Course::find($id);

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
}