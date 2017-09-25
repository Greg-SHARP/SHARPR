<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/course', [

	'uses' => 'CourseController@postCourse'
]);

Route::get('/courses', [

	'uses' => 'CourseController@getCourses'
]);

Route::put('/course/{id}', [

	'uses' => 'CourseController@putCourses'
]);

Route::put('/course/{id}', [

	'uses' => 'CourseController@deleteCourses'
]);