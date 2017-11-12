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

//Category
Route::post('/category', ['uses' => 'CategoryController@postCategory']);
Route::get('/categories', ['uses' => 'CategoryController@getCategories' ]);
Route::get('/category/{id}', ['uses' => 'CategoryController@getCategory' ]);
Route::put('/category/{id}', ['uses' => 'CategoryController@putCategory']);
Route::delete('/category/{id}', ['uses' => 'CategoryController@deleteCourse']);

//Course
Route::post('/course', ['uses' => 'CourseController@postCourse']);

Route::get('/courses', [
    'middleware' => 'auth',
	'uses' => 'CourseController@getCourses'
]);

Route::get('/course/{id}', ['uses' => 'CourseController@getCourse']);
Route::put('/course/{id}', ['uses' => 'CourseController@putCourse']);
Route::delete('/course/{id}', ['uses' => 'CourseController@deleteCourse']);

Route::post('/course/{id}/like', [
	'uses' => 'CourseController@likeCourse',
	'middleware' => 'auth'
]);

Route::post('/course/{id}/dislike', [
	'uses' => 'CourseController@dislikeCourse',
	'middleware' => 'auth'
]);

//Semester
Route::post('/semester', ['uses' => 'SemesterController@postSemester']);
Route::get('/semesters', ['uses' => 'SemesterController@getSemesters' ]);
Route::get('/semester/{id}', ['uses' => 'SemesterController@getSemester' ]);
Route::put('/semester/{id}', ['uses' => 'SemesterController@putSemester']);
Route::delete('/semester/{id}', ['uses' => 'SemesterController@deleteSemester']);

//Certificate
Route::post('/certificate', ['uses' => 'CertificateController@postCertificate']);
Route::get('/certificates', ['uses' => 'CertificateController@getCertificates' ]);
Route::get('/certificate/{id}', ['uses' => 'CertificateController@getCertificate' ]);
Route::put('/certificate/{id}', ['uses' => 'CertificateController@putCertificate']);
Route::delete('/certificate/{id}', ['uses' => 'CertificateController@deleteCertificate']);

//Instructor
Route::post('/instructor', ['uses' => 'InstructorController@postInstructor']);
Route::get('/instructors', ['uses' => 'InstructorController@getInstructors']);
Route::get('/instructor/{id}', ['uses' => 'InstructorController@getInstructor']);
Route::put('/instructor/{id}', ['uses' => 'InstructorController@putInstructor']);
Route::delete('/instructor/{id}', ['uses' => 'InstructorController@deleteInstructor']);

//Meeting
Route::post('/meeting', ['uses' => 'MeetingController@postMeeting']);
Route::get('/meetings', ['uses' => 'MeetingController@getMeetings']);
Route::get('/meeting/{id}', ['uses' => 'MeetingController@getMeeting']);
Route::put('/meeting/{id}', ['uses' => 'MeetingController@putMeetings']);
Route::delete('/meeting/{id}', ['uses' => 'MeetingController@deleteMeeting']);

//Student
Route::post('/student', ['uses' => 'StudentController@postStudent']);
Route::get('/students', ['uses' => 'StudentController@getStudents']);
Route::get('/student/{id}', ['uses' => 'StudentController@getStudent']);
Route::put('/student/{id}', ['uses' => 'StudentController@putStudent']);
Route::delete('/student/{id}', ['uses' => 'StudentController@deleteStudent']);

//Tag
Route::post('/tag', ['uses' => 'TagController@postTag']);
Route::get('/tags', ['uses' => 'TagController@getTags']);
Route::get('/tag/{id}', ['uses' => 'TagController@getTag']);
Route::put('/tag/{id}', ['uses' => 'TagController@putTag']);
Route::delete('/tag/{id}', ['uses' => 'TagController@deleteTag']);

//Type
Route::post('/role', ['uses' => 'RoleController@postRole']);
Route::get('/roles', ['uses' => 'RoleController@getRoles']);
Route::get('/role/{id}', ['uses' => 'RoleController@getRole']);
Route::put('/role/{id}', ['uses' => 'RoleController@putRole']);
Route::delete('/role/{id}', ['uses' => 'RoleController@deleteRole']);

//User
Route::post('/user', ['uses' => 'UserController@signup']);
Route::post('/login', ['uses' => 'UserController@login']);
Route::get('/users', ['uses' => 'UserController@getUsers']);
Route::get('/user/{id}', ['uses' => 'UserController@getUser']);