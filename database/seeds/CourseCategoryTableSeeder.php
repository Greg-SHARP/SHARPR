<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\Course;

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

            $sub_categories = Category::where('parent', $category->id)->get();

            if($sub_categories){

                foreach($sub_categories as $sub_category) {
            
                    $i = 0;
                    $rand = rand(1, 2);

                    while($i < $rand){

                        $i++;

                        DB::table('category_course')
                            ->insert(['course_id' => $course->id, 'category_id' => $sub_category->id]);
                    }
                }
            }
        }
    }
}
