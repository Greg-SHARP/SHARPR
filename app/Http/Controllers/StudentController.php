<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;

class StudentController extends Controller
{
    public function postStudent(Request $request){

    	$student = new Student();
    	
    	$student->user_id = $request->input('user_id');
    	$student->details = $request->input('details');

    	$student->save();

    	return response()->json(['student' => $student], 201);
    }
    public function getStudents(){

    	$students = Student::with('addresses')
            ->with('user:id,email,dob,status,verified,referred_by')
            ->with('courses')
            ->get();

        $students->map(function($i){

            $i->email       = $i->user->email;
            $i->dob         = $i->user->dob;
            $i->status      = $i->user->status;
            $i->verified    = $i->user->verified;
            $i->referred_by = $i->user->referred_by;

            unset($i->user);

            return $i;
        });

    	$response = [
    		'students' => $students
    	];

    	return response()->json($response, 200);
    }
    public function getStudent($id){

    	$student = Student::with('addresses')
            ->with('user:id,email,dob,status,verified,referred_by')
            ->with('courses')
            ->find($id);

        if(!$student){

            return response()->json(['message' => 'Student not found'], 404);
        }

        $student->email       = $student->user->email;
        $student->dob         = $student->user->dob;
        $student->status      = $student->user->status;
        $student->verified    = $student->user->verified;
        $student->referred_by = $student->user->referred_by;

        unset($student->user);

        return response()->json($student, 200);
    }
    public function putStudent(Request $request, $id){

    	$student = Student::find($id);

    	if(!$student){

    		return response()->json(['message' => 'Student not found'], 404);
    	}
    	
    	$student->user_id = $request->input('user_id');
    	$student->details = $request->input('details');

    	$student->save();

    	return response()->json(['student' => $student], 200);
    }
    public function deleteStudent($id){

    	$student = Student::find($id);

    	$student->delete();

    	return response()->json(['message' => 'Student deleted'], 200);
    }
}
