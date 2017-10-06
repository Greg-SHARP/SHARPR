<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Semester;

class SemesterController extends Controller
{
    public function postSemester(Request $request){

    	$semester = new Semester();

    	$semester->name          = $request->input('name');
    	$semester->instructor_id = $request->input('instructor_id');
    	$semester->address       = $request->input('address');
    	$semester->city          = $request->input('city');
    	$semester->state         = $request->input('state');
    	$semester->zip           = $request->input('zip');
    	$semester->amount        = $request->input('amount');
    	$semester->availability  = $request->input('availability');

    	$semester->save();

    	return response()->json(['semester' => $semester], 201);
    }
    public function getSemesters(){

    	$semesters = Semester::with('course', 'course.instructor:id,name,email')->get();

    	$response = [
    		'semesters' => $semesters
    	];

    	return response()->json($response, 200);
    }
    public function getSemester($id){

    	$semester = Semester::with('course', 'course.instructor:id,name,email')->find($id);

    	if(!$semester){

    		return response()->json(['message' => 'Semester not found'], 404);
    	}

    	return response()->json($semester, 200);
    }
    public function putSemester(Request $request, $id){

    	$semester = Semester::find($id);

    	if(!$semester){

    		return response()->json(['message' => 'Semester not found'], 404);
    	}
    	
    	$semester->name          = $request->input('name');
    	$semester->instructor_id = $request->input('instructor_id');
    	$semester->address       = $request->input('address');
    	$semester->city          = $request->input('city');
    	$semester->state         = $request->input('state');
    	$semester->zip           = $request->input('zip');
    	$semester->amount        = $request->input('amount');
    	$semester->availability  = $request->input('availability');

    	$semester->save();

    	return response()->json(['course' => $semester], 200);
    }
    public function deleteSemester($id){

    	$semester = Semester::find($id);

    	$semester->delete();

    	return response()->json(['message' => 'Semester deleted'], 200);
    }
}
