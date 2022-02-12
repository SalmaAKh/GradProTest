@extends('template.template')
<?php

function reWriteWeekResult($day){

    return $day;

}
function reWriteColorResult($index){

    return array("Blue", "Green", "Bronze", "#fd397a", "Purple","Brown", "grey", "Capri")[$index-1];
}
function reWriteTimeResult($time){

    $arr = array("1"=>"08","2"=>"10","3"=>"12","4"=>"14","5"=>"16",);


    return $arr[$time];
}




?>
@section('script')
    <script src="./assets/vendors/custom/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>

@stop

@section('style')
    <link href="./assets/vendors/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
<script>
    $( "#timetable" ).addClass( "kt-menu__item--here" );

</script>
    <style>
        .fc-time-grid .fc-slats td {
            height: 5em;
        }
        .fc-left{
            display: none;
        }
        .fc-content:before{
            background: #e2e5ec00!important;
        }
    </style>
@stop

@section('content')

    <div class=col-sm-12">
        <div class="kt-portlet kt-portlet--mobile" >

            <div class="kt-portlet__body" style="height:100px">


                <div id="kt_calendar">

<form method="post" action="{{route('time_table.generate')}}"   >

@csrf

    <<button type="submit" class="btn btn-lg btn-primary" style="position: absolute; left: 41%; margin-left: auto; background: #374afb; margin-right: auto; border: navajowhite; color: white;">Start Generating Timetable</button>




</form>              </div>


            </div>
        </div>
    </div>




@stop
