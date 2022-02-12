<?php

namespace App\Http\Controllers;

use App\ConstrainHour;
use App\OfferedCourse;
use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimetableController extends Controller
{

    public function generate_view()
    {
        return view('time_table.generate');


    }

    public function store_generation()
    {
        DB::beginTransaction();
        OfferedCourse::where('id', '>', 0)->delete();

        $data = request('data');

        $room = collect(Room::all());

        foreach ($data as $datum) {

             $datum['room_id'] = $room->firstWhere('room_id',$datum['room_id'])['id'];
            OfferedCourse::create($datum);

        }
        DB::commit();

        return response()->json(['success',200]);


    }

    public function generate()
    {


        $p=new Genatic_Algotrthm\Ginatic_Int();
        $p->initialize();


        $data['data']=$p->getScheduleDetails();

        return view('time_table.store', $data);


    }

    public function view()
    {

        return view('time_table.view');


    }

}
