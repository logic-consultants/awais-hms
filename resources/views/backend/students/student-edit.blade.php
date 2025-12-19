@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title" >
					<i class="entypo-plus-circled"></i>{{_lang('Update  Student')}}
				</div>
			</div>
			<div class="panel-body">
			  <div class="col-md-10">
				<form action="{{route('students.update',$student->id)}}" autocomplete="off" class="form-horizontal form-groups-bordered validate" enctype="multipart/form-data" method="post" accept-charset="utf-8">
					@csrf
					{{ method_field('PATCH') }}
					<input type="hidden" value="1" name="guardian">
					<div class="row">

					<div class="col-md-6">

					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('First Name')}}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="first_name" value="{{ $student->first_name }}" required>
						</div>
					</div>
					</div>
					

					<div class="col-md-6">
					
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang("Father's Name")}}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="father_name" value="{{ $student->father_name }}" required>
						</div>
					</div>

					</div>

					<div class="col-md-6">

					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Birthday')}}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control datepicker" name="birthday" value="{{$student->birthday}}" required>
						</div>
					</div>
					</div>

					<div class="col-md-6">
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Gender')}}</label>
						<div class="col-sm-9">
							<select name="gender" class="form-control select2" required>
								<option @if($student->gender=='Male') selected @endif value="Male">Male</option>
								<option @if($student->gender=='Female') selected @endif value="Female">Female</option>
							</select>
						</div>
					</div>
					</div>

					
					<div class="col-md-6">
					
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Blood Group')}}</label>
						<div class="col-sm-9">
							<select name="blood_group" class="form-control select2">
								<option value="">{{ _lang('Select One') }}</option>
								<option @if($student->blood_group=='N/A') selected @endif value="N/A">N/A</option>
								<option @if($student->blood_group=='A+') selected @endif value="A+">A+</option>
								<option @if($student->blood_group=='A-') selected @endif value="A-">A-</option>
								<option @if($student->blood_group=='B+') selected @endif value="B+">B+</option>
								<option @if($student->blood_group=='B-') selected @endif value="B-">B-</option>
								<option @if($student->blood_group=='AB+') selected @endif value="AB+">AB+</option>
								<option @if($student->blood_group=='AB-') selected @endif value="AB-">AB-</option>
								<option @if($student->blood_group=='O+') selected @endif value="O+">O+</option>
								<option @if($student->blood_group=='O+') selected @endif value="O-">O-</option>
							</select>
						</div>
					</div>

					</div>

					<div class="col-md-6">
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Religion')}}</label>
						<div class="col-sm-9">
						    <select name="religion" class="form-control niceselect wide">
								<option value="">{{ _lang('Select One') }}</option>
								{{ create_option("picklists","value","value",$student->religion,array("type="=>"Religion")) }}	
							</select>
						</div>
					</div>
					</div>

					<div class="col-md-6">
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Phone')}}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control phoneNumber"  name="phone" value="{{ $student->phone }}" required>
						</div>
					</div>
					</div>

					<div class="col-md-6">
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Home Phone')}}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control phoneNumber" name="home_phone" value="{{ $student->home_phone }}">
						</div>
					</div>
					</div>

					<div class="col-md-6">
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Address')}}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="address" value="{{$student->address}}">
						</div>
					</div>
					</div>

					<div class="col-md-6">
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('State')}}</label>
						<div class="col-sm-9">
									<select name="state" class="form-control select2" required>
											{{ get_country_states($student->state, 'Pakistan') }}
									</select>
						</div>
					</div>
					</div>

					<div class="col-md-6">
					<input type="hidden" value="{{ $student->ss_id }}" name="ss_id">
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Country')}}</label>
						<div class="col-sm-9">
							<select name="country" class="form-control select2" required>
								{{ get_country_list($student->country) }}
							</select>
						</div>
					</div>
					</div>

					<div class="col-md-6">
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Floor')}}</label>
						<div class="col-sm-9">
							<select name="class" class="form-control select2" id="class" required>
								<option value="">{{ _lang('Select One') }}</option>
								{{ create_option('classes','id','class_name',$student->class_id) }}
							</select>
						</div>
					</div>
					</div>

					<div class="col-md-6">
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Room')}}</label>
						<div class="col-sm-9">
							<select name="section" class="form-control niceselect wide" id="section" required>
								<option value="">{{ _lang('Select One') }}</option>
								@foreach($sections AS $data)
								<option data-class="{{$data->class_id}}" @if($student->section_id==$data->id) selected @endif value="{{$data->id}}">{{ $data->section_name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					</div>

					<div class="col-md-6">
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Group')}}</label>
						<div class="col-sm-9">
							<select name="department" class="form-control select2" required>
								<option value="">{{ _lang('Select One') }}</option>
								{{ create_option('departments','id','department_name',$student->department_id) }}
							</select>
						</div>
					</div>
					</div>
					
					<div class="col-md-6">
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Register NO')}}</label>
						<div class="col-sm-9">
							<input type="number" class="form-control" id="register_no" name="register_no" value="{{$student->register_no}}" required>
						</div>
					</div>
					</div>

					<div class="col-md-6">
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Student CNIC ')}}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="activities" name="activities" value="{{$student->activities}}">
						</div>
					</div>
					</div>

					<div class="col-md-6">
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Remarks')}}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="remarks" value="{{$student->remarks}}">
						</div>
					</div>
					</div>


					<div class="form-group">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<span>{{ _lang('Student Fees') }}</span>
									<button type="button" class="btn btn-danger pull-right" id="add-item-row-assign" style="margin-top:-7px;margin-left:10px;">{{ _lang('Add New Row') }}</button>
								</div>

								<div class="panel-body @if(count($assign_fees)>0)@else d-none @endif" id="invoice_assign_div">
								    
								  <table class="table">
									<thead style="background:#dce9f9;">
										<th>{{ _lang('Fee Type') }}</th>
										<th style="text-align:left">{{ _lang('Amount')." ".get_option('currency_symbol') }}</th>
										<th style="text-align:left">{{ _lang('Discount')." ".get_option('currency_symbol') }}</th>
										<th style="text-align:left">{{ _lang('Total')." ".get_option('currency_symbol') }}</th>		  
									</thead>
									<tbody id="invoice_assign">
										@if(count($assign_fees)>0)
										@foreach($assign_fees as $item)				
									   <tr>
										 <td width="40%">{!! get_fee_selectbox('select2',$item->fee_id) !!}</td>
										 <td><input type="number" class="form-control float-field amount" name="amount[]"value="{{ $item->amount }}"></td>
										 <td><input type="number" class="form-control float-field discount" name="discount[]"value="{{ $item->discount }}"></td>
										 <td><input type="number" class="form-control float-field total" name="sub_total[]"value="{{ $item->amount-$item->discount }}" readOnly="true"></td>
									   </tr>
								    	@endforeach
								    	@endif
									</tbody>
									<tfoot>
										<tr>
											<td class="text-right" colspan="3"><label class="control-label">{{ _lang('Total') }}</label></td>
											<td><input type="text" class="form-control" id="total_assign" name="total" value="{{ $assign_fees->sum('amount') - $assign_fees->sum('discount') }}" readOnly="true"></td>
										</tr>
									</tfoot>
								  </table>
								  
								</div>
								
							</div>
						</div>
					</div>
					
					<hr>
					<div class="page-header">
					  <h4>Login Details</h4>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Email')}}</label>
						<div class="col-sm-9">
							<input type="email" class="form-control" name="email" value="{{$student->email}}" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Password')}}</label>
						<div class="col-sm-9">
							<input type="password" class="form-control" name="password">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Confirm Password')}}</label>
						<div class="col-sm-9">
							<input type="password" class="form-control" name="password_confirmation">
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Profile Picture')}}</label>
						<div class="col-sm-9">
							<input type="file" class="form-control dropify" data-default-file="{{ asset('uploads/images/'.$student->image) }}" name="image" data-allowed-file-extensions="jpg jpeg JPG JPEG png PNG">
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info">Update Student</button>
						</div>
					</div>
				</form>
			   </div>	
			    <table style="display:none;">
					<tr id="fee_row_assign">
					   <td width="40%">{!! get_fee_selectbox() !!}</td>
					   <td><input type="number" min="0" value="0" class="form-control float-field amount" name="amount[]"></td>
					   <td><input type="number" value="0" class="form-control float-field discount" min="0" name="discount[]"></td>
					   <td><input type="number" value="0" class="form-control float-field total" name="sub_total[]" readOnly="true"></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection

@section('js-script')
<script>
$(window).on('load', function() {
    
     $('#phone').mask("929999999999");
     $('#activities').mask("09999-9999999-9");
     if($('#register_no').val()=="")
     {
         $('#register_no').val(Math.floor((Math.random() * 99999999) + 1)) ;
     }    
    
    
	//$("#section").next().find("ul li").css("display","none");
	var class_id = $("#class").val();
	$('#section option[data-class="' + class_id + '"]').each(function(){
		var section_id = $(this).val();
		$("#section").next().find("ul li[data-value='" + section_id + "']").css("display","block");
	});
	
	load_option_subject();
	
	$(document).on('change','#class',function(){
		load_option_subject();
	});

	$(document).on('click','#add-item-row-assign',function(){
		var row = $("#fee_row_assign").clone();
		$('#invoice_assign_div').removeClass('d-none');		
		$(row).removeAttr( "id" );		
		$(row).find('select').select2();		
		$("#invoice_assign").append(row);		
	});
	
	$(document).on('keyup','.amount,.discount',function(){
		var amount = parseFloat($(this).closest("tr").find(".amount").val());
		var discount = parseFloat($(this).closest("tr").find(".discount").val());
		$(this).closest("tr").find(".total").val(amount-discount);
        
		//Show Total Amount
		var total = 0;
		jQuery("#invoice_assign > tr").each(function () {
		    var sub_total = parseFloat($(this).find(".total").val());
			total +=sub_total;
		});	

        $("#total_assign").val(total);		
	});
	
	
	function load_option_subject(){
		var class_id = $("#class").val();
		var link = "{{ url('students/get_subjects/') }}";
		$.ajax({
			url: link+"/"+class_id,
			success: function(data){		
				$('#optional_subject').html(data);	
                $('#optional_subject').val("{{ $student->optional_subject }}");				
			}
		});
	}

		$('.phoneNumber').on('input', function () {
	 let input = $(this).val().replace(/\D/g, ''); // Remove non-digits
    if (input.length > 11) input = input.substring(0, 11); // Limit to 11 digits

    let formatted = '';

    if (input.length < 5) {
        formatted = '(' + input;
    } else if (input.length < 8) {
        formatted = '(' + input.substring(0, 4) + ') ' + input.substring(4);
    } else {
        formatted = '(' + input.substring(0, 4) + ') ' + input.substring(4, 7) + ' ' + input.substring(7, 11);
    }

    $(this).val(formatted);
	});

			
	$(document).on("change","#class",function(){
		$("#section").val("");
		$("#section").next().find(".current").html("{{ _lang('Select One') }}");
		$("#section").next().find("ul li:not(:first-child)").css("display","none");
		
		var class_id = $(this).val();
		$('#section option[data-class="' + class_id + '"]').each(function(){
			var section_id = $(this).val();
			$("#section").next().find("ul li[data-value='" + section_id + "']").css("display","block");
		});
		//$("#section").next().find("ul li").css("display","none");
		//$("#section").val("");
	});
});
</script>
@stop
