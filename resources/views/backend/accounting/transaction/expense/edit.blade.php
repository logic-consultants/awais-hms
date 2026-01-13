@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">{{ _lang('Update Expense') }}</div>

			<div class="panel-body">
		<form method="post" action="{{ route('transactions.update_expense', $id) }}" enctype="multipart/form-data">
    {{ csrf_field() }}  


				<div class="col-md-6">
				 <div class="form-group">
					<label class="control-label">{{ _lang('Trans Date') }}</label>						
					<input type="text" class="form-control datepicker" name="trans_date" value="{{ $transaction->trans_date }}" required>
				 </div>
				</div>
<!--<input type="hidden" name="account_id" value="1">-->


				<div class="col-md-6">
				 <div class="form-group">
					<label class="control-label">{{ _lang('Amount')." ".get_option('currency_symbol') }}</label>						
					<input type="text" class="form-control float-field" name="amount" value="{{ $transaction->amount }}" required>
				 </div>
				</div>


				<div class="col-md-6">
				 <div class="form-group">
					 {{-- @dd($transaction->chart_id == $account_types[5]['id']) --}}
					<label class="control-label">{{ _lang('Payment to Account') }}</label>						
					<select class="form-control select2" name="chart_id" required>
						@foreach($account_types as $account)
				<option value="{{ $account['id'] }}"  @selected($transaction->chart_id == $account['id'])>{{ $account['account_name'] }}</option>
				@endforeach
			</select>
				 </div>
				</div>
							
				<div class="col-md-6">
				 <div class="form-group">
					<label class="control-label">{{ _lang('Payment From Account') }}</label>						
						<select class="form-control select2" name="account_id">
				@foreach($cash_and_bank as $account)
				<option value="{{ $account['id'] }}" @selected($transaction->account_id == $account['id'])>{{ $account['account_name'] }}</option>
				@endforeach
			</select>
				 </div>
				</div>

	<input type="hidden" name="trans_type" value="expense">
				<input type="hidden" name="dr_cr" value="cr">

			

				<div class="col-md-6">
				 <div class="form-group">
					<label class="control-label">{{ _lang('Attachment') }}</label>						
					<input type="file" class="form-control appsvan-file" data-value="{{ $transaction->attachment}}" name="attachment">
				 </div>
				</div>

				<div class="col-md-6">
				 <div class="form-group">
					<label class="control-label">{{ _lang('Note') }}</label>						
					<textarea class="form-control" name="note">{{ $transaction->note }}</textarea>
				 </div>
				</div>

				
				<div class="col-md-12">
				  <div class="form-group">
					<button type="submit" class="btn btn-primary">{{ _lang('Update Expense') }}</button>
				  </div>
				</div>
			</form>
			</div>
		</div>
	</div>
</div>

@endsection


