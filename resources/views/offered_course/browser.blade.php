@extends('template.template')

@section('content')

 

<div class="col-md-12 ">
                                <!-- BEGIN Portlet PORTLET-->
                                <div class="portlet box blue-hoki">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-gift"></i>Offered Courses </div>
                                        <div class="actions">
                                    
                                            <a href="/api/admin/offered_course/new" class="btn btn-default btn-sm">
                                                <i class="fa fa-plus"></i> Add  new course</a>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                               
                                        

<table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Course Code</th>
                <th>Course Name</th>
                <th>Instructor Name</th>
                <th>Delete</th>
               
            </tr>
        </thead>
        <tbody>
          @foreach(App\OfferedCourse::all() as $code)

            <tr>
                <td>{{$code->program_curriculum->course_code}}</td>
                <td>{{$code->program_curriculum->course_name}}</td>
                <td>{{$code->instructor->user->name}}</td>
                <td>
                    
                    <button type="button" class="btn red">
                                                                        <i class="fa fa-trash"></i> Delete</button>
                
                
                </td>
         
           
            </tr>
            @endforeach
 
        </tbody>
  
    </table>

                                        
                                        
                                        
                                    </div>
                                </div>
                                <!-- END Portlet PORTLET-->
                            </div>








@stop