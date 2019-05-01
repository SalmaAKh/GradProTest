<?php

namespace App\Http\Controllers\Genatic_Algotrthm;

use App\Hour;
use App\Http\Controllers\Genatic_Algotrthm\Fitness_Function;
use App\Http\Controllers\Genatic_Algotrthm\SelectionMethod;
use App\Http\Controllers\Genatic_Algotrthm\CrossOver;
use App\Instructor;
use App\OfferedCourse;
use App\Room;
use Illuminate\Http\Request;
use App\Day;
use vendor\project\StatusTest;

class Ginatic_Int
{

    protected $day;
    protected $hour;

    public $instructorId;
    public $rooms;
    public $labs;
    public $offered_C;
    public $Events;
    protected $PopulationSize = 5;
    public $CheckList;
    public $count;
    public $childEvent;
    public $Generation=0;
    public $GenerationLimit=24;


    public function initialize()
    {
        $this->day = Day::all()->toArray();
        $this->hour = Hour::all()->toArray();
        $this->instructorId = Instructor::all('id')->toArray(); //Due to DB conflict unusable ATM.
        $this->offered_C = OfferedCourse::all()->toArray();
        $this->rooms = Room::where('room_type', '=', 1)->get()->toArray();
        $this->labs = Room::where('room_type', '=', 2)->get()->toArray();



        $fitness=new Fitness_Function();
        $Selection=new SelectionMethod();
        $Crossover=new CrossOver();
        for ($i = 0; $i < $this->PopulationSize; $i++) {

            foreach ($this->offered_C as $key => $course) {

                $this->Events[$i][$key]['Course_id'] = $course['program_curriculum_id'];
                $this->Events[$i][$key]['Fitness'] = 0;
                $this->Events[$i][$key]['Semester'] = $course['semester'];
                $this->Events[$i][$key]['Instructor_id'] = $course['instructor_id'];
                $this->Events[$i][$key]['Event_Type']= $course['event_type'];

                //******LECTURE ASSIGNED TO TIME SLOT BEFORE 16:30*******
                if($this->Events[$i][$key]['Event_Type']==1)
                    $this->Events[$i][$key]['Time_slot'] =rand(0,4)*5*rand(0,3);
                 else
                $this->Events[$i][$key]['Time_slot'] = rand(0, 24);


                //******ASSIGNING LABS TO LABS ROOM ONLY***********
                if($this->Events[$i][$key]['Event_Type']==3) {
                    $this->Events[$i][$key]['Rooms'] = $this->labs[rand(0, sizeof($this->labs) - 1)]['room_id'];
                } else {
                    $this->Events[$i][$key]['Rooms'] = $this->rooms[rand(0, sizeof($this->rooms) - 1)]['room_id'];
                }

                $this->Events[$i][$key]['My_Key'] = $key;

            }

            $this->Events[$i]=$fitness->Fitness($i,$this->Events,$this->instructorId,$this->rooms);

        }

        while($this->Generation<$this->GenerationLimit) {//start of gerating
            $Selection->TotalFitness=0;
            $childEvent=null;
            $Fit=null;
                foreach ($this->Events as $key => $event)
                    $Fit[$key] = $Selection->FitnessSum($event);

            highlight_string("<?php\n\$data =\n" . var_export( $Fit, true) . ";\n?>");

            $Selection->Selection($Fit);

            for($i=0;$i<$this->PopulationSize;$i++) {
                $Parent1 = $Selection->getIndex();
                do {
                $Parent2 = $Selection->getIndex();
                } while($Parent1==$Parent2);

                $childEvent[$i] = $Crossover->Crossover($this->Events[$Parent1], $this->Events[$Parent2],$this->rooms,$this->labs);
                //Muation Here
                $childEvent[$i] = $fitness->Fitness($i, $childEvent, $this->instructorId, $this->rooms);
            }
            $this->Events=null;
            $this->Events=$childEvent;
            $this->Generation++;
/*            highlight_string("<?php\n\$data =\n" . var_export('this is child', true) . ";\n?>");*/
/*            highlight_string("<?php\n\$data =\n" . var_export($childEvent, true) . ";\n?>");*/
        }


    }

}



























        ///////////////////
       /* foreach ($this->CheckList as $key => $InstructoreLecture) {

            foreach ($InstructoreLecture as $Eventi) {
                foreach ($InstructoreLecture as $Eventj) {
                    if (sizeof($InstructoreLecture) == 1) {
                        $index1 = $Eventi['My_Key'];
                        $this->Events[$i][$index1]['Fitness']++;
                    }
                    if ($Eventi['Time_slot'] != $Eventj['Time_slot']) {
                        $index1 = $Eventi['My_Key'];
                        if (!$this->Events[$i][$index1]['Fitness'])
                            $this->Events[$i][$index1]['Fitness']++;
                        //Adjust to reduce complexity by manipulating multiple fitness

                    }
                }
            }


        }


        foreach ($this->rooms as $key => $Room) {
            $searchID = $Room['room_id'];
            $this->checkList2[$key] = $collection2->filter(function ($value, $key) use ($searchID) {
                if ($searchID == $value['Rooms'])
                    return $value;

            });

        }


        foreach ($this->checkList2 as $key => $RoomLecture) {

            foreach ($RoomLecture as $Eventn) {
                foreach ($RoomLecture as $Eventm) {
                    if (sizeof($RoomLecture) == 1) {
                        $index2 = $Eventn['My_Key'];
                        $this->Events[$i][$index2]['Fitness']++;
                    }
                    if ($Eventn['Time_slot'] != $Eventm['Time_slot']) ;
                    else {
                        $index2 = $Eventn['My_Key'];
                        if ($this->Events[$i][$index2]['Fitness'] < 2)
                            $this->Events[$i][$index2]['Fitness']++;
                        //Adjust to reduce complexity by manipulating multiple fitness

                    }
                }
            }

                }
        */







/*            highlight_string("<?php\n\$data =\n" . var_export($this->checkList2[$key], true) . ";\n?>");*/


