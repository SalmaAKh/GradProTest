<?php

namespace App\Http\Controllers;

use App\ConstrainHour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstructorConstraintController extends Controller
{

    public function store(){
        if(\request()->has('message'))
        $data =  request('message');
        else
            $data =  array();


        DB::beginTransaction();

        ConstrainHour::where("instructor_id",auth()->user()->instructor->id)->delete();

        foreach ($data as $datum){

            ConstrainHour::create(["instructor_id"=>auth()->user()->instructor->id,'hour_id'=>$datum['hour_id'],'day_id'=>$datum['day_id']]);
        }
        DB::commit();

        return response()->json(['success',200]);
    }
}
