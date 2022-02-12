<?php


function reWriteWeekResult($day){

    return $day+1;

}
function reWriteColorResult($index){

    return array("Blue", "Green", "#006e8f", "#fd397a", "Purple", "Black", "Brown", "Grey", "Capri")[$index-1];
}
function reWriteTimeResult($time){

    $arr = array("0"=>"08","1"=>"10","2"=>"12","3"=>"14","4"=>"16","5"=>"18",);


    return $arr[$time];
}


?>


@extends('template.template')




@section('style')
    <link href="./assets/vendors/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />

    <style>
       . .fc-time-grid .fc-slats td {
            height: 5em;
        }

        .fc-time-grid .fc-slats td {
            height: 5em;
        }
        .fc-left{
            display: none;
        }
        .fc-content:before{
            background: #e2e5ec00!important;
        }

       .fc-content .fc-title , .fc-content .fc-time{
            color:white!important;
        }


    </style>
@stop



@section('script')

    <script src="./assets/vendors/custom/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>


    <script>

        var data = [
                @foreach($data as $key=>$item)

            {

                room_id: '{{$item['hall_id']}}',
                event_type: '{{$item['event_type']}}',
                group_id: '{{$item['group_id']}}',
                semester: '{{$item['semester']}}',
                program_curriculum_id: '{{$item['program_curriculum_id']}}',
                instructor_id: '{{$item['instructor_id']}}',
                time_slot: '{{$item['time_slot']}}',
                title: '{{$item['course_name']}}',
                start: '2019-04-0{{reWriteWeekResult($item["day"])}}T{{reWriteTimeResult($item['time_slot'])}}:30:00+00:00',
                end: '2019-04-0{{reWriteWeekResult($item["day"])}}T{{reWriteTimeResult($item['time_slot']+1)}}:30:00+00:00',
                color: '{{reWriteColorResult($item['semester'])}}', // override!
                description: "{{$item['course_name']}}", // override!


            },
            @endforeach

        ];

        var KTCalendarExternalEvents = function() {



            var initCalendar = function() {
                var calendar = $('#kt_calendar');
                var todayDate = moment("2019-04-01").startOf('day');
                var YM = todayDate.format('YYYY-MM');
                var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
                var TODAY = todayDate.format('YYYY-MM-DD');
                var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');
                calendar.fullCalendar({
                    plugins: [ 'interaction', 'weekGrid' ],
                    minTime: "08:30:00",
                    maxTime: "18:30:00",
                    header: {
                        right: 'week'
                    },        weekends: false,
                    weekMode: 'fixed',
                    columnFormat: 'ddd',
                    defaultDate: '2019-04-01',
                    defaultView: 'agendaWeek',
                    defaultTimedEventDuration: '02:00',
                    allDaySlot: false,
                    events: data,


                    selectable : false,

                    contentHeight:"auto",     //specific height instead of auto
                    slotDuration: '02:00:00',
                    eventLimit: true, // allow "more" link when too many events
                    editable: true,
                    eventDurationEditable: false,
                    views: {
                        dayGrid: {
                            eventLimit:1
                        },
                        timeGrid: {
                            eventLimit:1
                        },
                        week: {
                            eventLimit:1
                        },
                        day: {
                            eventLimit:1                        }
                    },

                    eventRender: function(event, element) {
                        // default render
                        if (element.hasClass('fc-day-grid-event')) {
                            element.data('content', event.description);
                            element.data('placement', 'top');
                            KTApp.initPopover(element);
                        } else if (element.hasClass('fc-time-grid-event')) {
                            element.find('.fc-title').append('<div class="fc-description">' + event.description + '</div>');
                        } else if (element.find('.fc-list-item-title').lenght !== 0) {
                            element.find('.fc-list-item-title').append('<div class="fc-description">' + event.description + '</div>');
                        }


                    }
                });
            }

            return {
                //main function to initiate the module
                init: function() {
                    initCalendar();
                }
            };
        }();

        jQuery(document).ready(function() {
            KTCalendarExternalEvents.init();

            $('.loading').fadeOut('slow')
        });

        $('#save').on('click',function () {

            var timeSlot = ["08","10","12","14","16"];

            var data = JSON.stringify($("#kt_calendar").fullCalendar("clientEvents").map(function(e) {

                return {
                    day_id: moment(e.start).day() ,
                    hour_id:   timeSlot.indexOf( moment(e.start).format('HH'))+1,
                    room_id:   e.room_id,
                    program_curriculum_id: e.program_curriculum_id,
                    instructor_id: e.instructor_id,
                    group_id: e.group_id,
                    event_type: e.event_type,

                };
            }));

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                /* the route pointing to the post function */
                url: "{{route('timetable.store_generation_table')}}",
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {_token: CSRF_TOKEN, data:JSON.parse(data)},
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    Swal.fire(
                        'Success',
                        'Your Data Added Successfully',
                        'success'
                    )

                    setTimeout(function () {
                        window.location = '{{route('timetable.view')}}';
                    },500)
                },
                error:function (data) {
                    Swal.fire(
                        'error',
                        'You have an error',
                        'error'
                    )
                }
            });




        })




        $( "#timetable" ).addClass( "kt-menu__item--here" );

    </script>



@stop



@section('content')

<img class="loading" src="https://ui-ex.com/images/background-transparent-loading-3.gif" style="position: fixed; top: 50%; z-index: 100000000; right: 42%;">
    <div class="col-sm-12" id="main" >
        <div class="kt-portlet kt-portlet--mobile" >
             <a href="javascript:;" id="save" class="btn btn-warning" style="position: absolute; background: #374afb; border: unset; color: white; width: 144px; right: 35px; top: 10px;">Save Timetable</a>

            <div class="kt-portlet__body">

                <div id="kt_calendar" style="height: 800px;"></div>


            </div>
        </div>
    </div>



@stop
