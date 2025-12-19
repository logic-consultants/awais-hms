<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Fee Bill</title>
    @include('backend.pdf.layouts.feebill_css')
</head>
<body>
<main>

    @php $department =\App\Department::find($invoices[0]['department_id']); @endphp
    <div class="row" style="padding: 0px;margin: 0px;">
        <div class="col-md-4" style="padding: 0px;margin: 0px;">
            <div style="padding: 10px;border-right:2px dashed #968585;">
                <table cellpadding="0" cellspacing="0">
                    <tr class="top">
                        <td colspan="2">
                            <table>
                                <tr>
                                    <td class="title" style="width: 23%">
                                        <img src="{{ get_department_logo(@$department->id,'school_logo') }}" style="width:80px;">
                                    </td>
                                    <td style="width: 54%;text-align: center;">
                                        <b>{{ get_option("school_name") }}</b><br/>
                                        <small>{{ get_option("address") }}
                                        {{ _lang('Ph')." : ".get_option("phone") }}</small><br/>
                                        <span style="font-weight: 600;margin-top: 7px;">Hostel Copy</span>

                                    </td>
                                    <td style="width: 23%">
                                        <img src="{{ get_department_logo(@$department->id,'bank_logo') }}" style="width:80px;">
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
                        <td class="text-left pt-3"><b>A/C#: </b><strong>{{ @$department->bank_account }}</strong></td>
                        <td class="text-right pt-3"><b>R#: </b><strong>__________</strong></td>
                    </tr>
                    <tr class="brk-10">
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td class="pt-3 pb-3" colspan="2"><b class="pm-0">{{ _lang("Name")}}:</b><strong> {{ $invoices[0]['first_name']." ".$invoices[0]['last_name'] }}</strong></td>
                    </tr>
                    <tr>
                        <td class="pt-3 pb-3" colspan="2"><b class="pm-0">{{ _lang("Family Head") }}:</b> <strong>{{$invoices[0]['parent_name']}}</strong></td>
                    </tr>
                    <tr>
                        <td class="pt-3 pb-3" class="text-left" width="50%"><b class="pm-0"> {{ _lang("Class") }}:</b> <strong>{{$invoices[0]['class_name']}}</strong></td>
                        <td class="pt-3 pb-3" class="text-left" width="50%"><b class="pm-0"> {{ _lang("Section") }}:</b> <strong>{{$invoices[0]['section_name']}}</strong></td>
                    </tr>

                    <tr class="brk-10">
                        <td colspan="2"></td>
                    </tr>
                </table>
                <div style="margin-top: 10px;"> 
                    <fieldset>
                        <legend>Fee Details:</legend>
                        @if(count($invoices)>0)
                        @php $grand_total=0 @endphp
                        @foreach($invoices as $row_period)
                        <b>{{ _lang('Periods') }}:</b> 
                        <span>
                            {{ $row_period['title'] }}
                        </span>
                        <table class="table-data" style="margin-top: 5px;margin-bottom: 5px;">
                            <tbody>    
                                @foreach($row_period['invoice_item'] as $item)                
                                   <tr>
                                     <td class="text-left" width="70%"><b>{{ @$item['feetypename']['fee_type'] }}</b></td>
                                     <td class="text-right">{{ $currency." ".decimalPlace($item['amount']-$item['discount']) }}</td>
                                   </tr>
                                @endforeach
                            </tbody>
                            @php $grand_total=$grand_total+($row_period['total']-$row_period['paid']); @endphp
                        </table>
                        <hr/>

                        @endforeach

                        <p class="text-right" style="margin: 3px;"> 
                        <b>
                            {{_lang('Total Receivable')}}: {{ $currency." ".decimalPlace($grand_total) }}
                        </b>
                        </p>
                        <p class="text-right" style="margin: 3px;"> 
                            <b>
                                {{_lang('After Due Date')}}: {{ $currency." ".decimalPlace(($grand_total)+(100*count($invoices))) }}
                            </b>
                        </p>

                        <b>{{_lang('Due Date')}}:</b> 
                        <span>
                            {{date('l, F d, Y',strtotime($invoices[0]['due_date']))}}
                        </span>
                        @endif
                    </fieldset>
                </div> 

                <table style="margin-top: 30px;">
                    <tr>
                        <th style="text-align: left;border:none;padding: 3px;width:70%;"><b style="border-top: 1px solid #c59999b3;">Deposited By:</b></th>
                        <th style="text-align: left;border:none;padding: 3px;width:30%;"><b style="border-top: 1px solid #c59999b3;">Received By:</b></th>
                    </tr>
                    <tr class="brk-10">
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td class="text-left" colspan="2">This Voucher is valid only in the month of : {{date('F',strtotime(now()))}}</td>
                    </tr>
                    <tr>
                        <td class="text-left pt-3" colspan="2">Dues once paid are not refundable in anycase.</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-md-4" style="padding: 0px;margin: 0px;">
            <div style="padding: 10px;border-right:2px dashed #968585;">
                <table cellpadding="0" cellspacing="0">
                    <tr class="top">
                        <td colspan="2">
                            <table>
                                <tr>
                                    <td class="title" style="width: 23%">
                                        <img src="{{ get_department_logo(@$department->id,'school_logo') }}" style="width:80px;">
                                    </td>
                                    <td style="width: 54%;text-align: center;">
                                        <b>{{ get_option("school_name") }}</b><br/>
                                        <small>{{ get_option("address") }}
                                        {{ _lang('Ph')." : ".get_option("phone") }}</small><br/>
                                        <span style="font-weight: 600;margin-top: 7px;">Bank Copy</span>

                                    </td>
                                    <td style="width: 23%">
                                        <img src="{{ get_department_logo(@$department->id,'bank_logo') }}" style="width:80px;">
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
                        <td class="text-left pt-3"><b>A/C#: </b><strong>{{ @$department->bank_account }}</strong></td>
                        <td class="text-right pt-3"><b>R#: </b><strong>__________</strong></td>
                    </tr>
                    <tr class="brk-10">
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td class="pt-3 pb-3" colspan="2"><b class="pm-0">{{ _lang("Name")}}:</b><strong> {{ $invoices[0]['first_name']." ".$invoices[0]['last_name'] }}</strong></td>
                    </tr>
                    <tr>
                        <td class="pt-3 pb-3" colspan="2"><b class="pm-0">{{ _lang("Family Head") }}:</b> <strong>{{$invoices[0]['parent_name']}}</strong></td>
                    </tr>
                    <tr>
                        <td class="pt-3 pb-3" class="text-left" width="50%"><b class="pm-0"> {{ _lang("Class") }}:</b> <strong>{{$invoices[0]['class_name']}}</strong></td>
                        <td class="pt-3 pb-3" class="text-left" width="50%"><b class="pm-0"> {{ _lang("Section") }}:</b> <strong>{{$invoices[0]['section_name']}}</strong></td>
                    </tr>

                    <tr class="brk-10">
                        <td colspan="2"></td>
                    </tr>
                </table>
                <div style="margin-top: 10px;"> 
                    <fieldset>
                        <legend>Fee Details:</legend>
                        @if(count($invoices)>0)
                        @php $grand_total=0 @endphp
                        @foreach($invoices as $row_period)
                        <b>{{ _lang('Periods') }}:</b> 
                        <span>
                            {{ $row_period['title'] }}
                        </span>
                        <table class="table-data" style="margin-top: 5px;margin-bottom: 5px;">
                            <tbody>    
                                @foreach($row_period['invoice_item'] as $item)                
                                   <tr>
                                     <td class="text-left" width="70%"><b>{{ @$item['feetypename']['fee_type'] }}</b></td>
                                     <td class="text-right">{{ $currency." ".decimalPlace($item['amount']-$item['discount']) }}</td>
                                   </tr>
                                @endforeach
                            </tbody>
                            @php $grand_total=$grand_total+($row_period['total']-$row_period['paid']); @endphp
                        </table>

                        <hr/>

                        @endforeach

                        <p class="text-right" style="margin: 3px;"> 
                        <b>
                            {{_lang('Total Receivable')}}: {{ $currency." ".decimalPlace($grand_total) }}
                        </b>
                        </p>
                        <p class="text-right" style="margin: 3px;"> 
                            <b>
                                {{_lang('After Due Date')}}: {{ $currency." ".decimalPlace(($grand_total)+(100*count($invoices))) }}
                            </b>
                        </p>
                        <b>{{_lang('Due Date')}}:</b> 
                        <span>
                            {{date('l, F d, Y',strtotime($invoices[0]['due_date']))}}
                        </span>
                        @endif
                    </fieldset>
                </div> 

                <table style="margin-top: 30px;">
                    <tr>
                        <th style="text-align: left;border:none;padding: 3px;width:70%;"><b style="border-top: 1px solid #c59999b3;">Deposited By:</b></th>
                        <th style="text-align: left;border:none;padding: 3px;width:30%;"><b style="border-top: 1px solid #c59999b3;">Received By:</b></th>
                    </tr>
                    <tr class="brk-10">
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td class="text-left" colspan="2">This Voucher is valid only in the month of : {{date('F',strtotime(now()))}}</td>
                    </tr>
                    <tr>
                        <td class="text-left pt-3" colspan="2">Dues once paid are not refundable in anycase.</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-md-4" style="padding: 0px;margin: 0px;">
            <div style="padding: 10px;">
                <table cellpadding="0" cellspacing="0">
                    <tr class="top">
                        <td colspan="2">
                            <table>
                                <tr>
                                    <td class="title" style="width: 23%">
                                        <img src="{{ get_department_logo(@$department->id,'school_logo') }}" style="width:80px;">
                                    </td>
                                    <td style="width: 54%;text-align: center;">
                                        <b>{{ get_option("school_name") }}</b><br/>
                                        <small>{{ get_option("address") }}
                                        {{ _lang('Ph')." : ".get_option("phone") }}</small><br/>
                                        <span style="font-weight: 600;margin-top: 7px;">Student Copy</span>

                                    </td>
                                    <td style="width: 23%">
                                        <img src="{{ get_department_logo(@$department->id,'bank_logo') }}" style="width:80px;">
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
                        <td class="text-left pt-3"><b>A/C#: </b><strong>{{ @$department->bank_account }}</strong></td>
                        <td class="text-right pt-3"><b>R#: </b><strong>__________</strong></td>
                    </tr>
                    <tr class="brk-10">
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td class="pt-3 pb-3" colspan="2"><b class="pm-0">{{ _lang("Name")}}:</b><strong> {{ $invoices[0]['first_name']." ".$invoices[0]['last_name'] }}</strong></td>
                    </tr>
                    <tr>
                        <td class="pt-3 pb-3" colspan="2"><b class="pm-0">{{ _lang("Family Head") }}:</b> <strong>{{$invoices[0]['parent_name']}}</strong></td>
                    </tr>
                    <tr>
                        <td class="pt-3 pb-3" class="text-left" width="50%"><b class="pm-0"> {{ _lang("Class") }}:</b> <strong>{{$invoices[0]['class_name']}}</strong></td>
                        <td class="pt-3 pb-3" class="text-left" width="50%"><b class="pm-0"> {{ _lang("Section") }}:</b> <strong>{{$invoices[0]['section_name']}}</strong></td>
                    </tr>

                    <tr class="brk-10">
                        <td colspan="2"></td>
                    </tr>
                </table>
                <div style="margin-top: 10px;"> 
                    <fieldset>
                        <legend>Fee Details:</legend>
                        @if(count($invoices)>0)
                        @php $grand_total=0 @endphp
                        @foreach($invoices as $row_period)
                        <b>{{ _lang('Periods') }}:</b> 
                        <span>
                            {{ $row_period['title'] }}
                        </span>
                        <table class="table-data" style="margin-top: 5px;margin-bottom: 5px;">
                            <tbody>    
                                @foreach($row_period['invoice_item'] as $item)                
                                   <tr>
                                     <td class="text-left" width="70%"><b>{{ @$item['feetypename']['fee_type'] }}</b></td>
                                     <td class="text-right">{{ $currency." ".decimalPlace($item['amount']-$item['discount']) }}</td>
                                   </tr>
                                @endforeach
                            </tbody>
                            @php $grand_total=$grand_total+($row_period['total']-$row_period['paid']); @endphp
                        </table>
                        <hr/>

                        @endforeach

                        <p class="text-right" style="margin: 3px;"> 
                        <b>
                            {{_lang('Total Receivable')}}: {{ $currency." ".decimalPlace($grand_total) }}
                        </b>
                        </p>
                        <p class="text-right" style="margin: 3px;"> 
                            <b>
                                {{_lang('After Due Date')}}: {{ $currency." ".decimalPlace(($grand_total)+(100*count($invoices))) }}
                            </b>
                        </p>
                        <b>{{_lang('Due Date')}}:</b> 
                        <span>
                            {{date('l, F d, Y',strtotime($invoices[0]['due_date']))}}
                        </span>
                        @endif
                    </fieldset>
                </div> 

                <table style="margin-top: 30px;">
                    <tr>
                        <th style="text-align: left;border:none;padding: 3px;width:70%;"><b style="border-top: 1px solid #c59999b3;">Deposited By:</b></th>
                        <th style="text-align: left;border:none;padding: 3px;width:30%;"><b style="border-top: 1px solid #c59999b3;">Received By:</b></th>
                    </tr>
                    <tr class="brk-10">
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td class="text-left" colspan="2">This Voucher is valid only in the month of : {{date('F',strtotime(now()))}}</td>
                    </tr>
                    <tr>
                        <td class="text-left pt-3" colspan="2">Dues once paid are not refundable in anycase.</td>
                    </tr>
                </table>
            </div>
        </div>
        
    </div>
    
</main>

</body>
</html>
