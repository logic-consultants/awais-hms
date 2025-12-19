@extends('layouts.backend')

@section('content')
<style type="text/css">

</style>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
			  <span class="panel-title" >{{ _lang('Student Ledger') }}</span>
			  	<div class="row" style="margin-top: 4px;">
					<div class="col-md-3">
						<select id="student_id" class="form-control select2">
						   <option value="0">{{ _lang('Select Student') }}</option>
							@foreach($students AS $data)
							<option value="{{$data->id}}" @if($data->id ==$student_id) selected @endif>{{$data->register_no}}-{{$data->first_name}}-{{$data->section_name}}</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-2">
						<select id="status" class="form-control select2">
						   	<option value="All" @if($status=='All') selected @endif>{{ _lang('All Status') }}</option>
							<option value="Paid" @if($status=='Paid') selected @endif>Paid</option>
							<option value="Unpaid" @if($status=='Unpaid') selected @endif>Unpaid</option>
						</select>
					</div>
					<div class="col-md-1">
			  			<span class="btn btn-danger btn-sm" style="margin-left: 7px;margin-top: 3px;" onclick="showClass();">{{ _lang('View Result') }}</span>
					</div>

					<div class="col-md-6">
					    <span class="btn btn-primary pull-right hand" style="margin-top:3px;margin-right:10px;background: #e74c3c;color: #fff;border:0px;">{{ _lang('Blance') }} : {{$total_blance}}</span>
						@if($status !='Paid')
					    <span class="btn btn-warning pull-right hand d-none fee_ledger_button" id="fee_bill_button" style="margin-top:3px;margin-right:10px;">{{ _lang('Print Fee Bill') }}</span>
					    @endif
						@if($status !='Unpaid')
					    <span class="btn btn-success pull-right hand d-none fee_ledger_button" id="pay_sllip_button" style="margin-top:3px;margin-right:10px;">{{ _lang('Print Pay Sllip') }}</span>
					    @endif
					</div>
				</div>

				
			</div>

			<div class="panel-body">
			@if(count($invoices)>0)
			  	<div style="max-height: 500px;overflow-y: scroll;">
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
							<th>Inv#</th>
							<th class="text-center">{{ _lang('Due Date') }}</th>
							<th class="text-center">{{ _lang('Payment Date') }}</th>
							<th>{{ _lang('Status') }}</th>
							<th class="text-right">{{ _lang('Total') }}</th>
							<th class="text-right">{{ _lang('Paid') }}</th>
							<th class="text-right">{{ _lang('Due') }}</th>
				        	@if(count($fees)>0)
				        	@foreach($fees as $fee)
				        	<th class="text-right">{{$fee->fee_type}}</th>
				        	@endforeach
				        	@endif
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
								<td>
									@if($invoice->status=="Paid" || $invoice->paid>0)
									<a href="{{ url('invoices/feebill/'.$invoice->id.'?type=pay_sllip') }}" target="_blank" title="Print">{{ $invoice->id }}</a>
									@else
									<a href="{{ url('invoices/feebill/'.$invoice->id.'?type=fee_bill') }}" target="_blank" title="Print">{{ $invoice->id }}</a>
									@endif
								</td>
								<td class="text-center">{{ date('d-M-Y', strtotime($invoice->due_date)) }}</td>
								<td class="text-center">
									@if($invoice->payment_date)
									{{ date('d-M-Y', strtotime($invoice->payment_date)) }}
									@else
									--
									@endif
								</td>
								<td>{!! $invoice->status=="Paid" ? '<i class="fa fa-circle paid"></i>'.$invoice->status : '<i class="fa fa-circle unpaid"></i>'.$invoice->status !!}</td>
								<td class="text-right">{{ $invoice->total }}</td>
								<td class="text-right">{{ $invoice->paid }}</td>
								<td class="text-right">{{ $invoice->total - $invoice->paid }}</td>
								@if(count($fees)>0)
				                @php $total = 0; @endphp
						        @foreach($fees as $fee)
						        	@if(count($invoice->invoice_item)>0)

							        	@php $item_price=0; @endphp
							        	@foreach($invoice->invoice_item as $item)
								        	@if($item->fee_id == $fee->id)
								        	@php $item_price = ($item->amount - $item->discount); @endphp
								        	@endif
							        	@endforeach
							        	@if(!empty($item_price))
				            			<td class="text-right">{{$item_price}}</td>
							        	@else
							        	<td class="text-right">0</td>
							        	@endif
						        	@else
						        	<td class="text-right">0</td>

						        	@endif
					        	@endforeach
					        	@endif
						  </tr>
						  @endforeach
						</tbody>
				  	</table>
				</div>
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
        fee_ledger();
    });
	$('.check-single').on('change', function(){
        fee_ledger();
    });
	$('.allReceiptDate').on('change', function(){
        var allDate = $(this).val();
        $('.receipt_date_input').val(allDate);
    });

    var checked_ids=[];
    var fee_bill_url=null;
    var pay_sllip_url=null;
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

        fee_bill_url="{{ route('student_ledger_print') }}?type=fee_bill&invoice_id="+checked_ids;
        pay_sllip_url="{{ route('student_ledger_print') }}?type=pay_sllip&invoice_id="+checked_ids;
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
		var status = $('#status option:selected').val();
		var student_id = $('#student_id option:selected').val();
		window.location = "<?php echo url('invoices/student/ledger') ?>/"+student_id+"/"+status;
	}

	$('#fee_bill_button').on('click', function(){
		window.open(fee_bill_url,'_blank');
    });
	$('#pay_sllip_button').on('click', function(){
		window.open(pay_sllip_url,'_blank');
    });
</script>
@stop


