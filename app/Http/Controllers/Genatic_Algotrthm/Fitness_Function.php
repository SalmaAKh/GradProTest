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
    public $checkedcount = 0;
    /**
     * @var array
     */
    private $labs = array();


    public function Fitness($name, $Events, $instructorId, $rooms, $labs, $OfferedCourses)
    {
        $this->checkedcount = 0;
        $this->Events = $Events; //List of events
        $this->instructorId = $instructorId;  //List of instructors ID
        $this->name = $name; //Schedule ID
        $this->roomId = $rooms; //Room ID
        $this->labs = $labs;
        $this->OfferedCourses= $OfferedCourses;

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
                if (floor($value['Time_slot'] / 5) == $i)
                    return $value;
            });
        }


        foreach ($this->EventByTimeSlot as $time => $event) {

            if (sizeof($event) != 0) {
                $this->InstructorConstraint($time);
                $this->ClassRoomConstraint($time);
                $this->SemesterConstraint($time);
            }
        }
        foreach ($this->EventByDay as $day => $event) {
            if (sizeof($event) != 0) {
                $this->InstructorConstraintByDay($event);
                $this->CourseConstrainByDay($event);

            }
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

//            $instructorLabs[$key] = $this->EventByTimeSlot[$time]->filter(function ( $value, $key) use ($searchID){
//                if($searchID == $value['Instructor_id'] && $value['Event_Type'] != 1)
//                    return $value;
//            });


            if (sizeof($instructorList[$key]) == 1) // if only one instructor event per time slot
            {
                foreach ($instructorList[$key] as $check) { // due to nature of data even if the result is one a foreach is required
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
        $LabListByTime = null;
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
        foreach ($this->labs as $key => $lab) {
            $searchID = $lab['room_id'];
            $labListByTime[$key] = $this->EventByTimeSlot[$time]->filter(function ($value, $key) use ($searchID) {
                if ($searchID == $value['Rooms']) {
                    return $value;
                }
            });

            if (sizeof($labListByTime[$key]) == 1) {
                foreach ($labListByTime[$key] as $check) {
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
        $CheckSemestercmpe = null;
        $CheckSemestercmse = null;
        $CheckSemesterblgm = null;
        for ($i = 1; $i <= 8; $i++) {
            $CheckSemestercmpe[$i - 1] = $this->EventByTimeSlot[$time]->filter(function ($value, $key) use ($i) {
                if ($i == $value['Semester']&&$value['department_id']==1) {
                    return $value;
                }
            });

            if (sizeof($CheckSemestercmpe[$i - 1]) == 1) {
                foreach ($CheckSemestercmpe[$i - 1] as $check) {
                    $index = $check['My_Key'];
                    $this->Events[$this->name][$index]['Fitness'] += 1;
                }
            }
        }
        for ($i = 1; $i <= 8; $i++) {
            $CheckSemestercmse[$i - 1] = $this->EventByTimeSlot[$time]->filter(function ($value, $key) use ($i) {
                if ($i == $value['Semester']&&$value['department_id']==2) {
                    return $value;
                }
            });

            if (sizeof($CheckSemestercmse[$i - 1]) == 1) {
                foreach ($CheckSemestercmse[$i - 1] as $check) {
                    $index = $check['My_Key'];
                    $this->Events[$this->name][$index]['Fitness'] += 1;
                }
            }
        }
        for ($i = 1; $i <= 8; $i++) {
            $CheckSemesterblgm[$i - 1] = $this->EventByTimeSlot[$time]->filter(function ($value, $key) use ($i) {
                if ($i == $value['Semester']&&$value['department_id']==3) {
                    return $value;
                }
            });

            if (sizeof( $CheckSemesterblgm[$i - 1]) == 3) {
                foreach ($CheckSemesterblgm[$i - 1] as $check) {
                    $index = $check['My_Key'];
                    $this->Events[$this->name][$index]['Fitness'] += 1;
                }
            }

        }

    }

    private function InstructorConstraintByDay($event)
    {
        $instructorList = null;

        foreach ($this->instructorId as $key => $Instructor) {
            $searchID = $Instructor['id'];
            $instructorList[$key] = $event->filter(function ($value, $key) use ($searchID) {
                if ($searchID == $value['Instructor_id'] && $value['Event_Type'] == 1)
                    return $value;
            });


            if (sizeof($instructorList[$key]) <= 2 && sizeof($instructorList[$key]) > 0) // if only one instructor event per time slot
            {
                foreach ($instructorList[$key] as $check) { // due to nature of data even if the result is one a foreach is required
                    $index = $check['My_Key'];              // in order to bypass the array indexing of the filter
                    $this->Events[$this->name][$index]['Fitness'] += 1;
                }
            }
        }
    }


    private function CourseConstrainByDay($event)
    {
        $CourseList = null;
        $CourseListByGroup = null;

        foreach ($this->OfferedCourses as $key => $course) {
            $searchID = $course['program_curriculum_id'];
            $CourseList[$key] = $event->filter(function ($value, $key) use ($searchID) {
                if ($searchID == $value['Course_id'])
                    return $value;
            });

            for ($i = 0; $i <= 3; $i++) {
                $searchID = $i;
                $CourseListByGroup[$key] = $CourseList[$key]->filter(function ($value, $key) use ($searchID) {
                    if ($searchID == $value['group_id'])
                        return $value;
                });
            }


            if (sizeof($CourseListByGroup[$key]) == 1) // if only one instructor event per time slot
            {
                foreach ($CourseListByGroup[$key] as $check) { // due to nature of data even if the result is one a foreach is required
                    $index = $check['My_Key'];              // in order to bypass the array indexing of the filter
                    $this->Events[$this->name][$index]['Fitness'] += 1;
                }
            }
        }
    }


}

