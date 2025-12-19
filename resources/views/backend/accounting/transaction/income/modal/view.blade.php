<div class="panel panel-default">
<div class="panel-body">
  <table class="table table-bordered" id="tblRecords">
	<tr><td colspan="2" class="text-center"><b>View</b></td></tr>
	<tr><td>{{ _lang('Trans Date') }}</td><td>{{ date("d-M-Y", strtotime($transaction->trans_date) ) }}</td></tr>
	<tr><td>{{ _lang('Amount') }}</td><td>{{ $transaction->amount }}</td></tr>
	<tr><td>{{ _lang('Income Type') }}</td><td>{{ $transaction->c_type }}</td></tr>
	<tr><td>{{ _lang('Payment Method') }}</td><td>{{ $transaction->account_name }}</td></tr>
	<tr><td>{{ _lang('Reference') }}</td><td>{{ $transaction->reference }}</td></tr>
	<tr>
	<td>{{ _lang('Attachment') }}</td>
		<td>
		  @if($transaction->attachment != "")
		   <a href="{{ asset('uploads/transactions/'.$transaction->attachment) }}" target="_blank" class="btn btn-primary">{{ _lang('View Attachment') }}</a>
		  @else
			  <label class="label label-warning">
		        <strong>{{ _lang('No Atachment Available !') }}</strong>
		      </label>
		  @endif
		</td>
	</tr>
	<tr><td>{{ _lang('Note') }}</td><td>{{ $transaction->note }}</td></tr>	
  </table>
</div>
</div>

<button id="btnPrint" onclick="printData();" class="btn btn-primary" style="margin:20px;">Print</button>

<script>

    
function printData()
{
   var divToPrint=document.getElementById("tblRecords");
   newWin= window.open("");
   newWin.document.write(divToPrint.outerHTML);
   newWin.print();
   newWin.close();
}
</script>