<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Instructor;

class InstructorController extends Controller
{
    public function postInstructor(Request $request){

    	$instructor = new Instructor();
    	
    	$instructor->user_id = $request->input('user_id');
    	$instructor->details = $request->input('details');

    	$instructor->save();

    	return response()->json(['instructor' => $instructor], 201);
    }
    public function getInstructors(){

    	$instructors = Instructor::with('addresses')
            ->with('user:id,email,dob,status,verified,referred_by')
            ->get();

    	$response = [
    		'instructors' => $instructors
    	];

    	return response()->json($response, 200);
    }
    public function getInstructor($id){

    	$instructor = Instructor::with('addresses')
            ->with('user:id,email,dob,status,verified,referred_by')
            ->find($id);

    	if(!$instructor){

    		return response()->json(['message' => 'Instructor not found'], 404);
    	}

    	return response()->json($instructor, 200);
    }
    public function putInstructor(Request $request, $id){

    	$instructor = Instructor::find($id);

    	if(!$instructor){

    		return response()->json(['message' => 'Instructor not found'], 404);
    	}
    	
    	$instructor->user_id = $request->input('user_id');
    	$instructor->details = $request->input('details');

    	$instructor->save();

    	return response()->json(['instructor' => $instructor], 200);
    }
    public function deleteInstructor($id){

    	$instructor = Instructor::find($id);

    	$instructor->delete();

    	return response()->json(['message' => 'Instructor deleted'], 200);
    }
}
