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
Route::get('/courses', ['uses' => 'CourseController@getCourses']);
Route::get('/course/{id}', ['uses' => 'CourseController@getCourse']);
Route::put('/course/{id}', ['uses' => 'CourseController@putCourse']);
Route::delete('/course/{id}', ['uses' => 'CourseController@deleteCourse']);
Route::post('/course/{id}/like', ['uses' => 'CourseController@likeCourse']);
Route::post('/course/{id}/dislike', ['uses' => 'CourseController@dislikeCourse']);
Route::post('/course/suggest', ['uses' => 'CourseController@suggest']);

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

//Institution
Route::post('/institution', ['uses' => 'InstitutionController@postInstitution']);
Route::get('/institutions', ['uses' => 'InstitutionController@getInstitutions']);
Route::get('/institution/{id}', ['uses' => 'InstitutionController@getInstitution']);
Route::put('/institution/{id}', ['uses' => 'InstitutionController@putInstitution']);
Route::delete('/institution/{id}', ['uses' => 'InstitutionController@deleteInstitution']);

//Meeting
Route::post('/meeting', ['uses' => 'MeetingController@postMeeting']);
Route::get('/meetings', ['uses' => 'MeetingController@getMeetings']);
Route::get('/meeting/{id}', ['uses' => 'MeetingController@getMeeting']);
Route::put('/meeting/{id}', ['uses' => 'MeetingController@putMeetings']);
Route::delete('/meeting/{id}', ['uses' => 'MeetingController@deleteMeeting']);

//Student
Route::get('/students', ['uses' => 'StudentController@getStudents']);
Route::get('/student/{id}', ['uses' => 'StudentController@getStudent']);
Route::put('/student', ['uses' => 'StudentController@putStudent'])->middleware('auth');

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
Route::post('/user/check_email', ['uses' => 'UserController@checkEmail']);
Route::get('/users', ['uses' => 'UserController@getUsers']);
Route::get('/user/{id}', ['uses' => 'UserController@getUser']);
Route::post('/user/book', ['uses' => 'UserController@book']);

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
	Route::post('signup', ['uses' => 'AuthController@signup']);
	Route::post('google', ['uses' => 'AuthController@google']);
	Route::post('facebook', ['uses' => 'AuthController@facebook']);
	Route::post('linkedin', ['uses' => 'AuthController@linkedin']);
});

//Search
Route::get('/search', ['uses' => 'SearchController@search']);