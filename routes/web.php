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

Route::get('/', function () {
    //return view('welcome');
    $p=new App\Http\Controllers\Genatic_Algotrthm\Ginatic_Int();
    $p->initialize();


    $data['data']=$p->getScheduleDetails();

     return view('welcome',$data);


});
