<?php
/**
 * Created by PhpStorm.
 * User: noor2
 * Date: 5/7/2019
 * Time: 1:01 AM
 */

namespace App\Http\Controllers;
use App\OfferedCourse;
use Illuminate\Http\Request;

class OfferedCourseController extends Controller
{
    public function store(Request $request)
    {
        $course= OfferedCourse::create(["program_curriculum_id"=>$request->program_curriculum_id,"instructor_id"=>$request->instructor_id]);
        return view('offered_course.new');
    }
    public function destroy(OfferedCourse $offeredCourse)
    {
        $offeredCourse->delete();
        return redirect ()->back();

    }
   public function remove ($code){

       foreach ( OfferedCourse::get()->where('program_curriculum_id',$code) as $offeredCourse)
       {

           $this->destroy($offeredCourse);
        }
        return redirect ()->back();

   }
}
