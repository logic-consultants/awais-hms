@extends('layouts.backend')
@section('content')
<style type="text/css">
	.form-check-input{
		cursor: pointer;
	}
	.form-check-label{
		cursor: pointer;
	}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title" >
					{{_lang('Reports')}}
				</span>
			</div>
			<div class="panel-body">
				<form action="{{ url('reports/generate_report') }}" method="get" autocomplete="off" target="_blank">
					<div class="row">
						<div class="col-md-6">
							<div class="panel-group" id="accordion">
							  <div class="panel panel-default">
							    <div class="panel-heading">
							      <h4 class="panel-title">
							        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
							        {{ _lang('Academic') }}</a>
							      </h4>
							    </div>
							    <div id="collapse1" class="panel-collapse collapse in">
							      <div class="panel-body">
							      	<div class="form-check">
									  <input class="form-check-input" type="radio" name="report_name" value="fee_summary" id="fee_summary" required="" checked="">
									  <label class="form-check-label" for="fee_summary">
									    Fee Summary
									  </label>
									</div>
							      	<div class="form-check">
									  <input class="form-check-input" type="radio" name="report_name" value="fee_summary_with_dues" id="fee_summary_with_dues" required="">
									  <label class="form-check-label" for="fee_summary_with_dues">
									    Fee Summary With Dues
									  </label>
									</div>
									<div class="form-check">
									  <input class="form-check-input" type="radio" name="report_name" value="daily_fee_receipt_report" id="daily_fee_receipt_report" required="">
									  <label class="form-check-label" for="daily_fee_receipt_report">
									    Daily Fee Receipt Report
									  </label>
									</div>
									<div class="form-check">
									  <input class="form-check-input" type="radio" name="report_name" value="fee_definition_student_wise" id="fee_definition_student_wise" required="">
									  <label class="form-check-label" for="fee_definition_student_wise">
									    Fee Definition(Student Wise)
									  </label>
									</div>
									<div class="form-check">
									  <input class="form-check-input" type="radio" name="report_name" value="unpaid_summary" id="unpaid_summary" required="">
									  <label class="form-check-label" for="unpaid_summary">
									    Unpaid Summary for All
									  </label>
									</div>
									<div class="form-check">
									  <input class="form-check-input" type="radio" name="report_name" value="unpaid_summary_current" id="unpaid_summary_current" required="">
									  <label class="form-check-label" for="unpaid_summary_current">
									    Unpaid Summary for Current
									  </label>
									</div>
									<div class="form-check">
									  <input class="form-check-input" type="radio" name="report_name" value="unpaid_details" id="unpaid_details" required="">
									  <label class="form-check-label" for="unpaid_details">
									    Unpaid Details
									  </label>
									</div>
							      </div>
							    </div>
							  </div>
							  <div class="panel panel-default">
							    <div class="panel-heading">
							      <h4 class="panel-title">
							        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
							        {{ _lang('Finacial') }}</a>
							      </h4>
							    </div>
							    <div id="collapse2" class="panel-collapse collapse">
							      <div class="panel-body">

									<div class="form-check">
									  <input class="form-check-input" type="radio" name="report_name" value="invoice_dues_feebill" id="invoice_dues_feebill" required="">
									  <label class="form-check-label" for="invoice_dues_feebill">
									    Dues Fee Bill
									  </label>
									</div>

							      </div>
							    </div>
							  </div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="control-label">{{ _lang('Session') }}</label>
										<select name="session" class="form-control">
										   <option value="">{{ _lang('Select Session') }}</option>
										   {{ create_option('academic_years','id','session',$session) }}
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">{{ _lang('Floor') }}</label>
										<select name="class_id" class="form-control" onChange="getData(this.value);">
											<option value="All">{{ _lang('All Floor') }}</option>
											{{ create_option('classes','id','class_name',$class_id) }}
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">{{ _lang('Room') }}</label>
										<select name="section_id" onchange="get_students();" class="form-control">
											<option value="All">{{ _lang('All Room') }}</option>
											{{ create_option('sections','id','section_name',$section_id,array("class_id="=>$class_id)) }}
										</select>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">{{ _lang('Date From') }}</label>
										<div class="input-group">
											<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
											<input type="text" class="form-control date_from" name="date_from" value="{{ $date_from }}" readOnly="true">
									    </div>
									</div>
								</div>
								
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">{{ _lang('Date To') }}</label>
										<div class="input-group">
											<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
											<input type="text" class="form-control date_to" name="date_to" value="{{ $date_to }}" readOnly="true">
									    </div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group pull-right">
								<button type="submit" style="margin-top:24px;" class="btn btn-primary rect-btn">{{_lang('Generate Report')}}</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
@section('js-script')
<script type="text/javascript">
	$(document).ready(function(){
	   $(".date_from").datepicker({
	       format: 'dd-mm-yyyy',
	       autoclose: true,
	   }).on('changeDate', function (selected) {
	       var minDate = new Date(selected.date.valueOf());
	       $('.date_to').datepicker('setStartDate', minDate);
	   });

	   $(".date_to").datepicker({
	       format: 'dd-mm-yyyy',
	       autoclose: true,
	   }).on('changeDate', function (selected) {
	           var minDate = new Date(selected.date.valueOf());
	           $('.date_from').datepicker('setEndDate', minDate);
	   });
	});
	function getData(val) {
		var _token=$('input[name=_token]').val();
		var class_id=$('select[name=class_id]').val();
		$.ajax({
			type: "POST",
			url: "{{url('sections/section')}}",
			data:{_token:_token,class_id:class_id,all_section:'All'},
			beforeSend: function(){
				$("#preloader").css("display","block");
			},success: function(sections){
				$("#preloader").css("display","none");
				$('select[name=section_id]').html(sections);				
			}
		});
	}

</script>
@stop