@extends('template.template')

@section('content')


<div class="tab-pane active" id="tab_1">
                                            <div class="portlet box blue">
                                                <div class="portlet-title">
                                                    <div class="caption">
                                                        <i class="fa fa-gift"></i>Create New Offered Course </div>
                                                 
                                                    
                                                </div>
                                                <div class="portlet-body form">
                                                    <!-- BEGIN FORM-->
                                                    <form action="#" class="horizontal-form">
                                                        <div class="form-body">
                                                            <h3 class="form-section">Offerd Courses</h3>
                                                    
                                                            <!--/row-->
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Courses Code</label>
                                                                        <select class="form-control">
                                                                            @foreach(App\ProgramCurriculum::all() as $code)
                                                                            <option value="{{$code->id}}">{{$code->course_code}}</option>
                                                                            @endforeach
                                                                         </select>
                                                                        <span class="help-block"> Select your Course </span>
                                                                    </div>
                                                                </div>
                                                                <!--/span-->
                                                                       <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Instructors</label>
                                                                        <select class="form-control">
                                                                           @foreach(App\Instructor::all() as $Instructor)
                                                                            <option value="{{$Instructor->id}}">{{$Instructor->user->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <span class="help-block"> Select the instructor </span>
                                                                    </div>
                                                                </div>
                                                                <!--/span-->
                                                            </div>
                                                 
                                                            
                                                        </div>
                                                        <div class="form-actions right">
                                                            <button type="button" class="btn default">Cancel</button>
                                                            <button type="submit" class="btn blue">
                                                                <i class="fa fa-check"></i> Save</button>
                                                        </div>
                                                    </form>
                                                    <!-- END FORM-->
                                                </div>
                                            </div>
                                           
                                            </div>
 

@stop