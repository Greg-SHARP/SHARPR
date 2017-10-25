<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Course;
use App\Category;
use App\Tag;

class LikesTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //get all users
        $users = User::all();

        //for every user, give them 10 likes/dislikes for courses, primary categories, sub-categories and tags
        foreach($users as $user){

        	//do for courses
            $rand = rand(0, 10);

            $courses = Course::inRandomOrder()->take($rand)->get();

            foreach($courses as $index => $course){

            	//if index is even, like, odd dislike
            	if($index % 2 == 0){

            		DB::table('user_like_course')->insert([
            			'user_id' => $user->id, 
            			'course_id' => $course->id, 
            			'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')]);
            	}
            	else{

            		DB::table('user_dislike_course')->insert([
            			'user_id' => $user->id, 
            			'course_id' => $course->id, 
            			'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')]);
            	}
            }

            //do for categories
            $rand = rand(0, 10);

            $categories = Category::inRandomOrder()->take($rand)->get();

            foreach($categories as $index => $category){

            	//if index is even, like, odd dislike
            	if($index % 2 == 0){

            		DB::table('user_like_category')->insert([
            			'user_id' => $user->id, 
            			'category_id' => $category->id, 
            			'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')]);
            	}
            	else{

            		DB::table('user_dislike_category')->insert([
            			'user_id' => $user->id, 
            			'category_id' => $category->id, 
            			'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')]);
            	}
            }

            //do for tags
            $rand = rand(0, 10);

            $tags = Tag::inRandomOrder()->take($rand)->get();

            foreach($tags as $index => $tag){

            	//if index is even, like, odd dislike
            	if($index % 2 == 0){

            		DB::table('user_like_tag')->insert([
            			'user_id' => $user->id, 
            			'tag_id' => $tag->id, 
            			'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')]);
            	}
            	else{

            		DB::table('user_dislike_tag')->insert([
            			'user_id' => $user->id, 
            			'tag_id' => $tag->id, 
            			'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')]);
            	}
            }
        }
    }
}
