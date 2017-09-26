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

//Category
Route::post('/category', ['uses' => 'CategoryController@postCategory']);
Route::get('/categories', ['uses' => 'CategoryController@getCategories' ]);
Route::get('/category/{id}', ['uses' => 'CategoryController@getCategory' ]);
Route::put('/category/{id}', ['uses' => 'CategoryController@putCategory']);
Route::put('/category/{id}', ['uses' => 'CategoryController@deleteCourse']);

//Course
Route::post('/course', ['uses' => 'CourseController@postCourse']);
Route::get('/courses', ['uses' => 'CourseController@getCourses' ]);
Route::get('/course/{id}', ['uses' => 'CourseController@getCourse' ]);
Route::put('/course/{id}', ['uses' => 'CourseController@putCourse']);
Route::put('/course/{id}', ['uses' => 'CourseController@deleteCourse']);

//Certificate
Route::post('/certificate', ['uses' => 'CertificateController@postCertificate']);
Route::get('/certificates', ['uses' => 'CertificateController@getCertificates' ]);
Route::get('/certificate/{id}', ['uses' => 'CertificateController@getCertificate' ]);
Route::put('/certificate/{id}', ['uses' => 'CertificateController@putCertificate']);
Route::put('/certificate/{id}', ['uses' => 'CertificateController@deleteCertificate']);

//Instructor
Route::post('/instructor', ['uses' => 'InstructorController@postInstructor']);
Route::get('/instructors', ['uses' => 'InstructorController@getInstructors']);
Route::get('/instructor/{id}', ['uses' => 'InstructorController@getInstructor']);
Route::put('/instructor/{id}', ['uses' => 'InstructorController@putInstructor']);
Route::put('/instructor/{id}', ['uses' => 'InstructorController@deleteInstructor']);

//Meeting
Route::post('/meeting', ['uses' => 'MeetingController@postMeeting']);
Route::get('/meetings', ['uses' => 'MeetingController@getMeetings']);
Route::get('/meeting/{id}', ['uses' => 'MeetingController@getMeeting']);
Route::put('/meeting/{id}', ['uses' => 'MeetingController@putMeetings']);
Route::put('/meeting/{id}', ['uses' => 'MeetingController@deleteMeeting']);

//Student
Route::post('/student', ['uses' => 'StudentController@postStudent']);
Route::get('/students', ['uses' => 'StudentController@getStudents']);
Route::get('/student/{id}', ['uses' => 'StudentController@getStudent']);
Route::put('/student/{id}', ['uses' => 'StudentController@putStudent']);
Route::put('/student/{id}', ['uses' => 'StudentController@deleteStudent']);

//Tag
Route::post('/tag', ['uses' => 'TagController@postTag']);
Route::get('/tags', ['uses' => 'TagController@getTags']);
Route::get('/tag/{id}', ['uses' => 'TagController@getTag']);
Route::put('/tag/{id}', ['uses' => 'TagController@putTag']);
Route::put('/tag/{id}', ['uses' => 'TagController@deleteTag']);

//Type
Route::post('/type', ['uses' => 'TypeController@postType']);
Route::get('/types', ['uses' => 'TypeController@getTypes']);
Route::get('/type/{id}', ['uses' => 'TypeController@getType']);
Route::put('/type/{id}', ['uses' => 'TypeController@putType']);
Route::put('/type/{id}', ['uses' => 'TypeController@deleteType']);

//User
Route::post('/user', ['uses' => 'UserController@postUser']);
Route::get('/users', ['uses' => 'UserController@getUsers']);
Route::get('/user/{id}', ['uses' => 'UserController@getUser']);
Route::put('/user/{id}', ['uses' => 'UserController@putUser']);
Route::put('/user/{id}', ['uses' => 'UserController@deleteUser']);