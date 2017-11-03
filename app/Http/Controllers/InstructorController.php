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
            ->with('user:id,name,email,dob,status,verified,referred_by')
            ->get();

        $instructors->map(function($i){

            $i->id          = $i->user->id;
            $i->name        = $i->user->name;
            $i->email       = $i->user->email;
            $i->dob         = $i->user->dob;
            $i->status      = $i->user->status;
            $i->verified    = $i->user->verified;
            $i->referred_by = $i->user->referred_by;

            unset($i->user);
            unset($i->user_id);

            return $i;
        });

    	$response = [
    		'instructors' => $instructors
    	];

    	return response()->json($response, 200);
    }
    public function getInstructor($id){

        $instructor = Instructor::whereHas('user', function ($query) use ($id){

            $query->where('id', $id);
        })
        ->with('user:id,name,email,dob,status,verified,referred_by')
        ->with('addresses')
        ->first();

        if(!$instructor){

            return response()->json(['message' => 'Instructor not found'], 404);
        }

        $instructor->id          = $instructor->user->id;
        $instructor->name        = $instructor->user->name;
        $instructor->email       = $instructor->user->email;
        $instructor->dob         = $instructor->user->dob;
        $instructor->status      = $instructor->user->status;
        $instructor->verified    = $instructor->user->verified;
        $instructor->referred_by = $instructor->user->referred_by;

        unset($instructor->user);
        unset($instructor->user_id);

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
