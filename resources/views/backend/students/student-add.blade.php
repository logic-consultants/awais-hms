@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title">
					{{_lang('Add New Student')}}
				</div>
			</div>
			<div class="panel-body">
				<div class="col-md-12">
					<form action="{{route('students.store')}}" autocomplete="off" class="form-horizontal form-groups-bordered validate" enctype="multipart/form-data" method="post" accept-charset="utf-8">
						@csrf
						<div class="row" style="margin-top: 10px">
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-sm-3 control-label">{{_lang('First Name')}}</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-sm-3 control-label">{{_lang("Father's Name")}}</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="father_name" value="{{ old('father_name') }}" required>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							{{-- <div class="col-md-6">
								<div class="form-group">
									<label class="col-sm-3 control-label">{{_lang('Guardian')}}</label>
									<div class="col-sm-7">
										<select name="guardian" id="guardian" class="form-control" required>	
										</select>
									</div>
									<a href="{{route('parents.create')}}" data-title="{{ _lang('Add New Parent') }}" class="btn btn-primary btn-sm ajax-modal"><i class="fa fa-plus"></i>Quick Add</a>
								</div>
							</div> --}}
							<input type="hidden" value="1" name="guardian">
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-sm-3 control-label">{{_lang('Gender')}}</label>
									<div class="col-sm-9">
										<select name="gender" class="form-control niceselect wide" required>
											<option value="">{{ _lang('Select One') }}</option>
										    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>{{ _lang('Male') }}</option>
    										<option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>{{ _lang('Female') }}</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-sm-3 control-label">{{_lang('Birthday')}}</label>
									<div class="col-sm-9">
										<input type="text" class="form-control datepicker" name="birthday" value="{{ old('birthday') }}" required>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-sm-3 control-label">{{_lang('Blood Group')}}</label>
									<div class="col-sm-9">
										<select name="blood_group" class="form-control select2" id="blood_group">
											<option value="">{{ _lang('Select One') }}</option>
											<option value="N/A" @selected(old('blood_group') == 'N/A')>{{ _lang('N/A') }}</option>
											<option value="A+" @selected(old('blood_group') == 'A+')>{{ _lang('A+') }}</option>
											<option value="A-" @selected(old('blood_group') == 'A-')>{{ _lang('A-') }}</option>
											<option value="B+" @selected(old('blood_group') == 'B+')>{{ _lang('B+') }}</option>
											<option value="B-" @selected(old('blood_group') == 'B-')>{{ _lang('B-') }}</option>
											<option value="AB+" @selected(old('blood_group') == 'AB+')>{{ _lang('AB+') }}</option>
											<option value="AB-" @selected(old('blood_group') == 'AB-')>{{ _lang('AB-') }}</option>
											<option value="O+" @selected(old('blood_group') == 'O+')>{{ _lang('O+') }}</option>
											<option value="O-" @selected(old('blood_group') == 'O-')>{{ _lang('O-') }}</option>
										</select>
									</div>
								</div>
							</div>
								<div class="col-md-6">
								<div class="form-group">
									<label class="col-sm-3 control-label">{{ _lang('Religion') }}</label>
									<div class="col-sm-9">
										<select name="religion" class="form-control niceselect wide">
											<option value="">{{ _lang('Select One') }}</option>
											{{ create_option("picklists","value","value",old('religion'),array("type="=>"Religion")) }}	
										</select>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
						
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-sm-3 control-label">{{_lang('Cell Phone')}}</label>
									<div class="col-sm-9">
										<input type="text" class="form-control phoneNumber" name="phone" value="{{ old('phone') }}"
												placeholder="(123) 456-7890"
												required>
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label class="col-sm-3 control-label">{{ _lang('Home Phone') }}</label>
									<div class="col-sm-9">
										<input type="text" class="form-control phoneNumber" name="home_phone" value="{{ old('home_phone') }}">
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-sm-3 control-label">{{_lang('Address')}}</label>
									<div class="col-sm-9">
										<input class="form-control" name="address" value="{{ old('address') }}" />
									</div>
								</div>
							</div>
								<div class="col-md-6">
								<div class="form-group">
									<label class="col-sm-3 keratoconus is an eye condition in which the cornea thins and gradually bulges outward into a cone shape, causing blurry vision and light sensitivity. control-label">{{_lang('State')}}</label>
									<div class="col-sm-9">
										<select name="state" class="form-control select2" required>
											{{ get_country_states(old('state'), 'Pakistan') }}
										</select>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
						
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-sm-3 control-label">{{_lang('Country')}}</label>
									<div class="col-sm-9">
										<select name="country" class="form-control select2" required>
											{{ get_country_list(old('country')??'Pakistan') }}
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
											{{ create_option('classes','id','class_name',old('class')) }}
										</select>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
						
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-sm-3 control-label">{{_lang('Room')}}</label>
									<div class="col-sm-9">
										<select name="section" class="form-control" id="section" required>
											<option value="">{{ _lang('Select One') }}</option>
											@foreach($sections as $data)
												<option data-class="{{ $data->class_id }}" value="{{ $data->id }}" @selected(old('section') == $data->id)>{{ $data->section_name }}</option>
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
											{{ create_option('departments','id','department_name',old('department')) }}
										</select>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-sm-3 control-label">{{_lang('Student CNIC ')}}</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" id="activities" name="activities" value="{{ old('activities') }}">
									</div>
								</div>
							</div>

								<div class="col-md-6">
								<div class="form-group">
									<label class="col-sm-3 control-label">{{_lang('Register NO')}}</label>
									<div class="col-sm-9">
										<input type="number" class="form-control" id="register_no" name="register_no" value="{{ old('register_no') }}" required>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
						
							
							
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-sm-3 control-label">{{_lang('Remarks')}}</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="remarks" value="{{ old('remarks') }}">
									</div>
								</div>
							</div>
						</div>


						<div class="form-group" style="margin-top:20px">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">
										<span>{{ _lang('Student Fees') }}</span>
										<button type="button" class="btn btn-danger pull-right" id="add-item-row-assign" style="margin-top:-7px;margin-left:10px;">{{ _lang('Add New Row') }}</button>
									</div>
									<div class="panel-body d-none" id="invoice_assign_div">
										<table class="table">
											<thead style="background:#dce9f9;">
												<th>{{ _lang('Fee Type') }}</th>
												<th style="text-align:left">{{ _lang('Amount')." ".get_option('currency_symbol') }}</th>
												<th style="text-align:left">{{ _lang('Discount')." ".get_option('currency_symbol') }}</th>
												<th style="text-align:left">{{ _lang('Total')." ".get_option('currency_symbol') }}</th>		  
											</thead>
											<tbody id="invoice_assign">
											</tbody>
											<tfoot>
												<tr>
													<td class="text-right" colspan="3"><label class="control-label">{{ _lang('Total') }}</label></td>
													<td><input type="text" class="form-control" id="total_assign" name="total" value="{{ old('total') }}" readOnly="true"></td>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>
							</div>
						</div>

						<hr>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-sm-3 control-label"></label>
									<div class="col-sm-9">
										<label class="c-container" style="padding-top: 2px;">Need Login Details<input name="need_login" class="need_login_click" value="1" type="checkbox"><span class="checkmark"></span></label>
									</div>
								</div>
							</div>
						</div>

						<div id="need_login_div" class="d-none">
							<div class="page-header">
								<h4>Login Details</h4>
							</div>
							<div class="row">
								<div class="col-md-8">
									<div class="form-group">
										<label class="col-sm-3 control-label">{{_lang('Email')}}</label>
										<div class="col-sm-9">
											<input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-8">
									<div class="form-group">
										<label class="col-sm-3 control-label">{{_lang('Password')}}</label>
										<div class="col-sm-9">
											<input type="password" class="form-control" name="password" required>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-8">
									<div class="form-group">
										<label class="col-sm-3 control-label">{{_lang('Confirm Password')}}</label>
										<div class="col-sm-9">
											<input type="password" class="form-control" name="password_confirmation" required>
										</div>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-8">
									<div class="form-group">
										<label class="col-sm-3 control-label">{{_lang('Profile Picture')}}</label>
										<div class="col-sm-9">
 											<input type="file" class="form-control dropify" name="image" data-allowed-file-extensions="jpg jpeg JPG JPEG png PNG">
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="form-group mt-2">
							<div class="col-sm-offset-11">
								<button type="submit" class="btn btn-info">Add Student</button>
							</div>
						</div>
					</form>
				</div>
				<table style="display:none;">
					<tr id="fee_row_assign">
						<td width="40%">{!! get_fee_selectbox() !!}</td>
						<td><input type="number" min="0" value="0" class="form-control float-field amount" name="amount[]" required></td>
						<td><input type="number" value="0" class="form-control float-field discount" min="0" name="discount[]" required></td>
						<td><input type="number" value="0" class="form-control float-field total" name="sub_total[]" readOnly="true" required></td>
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
	if($('#register_no').val()=="") {
		$('#register_no').val(Math.floor((Math.random() * 99999999) + 1));
	}
	
	$("#section").next().find("ul li").css("display","none");
	$(document).on("change","#class",function(){
		$("#section").next().find("ul li").css("display","none");
		var class_id = $(this).val();
		$('#section option[data-class="' + class_id + '"]').each(function(){
			var section_id = $(this).val();
			$("#section").next().find("ul li[data-value='" + section_id + "']").css("display","block");
		});
	});

	$(document).on('click','#add-item-row-assign',function(){
		var row = $("#fee_row_assign").clone();
		$('#invoice_assign_div').removeClass('d-none');		
		$(row).removeAttr("id");		
		$(row).find('select').select2();		
		$("#invoice_assign").append(row);		
	});
	
	$(document).on('keyup','.amount,.discount',function(){
		var amount = parseFloat($(this).closest("tr").find(".amount").val());
		var discount = parseFloat($(this).closest("tr").find(".discount").val());
		$(this).closest("tr").find(".total").val(amount-discount);
		
		var total = 0;
		jQuery("#invoice_assign > tr").each(function () {
			var sub_total = parseFloat($(this).find(".total").val());
			total += sub_total;
		});	
		$("#total_assign").val(total);		
	});
	
	$(document).on('change','#class',function(){
		load_option_subject();
	});
	
	$(document).on('change','.need_login_click',function(){
		if ($(this).is(":checked")) {
			$('#need_login_div').removeClass('d-none');
		} else {
			$('#need_login_div').addClass('d-none');
		}
	});
	
	function load_option_subject(){
		var class_id = $("#class").val();
		var link = "{{ url('students/get_subjects/') }}";
		$.ajax({
			url: link+"/"+class_id,
			success: function(data){		
				$('#optional_subject').html(data);				
			}
		});
	}

	$('#section').select2();

	$('#guardian').select2({
		placeholder: "{{ _lang('Select One') }}",
		ajax: {
			dataType: "json",
			url: "{{ url('parents/get_parents') }}",
			delay: 400,
			data: function(params) {
				return {
					term: params.term
				}
			},
			processResults: function (data, page) {
				return {
					results: data
				};
			},
		}
	});


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

	
});
</script>

@stop