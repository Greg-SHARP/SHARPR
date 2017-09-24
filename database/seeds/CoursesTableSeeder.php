<?php

use Illuminate\Database\Seeder;
use App\Course;
use App\Meeting;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//create 50 courses
        $courses = factory(Course::class, 50)->create();

        //create 1 to 10 random classes for each course
        foreach($courses as $course){

        	$rand = rand(1, 10);

        	factory(Meeting::class, $rand)->create(['course_id' => $course->id]);
        }
    }
}
