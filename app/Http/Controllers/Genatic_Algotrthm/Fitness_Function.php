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
    private $Events, $name, $instructorId, $roomId, $Timeslot;
    private $collection;
    private $DiffLecture;
    private $EventByTimeSlot;
    private $EventByDay;
    /**
     * @var array
     */
    private $labs=array();


    public function Fitness($name, $Events, $instructorId, $rooms)
    {
        $this->Events = $Events; //List of events
        $this->instructorId = $instructorId;  //List of instructors ID
        $this->name = $name; //Schedule ID
        $this->roomId = $rooms; //Room ID

        $this->collection = collect($Events[$name]);
        for ($i = 0; $i < 25; $i++) //For each allowed timeslot
        {
            $this->EventByTimeSlot[$i] = $this->collection->filter(function ($value, $key) use ($i) //Filter out Events by timeslot (grouping)
            {
                if ($value['Time_slot'] == $i)
                    return $value;
            });
        }

        for ($i = 0; $i < 5; $i++) //For each allowed timeslot
        {
            $this->EventByDay[$i] = $this->collection->filter(function ($value, $key) use ($i) //Filter out Events by timeslot (grouping)
            {
                if ($value['Time_slot']/5 == $i)
                    return $value;
            });
        }


        foreach ($this->EventByTimeSlot as $time => $event) {
            $this->InstructorConstraint($time);
            $this->ClassRoomConstraint($time);
            $this->SemesterConstraint($time);
        }
        foreach ($this->EventByDay as $day=> $event) {
            $this->InstructorConstraintByDay($day);


        }
        return $this->Events[$name];
    }


    private function InstructorConstraint($time)
    {

        $instructorList = null;

        foreach ($this->instructorId as $key => $Instructor) {
            $searchID = $Instructor['id'];
            $instructorList[$key] = $this->EventByTimeSlot[$time]->filter(function ($value, $key) use ($searchID) {
                if ($searchID == $value['Instructor_id'] && $value['Event_Type'] == 1)
                    return $value;
            });

            $instructorLabs[$key] = $this->EventByTimeSlot[$time]->filter(function ( $value, $key) use ($searchID){
                if($searchID == $value['Instructor_id'] && $value['Event_Type'] != 1)
                    return $value;
            });

            if (sizeof($instructorList[$key]) == 1) // if only one instructor event per time slot
            {
                foreach ($instructorList[$key] as $check) { // due to nature of data even if the result is one a foreach is required
                    $index = $check['My_Key'];              // in order to bypass the array indexing of the filter
                    $this->Events[$this->name][$index]['Fitness']++;
                }
            }

            else if(sizeof($instructorLabs[$key]) == 1){
                foreach ($instructorLabs[$key] as $check) { // due to nature of data even if the result is one a foreach is required
                    $index = $check['My_Key'];              // in order to bypass the array indexing of the filter
                    $this->Events[$this->name][$index]['Fitness']++;
                }
            }
        }
    }



//        foreach ($instructorList as $checkTime)
//        {
//            $InstrucByTime = array();
//            $InstrucByDay = array();
//
//            for ($i = 0; $i < 25; $i++)
//            {
//                $InstrucByTime[$i] = $checkTime->filter(function ($value, $key) use ($i)
//                {
//                    if ($value['Time_slot'] == $i && $value['Event_Type'] == 1)
//                        return $value;
//                });
//
//                $InstrucByDay[$i] = $checkTime->filter(function ($value, $key) use ($i)
//                {
//                    if ($value['Time_slot'] / 5 == $i / 5 && $value['Event_Type'] == 1)
//                        return $value;
//                });
//
//                if (sizeof($InstrucByTime[$i]) == 1)
//                {
//                    foreach ($InstrucByTime[$i] as $check) {
//                        $index = $check['My_Key'];
//                        $this->Events[$this->name][$index]['Fitness']++;
//                    }
//                }
//                if (sizeof($InstrucByDay[$i]) <= 2)
//                {
//                    foreach ($InstrucByDay[$i] as $check)
//                    {
//                        $index2 = $check['My_Key'];
//                        $this->Events[$this->name][$index2]['Fitness']++;
//
//                    }
//                }
//
//            }
//        }
    /*/*        highlight_string("<?php\n\$data =\n" . var_export($InstrucByTime, true) . ";\n?>");*/
//
//    }

    private function ClassRoomConstraint($time)
    {
        $RoomListByTime = null;
        foreach ($this->roomId as $key => $Room) {
            $searchID = $Room['room_id'];
            $RoomListByTime[$key] = $this->EventByTimeSlot[$time]->filter(function ($value, $key) use ($searchID) {
                if ($searchID == $value['Rooms']) {
                    return $value;
                }

            });

            if (sizeof($RoomListByTime[$key]) == 1) {
                foreach ($RoomListByTime[$key] as $check) {
                    $index = $check['My_Key'];
                    $this->Events[$this->name][$index]['Fitness']++;
                }
            }


        }
    }



//        foreach ($RoomListByTime as $RoomLecture)
//        {
//            $RoombyTime = array();
//            for ($i = 0; $i < 25; $i++)
//            {
//                $RoombyTime[$i] = $RoomLecture->filter(function ($value, $key) use ($i)
//                {
//                    if ($value['Time_slot'] == $i)
//                        return $value;
//                });
//
//                if (sizeof($RoombyTime[$i]) == 1)
//                {
//
//                    foreach ($RoombyTime[$i] as $check)
//                    {
//                        $index = $check['My_Key'];
//                        $this->Events[$this->name][$index]['Fitness']++;
//                    }
//                }
//            }
//        }
//
//    }

    private function SemesterConstraint($time)
    {
        $CheckSemester = null;
        for ($i = 1; $i <= 8; $i++) {
            $CheckSemester[$i - 1] = $this->EventByTimeSlot[$time]->filter(function ($value, $key) use ($i) {
                if ($i == $value['Semester']) {
                    return $value;
                }
            });

            if (sizeof($CheckSemester[$i - 1]) == 1) {
                foreach ($CheckSemester[$i - 1] as $check) {
                    $index = $check['My_Key'];
                    $this->Events[$this->name][$index]['Fitness']++;
                }
            }
        }

    }

    private function InstructorConstraintByDay($day)
    {
        $instructorList = null;

        foreach ($this->instructorId as $key => $Instructor) {
            $searchID = $Instructor['id'];
            $instructorList[$key] = $this->EventByDay[$day]->filter(function ($value, $key) use ($searchID) {
                if ($searchID == $value['Instructor_id'] && $value['Event_Type'] == 1)
                    return $value;
            });

            $instructorLabs[$key] = $this->EventByTimeSlot[$day]->filter(function ( $value, $key) use ($searchID){
                if($searchID == $value['Instructor_id'] && $value['Event_Type'] != 1)
                    return $value;
            });

            if (sizeof($instructorList[$key]) <= 2) // if only one instructor event per time slot
            {
                foreach ($instructorList[$key] as $check) { // due to nature of data even if the result is one a foreach is required
                    $index = $check['My_Key'];              // in order to bypass the array indexing of the filter
                    $this->Events[$this->name][$index]['Fitness']++;
                }
            }

            if(sizeof($instructorLabs[$key])){
                foreach ($instructorLabs[$key] as $check) { // due to nature of data even if the result is one a foreach is required
                    $index = $check['My_Key'];              // in order to bypass the array indexing of the filter
                    $this->Events[$this->name][$index]['Fitness']++;
                }
            }
        }
    }

}

//        foreach ($CheckSemester as $SemesterCourse) {
//            $SemesterCourseTime = array();
//            for ($i = 0; $i < 25; $i++) {
//                $SemesterCourseTime[$i] = $SemesterCourse->filter(function ($value, $key) use ($i) {
//                    if ($value['Time_slot'] == $i)
//                        return $value;
//                });
//
//                $this->DiffLecture=false;
//                foreach ($SemesterCourseTime[$i] as $course){
//                    if(sizeof($SemesterCourseTime[$i]) == 1)
//                    {
//                    $this->Events[$this->name][$course['My_Key']]['Fitness']++;
//                    break;
//                    }
//                    $InCourse=array();
//                    $Instructore=$course['Instructor_id'];
//                    $CourseID=$course['Course_id'];
//                    $InCourse[$i]= $SemesterCourseTime[$i]->filter(function ($value,$key)use ( $CourseID,$Instructore){
//                        if($value['Course_id']==$CourseID) {
//                            if($value['Instructor_id'] != $Instructore && !$this->DiffLecture) $this->DiffLecture=true;
//                            else $this->DiffLecture=false;
//                            return $value;
//                        }
//                    });
//
//                    if( sizeof($InCourse) <= 1 || $this->DiffLecture)
//                        $this->Events[$this->name][$course['My_Key']]['Fitness']++;
//                }
//
//            }
//        }
//
//    }
//}

