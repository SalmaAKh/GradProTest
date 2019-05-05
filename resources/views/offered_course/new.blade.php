@extends('template.template')




@section('content')


    <div class="container">
    <div class="row">
        <div class="col-lg-12">
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
                <form class="kt-form kt-form--label-right">
                    <div class="kt-portlet__body">
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label>Courses Code</label>
                                <select class="form-control" >
                                    @foreach(App\ProgramCurriculum::all() as $code)
                                        <option value="{{$code->id}}">{{$code->course_code}}</option>
                                    @endforeach
                                </select>


                            </div>

                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>Instructors:</label>
                                <div class="kt-input-icon">

                                    <select class="form-control" >
                                        @foreach(App\Instructor::all() as $Instructor)
                                            <option value="{{$Instructor->id}}">{{$Instructor->user->name}}</option>
                                        @endforeach
                                    </select>

                                 </div>
                                <span class="form-text text-muted"> Select the instructor </span>
                            </div>
                            <div class="col-lg-6">
                                <label class="">Group Number:</label>
                                <div class="kt-input-icon">

                                    <select class="form-control" >
                                        @foreach(App\Instructor::all() as $groupnum)
                                            <option value="{{$groupnum->program_curriculum_id}}">{{$groupnum->groub_number}}</option>
                                        @endforeach
                                    </select>


                                 </div>
                                <span class="form-text text-muted"> Select the group number </span>
                            </div>
                        </div>
                     </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="reset" class="btn btn-primary">Save</button>
                                    <button type="reset" class="btn btn-secondary">Cancel</button>
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


@stop
