<?php

namespace App\Http\Controllers\Genatic_Algotrthm;


use App\Hour;
use App\Http\Controllers\Genatic_Algotrthm\Fitness_Function;
use App\Http\Controllers\Genatic_Algotrthm\SelectionMethod;
use App\Http\Controllers\Genatic_Algotrthm\CrossOver;
use App\Instructor;
use App\OfferedCourse;
use App\Room;
use App\ProgramCurriculum;
use \App\OtherDepartmentOfferedCourse;
use App\Department;
use Illuminate\Http\Request;
use App\Day;
use MongoDB\Driver\Query;
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
    protected $PopulationSize = 20;
    public $CheckList;
    public $count;
    public $childEvent;
    public $Generation=0;
    public $GenerationLimit=200;
    public $Courseidcmpe;
    public $Courseidcmse;
    public $Courseidblgm;
    public $Courseid;
    public $OtherDepartmentEnglishCourse;
    public $OtherDepartmentTurkishCourse;
    private $fitnessTarget;

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
        $this->labs = Room::whereIn('room_type',[2,3])->get()->toArray();
        $this->Courseidcmpe=ProgramCurriculum::where('department_id','=',1)->get('id')->toArray();
        $this->Courseidcmse=ProgramCurriculum::where('department_id','=',2)->get('id')->toArray();
        $this->Courseidblgm=ProgramCurriculum::where('department_id','=',3)->get('id')->toArray();
        $this->Courseid=array_merge($this->Courseidcmpe, $this->Courseidcmse,$this->Courseidblgm);
        $OtherDepartmentCourse=OtherDepartmentOfferedCourse::all();
        $OtherDepartmentEnglishCourse=$OtherDepartmentCourse->where('department_id',4);
        $OtherDepartmentTurkishCourse=$OtherDepartmentCourse->where('department_id',5);
        $this->fitnessTarget=sizeof($this->offered_C)*4;

        foreach ($OtherDepartmentEnglishCourse as $key=>$Course){

            $this->OtherDepartmentEnglishCourse[$key]['Time_slot']= (($Course['day_id']-1)*5 )+($Course['hour_id']-1);
            $this->OtherDepartmentEnglishCourse[$key]['semester']=$Course['semester'];
            $this->OtherDepartmentEnglishCourse[$key]['Fitness']=0;
            $this->OtherDepartmentEnglishCourse[$key]['My_Key']=$key;
        }

        foreach ($OtherDepartmentTurkishCourse as $key2=>$Course){
            $this->OtherDepartmentTurkishCourse[$key2-86]['Time_slot']= (($Course['day_id']-1)*5 )+($Course['hour_id']-1);
            $this->OtherDepartmentTurkishCourse[$key2-86]['semester']=$Course['semester'];
            $this->OtherDepartmentTurkishCourse[$key2-86]['Fitness']=0;
            $this->OtherDepartmentTurkishCourse[$key2-86]['My_Key']=$key2-86;

        }



        $fitness=new Fitness_Function();
        $Selection=new SelectionMethod();
        $Crossover=new CrossOver();
        $Data=array();
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
                    $this->Events[$i][$key]['Time_slot'] = rand(0,4)*5+rand(0,3);
                else
                    $this->Events[$i][$key]['Time_slot'] = rand(0,24);


                //******ASSIGNING LABS TO LABS ROOM ONLY***********
                if($this->Events[$i][$key]['Event_Type']==3) {
                    $this->Events[$i][$key]['Rooms'] = $this->labs[rand(0, sizeof($this->labs) - 1)]['room_id'];
                } else {
                    $this->Events[$i][$key]['Rooms'] = $this->rooms[rand(0, sizeof($this->rooms) - 1)]['room_id'];
                }

                $this->Events[$i][$key]['My_Key'] = $key;

            }

            $Data[$i]=$fitness->Fitness($i,$this->Events,$this->instructorId,$this->rooms,$this->labs,$this->Courseid,$this->OtherDepartmentTurkishCourse,$this->OtherDepartmentEnglishCourse);
            $this->Events[$i]=$Data[$i]['Events'];
        }
        $this->OutputSchedule=$this->Events[0];
        $this->OutputFit=0;


        while($this->Generation<$this->GenerationLimit) {
//            while($this->OutputFit!=2) {//start of gerating
            $Selection->TotalFitness=0;
            $childEvent=null;
            $Fit=null;
            $ChildFit=null;
            foreach ($this->Events as $key => $event)
            {
                $Fit[$key] = $Selection->FitnessSum($event)+$Data[$key]['OtherDepartmentFitness'];
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
                $Data[$i] = $fitness->Fitness($i, $childEvent, $this->instructorId, $this->rooms,$this->labs,$this->Courseid ,$this->OtherDepartmentTurkishCourse,$this->OtherDepartmentEnglishCourse);
                $childEvent[$i]=$Data[$i]['Events'];
            }
            foreach ($childEvent as $key => $event)
            {
                $ChildFit[$key] = $Selection->FitnessSum($event)/*+$Data[$key]['OtherDepartmentFitness']*/;
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
        }
//        echo ($fitness->checkedcount);
        /*        highlight_string("<?php\n\$data =\n" . var_export($childEvent, true) . ";\n?>");*/
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
            $instructorName = $instructors->where('id',$event['Instructor_id'])->first()['user']['name'];
            $hall_code = $event['Rooms'];
            $course_name = $courses->where('program_curriculum_id',$event['Course_id'])->first()->program_curriculum->course_code;
            $department=$event['department_id'];
            $time=($event['Time_slot']);
            if($event['Event_Type']!=1)
                $course_name.=' - Lab';
            else $course_name.= '-'.$instructorName;

            $data[] = array("event_type"=>$event['Event_Type'],"instructor_id"=>$event['Instructor_id'],"program_curriculum_id"=>$event['Course_id'],"group_id"=>$event['group_id'],"semester"=>$event['Semester'],"day"=>floor($time/5),'time_slot'=>$time%5,"hall_id"=>$hall_code,"instructor_name"=>$instructorName,"course_name"=>$course_name,"department"=>$department);
        }
        echo ($this->OutputFit);

        $v =1;
        return $data;
    }
}
