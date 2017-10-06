<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Meeting;

class MeetingController extends Controller
{
    public function postMeeting(Request $request){

    	$meeting = new Meeting();

    	$meeting->name = $request->input('name');

    	$meeting->save();

    	return response()->json(['meeting' => $meeting], 201);
    }
    public function getMeetings(){

    	$meetings = Meeting::with('semester')
            ->with('semester.course')
            ->with('semester.course.instructor:id,name,email')
            ->get();

    	$response = [
    		'meetings' => $meetings
    	];

    	return response()->json($response, 200);
    }
    public function getMeeting($id){

    	$meeting = Meeting::with('semester')
            ->with('semester.course')
            ->with('semester.course.instructor:id,name,email')
            ->find($id);

    	if(!$meeting){

    		return response()->json(['message' => 'Meeting not found'], 404);
    	}

    	return response()->json($meeting, 200);
    }
    public function putMeeting(Request $request, $id){

    	$meeting = Meeting::find($id);

    	if(!$meeting){

    		return response()->json(['message' => 'Meeting not found'], 404);
    	}

    	$meeting->name = $request->input('name');

    	$meeting->save();

    	return response()->json(['meeting' => $meeting], 200);
    }
    public function deleteMeeting($id){

    	$meeting = Meeting::find($id);

    	$meeting->delete();

    	return response()->json(['message' => 'Meeting deleted'], 200);
    }
}