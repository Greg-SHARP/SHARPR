<?php

use Illuminate\Database\Seeder;
use App\Course;
use App\Category;

class CourseCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses = Course::all();

        //give every course 1 primary category
        foreach($courses as $course){

    		$category = Category::inRandomOrder()->where('parent', NULL)->first();

    		DB::table('category_course')
    			->insert(['course_id' => $course->id, 'category_id' => $category->id]);
        }
    }
}
