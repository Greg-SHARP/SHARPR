<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function postUser(Request $request){

    	$user = new User();
    	
    	$user->user_id = $request->input('user_id');
    	$user->details = $request->input('details');

    	$user->save();

    	return response()->json(['user' => $user], 201);
    }
    public function getUsers(){

    	$users = User::all();

    	$response = [
    		'users' => $users
    	];

    	return response()->json($response, 200);
    }
    public function getUser($id){

    	$user = User::find($id);

    	if(!$user){

    		return response()->json(['message' => 'User not found'], 404);
    	}

    	return response()->json($user, 200);
    }
    public function putUser(Request $request, $id){

    	$user = User::find($id);

    	if(!$user){

    		return response()->json(['message' => 'User not found'], 404);
    	}
    	
    	$user->user_id = $request->input('user_id');
    	$user->details = $request->input('details');

    	$user->save();

    	return response()->json(['user' => $user], 200);
    }
    public function deleteUser($id){

    	$user = User::find($id);

    	$user->delete();

    	return response()->json(['message' => 'User deleted'], 200);
    }
}
