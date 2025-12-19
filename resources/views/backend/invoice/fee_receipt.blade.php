@extends('layouts.backend')

@section('content')
<style type="text/css">

</style>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
			  <span class="panel-title">{{ _lang('Fee Receipt') }}</span>

			  	<span class="btn btn-danger btn-sm pull-right" style="margin-left: 7px;" onclick="showClass();">{{ _lang('View Result') }}</span>
				<select id="section" name="section_id" class="select_class pull-right">
				   <option value="All">{{ _lang('All Rooms') }}</option>
					@foreach(get_table('sections') AS $data)
					<option data-class="{{$data->class_id}}" value="{{$data->id}}" @if($data->id ==$section) selected @endif>{{$data->section_name}}</option>
					@endforeach
				</select>
			    <select id="class" name="class_id" class="select_class pull-right" onChange="getData(this.value);">
				   <option value="All">{{ _lang('All Floor') }}</option>
				   {{ create_option('classes','id','class_name',$class) }}
				</select>
				<select id="session" class="select_class pull-right">
				   <option value="0">{{ _lang('Select Session') }}</option>
				   {{ create_option('academic_years','id','session',$session) }}
				</select>
			</div>

			<div class="panel-body">
			 @if(count($invoices)>0)
			<form method="post" autocomplete="off" action="{{route('invoices.fee_receipt_store')}}" enctype="multipart/form-data">
				{{ csrf_field() }}
			  	<div class="row">
					<div class="col-md-3">
					  <div class="form-group">
						<label class="control-label">{{ _lang('Account') }}</label>						
						<select class="form-control select2" name="account_id" required>
							{{ create_option("bank_cash_accounts","id","account_name",old('account_id')) }}
						</select>
					  </div>
					</div>
					<div class="col-md-3">
					  <div class="form-group">
						<label class="control-label">{{ _lang('Payment Method') }}</label>						
						<select class="form-control select2" name="payment_method_id" required="">
							{{ create_option("payment_methods","id","name",old('payment_method_id')) }}
						</select>
					  </div>
					</div>
					<div class="col-md-3">
					  <div class="form-group">
						<label class="control-label">{{ _lang('Income Type') }}</label>						
						<select class="form-control select2" name="chart_id" required>
							{{ create_option("chart_of_accounts","id","name",old('chart_id'),array("type="=>"income")) }}
						</select>
					  </div>
					</div>
			  		<div class="col-md-3">
					  <div class="form-group">
						<label class="control-label">{{ _lang('Receipt Date') }}</label>						
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
							<input type="text" class="form-control datepicker allReceiptDate" name="all_receipt_date">
						</div>
					  </div>
					</div>
					{{-- <div class="col-md-6">
					  <div class="form-group">
						<label class="control-label">Note</label>
						<textarea style="padding: 4px 5px;height: 45px;" class="form-control" name="note"></textarea>
					  </div>
					</div> --}}
			  	</div>
				<table class="table table-bordered">
					<thead>
					  <tr>
						<th>
							<div style="display: inline-flex;">
                                <input type="checkbox" class="check-all" />
                                <div>
                                    <label></label>
                                </div>
                            </div>
						</th>
						<th>SL#</th>
						<th>Inv#</th>
						<th>{{ _lang('Student Info') }}</th>
						<th>{{ _lang('Inv Date') }}</th>
						<th>{{ _lang('Due Date') }}</th>
						<th>{{ _lang('Total') }}</th>
						<th>{{ _lang('Paid') }}</th>
						<th>{{ _lang('Due') }}</th>
						<th>{{ _lang('Receipt No.') }}</th>
						<th>{{ _lang('Receipt Date') }}</th>
					  </tr>
					</thead>
					<tbody>
					  
					  @foreach($invoices as $key => $invoice)
					  <tr id="row_{{ $invoice->id }}">
							<td>
								<div style="display: inline-flex;">
                                    <input type="checkbox" class="check-single" name="invoice_id[]" data-class="#row_{{$invoice->id}}" value="{{$invoice->id}}" data-student_id="{{$invoice->student_id}}"/>
                                    <div>
                                        <label></label>
                                    </div>
                                </div>								
							</td>
							<td>{{ ++$key }}</td>
							<td>{{ $invoice->id }}</td>
							<td>
								<b>{{ $invoice->first_name." ".$invoice->last_name }}</b> <br/>
								Reg # : {{$invoice->register_no}}<br/>
								{{ $invoice->class_name }} / {{ $invoice->section_name }}
							</td>
							<td>{{ date('d-M-Y', strtotime($invoice->created_at)) }}</td>
							<td>{{ date('d-M-Y', strtotime($invoice->due_date)) }}</td>
							<td>{{ $invoice->total }}</td>
							<td>{{ $invoice->paid }}</td>
							<td>{{ $invoice->total - $invoice->paid }}</td>
							<td style='max-width:100px;'>
								<input type="hidden" name="id[]" value="{{$invoice->id}}">
								<input type="text" class="form-control receipt_no_input" style="padding: 0px;" name="receipt_no[]" placeholder="Receipt No.">
							</td>
							<td style='max-width:100px;'>
								<input type="text" class="form-control datepicker receipt_date_input" style="padding: 0px;" name="receipt_date[]" placeholder="Receipt Date">
							</td>
					  </tr>
					  @endforeach
					</tbody>
			  	</table>
			  	<div class="row">
			  		<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-body">
							    <button type="submit" class="btn btn-primary pull-right" style="margin-top:-7px;">{{ _lang('Save') }}</button>
							    
							</div>
						</div>
					</div>
			  	</div>
			</form>
		  	@else
		  	<p class="text-center text-danger">Data not found!</p>
		  	@endif
			</div>
		</div>
	</div>
</div>
@endsection

@section('js-script')
<script>
	$('.check-all').on('change', function(){
        $('.check-single').prop('checked', $(this).prop('checked'));
        if($(this).prop("checked") == true){
            $('.receipt_no_input').attr('required', '');
            $('.receipt_date_input').attr('required', '');
        }else if($(this).prop("checked") == false){
            $('.receipt_no_input').removeAttr('required');
            $('.receipt_date_input').removeAttr('required');
        }
        fee_ledger();
    });
	$('.check-single').on('change', function(){
		var get_class =$(this).data('class');
        if($(this).prop("checked") == true){
        	$(get_class).find(".receipt_no_input").attr('required', '');
        	$(get_class).find(".receipt_date_input").attr('required', '');
        }else if($(this).prop("checked") == false){
        	$(get_class).find(".receipt_no_input").removeAttr('required');
        	$(get_class).find(".receipt_date_input").removeAttr('required');
        }
        fee_ledger();
    });
	$('.allReceiptDate').on('change', function(){
        var allDate = $(this).val();
        $('.receipt_date_input').val(allDate);
    });

    var checked_ids=[];
    var url=null;
	function fee_ledger() {
		var selected=0;
        $('.check-single').each(function(){
            if($(this).prop("checked")) ++selected;
        });
        if(selected) $('.fee_ledger_button').removeClass('d-none');
        else $('.fee_ledger_button').addClass('d-none');

        var checkbox_ids=[];

        $('.check-single').each(function(){

            var id=$(this).val();
            var student_id=$(this).data('student_id');
            var status=0;

            if($(this).prop('checked')) status=1;

            checkbox_ids.push({
                id: id,
                student_id: student_id,
                status: status
            });

        });
        checked_ids=[];
        same_student_id=[];
        checkbox_ids.filter(function (el) {
          if (el.status) {
            checked_ids.push(el.id);
            same_student_id.push(el.student_id);
            
          }
        });
        if(same_student_id.length >0 && same_student_id.every( g => g === same_student_id[0])){
            $('.fee_ledger_button').removeClass('d-none');
        }else{
        	$('.fee_ledger_button').addClass('d-none');
        }	
        
	}
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
	function showClass(){
		var session_id = $('#session option:selected').val();
		var class_id = $('#class option:selected').val();
		var section_id = $('#section option:selected').val();

		window.location = "<?php echo url('invoices/fee_receipt') ?>/"+class_id+"/"+section_id+"/"+session_id;
	}

	$('.fee_ledger_button').on('click', function(){
        location.href=url;
    });
</script>
@stop


