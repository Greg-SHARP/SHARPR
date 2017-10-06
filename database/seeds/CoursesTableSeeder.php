<?php

use Illuminate\Database\Seeder;
use App\Course;
use App\Meeting;
use App\Semester;
use App\Rating;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//create 40 courses
        $courses = factory(Course::class, 100)->create();

        //create 1 semester for each course
        foreach($courses as $course){

        	$semesters = factory(Semester::class, 1)->create(['course_id' => $course->id]);

            //create 0 to 10 ratings for each course
            $rand = rand(1, 10);

            factory(Rating::class, $rand)->create(['rateable_id' => $course->id, 'rateable_type' => 'courses']);

            //create 1 to 10 random meetings for each course
            foreach($semesters as $semester){

                $rand = rand(1, 10);

                factory(Meeting::class, $rand)->create(['semester_id' => $semester->id]);
            }
        }
    }
}
