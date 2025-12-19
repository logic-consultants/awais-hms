<!--Invoice Information-->
<div class="panel panel-default">
<div class="panel-heading">
	<button type="button" data-print="print-invoice" class="btn btn-primary btn-sm print"><i class="fa fa-print"></i> {{ _lang('Print Invoice') }}</button>
</div>
    <div class="panel-body">
		<div class="invoice-box" style="padding: 20px;" id="print-invoice">
			<div class="row" style="padding: 0px;margin: 0px;">
				<div class="col-md-4" style="padding: 0px;margin: 0px;min-height: 1000px;position: relative;">
            <table cellpadding="0" cellspacing="0">
                <tr class="top">
                    <td colspan="2">
                        <table>
                            <tr>
                                <td class="title" style="width: 23%">
                                    <img src="{{ get_logo() }}" style="width:80px;">
                                </td>
                                <td style="width: 54%;text-align: center;">
                                    <b>{{ get_option("school_name") }}</b><br/>
                                    <small>{{ get_option("address") }}
                                    {{ _lang('Ph')." : ".get_option("phone") }}</small><br/>
                                    <small style="font-weight: 600;margin-top: 7px;display: inline-block;">School Copy</small>

                                </td>
                                <td style="width: 23%">
                                    <img src="{{ get_logo() }}" style="width:80px;">
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><h2 class="pm-0" align="center">{{ _lang('Fee Challan Form') }}</h2></td>
                </tr>
                <tr>
                    <td class="pt-3" colspan="2"><h4 class="pm-0" align="center">Credited At: {{ @$department->bank_name }}</h4></td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center pt-3"><span class="pm-0">{{ @$department->department_name }}</span></td>
                </tr>
                <tr>
                    <td class="text-left pt-3"><b>A/C#:</b><strong>{{ @$department->bank_account }}</strong></td>
                    <td class="text-right pt-3"><b>R#:</b><strong>__________</strong></td>
                </tr>
                <tr class="brk-10">
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td class="pt-3 pb-3" colspan="2"><b class="pm-0">{{ _lang("Name")}}:</b><strong> {{ $invoice->first_name." ".$invoice->last_name }}</strong></td>
                </tr>
                <tr>
                    <td class="pt-3 pb-3" colspan="2"><b class="pm-0">{{ _lang("Family Head") }}:</b> <strong>{{$invoice->parent_name}}</strong></td>
                </tr>
                <tr>
                    <td class="pt-3 pb-3" colspan="2"><b class="pm-0">{{ _lang("Department") }}:</b> <strong>{{@$department->department_name}}</strong></td>
                </tr>
                <tr>
                    <td class="pt-3 pb-3" class="text-left" width="50%"><b class="pm-0"> {{ _lang("Class") }}:</b> <strong>{{$invoice->class_name}}</strong></td>
                    <td class="pt-3 pb-3" class="text-left" width="50%"><b class="pm-0"> {{ _lang("Section") }}:</b> <strong>{{$invoice->section_name}}</strong></td>
                </tr>

                <tr>
                    <td class="pt-3 pb-3" colspan="2"><b class="pm-0">{{ _lang('Periods') }}:</b> {{ $invoice->title }}</td>
                </tr>

                <tr class="brk-10">
                    <td colspan="2"></td>
                </tr>
            </table>    

            <!--End Invoice Information-->
                
            <!--Invoice Product-->
            <div class="col-md-12"> 
                <fieldset>
                    <legend>Fee Details:</legend>
                    <table class="table-data">
                        <tbody>    
                            @foreach($invoiceItems as $item)                
                               <tr>
                                 <td class="text-left" width="70%"><b>{{ $item->fee_type }}</b></td>
                                 <td class="text-right">{{ $currency." ".decimalPlace($item->amount-$item->discount) }}</td>
                               </tr>
                            @endforeach
                        </tbody>
                        <tbody>
                            <tr>
                                <td class="text-left"><b>{{ _lang('Total Receivable') }}</b></td>
                                <td class="text-right"><b>{{ $currency." ".decimalPlace($invoice->total-$invoice->paid) }}</b></td>
                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <td class="text-left"><b>{{ _lang('After Due Date') }}</b></td>
                                <td class="text-right"><b>{{ $currency." ".decimalPlace(($invoice->total-$invoice->paid)+100) }}</b></td>
                            </tr>
                        </tbody>
                    </table>
                </fieldset>
            </div> 

            <div class="footer">
                <div class="row">
                    <div class="col-md-12">
                        <table>
                            <tr>
                                <th style="text-align: left;border:none;padding: 3px;width:70%;"><b style="border-top: 1px solid #c59999b3;">Deposited By:</b></th>
                                <th style="text-align: left;border:none;padding: 3px;width:30%;"><b style="border-top: 1px solid #c59999b3;">Received By:</b></th>
                            </tr>
                            <tr class="brk-10">
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td class="text-left" colspan="2"><b>This Voucher is valid only in the month of : {{date('F',strtotime(now()))}}</b></td>
                            </tr>
                            <tr>
                                <td class="text-left pt-3" colspan="2"><b>Dues once paid are not refundable in anycase.</b></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
			</div>
		 

		</div><!--End Invoice Box-->
    </div>
</div>
