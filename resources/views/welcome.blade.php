<?php


function reWriteWeekResult($day){

    return $day+1;

}
function reWriteColorResult($index){

    return array("Blue", "Green", "Bronze", "#fd397a", "Purple", "Black", "#5da549", "grey", "Capri")[$index-1];
}
function reWriteTimeResult($time){

    $arr = array("0"=>"08","1"=>"10","2"=>"12","3"=>"14","4"=>"16",);


    return $arr[$time];
}


?>



    <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.css" />

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div id="kt_calendar" style="height: 800px;"></div>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://fullcalendar.io/js/fullcalendar-2.4.0/lib/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.js"></script>
<script>

    var data = [
            @foreach($data as $key=>$item)

        {
            title: '{{$item['course_name']}}',
            start: '2019-04-0{{reWriteWeekResult($item["day"])}}T{{reWriteTimeResult($item['time_slot'])}}:00:00+00:00',
            color: '{{reWriteColorResult($item['semester'])}}' // override!

        },
        @endforeach

    ];

    $(document).ready(function() {

        $('#kt_calendar').fullCalendar({
            minTime: "08:00:00",
            maxTime: "18:00:00",
            header: {
                right: 'week'
            },        weekends: false,
            weekMode: 'fixed',
            columnFormat: 'ddd',
            defaultDate: '2019-04-01',
            defaultView: 'agendaWeek',
            defaultTimedEventDuration: '02:00',
            allDaySlot: false,
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            events: data
        });


    });


</script>
</html>
