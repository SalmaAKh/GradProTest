<?php
/**
 * Created by PhpStorm.
 * User: salma khater
 * Date: 4/23/2019
 * Time: 4:14 PM
 */

namespace App\Http\Controllers\Genatic_Algotrthm;
use App\Http\Controllers\Genatic_Algotrthm\Ginatic_Int;
use App\Http\Controllers\Genatic_Algotrthm\Fitness_Function;


class CrossOver extends Ginatic_Int
{

    public function Crossover($TimeTable1, $TimeTable2,$room,$lab)
    {

        $Child = $TimeTable1;
/*        highlight_string("<?php\n\$data =\n" . var_export($Child, true) . ";\n?>");*/

        foreach ($Child as $key=>$childEvents) {
            $Child[$key]['Fitness'] = 0;
//            for ($key = 0; $key < sizeof($TimeTable1); $key++)
//            {
//                $Randnum = rand(0, 100)/10;
//                if (0.35<$Randnum&&$Randnum< 5)
////                if ($Randnum>8&&$Randnum<=9)
//                    $Child[$key]['Time_slot'] = $TimeTable1[$key]['Time_slot'];
//                else if(5.35<$Randnum&&$Randnum<=10)
////                else if($Randnum>9&&$Randnum<=10)
//                    $Child[$key]['Time_slot'] = $TimeTable2[$key]['Time_slot'];
//                else if(($Randnum<=0.35)||($Randnum>=5&&$Randnum<=5.35)){
////                else if($Randnum<=8){
//                    if($Child[$key]['Event_Type']==1)
//                        $Child[$key]['Time_slot']= rand(0,4)*5*rand(0,3);
//                    else
//                        $Child[$key]['Time_slot']=  rand(0, 24);
//                    }
//            }
//
//            for ($key = 0; $key <sizeof($TimeTable1); $key++)
//            {
//
//                $Randnum2 =mt_rand(0, 100)/10;
//
//                if (0.35<$Randnum&&$Randnum< 5)
//                    $Child[$key]['Rooms'] = $TimeTable2[$key]['Rooms'];
//
//                else if(5.35<$Randnum&&$Randnum<=10)
//                    $Child[$key]['Rooms'] = $TimeTable1[$key]['Rooms'];
//                else if(($Randnum<=0.35)||($Randnum>=5&&$Randnum<=5.35)){
//
//                    if( $Child[$key] ['Event_Type']==3)
//                    {
//                        $Child[$key]['Rooms']  = $lab[rand(0, sizeof($lab) - 1)]['room_id'];
//                    } else {
//                        $Child[$key]['Rooms']  = $room[rand(0, sizeof($room) - 1)]['room_id'];
//                    }
//                }
//            }




                $Choice1 = rand(0, 1);
                if ($Choice1) {
                    $Child[$key]['Time_slot'] = $TimeTable1[$key]['Time_slot'];
                } else $childEvents['Time_slot'] = $TimeTable2[$key]['Time_slot'];
                $Choice2 = rand(0, 1);
                if (!$Choice2) {
                    $Child[$key]['Rooms'] = $TimeTable1[$key]['Rooms'];
                } else $Child[$key]['Rooms'] = $TimeTable2[$key]['Rooms'];


                $Ratio1 = rand(0, 100) / 1000;
                if ($Ratio1 < 0.01) {
                    if ($Child[$key]['Event_Type'] == 1)
                        $Child[$key]['Time_slot'] = rand(0, 4) * 5 * rand(0, 3);
                    else
                        $Child[$key]['Time_slot'] = rand(0, 24);
                }

                $Ratio2 = rand(0, 100) / 1000;
                if ($Ratio2< 0.01) {

                    if ($childEvents ['Event_Type'] == 3)
                        $childEvents['Rooms'] = $lab[rand(0, sizeof($lab) - 1)]['room_id'];
                    else
                        $childEvents['Rooms'] = $room[rand(0, sizeof($room) - 1)]['room_id'];
                }

        }
        return $Child;
    }
}
