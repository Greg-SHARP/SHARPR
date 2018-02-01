<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Instructor;
use App\Address;
use JWTAuth;

class InstructorController extends Controller
{
    public function getInstructors(){

    	$instructors = Instructor::with('addresses')
            ->with('user:id,name,email,dob,profile_img,status,verified,referred_by')
            ->with('ratings')
            ->get();

        $instructors->map(function($i){

            $i->id          = $i->user->id;
            $i->name        = $i->user->name;
            $i->email       = $i->user->email;
            $i->dob         = $i->user->dob;
            $i->profile_img = $i->user->profile_img;
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
        ->with('user:id,name,email,dob,status,profile_img,verified,referred_by')
        ->with('ratings')
        ->with('addresses')
        ->first();

        if(!$instructor){

            return response()->json(['message' => 'Instructor not found'], 404);
        }

        $instructor->id          = $instructor->user->id;
        $instructor->name        = $instructor->user->name;
        $instructor->email       = $instructor->user->email;
        $instructor->dob         = $instructor->user->dob;
        $instructor->profile_img = $instructor->user->profile_img;
        $instructor->status      = $instructor->user->status;
        $instructor->verified    = $instructor->user->verified;
        $instructor->referred_by = $instructor->user->referred_by;

        unset($instructor->user);
        unset($instructor->user_id);

    	return response()->json($instructor, 200);
    }

    public function putInstructor(Request $request){

        //get user
        $user = JWTAuth::parseToken()->authenticate();

        //save name
        if($request->input('name')) {

            //validate data
            $this->validate($request, [
                'name' => 'required'
            ]);

            $user->name = $request->input('name');
            $user->profile_img = $request->input('profile_img');

            $user->save();
        }

        //save phone
        if($request->input('phone')) {

            $user->instructor->phone = $request->input('phone');

            $user->instructor->save();
        }

        //save details
        if($request->input('details')) {

            //decode details
            $user->instructor->details = collect(json_decode($user->instructor->details));

            //merge
            $user->instructor->details = $user->instructor->details->merge($request->input('details'));

            //encode
            $user->instructor->details = json_encode($user->instructor->details);

            //save instructor
            $user->instructor->save();
        }

        return response()->json(['message' => 'Instructor Saved!'], 200);
    }
}
