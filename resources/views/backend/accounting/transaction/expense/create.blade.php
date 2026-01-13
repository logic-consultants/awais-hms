@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-12">
	<div class="panel panel-default">
	<div class="panel-heading">{{ _lang('Add Expense') }}</div>

	<div class="panel-body">
	  <form method="post" class="validate" autocomplete="off" action="{{ url('transactions') }}" enctype="multipart/form-data">
		{{ csrf_field() }}
		
			<div class="col-md-6">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Payment From Account') }}</label>						
			<select class="form-control select2" name="account_id">
				@foreach($cash_and_bank as $account)
				<option value="{{ $account['id'] }}">{{ $account['account_name'] }}</option>
				@endforeach
			</select>
		  </div>
		</div>
			<div class="col-md-6">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Payment to Account') }}</label>						
			<select class="form-control select2" name="chart_id" required>
				@foreach($account_types as $account)
				<option value="{{ $account['id'] }}">{{ $account['account_name'] }}</option>
				@endforeach
			</select>
		  </div>
		</div>
		
		<div class="col-md-6">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Amount')." ".get_option('currency_symbol') }}</label>						
			<input type="text" class="form-control float-field" name="amount" value="{{ old('amount') }}" required>
		  </div>
		</div>
		
		<div class="col-md-6">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Date') }}</label>						
			<input type="text" class="form-control datepicker" name="trans_date" value="{{ old('trans_date') }}" required>
		  </div>
		</div>
<!--<input type="hidden" name="account_id" value="1" >-->


	
		
		<input type="hidden" name="trans_type" value="expense">
		<input type="hidden" name="dr_cr" value="cr">

		<!--<div class="col-md-6">-->
		<!--  <div class="form-group">-->
		<!--  <label class="control-label">{{ _lang('Payee') }}</label>						-->
		<!--  <select class="form-control select2" name="payee_payer_id">-->
		<!--		{{ create_option("payee_payers","id","name",old('payee_payer_id'),array("type="=>"payee")) }}-->
		<!--	</select>-->
		<!--  </div>-->
		<!--</div>-->

	

		<div class="col-md-6">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Attachment') }}</label>						
			<input type="file" class="form-control appsvan-file" name="attachment" >
		  </div>
		</div>

		<div class="col-md-6">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Note') }}</label>						
			<textarea class="form-control" name="note">{{ old('note') }}</textarea>
		  </div>
		</div>

				
		<div class="col-md-12">
		  <div class="form-group">
		    <button type="reset" class="btn btn-danger">{{ _lang('Reset') }}</button>
			<button type="submit" class="btn btn-primary">{{ _lang('Save Expense') }}</button>
		  </div>
		</div>
	  </form>
	</div>
  </div>
 </div>
</div>
@endsection


