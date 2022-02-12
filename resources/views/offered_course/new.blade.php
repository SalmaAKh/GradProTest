@extends('template.template')




@section('style')

    <style>
        .cloning:first-child ,  .cloning:nth-child(2){

            margin-top: 0!important;
        }
    </style>
    @stop

@section('script')
<script>
    $( "#offered_courses" ).addClass( "kt-menu__item--here" );


    $('#add_new').on('click', function() {


        $('#clonable').clone().appendTo( "#base" );;

    });
</script>
<script>
    $('.remove').on('click',function () {
        $(this).parent().remove();

    })
</script>
    @stop
@section('content')


    <div class="container">
    <div class="row">
        <div class="col-lg-12" >
            <!--begin::Portlet-->
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            Add Offered Course
                        </h3>
                    </div>
                </div>
                <!--begin::Form-->
                <form class="kt-form kt-form--label-right" method="post" action="{{route('offeredcourse.store')}}">
                    <div class="kt-portlet__body">
                        {{csrf_field()}}
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label>Courses Code</label>
                                <select class="form-control" name="program_curriculum_id">
                                    @foreach(App\ProgramCurriculum::where('department_id','<','4')->get() as $code)
                                        <option value="{{$code->id}}">{{$code->course_code}}</option>
                                    @endforeach
                                </select>


                            </div>

                        </div>
                        <div class="form-group row" id="base" style="position: relative;">
                            <div class="col-lg-5 cloning " id="clonable" style="margin-top: 20px;margin-left: 20px;" >
                                <label>Instructors:</label>
                                <a href="javascript:;" onclick="$(this).closest('#clonable').remove();"> <i class="fa fa-trash" style="position: absolute; left: -10px; bottom: 33px; font-size: 16px;"></i></a>
                                <div class="kt-input-icon">

                                    <select class="form-control" name="instructor_id[]">
                                        @foreach(App\Instructor::all() as $Instructor)
                                            <option value="{{$Instructor->id}}">{{$Instructor->user->name}}</option>
                                        @endforeach
                                    </select>

                                 </div>
                                <span class="form-text text-muted"> Select the instructor </span>
                            </div>

                        </div>
                     </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions" >
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-primary" >Save</button>
                                    <a  id="add_new" class="btn btn-warning" style="cursor: pointer;background: #374afb; border: unset; color: white;" >add new group</a>


                                </div>

                            </div>
                        </div>
                    </div>
                </form>
                <!--end::Form-->
            </div>
            <!--end::Portlet-->


        </div>
    </div>
    </div>
<style>


    @media (min-width: 1024px)
    {
        #clonable:nth-child(even){
            margin-left:160px!important
        }

    }

    #clonable:first-child a {
        display:none;
    }
</style>

@stop
