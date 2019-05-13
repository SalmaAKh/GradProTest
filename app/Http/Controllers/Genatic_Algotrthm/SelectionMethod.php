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


    public function SelectionP1($FitnessArray)
    {
        while (1) {
            for ($i = 0; $i < sizeof($FitnessArray); $i++){
                $Randomfloat = rand(0, 10) / 10;
            $EvantsFitnessperc = $FitnessArray[$i] / $this->TotalFitness;
            if ($EvantsFitnessperc >= $Randomfloat)
                return $i;
        }
    }
}

public function SelectionP2($FitnessArray)
{
    while (1) {
        for ($i = 0; $i < sizeof($FitnessArray); $i++) {
            $Randomfloat = rand(0, 10) / 10;
            $EvantsFitnessperc = $FitnessArray[$i] / $this->TotalFitness;
            if ($EvantsFitnessperc >= $Randomfloat)
                return $i;
        }
    }
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