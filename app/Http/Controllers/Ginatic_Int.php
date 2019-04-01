<?php

namespace App\Http\Controllers;

use App\Hour;
use App\Instructor;
use App\OfferedCourse;
use App\Room;
use Illuminate\Http\Request;
use App\Day;

class Ginatic_Int extends Controller
{

    private $day;
    private $hour;

    public $instructorId;
    public $rooms;
    public $labs;
    public $offered_C;
    public $Events;
    private $PopulationSize = 2;
    public $CheckList;
    public $count;



    public function initialize()
    {
        $this->day = Day::all()->toArray();
        $this->hour = Hour::all()->toArray();
        $this->instructorId=Instructor::all('id')->toArray(); //Due to DB conflict unusable ATM.

        $this->offered_C = OfferedCourse::all()->toArray();
        $this->rooms = Room::where('room_type', '=', 1)->get()->toArray();
        $this->labs = Room::where('room_type', '=', 2)->get()->toArray();


        for ($i = 0; $i < $this->PopulationSize; $i++) {
            if ($i == 0) $name = 'TimeTable_1';
            else $name = 'TimeTable_2';
            foreach ($this->offered_C as $key => $course) {

                $this->Events[$name][$key]['Course_id'] = $course['program_curriculum_id'];
                $this->Events[$name][$key]['Fitness'] = 0;
                $this->Events[$name][$key]['Instructor_id'] = $course['instructor_id'];
                $this->Events[$name][$key]['Time_slot'] = rand(0, 24);
                //chech if lab for room type
                $this->Events[$name][$key]['Rooms'] = $this->rooms[rand(0, sizeof($this->rooms) - 1)]['room_id'];
                $this->Events[$name][$key]['My_Key'] = $key;
            }

        }

        $this->Fitness('TimeTable_1');
    }

    public function Fitness($name)
    {
        $this->CheckList=null;
        $collection=collect($this->Events[$name]);

        foreach ($this->instructorId as $key=>$Instructor)
        {
            $searchID=$Instructor['id'];
            $this->CheckList[$key]=$collection->filter(function ($value , $key) use ($searchID) {
              if($searchID == $value['Instructor_id'])
                return $value;
            });
        }

        foreach ($this->CheckList as $key=>$InstructoreLecture) {

            foreach ($InstructoreLecture as $Eventi) {
                foreach ($InstructoreLecture as $Eventj) {
                    if(sizeof($InstructoreLecture)==1)
                    {
                        $index1=$Eventi['My_Key'];
                        $this->Events[$name][$index1]['Fitness']++;
                    }
                    if($Eventi['Time_slot'] != $Eventj['Time_slot'])
                    {
                        $index1=$Eventi['My_Key'];
                        if(!$this->Events[$name][$index1]['Fitness'])
                        $this->Events[$name][$index1]['Fitness']++;
                       //Adjust to reduce complexity by manipulating multiple fitness

                    }
                }
            }
        }
        highlight_string("<?php\n\$data =\n" . var_export($this->Events[$name], true) . ";\n?>");

    }
}
