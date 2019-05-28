<?php

namespace App\Http\Controllers\Genatic_Algotrthm;


use App\Hour;
use App\Http\Controllers\Genatic_Algotrthm\Fitness_Function;
use App\Http\Controllers\Genatic_Algotrthm\SelectionMethod;
use App\Http\Controllers\Genatic_Algotrthm\CrossOver;
use App\Instructor;
use App\OfferedCourse;
use App\Room;
use\App\ProgramCurriculum;
use\App\Department;
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
    public $GenerationLimit=5;

    public $OutputSchedule;
    /**
     * @var int
     */
    public $OutputFit;


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
                $this->Events[$i][$key]['group_id']= $course['group_id'];
                $this->Events[$i][$key]['department_id']= $course['department_id'];


                //******LECTURE ASSIGNED TO TIME SLOT BEFORE 16:30*******
                if($this->Events[$i][$key]['Event_Type']==1)
                    $this->Events[$i][$key]['Time_slot'] =rand(0,4)*5+rand(0,3);
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

            $this->Events[$i]=$fitness->Fitness($i,$this->Events,$this->instructorId,$this->rooms,$this->labs,$this->offered_C);

        }
        $this->OutputSchedule=$this->Events[0];
        $this->OutputFit=0;


        while($this->Generation<$this->GenerationLimit) {//start of gerating
            $Selection->TotalFitness=0;
            $childEvent=null;
            $Fit=null;
            $ChildFit=null;

            foreach ($this->Events as $key => $event)
            {
                $Fit[$key] = $Selection->FitnessSum($event);
                if($Fit[$key]> $this->OutputFit)
                {
                    $this->OutputFit=$Fit[$key];
                    $this->OutputSchedule=$event;
                }
            }


            for($i=0;$i<$this->PopulationSize;$i++) {


                $Parent1 = $Selection->SelectionP1($Fit);
                do {
                    $Parent2 = $Selection->SelectionP1($Fit);
                } while($Parent1==$Parent2);

                $childEvent[$i] = $Crossover->Crossover($this->Events[$Parent1], $this->Events[$Parent2],$this->rooms,$this->labs);
                //Muation Here
                $childEvent[$i] = $fitness->Fitness($i, $childEvent, $this->instructorId, $this->rooms,$this->labs , $this->offered_C);
            }
            foreach ($childEvent as $key => $event)
            {
                $ChildFit[$key] = $Selection->FitnessSum($event);
                if($ChildFit[$key]> $this->OutputFit)
                {
                    $this->OutputFit=$ChildFit[$key];
                    $this->OutputSchedule=$event;
                }
            }
            //$this->Events=null;
            //$this->Events=$childEvent;

            $this->GetNextPopulation($childEvent,$Fit,$ChildFit);
            $this->Generation++;
/*            highlight_string("<?php\n\$data =\n" . var_export('this is child', true) . ";\n?>");*/
/*            highlight_string("<?php\n\$data =\n" . var_export($childEvent, true) . ";\n?>");*/
        }
        echo ($fitness->checkedcount);
        return;
    }

    private function GetNextPopulation($ChildPopulation, $ParentsFitness, $ChildesFitness)
    {
        $AllIndexes=array();
        $AllFitness=array(); //Try array_merge()
        for($i=0;$i<$this->PopulationSize;$i++) {
            $AllIndexes[$i] = $i;
            $AllFitness[$i]=$ParentsFitness[$i];
        }
        for($i=$this->PopulationSize;$i<2*$this->PopulationSize;$i++) {
            $AllIndexes[$i] = $i;
            $AllFitness[$i]=$ChildesFitness[$i - $this->PopulationSize];
        }
        array_multisort($AllFitness,SORT_DESC,$AllIndexes);
        for($i=0;$i<$this->PopulationSize;$i++){
            if($AllIndexes[$i]>=$this->PopulationSize)
                $this->Events[$i]=$ChildPopulation[$AllIndexes[$i] - $this->PopulationSize];
            else
                $this->Events[$i]= $this->Events[$AllIndexes[$i]];
           // $this->Events[$i]=  ($AllIndexes[$i]>$this->PopulationSize) ? $ChildPopulation[$AllIndexes[$i] - $this->PopulationSize] : $this->Events[$AllIndexes[$i]];
        }
    }


    public function getScheduleDetails(){
        $instructors =  Instructor::with('user')->get();
        $instructors = collect($instructors);
        $Hall =  Room::all();
        $Hall = collect($Hall);
        $courses =  OfferedCourse::with('program_curriculum')->get();
        $courses = collect($courses);
        $data=array();
        $days=array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday");

        foreach ($this->OutputSchedule as $key=>$event){
            $instructorName = $instructors->where('id',$event['Instructor_id'])->first()->user->name;
            $hall_code = $event['Rooms'];
            $course_name = $courses->where('program_curriculum_id',$event['Course_id'])->first()->program_curriculum->course_code;

            $time=($event['Time_slot']);
           if($event['Event_Type']!=1)
                $course_name.=' - Lab';
           else $course_name.= '-'.$instructorName;

            $data[] = array("semester"=>$event['Semester'],"day"=>floor($time/5),'time_slot'=>$time%5,"hall_id"=>$hall_code,"instructor_name"=>$instructorName,"course_name"=>$course_name);
        }
        echo ($this->OutputFit);

        $v =1;
        return $data;
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


