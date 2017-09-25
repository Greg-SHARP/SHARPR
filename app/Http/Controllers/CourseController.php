<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;

class CourseController extends Controller
{
    public function postCourse(Request $request){

    	$course = new Course();
    	$course->name = $request->input('name');
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
    public function putCourse(Request $request, $id){

    	$course = Course::find($id);

    	if(!$course){

    		return response()->json(['message' => 'Course not found'], 404);
    	}

    	$course->name = $request->input('name');
    	$course->save();

    	return response()->json(['course' => $course], 200);
    }
    public function deleteCourse($id){

    	$course = Course::find($id);
    	$course->delete();

    	return response()->json(['message' => 'Course deleted'], 200);
    }
}