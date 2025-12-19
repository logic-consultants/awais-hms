@extends('layouts.backend')

@section('content')
<style type="text/css">

</style>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">

			<div class="panel-body">
			 @if(count($invoices)>0)
			<form method="post" autocomplete="off" action="{{route('invoices_student_fee_ledger_store')}}" enctype="multipart/form-data">
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
							<label class="control-label">{{ _lang('Receipt No') }}</label>						
							<input type="text" class="form-control" name="receipt_no" value="{{ old('receipt_no') }}" required>
						  </div>
					</div>
			  		<div class="col-md-3">
					  <div class="form-group">
						<label class="control-label">{{ _lang('Receipt Date') }}</label>						
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
							<input type="text" class="form-control datepicker" name="receipt_date" required>
						</div>
					  </div>
					</div>
					<div class="col-md-12">
					  <div class="form-group">
						<label class="control-label">Note</label>
						<textarea style="padding: 4px 5px;height: 45px;" class="form-control" name="note"></textarea>
					  </div>
					</div>
			  	</div>
				<table class="table table-bordered">
					<thead>
					  <tr>
						<th>SL#</th>
						<th>Inv#</th>
						<th>{{ _lang('Student Info') }}</th>
						<th>{{ _lang('Inv Date') }}</th>
						<th>{{ _lang('Due Date') }}</th>
						<th>{{ _lang('Total') }}</th>
						<th>{{ _lang('Paid') }}</th>
						<th>{{ _lang('Due') }}</th>
					  </tr>
					</thead>
					<tbody>
					  @php $grand_total=0 @endphp
					  @foreach($invoices as $key => $invoice)
					  <tr>
							<td>{{ ++$key }}</td>
							<td>{{ $invoice->id }}</td>
							<td>
								<b>{{ $invoice->first_name." ".$invoice->last_name }}</b> <br/>
								Reg # : {{$invoice->register_no}}<br/>
								{{ $invoice->class_name }} / {{ $invoice->section_name }}
							</td>
							<td>{{ date('d-M-Y', strtotime($invoice->created_at)) }}</td>
							<td>{{ date('d-M-Y', strtotime($invoice->due_date)) }}</td>
							<td class="text-right">{{ $invoice->total }}</td>
							<td class="text-right">{{ $invoice->paid }}</td>
							<td class="text-right">{{ $invoice->total - $invoice->paid }}</td>
							@php $grand_total=$grand_total + ($invoice->total - $invoice->paid) @endphp
							<input type="hidden" name="invoice_id[]" value="{{$invoice->id}}">
					  </tr>
					  @endforeach
					</tbody>
					<tfoot>
						<th class="text-right" colspan="7">Grand Total:</th>
						<th class="text-right">{{$grand_total}}</th>
					</tfoot>
			  	</table>
			  	<div class="row">
			  		<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-body">
							    <button type="submit" class="btn btn-primary pull-right" style="margin-top:-7px;">{{ _lang('Submit') }}</button>
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

@stop


