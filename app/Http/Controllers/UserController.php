<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

class UserController extends Controller
{
    
    public function signup(Request $request){

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);

        $user->save();

        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

    public function getUsers(){

    	$users = User::all();

    	$response = [
    		'users' => $users
    	];

    	return response()->json($response, 200);
    }

    public function getUser(Request $request, $id){

    	$user = User::find($id);

        //get likes
        if($request->input('likes') == true){

            $user->likes();

            $likes = $user->likes->mapToGroups(function($item, $key){

                return [$item['likeable_type'] => $item['likeable_id']];
            });

            unset($user->likes);

            $user->likes = $likes;
        }

        //get dislikes
        if($request->input('dislikes') == true){

            $user->dislikes();

            $dislikes = $user->dislikes->mapToGroups(function($item, $key){

                return [$item['dislikeable_type'] => $item['dislikeable_id']];
            });

            unset($user->dislikes);

            $user->dislikes = $dislikes;
        }

    	if(!$user){

    		return response()->json(['message' => 'User not found'], 404);
    	}

    	return response()->json($user, 200);
    }
    
    public function checkEmail(Request $request){

        $this->validate($request, [
            'email' => 'required|email|unique:users'
        ]);

        return response()->json([
            'message' => 'Email valid!'
        ], 201);
    }
}
