<?php
/**
 * Created by PhpStorm.
 * User: salma khater
 * Date: 4/23/2019
 * Time: 12:32 PM
 */

namespace App\Http\Controllers\Genatic_Algotrthm;


use App\Http\Controllers\Genatic_Algotrthm\Ginatic_Int;
use App\Http\Controllers\Genatic_Algotrthm\Fitness_Function;
//use phpDocumentor\Reflection\Types\Parent_;

class SelectionMethod
{

    public $TotalFitness = 0;
    protected $PopulationSize = 100;
    private $SelectionArray = array();

    public function FitnessSum($events)
    {

        $FitnessSum = 0;

        for ($i = 0; $i < sizeof($events); $i++) {
            $FitnessSum += $events[$i]['Fitness'];
        }
        $this->TotalFitness += $FitnessSum;
        return $FitnessSum;
    }

    public function selectionintialization($FitnessArray){

        $AllIndexes=array();
        $AllFitness=array(); //Try array_merge()
        for($i=0;$i<$this->PopulationSize;$i++) {
            $AllIndexes[$i] = $i;
            $AllFitness[$i]=$FitnessArray[$i];
        }

        array_multisort($AllFitness,SORT_DESC,$AllIndexes);

        for ($i=0;$i<=20;$i++){
            $bestfitness[$i]=$AllFitness[$i];
            $newindex[$i]=$AllIndexes[$i];
        }
        return $newindex;
    }


    public function SelectionP1($BestfitIndix)
    {
                $rand=rand(0,20);
                $par=$BestfitIndix[$rand];
                return $par;
    }


 //    $index=0;
//
//    for($i=0;$i<sizeof($FitnessArray);$i++)
//    {
//        $TimeTablePerc=round(($FitnessArray[$i]/$this->TotalFitness)*100);
//
//        for($j=0;$j<$TimeTablePerc;$j++,$index++)
//        {
//            $this->SelectionArray[$index]=$i;
//        }
//    }

    public function getIndex()
    {
        return $this->SelectionArray[rand(0,sizeof($this->SelectionArray)-1)];
    }


//    for($i=0;$i<sizeof($Events);$i++){
//       $Parent1=$SelectionArray[rand(0,$index-1)];
//       $Parent2=$SelectionArray[rand(0,$index-1)];
//       while ($Parent1==$Parent2)
//           $Parent2=$SelectionArray[rand(0,$index-1)];
//
////            $Crossover->Crossover($Events[$Parent1],$Events[$Parent2]);
//    }

}