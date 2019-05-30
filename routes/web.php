<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function() {return redirect()->route('login');});

Route::group(['prefix' => 'api',  'middleware' => 'auth'], function()
{

    Route::post('instructor/constraint/store',"InstructorConstraintController@store")->name('instructor.constraint.store');
    Route::post('course/constraint/store',"CourseConstraintController@store")->name('course.constraint.store');


});
Route::group(['prefix' => 'admin',  'middleware' => 'auth'], function()
{
    Route::get('dashboard', function() {return view('test');} )->name('dashboard');


    Route::get('offered_course/browser', function () {

        return view('offered_course.browser');

    })->name('offered_course.browser')->middleware('role:admin');

    Route::get('offered_course/new', function () {
        return view('offered_course.new');
    })->name('offered_course.new')->middleware('role:admin');;

    Route::get('time_table/view', function () {
        return view('time_table.view');
    });


    Route::get('instructor/table', function () {
        return view('instructor.table');

    })->name('table')->middleware('role:instructor');


    Route::get('instructor/constraint', function () {

        return view('instructor.time_constraint');

    })->name('instructor.time_constraint')->middleware('role:instructor');

    Route::get('external/constraint', function () {

        return view('external_constraint.external_constraint');

    })->name('course.time_constraint')->middleware('role:instructor');



    Route::post('/addCourse',"OfferedCourseController@store")->name('offeredcourse.store');
    Route::get('{offeredCourse}/deleteCourse',"OfferedCourseController@remove")->name('offeredcourse.delete');

});
Auth::routes();



Route::get('/timetable', function () {
    //return view('welcome');
    $p=new App\Http\Controllers\Genatic_Algotrthm\Ginatic_Int();
    $p->initialize();


    $data['data']=$p->getScheduleDetails();

    return view('welcome',$data);


});
