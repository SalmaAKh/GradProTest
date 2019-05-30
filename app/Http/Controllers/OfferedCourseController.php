<?php
/**
 * Created by PhpStorm.
 * User: noor2
 * Date: 5/7/2019
 * Time: 1:01 AM
 */

namespace App\Http\Controllers;

use App\OfferedCourse;
use App\ProgramCurriculum;
use Illuminate\Http\Request;

class OfferedCourseController extends Controller
{
    public function store(Request $request)
    {

         $lab = ProgramCurriculum::find($request->program_curriculum_id)->lab_type;




        foreach (range(1, count(request()->instructor_id)) as $key=>$group_id) {

            foreach (range(1, 3) as $num) {
                $event_type = 1;
                if ($num == 3) {
                    $event_type = $lab;
                }
            $course = OfferedCourse::create(["program_curriculum_id" => $request->program_curriculum_id, "instructor_id" => $request->instructor_id[$key], "group_id" => $group_id, "event_type" => $event_type]);

            }

        }


        return redirect()->back();
    }

    public function destroy(OfferedCourse $offeredCourse)
    {

         OfferedCourse::where('group_id',$offeredCourse->group_id)->where('program_curriculum_id',$offeredCourse->program_curriculum_id)->delete();
        return redirect()->back();

    }

    public function remove( OfferedCourse $offeredCourse)
    {
         OfferedCourse::where('group_id',$offeredCourse->group_id)->where('program_curriculum_id',$offeredCourse->program_curriculum_id)->delete();

        return redirect()->back();

    }
}
