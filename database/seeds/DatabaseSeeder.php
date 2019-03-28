<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {


        \App\Day::firstorcreate( ["name"=>"Monday"]);
        \App\Day::firstorcreate( ["name"=>"Tuesday"]);
        \App\Day::firstorcreate( ["name"=>"Wednesday"]);
        \App\Day::firstorcreate( ["name"=>"Thursday"]);
        \App\Day::firstorcreate( ["name"=>"Friday"]);

        \App\Hour::firstorcreate( ["starting"=>1]);
        \App\Hour::firstorcreate( ["starting"=>"2"]);
        \App\Hour::firstorcreate( ["starting"=>"3"]);
        \App\Hour::firstorcreate( ["starting"=>"4"]);
        \App\Hour::firstorcreate( ["starting"=>"5"]);


        factory(App\Department::class, 2)->create();
        factory(App\Instructor::class, 100)->create()->each(function ($instructor) {


                factory(App\ConstrainHour::class, rand(0,4))->create(['instructor_id'=>$instructor->id]);




         });;




        factory(App\Administrator::class, 10)->create();





        foreach (range(1,10) as $value){
            course:
            try {
                factory(App\ProgramCurriculum::class, 1)->create();

            } catch (\Illuminate\Database\QueryException $e) {
                echo "error in ProgramCurriculum \n ";
                goto course;
            }
        }




        foreach (range(1,24) as $value){
            Hall:
            try {
                factory(App\Room::class, 1)->create();

            } catch (\Illuminate\Database\QueryException $e) {
                echo "error in room \n ";

                goto Hall;
            }
        }



        foreach (range(1,50) as $value){
            OfferedCourse:
            try {
                factory(App\OfferedCourse::class, 1)->create();


            } catch (\Illuminate\Database\QueryException $e) {

                echo "error in OfferedCourse \n ";


                goto OfferedCourse;
            }
        }

    }
}
