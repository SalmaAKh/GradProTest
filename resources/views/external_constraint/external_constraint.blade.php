@extends('template.template')
<?php

function reWriteWeekResult($day){

    return $day;

}
function reWriteColorResult($index){

    return array("Blue", "Green", "Bronze", "Red", "Purple", "Black", "Brown", "grey", "Capri")[$index-1];
}
function reWriteTimeResult($time){

    $arr = array("1"=>"08","2"=>"10","3"=>"12","4"=>"14","5"=>"16",);


    return $arr[$time];
}




?>
@section('script')
    <script src="./assets/vendors/custom/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>

<script>

    $( "#time_constraint" ).addClass( "kt-menu__item--here" );
    var full_data =   [
            @foreach(\App\OtherDepartmentConstraint::get() as $key=>$item)

        {
            description: "{{$item->program_curriculum->course_code}}",
            title: "{{$item->program_curriculum->course_code}}",
            start: '2019-04-0{{reWriteWeekResult($item["day_id"])}}T{{reWriteTimeResult($item['hour_id'])}}:30:00+00:00',
            end: '2019-04-0{{reWriteWeekResult($item["day_id"])}}T{{reWriteTimeResult($item['hour_id']+1)}}:30:00+00:00',

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
                events: full_data,

                dateClick: function(info) {
                    console.log(info)
                    alert('Clicked on: ' + info.dateStr);
                    alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
                    alert('Current view: ' + info.view.type);
                    // change the day's background color just for fun
                    info.dayEl.style.backgroundColor = 'red';
                },
                selectable : true,
                select: function(start, end, jsEvent, view) {

                    start = moment(start).format();
                    end = moment(end).format();


                     var allDay = !start.hasTime && !end.hasTime;
                    var newEvent = new Object();
                    newEvent.title = selected[1];
                    newEvent.start = moment(start).format();
                    newEvent.end = moment(end).format();
                    newEvent.course_id = selected[1];
                    newEvent.allDay = false;
                    $('#kt_calendar').fullCalendar('renderEvent', newEvent);





                },
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
                        element.find('.fc-title').append('<div class="fc-description">' + event.description + '</div>');
                    } else if (element.find('.fc-list-item-title').lenght !== 0) {
                        element.find('.fc-list-item-title').append('<div class="fc-description">' + event.description + '</div>');
                    }

                    element.append( "<a href='javascript:;' class='flaticon2-close-cross delete' style='font-size: 15px; position: absolute; left: 8px; top: 5px; color: #fd397a;z-index:100000000000000'></a>" );
                    element.find(".delete").click(function() {
                        $('#kt_calendar').fullCalendar('removeEvents',event._id);
                    });
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
        $('#main').hide();
    });

var selected ;
    $('#course').on('change',function () {


        selected = [this.value,$(this).find(':selected').data('name')];
        $('#main').fadeIn();




        });

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





</script>

@stop

@section('style')
    <link href="./assets/vendors/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />

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


    <div class="col-sm-12" id="sub">
        <div class="kt-portlet kt-portlet--mobile" >
                        <div class="kt-portlet__body">

                <div class="form-group row">
                    <label class="col-lg-2 col-form-label">Course Name : </label>
                    <div class="col-lg-8">
                        <select class="form-control" id="course">

                            @foreach(\App\ProgramCurriculum::whereIn('department_id',[4,5])->get() as $course)
                            <option value="{{$course->id}}" data-name="{{$course->course_code}}">{{$course->course_name}} - {{$course->course_code}} </option>
                            @endforeach
                        </select>
                    </div>

                </div>


            </div>
        </div>
    </div>

    <div class=col-sm-12  id="main">
        <div class="kt-portlet kt-portlet--mobile" >
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <button style="position: absolute; right: 25px" type="button" class="btn btn-success" id="save">save</button>
                </div>
            </div>
            <div class="kt-portlet__body">


            <div id="kt_calendar"></div>


            </div>
        </div>
    </div>





@stop
