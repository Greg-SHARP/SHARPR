<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Institution;

class InstitutionController extends Controller
{
    public function postInstitution(Request $request){

    	$institution = new Institution();

    	$institution->name = $request->input('name');

    	$institution->save();

    	return response()->json(['institution' => $institution], 201);
    }
    public function getInstitutions(){

    	$institutions = Institution::with('addresses')
            ->with('user:id,name,email,profile_img,status,verified')
            ->with('addresses')
            ->with('courses')
            ->with('courses.group')
            ->with('courses.categories')
            ->with('courses.tags')
            ->with('courses.instructor')
            ->with('courses.semesters:id,course_id,amount,availability,primary_img')
            ->get();

        $institutions->map(function($i){

            $i->id          = $i->user->id;
            $i->name        = $i->user->name;
            $i->email       = $i->user->email;
            $i->profile_img = $i->user->profile_img;
            $i->status      = $i->user->status;
            $i->verified    = $i->user->verified;

            unset($i->user);
            unset($i->user_id);

            return $i;
        });

    	$response = [
    		'institutions' => $institutions
    	];

    	return response()->json($response, 200);
    }
    public function getInstitution($id){

    	$institution = Institution::whereHas('user', function ($query) use ($id){

	        	$query->where('id', $id);
		})
		->with('user:id,name,email,profile_img,status,verified')
		->with('addresses')
        ->with('courses')
        ->with('courses.group')
        ->with('courses.categories')
        ->with('courses.tags')
        ->with('courses.instructor')
        ->with('courses.semesters:id,course_id,amount,availability,primary_img')
		->first();

        if(!$institution){

            return response()->json(['message' => 'Institution not found'], 404);
        }

        $institution->id           = $institution->user->id;
        $institution->name         = $institution->user->name;
        $institution->email        = $institution->user->email;
        $institution->profile_img  = $institution->user->profile_img;
        $institution->status       = $institution->user->status;
        $institution->verified     = $institution->user->verified;

        unset($institution->user);
        unset($institution->user_id);

    	$response = [
    		'institution' => $institution
    	];

    	return response()->json($institution, 200);
    }
    public function putInstitution(Request $request, $id){

    	$institution = Institution::find($id);

    	if(!$institution){

    		return response()->json(['message' => 'Institution not found'], 404);
    	}

    	$institution->name = $request->input('name');

    	$institution->save();

    	return response()->json(['institution' => $institution], 200);
    }
    public function deleteInstitution($id){

    	$institution = Institution::find($id);

    	$institution->delete();

    	return response()->json(['message' => 'Institution deleted'], 200);
    }
}