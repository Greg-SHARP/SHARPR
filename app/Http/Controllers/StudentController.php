<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Student;
use App\Address;
use JWTAuth;

class StudentController extends Controller
{
    public function getStudents(){

    	$students = Student::with('addresses')
            ->with('user:id,name,email,dob,profile_img,status,verified,referred_by')
            ->with('courses')
            ->get();

        $students->map(function($i){

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
    		'students' => $students
    	];

    	return response()->json($response, 200);
    }

    public function getStudent($id){

    	$student = Student::whereHas('user', function ($query) use ($id){

            $query->where('id', $id);
        })
        ->with('user:id,name,email,dob,profile_img,status,verified,referred_by')
        ->with('addresses')
        ->with('courses')
        ->first();

        if(!$student){

            return response()->json(['message' => 'Student not found'], 404);
        }

        $student->id           = $student->user->id;
        $student->name         = $student->user->name;
        $student->email        = $student->user->email;
        $student->dob          = $student->user->dob;
        $student->profile_img  = $student->user->profile_img;
        $student->status       = $student->user->status;
        $student->verified     = $student->user->verified;
        $student->referred_by  = $student->user->referred_by;

        unset($student->user);
        unset($student->user_id);

        return response()->json($student, 200);
    }

    public function putStudent(Request $request){

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

            $user->student->phone = $request->input('phone');

            $user->student->save();
        }

        //save details
        if($request->input('details')) {

            //decode details
            $user->student->details = collect(json_decode($user->student->details));

            //merge
            $user->student->details = $user->student->details->merge($request->input('details'));

            //encode
            $user->student->details = json_encode($user->student->details);

            //save student
            $user->student->save();
        }

        return response()->json(['message' => 'Student Saved!'], 200);
    }
}
