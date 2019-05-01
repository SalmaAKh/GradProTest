<?php
/**
 * Created by PhpStorm.
 * User: salma khater
 * Date: 4/6/2019
 * Time: 2:40 PM
 */

namespace App\Http\Controllers\Genatic_Algotrthm;


use App\Http\Controllers\Genatic_Algotrthm\Ginatic_Int;
use App\Http\Controllers\Genatic_Algotrthm\SelectionMethod;
use phpDocumentor\Reflection\Types\Parent_;

class Fitness_Function //extends Ginatic_Int
{
    private $Events,$name,$instructorId,$roomId,$Timeslot;
    private $collection;
    private $DiffLecture;
    private $TimeSlotFilte;





    public function Fitness($name,$Events,$instructorId,$rooms)
    {
        $this->Events=$Events;
        $this->instructorId=$instructorId;
        $this->name=$name;
        $this->roomId=$rooms;

        $this->collection = collect($Events[$name]);
        foreach($Events as  $key=>$Event){
            for($i=0;$i<25;$i++){
                $TimeSlotFilter[$i] =$this->collection->filter(function ($value, $key) use ($i)
                {
                    if ($value['Time_slot'] == $i)
                        return $value;
                });
            }
        }
        $this->InstructorConstraint();
        $this->ClassRoomConstraint();
        $this->SemesterConstraint();

        return $this->Events[$name];
    }

    private function InstructorConstraint()
    {

        $CheckList = null;

        foreach ($this->instructorId as $key => $Instructor)
        {
            $searchID = $Instructor['id'];
            $CheckList[$key] = $this->collection->filter(function ($value, $key) use ($searchID)
            {
                if ($searchID == $value['Instructor_id'])
                    return $value;
            });
        }


        foreach ($CheckList as $checkTime)
        {
            $InstrucByTime = array();
            $InstrucByDay = array();

            for ($i = 0; $i < 25; $i++)
            {
                $InstrucByTime[$i] = $checkTime->filter(function ($value, $key) use ($i)
                {
                    if ($value['Time_slot'] == $i && $value['Event_Type'] == 1)
                        return $value;
                });

                $InstrucByDay[$i] = $checkTime->filter(function ($value, $key) use ($i)
                {
                    if ($value['Time_slot'] / 5 == $i / 5 && $value['Event_Type'] == 1)
                        return $value;
                });

                if (sizeof($InstrucByTime[$i]) == 1)
                {
                    foreach ($InstrucByTime[$i] as $check) {
                        $index = $check['My_Key'];
                        $this->Events[$this->name][$index]['Fitness']++;
                    }
                }
                if (sizeof($InstrucByDay[$i]) <= 2)
                {
                    foreach ($InstrucByDay[$i] as $check)
                    {
                        $index2 = $check['My_Key'];
                        $this->Events[$this->name][$index2]['Fitness']++;

                    }
                }

            }

        }
    }
    private function ClassRoomConstraint()
    {
        $CheckList = null;
        foreach ($this->roomId as $key => $Room)
        {
            $searchID = $Room['room_id'];
            $CheckList[$key] = $this->collection->filter(function ($value, $key) use ($searchID)
            {

                if ($searchID == $value['Rooms'])
                {
                    return $value;
                }

            });
        }

        foreach ($CheckList as $RoomLecture)
        {
            $RoombyTime = array();
            for ($i = 0; $i < 25; $i++)
            {
                $RoombyTime[$i] = $RoomLecture->filter(function ($value, $key) use ($i)
                {
                    if ($value['Time_slot'] == $i)
                        return $value;
                });

                if (sizeof($RoombyTime[$i]) == 1)
                {

                    foreach ($RoombyTime[$i] as $check)
                    {
                        $index = $check['My_Key'];
                        $this->Events[$this->name][$index]['Fitness']++;
                    }
                }
            }
        }

    }

    private function SemesterConstraint(){
        $CheckSemester=null;
        for($i=1;$i<=8;$i++){
            $CheckSemester[$i-1] = $this->collection->filter(function ($value, $key) use ($i) {
                if ($i == $value['Semester']) {
                    return $value;
                }
            });
        }


        foreach ($CheckSemester as $SemesterCourse) {
            $SemesterCourseTime = array();
            for ($i = 0; $i < 25; $i++) {
                $SemesterCourseTime[$i] = $SemesterCourse->filter(function ($value, $key) use ($i) {
                    if ($value['Time_slot'] == $i)
                        return $value;
                });

                $this->DiffLecture=false;
                foreach ($SemesterCourseTime[$i] as $course){
                    if(sizeof($SemesterCourseTime[$i]) == 1)
                    {
                    $this->Events[$this->name][$course['My_Key']]['Fitness']++;
                    break;
                    }
                    $InCourse=array();
                    $Instructore=$course['Instructor_id'];
                    $CourseID=$course['Course_id'];
                    $InCourse[$i]= $SemesterCourseTime[$i]->filter(function ($value,$key)use ( $CourseID,$Instructore){
                        if($value['Course_id']==$CourseID) {
                            if($value['Instructor_id'] != $Instructore && !$this->DiffLecture) $this->DiffLecture=true;
                            else $this->DiffLecture=false;
                            return $value;
                        }
                    });

                    if( sizeof($InCourse) <= 1 || $this->DiffLecture)
                        $this->Events[$this->name][$course['My_Key']]['Fitness']++;
                }

            }
        }

    }
}

