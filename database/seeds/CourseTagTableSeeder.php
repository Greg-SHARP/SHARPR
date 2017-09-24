<?php

use Illuminate\Database\Seeder;
use App\Course;
use App\Tag;

class CourseTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses = Course::all();

        //give every course 0 to 5 tags
        foreach($courses as $course){

        	$rand = rand(0, 5);

        	if($rand){

        		$tags = Tag::all()->random($rand);

	        	foreach($tags as $tag){

	        		DB::table('course_tag')
	        			->insert(['course_id' => $course->id, 'tag_id' => $tag->id]);
	        	}
        	}
        }
    }
}
