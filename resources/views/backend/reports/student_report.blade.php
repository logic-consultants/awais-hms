@extends('layouts.backend')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="panel-title">{{ _lang('Student List Report') }}</span>
            </div>
            
            <div class="panel-body">
                <form id="search_form" class="params-panel validate" action="{{ url('reports/student_report/view') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">{{ _lang('Floor') }}</label>
                            <select name="class_id" class="form-control select2" onChange="getData(this.value);" required>
                                <option value="">{{ _lang('Select Floor') }}</option>
                                {{ create_option('classes','id','class_name',$class_id) }}
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">{{ _lang('Room') }}</label>
                            <select name="section_id" class="form-control select2">
                                <option value="">{{ _lang('All Rooms') }}</option>
                                @if($class_id != 0)
                                    {{ create_option('sections','id','section_name',$section_id, array("class_id="=>$class_id)) }}
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <button type="submit" style="margin-top:24px;" class="btn btn-primary btn-block">{{ _lang('View Report') }}</button>
                        </div>
                    </div>
                </form>

                @if(isset($students))
                
                <div class="col-md-12">
                     <button type="button" onclick="printReport()" class="btn btn-primary btn-sm pull-right"><i class="fa fa-print"></i> {{ _lang('Print Report') }}</button>
                </div>

                <div class="col-md-12 params-panel">
                    <div class="text-center clear">
                        <h3 style="margin-bottom:0;">{{ get_option('school_name') }}</h3>
                        <h4 style="margin-top:5px;">{{ _lang('Student List Report') }}</h4>
                        <p><b>{{ _lang('Floor') }}:</b> {{ $class_name }} | <b>{{ _lang('Room') }}:</b> {{ $section_name }}</p>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">{{ _lang('Photo') }}</th>
                                    <th>{{ _lang('Name') }}</th>
                                    <th>{{ _lang('CNIC') }}</th> 
                                    <th>{{ _lang('Phone') }}</th>
                                    <th>{{ _lang('Room') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                <tr>
                                    <td class="text-center">
                                        <img src="{{ $student->photo ? asset('uploads/images/'.$student->photo) : asset('uploads/images/profile.png') }}" 
                                             style="width:50px; height:50px; object-fit:cover; border:1px solid #ddd; border-radius:4px;">
                                    </td>
                                    <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                    <td>{{ $student->cnic ?? $student->activities }}</td> 
                                    <td>{{ $student->phone }}</td>
                                    <td><b>{{ $student->room_name }}</b></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="print_content" style="display: none;">
                    <div style="text-align: center; margin-bottom: 20px;">
                        <h2 style="margin:0; padding:0;">{{ get_option('school_name') }}</h2>
                        <h3 style="margin:5px 0; padding:0;">{{ _lang('Student List Report') }}</h3>
                        <p style="margin:5px 0;">
                            <b>{{ _lang('Floor') }}:</b> {{ $class_name }} | 
                            <b>{{ _lang('Room') }}:</b> {{ $section_name }}
                        </p>
                    </div>
                    
                    <table style="width: 100%; border-collapse: collapse; font-family: sans-serif; font-size: 12px;">
                        <thead>
                            <tr>
                                <th style="border: 1px solid #000; padding: 5px; width: 10%;">{{ _lang('Photo') }}</th>
                                <th style="border: 1px solid #000; padding: 5px; width: 25%;">{{ _lang('Name') }}</th>
                                <th style="border: 1px solid #000; padding: 5px; width: 25%;">{{ _lang('CNIC') }}</th> 
                                <th style="border: 1px solid #000; padding: 5px; width: 15%;">{{ _lang('Phone') }}</th>
                                <th style="border: 1px solid #000; padding: 5px; width: 25%;">{{ _lang('Room') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                            <tr>
                                <td style="border: 1px solid #000; padding: 5px; text-align: center;">
                                    @if($student->photo)
                                        <img src="{{ asset('uploads/images/'.$student->photo) }}" style="width:40px; height:40px; object-fit: cover;">
                                    @else
                                        -
                                    @endif
                                </td>
                                <td style="border: 1px solid #000; padding: 5px;">{{ $student->first_name }} {{ $student->last_name }}</td>
                                <td style="border: 1px solid #000; padding: 5px;">{{ $student->cnic ?? $student->activities }}</td> 
                                <td style="border: 1px solid #000; padding: 5px;">{{ $student->phone }}</td>
                                <td style="border: 1px solid #000; padding: 5px;"><b>{{ $student->room_name }}</b></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('js-script')
<script type="text/javascript">
    // 1. AJAX for Rooms
    function getData(val) {
        var _token=$('input[name=_token]').val();
        $.ajax({
            type: "POST",
            url: "{{url('sections/section')}}",
            data:{_token:_token, class_id:val},
            beforeSend: function(){
                $("#preloader").css("display","block");
            },success: function(sections){
                $("#preloader").css("display","none");
                $('select[name=section_id]').html('<option value="">{{ _lang("All Rooms") }}</option>' + sections);                
            }
        });
    }

    
    function printReport() {
        // Grab the raw HTML from the hidden div
        var printContents = document.getElementById('print_content').innerHTML;
        
        // Open a new, blank window
        var myWindow = window.open('', '', 'width=900,height=600');
        
        // Write the HTML structure
        myWindow.document.write('<html><head><title>Student Report</title>');
        // Add minimal CSS to force black text and layout
        myWindow.document.write('<style>body{font-family: sans-serif;} table{width:100%;} th,td{border:1px solid #000; padding:5px; color:#000;}</style>');
        myWindow.document.write('</head><body>');
        myWindow.document.write(printContents);
        myWindow.document.write('</body></html>');
        
        // Finalize and print
        myWindow.document.close();
        myWindow.focus();
        setTimeout(function(){ 
            myWindow.print();
            myWindow.close();
        }, 500); // Slight delay ensures images load before printing
    }
</script>
@stop