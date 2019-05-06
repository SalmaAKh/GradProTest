<?php


Route::prefix('admin')->group(function () {

    Route::get('offered_course/browser', function () {
        return view('offered_course.browser');
        
    });

    Route::get('offered_course/new', function () {
        return view('offered_course.new');
    });

    Route::get('time_table/view', function () {
        return view('time_table.view');
    });
    Route::get('log/logIn', function () {
        return view('log.logIn');
    });

    Route::get('log/admin', function () {
        return view('log.admin');

    });
    Route::get('instructor/table', function () {
        return view('instructor.table');

    });
});



