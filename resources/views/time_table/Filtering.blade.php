@extends('template.template')
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
@section('script')
    <script src="./assets/vendors/custom/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>

    <script>



         var full_data = [
                @foreach(\App\OfferedCourse::all() as $key=>$item)

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
                room_id: "{{$item->room->room_id}}",
            },
            @endforeach
        ];


        "use strict";

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
                    events: [],

                    selectable : false,
                    contentHeight:"auto",     //specific height instead of auto
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
                    eventDragStop: function(e) {


                    },
                    eventResize: function(event, delta, revertFunc) {

                        //   revertFunc();

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

            $(" #room , .course , .semester , .instructor").on('change',function() {


                selected = $(this).find(':selected').data('name');

                var  events=    full_data.filter(function(e) {

                    if(e.room_id==selected||e.title==selected||e.instructor==selected||e.semester==selected)
                        return e;
                });

                $('#kt_calendar').fullCalendar( 'removeEvents');
                $('#kt_calendar').fullCalendar( 'addEventSource',events);
                $('#kt_calendar').fullCalendar( 'rerenderEvents' );



            })

        });

        var selected ;
;

        $('#save').on('click',function () {

            var timeSlot = ["08","10","12","14","16"];

            var data = JSON.stringify($("#kt_calendar").fullCalendar("clientEvents").map(function(e) {

                return {
                    day_id: moment(e.start).day() ,
                    hour_id:   timeSlot.indexOf( moment(e.start).format('HH'))+1,
                    course_id: selected[0],

                    //   department: e.department
                };
            }));

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                /* the route pointing to the post function */
                url: "{{route('course.constraint.store')}}",
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {_token: CSRF_TOKEN, message:JSON.parse(data)},
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (data) {
                    Swal.fire(
                        'Success',
                        'Your Data Added Successfully',
                        'success'
                    )
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

@section('content')

    <div class="row">
        <div class="col-sm-3" id="sub">
            <div class="kt-portlet kt-portlet--mobile" >
                <div class="kt-portlet__body">

                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label">Course: </label>
                        <div class="col-lg-8">
                            <select class="form-control course" id="course">
                                <option value="None" data-name="None">Not Selected </option>

                                @foreach(\App\ProgramCurriculum::whereIn('department_id',[1,2,3])->whereHas('offered_courses')->get() as $course)
                                    <option value="{{$course->id}}" data-name="{{$course->course_code}}">{{$course->course_name}} - {{$course->course_code}} </option>
                                @endforeach
                            </select>
                        </div>

                    </div>


                </div>
            </div>
        </div>

        <div class="col-sm-3" id="sub">
            <div class="kt-portlet kt-portlet--mobile" >
                <div class="kt-portlet__body">

                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label">Instructor</label>
                        <div class="col-lg-8">
                            <select class="form-control instructor" >
                                <option value="None" data-name="None">Not Selected </option>

                                @foreach(\App\User::whereHas('instructor.offered_courses')->get() as $instructor)
                                    <option value="{{$instructor->name}}" data-name="{{$instructor->name}}">{{$instructor->name}} </option>
                                @endforeach
                            </select>
                        </div>

                    </div>


                </div>
            </div>
        </div>


        <div class="col-sm-3" id="sub">
            <div class="kt-portlet kt-portlet--mobile" >
                <div class="kt-portlet__body">

                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label">Room: </label>
                        <div class="col-lg-8">
                            <select class="form-control" id="room">
                                <option value="None" data-name="None">Not Selected </option>

                                @foreach(\App\Room::whereHas('offered_courses')->get() as $room)
                                    <option value="{{$room->id}}" data-name="{{$room->room_id}}">{{$room->room_id}} </option>
                                @endforeach
                            </select>
                        </div>

                    </div>


                </div>
            </div>
        </div>


        <div class="col-sm-3" id="sub">
            <div class="kt-portlet kt-portlet--mobile" >
                <div class="kt-portlet__body">

                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label">Semester</label>
                        <div class="col-lg-8">
                            <select class="form-control semester" >
                                <option value="None" data-name="None">Not Selected </option>



                                @foreach(range(1,8) as $semester)
                                    <option value="{{$semester}}" data-name="{{$semester}}">{{$semester}} </option>
                                @endforeach
                            </select>
                        </div>

                    </div>


                </div>
            </div>
        </div>

    </div>
    <div class=col-sm-12  id="main" >
        <div class="kt-portlet kt-portlet--mobile" >
            <div class="kt-section__content kt-section__content--solid" style="margin-left:11px;margin-top: -50px; margin-bottom: -40px; ">
                <span style="color: green; margin-left: 17px; font-weight: 500;" > <i  class="fa fa-laptop"></i> Lab session  </span>
                <span style="color: green; margin-left: 17px; font-weight: 500;" > <i  class="fa fa-book-open" style="margin-right: 5px"></i>Tutorial session  </span>

                @foreach(array("Blue", "Green", "#006e8f", "#fd397a", "Purple", "Black", "#5da549", "Grey", "Capri") as $key=>$color)
                    @if($loop->last)  @continue @endif
                    <span class="kt-badge kt-badge--danger kt-badge--lg kt-badge--rounded" style="margin-top: 14px;font-weight: 500;background: {{$color}};height: 22px; width: 100px; font-size: 1rem; margin-left: 10px;">Semester {{$key+1}}</span>
                @endforeach

            </div>

            <div class="kt-portlet__body" style="border-top: 1px solid #dedede;;">


                <div id="kt_calendar"></div>


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
