<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\Course;
use App\Category;

class SearchController extends Controller
{
    public function search(Request $request){

    	$search = $request->input('str');

			if($search){

				$courses = Course::whereHas('semesters', function ($query){

					$query->where('availability', 'open');
				})
				->where('title', 'like', $search . '%')
				->select('id', 'title')
				->take(10)
				->get()
				->map(function($course){

					$course->type = 'course';

					return $course;
				});

				$result = $courses;

				if($result->count() < 10){

					$take = 10 - $result->count();

					$categories = Category::where('name', 'like', $search . '%')
					->select('id', 'name')
					->take($take)
					->get()
					->map(function($category){

						$category->title = $category->name;
						$category->type = 'category';

						unset($category->name);

						return $category;
					});

					$result = $result->merge($categories);
				}
    	}
    	else{

    		$groups = Group::all()->map(function($group){

    			$group->title = $group->label;
    			$group->type = 'group';

    			unset($group->label);

    			switch($group->id) {
    				case 1:
    					$group->img = 'assets/img/fun-icon.png';
    					break;

    				case 2:
    					$group->img = 'assets/img/work-icon.png';
    					break;

    				case 3:
    					$group->img = 'assets/img/kid-icon.png';
    					break;
    			}

    			return $group;
    		});

    		$result = $groups;
    	}

		return response()->json($result, 200);
    }
}