<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use App\Course;
use App\User;
use App\Dislike;
use App\Like;
use JWTAuth;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.refresh')->only('refresh');
    }
    
    public function postCourse(Request $request){

    	$course = new Course();

    	$course->name          = $request->input('name');
    	$course->instructor_id = $request->input('instructor_id');
    	$course->amount        = $request->input('amount');
    	$course->availability  = $request->input('availability');

    	$course->save();

    	return response()->json(['course' => $course], 201);
    }
    public function getCourses(Request $request){

        //check if semesters was provided
        if($request->input('semesters')){

            $semesters = $request->input('semesters');

            $courses = Course::whereHas('semesters', function ($query) use ($semesters){

                $query->whereIn('id', $semesters);
                $query->where('availability', 'open');
            })
            ->with(['semesters' => function($query) use ($semesters){

                $query->select('id','course_id','amount','availability','primary_img');
                $query->whereIn('id', $semesters);
                $query->with('addresses');
            }]);
        }
        else{

            //return only currently open courses
            $courses = Course::whereHas('semesters', function ($query){

               $query->where('availability', 'open');
            })
            ->with('semesters:id,course_id,amount,availability,primary_img')
            ->with('semesters.addresses');
        }

        //check if group was provided
        if($request->input('group')){

            //store group
            $group = (int) $request->input('group');

            $courses = $courses->whereHas('group', function($query) use ($group){
                $query->where('id', $group);
            });
        }

        //check if token is provided
        if(JWTAuth::getToken()){

            //get user
            $user = JWTAuth::parseToken()->authenticate();

            //get likes
            $likes = $user->likes->mapToGroups(function($item, $key){

                return [$item['likeable_type'] => $item['likeable_id']];
            });

            //set to array
            $likes = $likes->toArray();

            //get dislikes
            $dislikes = $user->dislikes->mapToGroups(function($item, $key){

                return [$item['dislikeable_type'] => $item['dislikeable_id']];
            });

            //set to array
            $dislikes = $dislikes->toArray();

            //exclude liked courses
            if(!empty($likes['courses'])){

                $courses = $courses->whereNotIn('id', $likes['courses']);
            }

            //exclude disliked courses
            if(!empty($dislikes['courses'])){

                $courses = $courses->whereNotIn('id', $dislikes['courses']);
            }

            //exclude disliked categories
            if(!empty($dislikes['categories'])){

                $courses = $courses->whereHas('categories', function($query) use ($dislikes){
                    $query->whereNotIn('id', $dislikes['categories']);
                });
            }

            //exclude disliked tags
            if(!empty($dislikes['tags'])){

                $courses = $courses->whereHas('tags', function($query) use ($dislikes){
                    $query->whereNotIn('id', $dislikes['tags']);
                });
            }
        }

        //check if excludes array was provided
        if($request->input('excludes')){

            //store excludes
            $excludes = $request->input('excludes');

            //check if array
            if( (is_array($excludes)) && (!empty($excludes)) ){

                //convert to ints
                $excludes = array_map('intval', $excludes);

                //exclude liked courses
                $courses = $courses->whereNotIn('id', $excludes);
            }
        }

        //check if likes array was provided
        if($request->input('likes')){

            //store likes
            $likes = $request->input('likes');

            //check if array
            if( (is_array($likes)) && (!empty($likes)) ){

                //convert to ints
                $likes = array_map('intval', $likes);

                //exclude liked courses
                $courses = $courses->whereNotIn('id', $likes);
            }
        }

        //check if dislikes array was provided
        if($request->input('dislikes')){

            //store dislikes
            $dislikes = $request->input('dislikes');

            //check if array
            if( (is_array($dislikes)) && (!empty($dislikes)) ){

                //convert to ints
                $dislikes = array_map('intval', $dislikes);

                $disliked_courses = Course::whereIn('id', $dislikes)
                ->whereHas('semesters', function ($query){

                   $query->where('availability', 'open');
                })
                ->with('categories', 'tags')
                ->get();

                //create new collections
                $disliked_cats = new Collection();
                $disliked_tags = new Collection();

                //merge dislikes
                foreach($disliked_courses as $course){
                    $disliked_cats = $disliked_tags->merge($course->categories);
                    $disliked_tags = $disliked_tags->merge($course->tags);
                }

                //get ids, remove duplicates
                $disliked_cats = $disliked_cats->pluck('id')->unique();
                $disliked_tags = $disliked_tags->pluck('id')->unique();

                //exclude disliked courses
                $courses = $courses->whereNotIn('id', $dislikes);

                //exclude disliked categories
                if(!empty($disliked_cats)){

                    $courses = $courses->whereHas('categories', function($query) use ($disliked_cats){
                        $query->whereNotIn('id', $disliked_cats);
                    });
                }

                //exclude disliked tags
                if(!empty($disliked_tags)){

                    $courses = $courses->whereHas('tags', function($query) use ($disliked_tags){
                        $query->whereNotIn('id', $disliked_tags);
                    });
                }
            }
        }
            
        $courses = $courses
        ->with('group')
        ->with('instructor:id,name,email')
        ->with('institution.user')
        ->with('categories', 'tags')
        ->inRandomOrder();

        //check if limit was provided
        if($request->input('limit')){

            //store limit
            $limit = (int) $request->input('limit');

            //if positive
            if($limit) $courses = $courses->take($limit);
        }

        //get courses
        $courses = $courses->get();

        //edit data
        if($courses){

            //edit data
            $courses = $courses->map(function($course){

                //if we have institution
                if($course->institution){

                    $course->institution->id = $course->institution->user_id; 
                    $course->institution->name = $course->institution->user->name;
                    $course->institution->email = $course->institution->user->email;

                    unset($course->institution->user);
                    unset($course->institution->details);
                }

                return $course;
            });

            $courses = $courses->map(function($course){

                //if we have institution
                if($course->institution){

                    unset($course->institution->user_id);
                }

                return $course;
            });
        }

        $response = [
         'courses' => $courses
        ];

    	return response()->json($response, 200);
    }
    public function getCourse($id){

        $course = Course::whereHas('semesters', function ($query){

            $query->where('availability', 'open');
        })
        ->with('group')
        ->with('instructor:id,name,email')
        ->with('institution.user')
        ->with('categories', 'tags', 'semesters', 'semesters.addresses', 'ratings')
        ->with('semesters.meetings')
        ->find($id);

        //edit data
        if($course){

            //if we have institution
            if($course->institution){

                $course->institution->id = $course->institution->user_id; 
                $course->institution->name = $course->institution->user->name;
                $course->institution->email = $course->institution->user->email;

                unset($course->institution->user);
                unset($course->institution->user_id);
                unset($course->institution->details);
            }
        }


    	if(!$course){

    		return response()->json(['message' => 'Course not found'], 404);
    	}

    	return response()->json($course, 200);
    }
    public function putCourse(Request $request, $id){

    	$course = Course::find($id);

    	if(!$course){

    		return response()->json(['message' => 'Course not found'], 404);
    	}
    	
    	$course->name          = $request->input('name');
    	$course->instructor_id = $request->input('instructor_id');
    	$course->address       = $request->input('address');
    	$course->city          = $request->input('city');
    	$course->state         = $request->input('state');
    	$course->zip           = $request->input('zip');
    	$course->amount        = $request->input('amount');
    	$course->availability  = $request->input('availability');

    	$course->save();

    	return response()->json(['course' => $course], 200);
    }
    public function deleteCourse($id){

    	$course = Course::find($id);

    	$course->delete();

    	return response()->json(['message' => 'Course deleted'], 200);
    }

    public function likeCourse($id){

        //get user
        $user = JWTAuth::parseToken()->authenticate();

        //get course
        $course = Course::with('categories', 'tags')->find($id);

        //if course found
        if($course){

            //create new like
            Like::updateOrCreate([
                'user_id' => $user->id,
                'likeable_id' => $course->id,
                'likeable_type' => 'courses']);

            //save like for each category
            foreach ($course->categories as $category){
                Like::updateOrCreate([
                    'user_id' => $user->id,
                    'likeable_id' => $category->id,
                    'likeable_type' => 'categories']);
            }

            //save like for each tag
            foreach ($course->tags as $tag){
                Like::updateOrCreate([
                    'user_id' => $user->id,
                    'likeable_id' => $tag->id,
                    'likeable_type' => 'tags']);
            }

            return response()->json(['message' => 'Likes saved!'], 201);
        }
        else{
            return response()->json(['message' => 'Error: Course Not Found!'], 404);
        }
    }

    public function dislikeCourse($id){

        //get user
        $user = JWTAuth::parseToken()->authenticate();

        //get course
        $course = Course::with('categories', 'tags')->find($id);

        //if course found
        if($course){

            //create new dislike
            Dislike::updateOrCreate([
                'user_id' => $user->id,
                'dislikeable_id' => $course->id,
                'dislikeable_type' => 'courses']);

            //save dislike for each category
            foreach ($course->categories as $category){
                Dislike::updateOrCreate([
                    'user_id' => $user->id,
                    'dislikeable_id' => $category->id,
                    'dislikeable_type' => 'categories']);
            }

            //save dislike for each tag
            foreach ($course->tags as $tag){
                Dislike::updateOrCreate([
                    'user_id' => $user->id,
                    'dislikeable_id' => $tag->id,
                    'dislikeable_type' => 'tags']);
            }

            return response()->json(['message' => 'Dislikes saved!'], 201);
        }
        else{
            return response()->json(['message' => 'Error: Course Not Found!'], 404);
        }
    }

    public function suggest(Request $request){

        if(!App::environment('local')) {

            //validate data
            $this->validate($request, [
                'suggestion' => 'required|min:100'
            ]);

            //send emails
            Mail::send('emails.suggestion', $data, function ($message) {

                $message->from('booking@shrpr.co', 'Shrpr Bookings');
                $message->to('bd@shrpr.co');
                $message->subject('Shrpr: Course Suggestion!');
            });
        }

        return response()->json(['message' => 'Email sent!'], 201);
    }

    private function checkArray($array){

        foreach($array as $value){

            if(!is_int($value)){

                return false;
            }
        }

        return true;
    }
}