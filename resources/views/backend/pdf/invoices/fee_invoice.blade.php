<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Fee Invoice</title>
    @include('backend.pdf.layouts.feebill_css')
</head>
<body>
<main>
    <!-- @php $department =\App\Department::find($invoices[0]['department_id']); @endphp -->
    <div class="row" style="padding: 0px;margin: 0px;">
        <div class="col-md-12" style="padding: 0px;margin: 0px;">
            <div style="padding: 10px;">
                <table cellpadding="0" cellspacing="0">
                    <tr class="top">
                        <td colspan="2">
                            <table>
                                <tr>
                                    <td class="title" style="width: 20%">
                                        <img src="{{ get_department_logo($department->id,'school_logo') }}" style="width:100%;">
                                    </td>
                                    <td style="width: 60%;text-align: center;">
                                        <b>{{ get_option("school_name") }}</b><br/>
                                        <small>{{ get_option("address") }}
                                        {{ _lang('Ph')." : ".get_option("phone") }}</small><br/>

                                    </td>
                                    <td style="width: 20%">
                                        <img src="{{ get_department_logo($department->id,'school_logo') }}" style="width:100%;">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><h2 class="pm-0" align="center">{{ _lang('Fee Invoice') }}</h2></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center pt-3"><span class="pm-0">{{ $department->department_name }}</span></td>
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
                            @php $grand_total=$grand_total+$row_period['paid']; @endphp
                        </table>
                        <hr/>

                        @endforeach

                        <p class="text-right" style="margin: 3px;"> 
                        <b>
                            {{_lang('Invoice Total')}}: {{ $currency." ".decimalPlace($grand_total) }}
                        </b>
                        </p>

                        <hr/>
                        <p class="text-left" style="margin: 3px;"> 
                        <b>
                            {{_lang('Total Balance')}}: {{ $currency." ".decimalPlace(@$tital_balance) }}
                        </b>
                        </p>

                        {{-- <b>{{_lang('Payment Date')}}:</b> 
                        <span>
                            {{date('l, F d, Y',strtotime($invoices[0]['due_date']))}}
                        </span> --}}
                        @endif
                    </fieldset>
                </div>
            </div>
        </div>        
    </div>
</main>

</body>
</html>
