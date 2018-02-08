<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rating;
use JWTAuth;

class RatingController extends Controller
{
    public function getRatings(Request $request, $type, $id){

    	$ratings = Rating::where('rateable_type', $type)
						 ->where('rateable_id', $id)
						 ->with('user:id,name,email,profile_img')
						 ->get();

    	return response()->json($ratings, 200);
    }

    public function getRating(Request $request, $type, $id){

        //get user
        $user = JWTAuth::parseToken()->authenticate();

    	$rating = Rating::where('rateable_type', $type)
						 ->where('rateable_id', $id)
						 ->where('user_id', $user->id)
						 ->first();

    	return response()->json($rating, 200);
    }

    public function postRating(Request $request, $type, $id){

        //validate data
        $this->validate($request, [
            'title' => 'required',
            'rating' => 'required',
            'comment' => 'required|min:40'
        ]);

        //get user
        $user = JWTAuth::parseToken()->authenticate();

        //create rating
        $rating = new Rating();

        //set data
        $rating->title         = $request->input('title');
        $rating->rating        = $request->input('rating');
        $rating->comment       = $request->input('comment');
        $rating->user_id       = $user->id;
        $rating->rateable_id   = $id;
        $rating->rateable_type = $type;

        //save rating
        $rating->save();

    	return response()->json($rating, 200);
    }

    public function putRating(Request $request, $type, $id){

        //validate data
        $this->validate($request, [
            'title' => 'required',
            'rating' => 'required',
            'comment' => 'required|min:40'
        ]);

        //get user
        $user = JWTAuth::parseToken()->authenticate();

        //get rating
        $rating = Rating::find($request->input('id'));

        //set data
        $rating->title         = $request->input('title');
        $rating->rating        = $request->input('rating');
        $rating->comment       = $request->input('comment');

        //save rating
        $rating->save();

    	return response()->json($rating, 200);
    }
}