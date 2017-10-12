<?php

use Illuminate\Database\Seeder;
use App\Course;
use App\User;

class CourseUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses = Course::all();

        //give every course, add 0 to 10 students
        foreach($courses as $course){

            $rand = rand(0, 10);

            //take 0 to 10
            if($rand){

				$users = User::inRandomOrder()
				            ->whereHas('roles', function($query){
				                $query->where('label', 'student');
				            })
				            ->take($rand)
				            ->get();
            }

            foreach($users as $user){

    			DB::table('course_user')
    				->insert(['course_id' => $course->id, 'user_id' => $user->id]);
            }
        }
    }
}
