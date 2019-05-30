@extends('template.template')

@section('style')
    <link href="./assets/vendors/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
@stop
@section('script')
    <script src="./assets/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
    <script>


        $( "#offered_courses" ).addClass( "kt-menu__item--here" );

        jQuery(document).ready(function() {

            $('#kt_table_1').DataTable();

        });

    </script>
@stop



@section('content')
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
			<span class="kt-portlet__head-icon">
				<i class="kt-font-brand flaticon2-line-chart"></i>
			</span>
                <h3 class="kt-portlet__head-title">
                    Basic
                </h3>
            </div>
         </div>

        <div class="kt-portlet__body">
            <!--begin: Datatable -->
            <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                <thead>
                <tr>
                     <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Instructor Name</th>
                    <th>Delete</th>

                </tr>
                </thead>

                <tbody>
                @foreach(\App\OfferedCourse::groupBy('program_curriculum_id','instructor_id')->get() as $code)
                    <tr>
                        <td>{{$code->program_curriculum->course_code}}</td>
                        <td>{{$code->program_curriculum->course_name}}</td>
                        <td>{{$code->instructor->user->name}}</td>
                        <td>
                            <a  class="btn red" href="{{route('offeredcourse.delete',$code->id)}}" style="padding-top: 5px;padding-bottom: 5px;    padding-right: 2px;    padding-left: 5px;
" >
                                <i class="flaticon-delete"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
            <!--end: Datatable -->
        </div>
    </div>



@stop
