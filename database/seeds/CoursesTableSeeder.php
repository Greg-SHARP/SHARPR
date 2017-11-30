<?php

use Illuminate\Database\Seeder;
use App\Course;
use App\Meeting;
use App\Semester;
use App\Rating;
use App\Address;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $i = 0;

        //create 100 courses
        while($i < 100){

            //create group_id
            $group_id = rand(1, 3);

            factory(Course::class)->create(['group_id' => $group_id]);

            $i++;
        }

        //get all courses
        $courses = Course::all();

        //create 1 to 2 semesters for each course
        foreach($courses as $course){

            $rand = rand(1, 2);

        	$semesters = factory(Semester::class, $rand)->create(['course_id' => $course->id]);

            //create 0 to 10 ratings for each course
            $rand = rand(1, 10);
            
            factory(Rating::class, $rand)->create(['rateable_id' => $course->id, 'rateable_type' => 'courses']);

            //create 1 to 10 random meetings for each course
            foreach($semesters as $semester){

                $rand = rand(1, 10);

                factory(Meeting::class, $rand)->create(['semester_id' => $semester->id]);

                //create address
                factory(Address::class)->create([
                    'addressable_id' => $semester->id, 
                    'addressable_type' => 'semesters']);
            }
        }
    }
}
