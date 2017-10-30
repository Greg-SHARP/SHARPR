<?php

use Illuminate\Database\Seeder;
use App\Course;
use App\Like;
use App\Dislike;
use App\User;

class LikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        //give every user 1 to 10 likes/dislikes of courses
        foreach($users as $user){

        	$rand = rand(0, 10);

        	if($rand){

        		//get random courses
        		$courses = Course::inRandomOrder()->take($rand)->with('categories', 'tags')->get();

        		//for each, like or dislike
        		foreach($courses as $course){

	        		$like = rand(0, 1);

	        		if($like){ //create like     

	        			//create new dislike
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
	        		}
	        		else{ //create dislike

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
	        		}
        		}
        	}
        }
    }
}
