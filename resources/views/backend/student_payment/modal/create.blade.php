<form method="post"  autocomplete="off" class="formSubmission" action="{{route('student_payments.store')}}" enctype="multipart/form-data" target="_blank">
	{{ csrf_field() }}
						
	<input type="hidden" class="form-control" name="invoice_id" value="{{ $invoice_id }}" required>
    @php $currency = get_option('currency_symbol'); @endphp
	
	@if(!empty($history))
	<div class="col-md-12">
		<table class="table table-bordered">
		    <thead>
			   <th colspan="4" class="text-center">{{ _lang('Payment History') }}</th>
			</thead>
			<thead>
			   <th>{{ _lang('Date') }}</th>
			   <th>{{ _lang('Amount') }}</th>
			   <th>{{ _lang('Note') }}</th>
			   <th>{{ _lang('payment Head') }}</th>
			</thead>
			<tbody>
			@foreach($history as $payment)
			   <tr>
			     <td>{{ $payment->date }}</td>
			     <td>{{ $currency." ".$payment->amount }}</td>
			     <td>{{ $payment->note }}</td>
				 <td> Income </td>
			   </tr>
			@endforeach
			</tbody>
		</table>
	</div>	
	@endif
	@if($invoice->status=="Unpaid")
	<div class="col-md-6">
	  <div class="form-group">
		<label class="control-label">{{ _lang('Student Total Balance')." ".$currency }}</label>						
		<input type="text" class="form-control" value="{{ \App\Invoice::where('student_id',$invoice->student_id)->sum('total') - \App\Invoice::where('student_id',$invoice->student_id)->sum('paid') }}" readOnly="true">
	  </div>
	</div>
	<div class="col-md-6">
	  <div class="form-group">
		<label class="control-label">{{ _lang('Total Amount')." ".$currency }}</label>						
		<input type="text" class="form-control" value="{{ $invoice->total }}" readOnly="true">
	  </div>
	</div>
	
	<div class="col-md-6">
	  <div class="form-group">
		<label class="control-label">{{ _lang('Total Paid')." ".$currency }}</label>						
		<input type="text" class="form-control" value="{{ $invoice->paid }}" readOnly="true">
	  </div>
	</div>

	<div class="col-md-6">
	  <div class="form-group">
		<label class="control-label">{{ _lang('Payable Amount')." ".$currency }}</label>	
		<input type="number" class="form-control float-field" readOnly="true" name="payable" value="{{ $invoice->total-$invoice->paid }}" max="{{ $invoice->total-$invoice->paid }}" required>
	 </div>
	</div>
	<div class="col-md-6">
	  <div class="form-group">
		<label class="control-label">{{ _lang('Date') }}</label>						
		<input type="text" class="form-control datepicker" name="date" value="{{ $payment_date }}" required>
	  </div>
	</div>
	<div class="col-md-6">
	  <div class="form-group">
		<label class="control-label">{{ _lang('Payment Method') }}</label>						
		<select class="form-control select2" name="account_id">
				@foreach($accounts as $account)
				<option value="{{ $account['id'] }}">{{ $account['account_name'] }}</option>
				@endforeach
			</select>
	  </div>
	</div>
	<!-- <div class="col-md-6">
	  <div class="form-group">
		<label class="control-label">{{ _lang('Income Type') }}</label>						
		<select class="form-control select2" name="chart_id" required>
			 @foreach($invoiceItems as $id => $fee_type)
        <option value="{{ $id }}" {{ old('chart_id') == $id ? 'selected' : '' }}>
            {{ $fee_type }}
        </option>
    @endforeach
		</select>
	  </div>
	</div> --> 
	<?php //print_r($invoiceItems); ?>
	@foreach($invoiceItems as $item)
    <div class="col-md-6">
        <div class="form-group">
            {!! get_fee_selectbox('select2', $item->fee_id) !!}
        </div>
    </div> 
    <div class="col-md-6">
        <div class="form-group">
            @php
                // Get total amount already paid for this specific fee item
                $paidAmount = \App\Transaction::where('chart_id', $item->fee_id)
                                ->where('invoice_id', $invoice->id)
                                ->sum('amount');

                // Calculate the remaining amount
                $remainingAmount = $item->amount - $paidAmount;
            @endphp

            <input 
                type="number" 
                class="form-control amount" 
                name="amount[]" 
                value="{{ $remainingAmount }}" 
                max="{{ $remainingAmount }}" 
                min="0"
                required>
        </div>
    </div>
@endforeach

	<input type="hidden" name="trans_type" value="income">
	<input type="hidden" name="trans_source_type" value="Student">
	<input type="hidden" name="school_id" value="{{ $invoice->school_id}}">
	<input type="hidden" name="dr_cr" value="cr">

	<div class="col-md-6">
	  <div class="form-group">
		<label class="control-label">{{ _lang('Receipt No') }}</label>						
		<input type="text" class="form-control" name="receipt_no" value="{{$invoice_paid}}"> 	
	  </div>
	</div>
	<div class="col-md-12">
	  <div class="form-group">
		<label class="control-label">{{ _lang('Note') }}</label>						
		<textarea class="form-control" name="note">{{ old('note') }}</textarea>
	  </div>
	</div>

				
	<div class="col-md-12">
	  <div class="form-group">
		<button type="submit" class="btn btn-primary save-print" name= "save_print" value="save_print">{{ _lang(' Print and Save') }}</button>

		{{-- <button type="submit" class="btn btn-primary save-pdf" name="save_pdf" value="save_pdf">{{ _lang('Save and PDF') }}</button> --}}

		<button type="submit" class="btn btn-primary" name="save_back" value="save_back">{{ _lang('Save') }}</button>

	</div>
	</div>
	@endif
</form>
<script>
	$('.formSubmission').on('submit', function(e) {
		setTimeout(function() {
			$('#main_modal').modal('hide');
		}, 1000);
	});

	$('.save-pdf ').on('click', function(){
		setTimeout(() => {
			
			$("#preloader").css("display", "block");
            window.location.href = "{{ url('/invoices') }}";
        }, 2000); // delay to ensure download is triggered
	})
	</script>