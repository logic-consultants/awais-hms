
<form method="post" class="validate" autocomplete="off" action="{{url('invoices')}}" enctype="multipart/form-data">
	{{ csrf_field() }}
	
	<div class="row">

		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<span>{{ _lang('Student Fees') }}</span>
					<button type="button" class="btn btn-danger pull-right" id="add-item-row-assign" style="margin-top:-7px;margin-left:10px;">{{ _lang('Add New Row') }}</button>
				    <button type="submit" class="btn btn-primary pull-right" style="margin-top:-7px;">{{ _lang('Save Invoice') }}</button>
				</div>

				<div class="panel-body">
				    
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
						 <td><input type="text" class="form-control float-field amount" name="amount[]"value="{{ $item->amount }}" required></td>
						 <td><input type="text" class="form-control float-field discount" name="discount[]"value="{{ $item->discount }}" required></td>
						 <td><input type="text" class="form-control float-field total" name="sub_total[]"value="{{ $item->amount-$item->discount }}" readOnly="true" required></td>
					   </tr>
				    	@endforeach	
				    	@else	  
					   <tr>
					     <td width="40%">{!! get_fee_selectbox('select2') !!}</td>
					     <td><input type="text" class="form-control float-field amount" name="amount[]"value="0" required></td>
					     <td><input type="text" class="form-control float-field discount" name="discount[]"value="0" required></td>
					     <td><input type="text" class="form-control float-field total" name="sub_total[]"value="0" readOnly="true" required></td>
					   </tr>
					   @endif
					</tbody>
					<tfoot>
						<tr>
							<td class="text-right" colspan="3"><label class="control-label">{{ _lang('Total') }}</label></td>
							<td><input type="text" class="form-control" id="total_assign" name="total" value="{{ old('total') }}" readOnly="true" required></td>
						</tr>
					</tfoot>
				  </table>
				  
				</div>
				
			</div>
		</div>
	 </div>
</form>

<table style="display:none;">
	<tr id="fee_row_assign">
	   <td width="40%">{!! get_fee_selectbox() !!}</td>
	   <td><input type="text" value="0" class="form-control float-field amount" name="amount[]" required></td>
	   <td><input type="text" value="0" class="form-control float-field discount" name="discount[]" required></td>
	   <td><input type="text" value="0" class="form-control float-field total" name="sub_total[]" readOnly="true" required></td>
	</tr>
</table>
 


<script type="text/javascript">

	$(document).on('click','#add-item-row-assign',function(){
		var row = $("#fee_row_assign").clone();
		console.log(row);		
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
	
		
</script>