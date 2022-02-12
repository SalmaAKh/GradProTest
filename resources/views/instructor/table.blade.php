<?php


function reWriteWeekResult($day){

    return $day+1;

}
function reWriteColorResult($index){

    return array("Blue", "Green", "#006e8f", "#fd397a", "Purple", "Black", "#5da549", "Grey", "Capri")[$index-1];
}
function reWriteTimeResult($time){

    $arr = array("0"=>"08","1"=>"10","2"=>"12","3"=>"14","4"=>"16","5"=>"18",);


    return $arr[$time-1];
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
        $( "#instructor" ).addClass( "kt-menu__item--here" );

        var data = [
                @foreach(\App\OfferedCourse::where('instructor_id',auth()->user()->instructor->id)->get() as $key=>$item)

            {

                event_type: '{{$item['event_type']}}',
                group_id: '{{$item['group_id']}}',
                semester: '{{$item['semester']}}',
                instructor: '{{$item->instructor->user->name}}',
                time_slot: '{{$item['time_slot']}}',
                title: '{{$item->program_curriculum->course_code}}',
                start: '2019-04-0{{reWriteWeekResult($item["day_id"]-1)}}T{{reWriteTimeResult($item['hour_id'])}}:30:00+00:00',
                end: '2019-04-0{{reWriteWeekResult($item["day_id"]-1)}}T{{reWriteTimeResult($item['hour_id']+1)}}:30:00+00:00',
                color: '{{reWriteColorResult($item['semester'])}}',
                description: "{{$item->room->room_id}}",
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

                    contentHeight:375,     //specific height instead of auto
                    slotDuration: '02:00:00',
                    eventLimit: true, // allow "more" link when too many events
                    editable: false,
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
                            element.find('.fc-title').append('<span class="fc-description">' + event.description + '</span>');
                        } else if (element.find('.fc-list-item-title').lenght !== 0) {
                            element.find('.fc-list-item-title').append('<span class="fc-description">' + event.description + '</span>');
                        }
                         element.find('.fc-description').append('<span  class="kt-badge kt-badge--success  kt-badge--inline kt-badge--pill" style="width: 50px; display: block; margin-left: -9px; margin-top: -3px;; background:unset;">group: '+event.group_id+'</span>');

                        if(event.event_type==2){
                            element.find('.fc-content').append('<i  style="position: absolute; top: 7px; left: 7px; color: white;" class="fa fa-book-open"></i>');

                        }

                       else if(event.event_type==3){
                            element.find('.fc-content').append('<i style="position: absolute; top: 7px; left: 7px; color: white;" class="fa fa-laptop"></i>');

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





    </script>



@stop



@section('content')

    <img class="loading" src="https://ui-ex.com/images/background-transparent-loading-3.gif" style="position: fixed; top: 50%; z-index: 100000000; right: 42%;">
    <div class="col-sm-12" id="main" >
        <div class="kt-portlet kt-portlet--mobile" >

            <div class="kt-portlet__body">

                <div id="kt_calendar" style="height: 800px;"></div>


            </div>
        </div>
    </div>


<style>
    .fc-unthemed .fc-description {  color: #ffffff;     line-height: 0.5;}
    .fc-content * {
        font-size: 10px!important;
        display: block;
    }
</style>
@stop
