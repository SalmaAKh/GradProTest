<?php

namespace App\Http\Controllers;

use App\OtherDepartmentConstraint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseConstraintController extends Controller
{

    public function store(){


        if(\request()->has('message'))
            $data =  request('message');
        else
            $data =  array();


        DB::beginTransaction();

        OtherDepartmentConstraint::where('id','>',0)->delete();

        foreach ($data as $datum){

            OtherDepartmentConstraint::create(["program_curriculum_id"=>$datum['course_id'],'hour_id'=>$datum['hour_id'],'day_id'=>$datum['day_id']]);
        }
        DB::commit();

        return response()->json(['success',200]);


    }
}
