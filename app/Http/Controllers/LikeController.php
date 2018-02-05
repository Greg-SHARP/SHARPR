<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Like;
use App\Course;
use JWTAuth;

class LikeController extends Controller
{
    function getCourses()
    {
        //get user
        $user = $this->guard()->user();

        $ids = Like::where('user_id', $user->id)
				->where('likeable_type', 'courses')
				->pluck('likeable_id');

		$courses = Course::whereIn('id', $ids)
						->with('group')
						->with('instructor:id,name,email')
						->with('institution.user')
						->with('categories', 'tags')
						->with('semesters.addresses')
						->inRandomOrder()
						->get();

        return response()->json($courses);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
}