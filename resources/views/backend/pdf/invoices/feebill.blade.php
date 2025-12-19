<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Fee Bill</title>
    @include('backend.pdf.layouts.feebill_css')
</head>
<body>
<main>
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

                    <tr class="brk-10">
                        <td colspan="2"></td>
                    </tr>
                </table>
                <div style="margin-top: 10px;"> 
                    <fieldset>
                        <b>{{ _lang('Periods') }}:</b> <span>{{ $invoice->title }}</span>
                        <legend>Fee Details:</legend>
                        <table class="table-data" style="margin-top: 10px;margin-bottom: 10px;">                     
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
                                    <td class="text-left"><b>{{ _lang('Previous Balance') }}</b></td>
                                    <td class="text-right"><b>{{ $currency." ".decimalPlace((\App\Invoice::where('student_id',$invoice->student_id)->sum('total') - \App\Invoice::where('student_id',$invoice->student_id)->sum('paid'))-($invoice->total-$invoice->paid)) }}</b></td>
                                </tr>
                            </tbody>
                           <tbody>              
                                   <tr>
                                     <td class="text-left" width="70%"><b>{{ _lang('Total Payable') }}</b></td>
                                     <td class="text-right">{{$currency." "}}{{\App\Invoice::where('student_id',$invoice->student_id)->sum('total') - \App\Invoice::where('student_id',$invoice->student_id)->sum('paid') }}</td>
                                   </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <td class="text-left"><b>{{ _lang('After Due Date') }}</b></td>
                                    <td class="text-right"><b>{{ $currency." ".decimalPlace((\App\Invoice::where('student_id',$invoice->student_id)->sum('total') - \App\Invoice::where('student_id',$invoice->student_id)->sum('paid'))+100) }}</b></td>
                                </tr>
                            </tbody>
                        </table>
                        <b>{{_lang('Due Date')}}:</b> <span>{{date('l, F d, Y',strtotime($invoice->due_date))}}</span>
                    </fieldset>
                </div> 

                <table style="margin-top: 100px;">
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

                    <tr class="brk-10">
                        <td colspan="2"></td>
                    </tr>
                </table>
                <div style="margin-top: 10px;"> 
                    <fieldset>
                        <b>{{ _lang('Periods') }}:</b> <span>{{ $invoice->title }}</span>
                        <legend>Fee Details:</legend>
                        <table class="table-data" style="margin-top: 10px;margin-bottom: 10px;">
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
                                    <td class="text-left"><b>{{ _lang('Previous Balance') }}</b></td>
                                    <td class="text-right"><b>{{ $currency." ".decimalPlace((\App\Invoice::where('student_id',$invoice->student_id)->sum('total') - \App\Invoice::where('student_id',$invoice->student_id)->sum('paid'))-($invoice->total-$invoice->paid)) }}</b></td>
                                </tr>
                            </tbody>
                           <tbody>              
                                   <tr>
                                     <td class="text-left" width="70%"><b>{{ _lang('Total Payable') }}</b></td>
                                     <td class="text-right">{{$currency." "}}{{\App\Invoice::where('student_id',$invoice->student_id)->sum('total') - \App\Invoice::where('student_id',$invoice->student_id)->sum('paid') }}</td>
                                   </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <td class="text-left"><b>{{ _lang('After Due Date') }}</b></td>
                                    <td class="text-right"><b>{{ $currency." ".decimalPlace((\App\Invoice::where('student_id',$invoice->student_id)->sum('total') - \App\Invoice::where('student_id',$invoice->student_id)->sum('paid'))+100) }}</b></td>
                                </tr>
                            </tbody>
                        </table>
                        <b>{{_lang('Due Date')}}:</b> <span>{{date('l, F d, Y',strtotime($invoice->due_date))}}</span>
                    </fieldset>
                </div> 

                <table style="margin-top: 100px;">
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
            <div style="padding: 10px">
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

                    <tr class="brk-10">
                        <td colspan="2"></td>
                    </tr>
                </table>
                <div style="margin-top: 10px;"> 
                    <fieldset>
                        <b>{{ _lang('Periods') }}:</b> <span>{{ $invoice->title }}</span>
                        <legend>Fee Details:</legend>
                        <table class="table-data" style="margin-top: 10px;margin-bottom: 10px;">        
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
                                    <td class="text-left"><b>{{ _lang('Previous Balance') }}</b></td>
                                    <td class="text-right"><b>{{ $currency." ".decimalPlace((\App\Invoice::where('student_id',$invoice->student_id)->sum('total') - \App\Invoice::where('student_id',$invoice->student_id)->sum('paid'))-($invoice->total-$invoice->paid)) }}</b></td>
                                </tr>
                            </tbody>
                           <tbody>              
                                   <tr>
                                     <td class="text-left" width="70%"><b>{{ _lang('Total Payable') }}</b></td>
                                     <td class="text-right">{{$currency." "}}{{\App\Invoice::where('student_id',$invoice->student_id)->sum('total') - \App\Invoice::where('student_id',$invoice->student_id)->sum('paid') }}</td>
                                   </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <td class="text-left"><b>{{ _lang('After Due Date') }}</b></td>
                                    <td class="text-right"><b>{{ $currency." ".decimalPlace((\App\Invoice::where('student_id',$invoice->student_id)->sum('total') - \App\Invoice::where('student_id',$invoice->student_id)->sum('paid'))+100) }}</b></td>
                                </tr>
                            </tbody>
                        </table>
                        <b>{{_lang('Due Date')}}:</b> <span>{{date('l, F d, Y',strtotime($invoice->due_date))}}</span>
                    </fieldset>
                </div> 

                <table style="margin-top: 100px;">
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
            </span>
        </div>
    </div>
</main>

</body>
</html>
