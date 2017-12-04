<?php

use Illuminate\Database\Seeder;
use App\Course;
use App\Meeting;
use App\Semester;
use App\Rating;
use App\Address;
use App\Group;
use App\Instructor;
use App\Category;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $i = 0;

        // //create 100 courses
        // while($i < 100){

        //     //create group_id
        //     $group_id = rand(1, 3);

        //     factory(Course::class)->create(['group_id' => $group_id]);

        //     $i++;
        // }

        // //get all courses
        // $courses = Course::all();

        // //create 1 to 2 semesters for each course
        // foreach($courses as $course){

        //     $rand = rand(1, 2);

        // 	$semesters = factory(Semester::class, $rand)->create(['course_id' => $course->id]);

        //     //create 0 to 10 ratings for each course
        //     $rand = rand(1, 10);
            
        //     factory(Rating::class, $rand)->create(['rateable_id' => $course->id, 'rateable_type' => 'courses']);

        //     //create 1 to 10 random meetings for each course
        //     foreach($semesters as $semester){

        //         $rand = rand(1, 10);

        //         factory(Meeting::class, $rand)->create(['semester_id' => $semester->id]);

        //         //create address
        //         factory(Address::class)->create([
        //             'addressable_id' => $semester->id, 
        //             'addressable_type' => 'semesters']);
        //     }
        // }

        //import courses
        Excel::load('excel/courses.csv', function($reader) {

            //get all courses
            $courses = $reader->all();

            foreach($courses as $course){

                //remove whitespace
                $course->group = trim($course->group);
                $course->category = trim($course->category);
                $course->sub_category = trim($course->sub_category);
                $course->institution = trim($course->institution);
                $course->course_title = trim($course->course_title);
                $course->instructor = trim($course->instructor);
                $course->description = trim($course->description);
                $course->amount = trim($course->amount);

                $course->streetAddress = trim($course->streetAddress);
                $course->city = trim($course->city);
                $course->state = trim($course->state);
                $course->zip = trim($course->zip);
                $course->location = trim($course->location);

                $course->primary_img = trim($course->primary_img);
                $course->secondary_img = trim($course->secondary_img);

                $course->day_1_start = trim($course->day_1_start);
                $course->day_1_end = trim($course->day_1_end);
                $course->day_2_start = trim($course->day_2_start);
                $course->day_2_end = trim($course->day_2_end);
                $course->day_3_start = trim($course->day_3_start);
                $course->day_3_end = trim($course->day_3_end);
                $course->day_4_start = trim($course->day_4_start);
                $course->day_4_end = trim($course->day_4_end);
                $course->day_5_start = trim($course->day_5_start);
                $course->day_5_end = trim($course->day_5_end);
                $course->day_6_start = trim($course->day_6_start);
                $course->day_6_end = trim($course->day_6_end);
                $course->day_7_start = trim($course->day_7_start);
                $course->day_7_end = trim($course->day_7_end);
                $course->day_8_start = trim($course->day_8_start);
                $course->day_8_end = trim($course->day_8_end);
                $course->day_9_start = trim($course->day_9_start);
                $course->day_9_end = trim($course->day_9_end);
                $course->day_10_start = trim($course->day_10_start);
                $course->day_10_end = trim($course->day_10_end);

                //get instructor
                $instructor = Instructor::whereHas('user', function ($query) use ($course){

                    $query->where('name', 'Susan Bishop');
                })
                ->first();

                //no instructor, move to next in loop
                if(!$instructor) continue;

                //get group
                $group = Group::where('label', $course->group)->first();

                //no group, move to next in loop
                if(!$group) continue;

                //get category
                $category = Category::where('name', $course->category)->first();
                $sub_category = Category::where('name', $course->sub_category)->first();

                //create new course
                $new_course = new Course;

                //set data
                $new_course->group_id = $group->id;
                $new_course->instructor = $instructor->user_id;
                $new_course->title = $course->course_title;
                $new_course->description = $course->description;

                //save course
                $new_course->save();

                if($category) $new_course->categories()->attach($category->id);
                if($sub_category) $new_course->categories()->attach($sub_category->id);

                //create semester
                $semester = new Semester;

                //create details
                $details = [
                    'secondary_img' => $course->secondary_img
                ];

                $semester->course_id = $new_course->id;
                $semester->amount = $course->amount;
                $semester->availability = 'open';
                $semester->primary_img = $course->primary_img;
                $semester->details = json_encode($details);

                //save semester to new course
                $new_course->semesters()->save($semester);

                //create address
                $address = new Address;

                $address->name = $course->location;
                $address->streetAddress = $course->streetAddress;
                $address->city = $course->city;
                $address->state = $course->state;
                $address->zip = $course->zip;
                $address->country = 'United States';
                $address->latitude = 41.22;
                $address->longitude = -73.41;
                $address->type = 'primary';
                $address->addressable_id = $semester->id;
                $address->addressable_type = 'semesters';

                $address->save();

                //add meeting if we have both a start and end
                if($course->day_1_start && $course->day_1_end){

                    $meeting = new Meeting;

                    $meeting->semester_id = $semester->id;
                    $meeting->start = new Datetime($course->day_1_start);
                    $meeting->end = new Datetime($course->day_1_end);

                    $meeting->save();
                }

                //add meeting if we have both a start and end
                if($course->day_2_start && $course->day_2_end){

                    $meeting = new Meeting;

                    $meeting->semester_id = $semester->id;
                    $meeting->start = new Datetime($course->day_2_start);
                    $meeting->end = new Datetime($course->day_2_end);

                    $meeting->save();
                }

                //add meeting if we have both a start and end
                if($course->day_3_start && $course->day_3_end){

                    $meeting = new Meeting;

                    $meeting->semester_id = $semester->id;
                    $meeting->start = new Datetime($course->day_3_start);
                    $meeting->end = new Datetime($course->day_3_end);

                    $meeting->save();
                }

                //add meeting if we have both a start and end
                if($course->day_4_start && $course->day_4_end){

                    $meeting = new Meeting;

                    $meeting->semester_id = $semester->id;
                    $meeting->start = new Datetime($course->day_4_start);
                    $meeting->end = new Datetime($course->day_4_end);

                    $meeting->save();
                }

                //add meeting if we have both a start and end
                if($course->day_5_start && $course->day_5_end){

                    $meeting = new Meeting;

                    $meeting->semester_id = $semester->id;
                    $meeting->start = new Datetime($course->day_5_start);
                    $meeting->end = new Datetime($course->day_5_end);

                    $meeting->save();
                }

                //add meeting if we have both a start and end
                if($course->day_6_start && $course->day_6_end){

                    $meeting = new Meeting;

                    $meeting->semester_id = $semester->id;
                    $meeting->start = new Datetime($course->day_6_start);
                    $meeting->end = new Datetime($course->day_6_end);

                    $meeting->save();
                }

                //add meeting if we have both a start and end
                if($course->day_7_start && $course->day_7_end){

                    $meeting = new Meeting;

                    $meeting->semester_id = $semester->id;
                    $meeting->start = new Datetime($course->day_7_start);
                    $meeting->end = new Datetime($course->day_7_end);

                    $meeting->save();
                }

                //add meeting if we have both a start and end
                if($course->day_8_start && $course->day_8_end){

                    $meeting = new Meeting;

                    $meeting->semester_id = $semester->id;
                    $meeting->start = new Datetime($course->day_8_start);
                    $meeting->end = new Datetime($course->day_8_end);

                    $meeting->save();
                }

                //add meeting if we have both a start and end
                if($course->day_9_start && $course->day_9_end){

                    $meeting = new Meeting;

                    $meeting->semester_id = $semester->id;
                    $meeting->start = new Datetime($course->day_9_start);
                    $meeting->end = new Datetime($course->day_9_end);

                    $meeting->save();
                }

                //add meeting if we have both a start and end
                if($course->day_10_start && $course->day_10_end){

                    $meeting = new Meeting;

                    $meeting->semester_id = $semester->id;
                    $meeting->start = new Datetime($course->day_10_start);
                    $meeting->end = new Datetime($course->day_10_end);

                    $meeting->save();
                }
            }
        });
    }
}
