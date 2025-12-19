<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Pay Sllip</title>
    @include('backend.pdf.layouts.feebill_css')

</head>
<div id="preloader">
		<div class="bar"></div>
	</div>

@if($save_print=='save_print')

<body onload="window.print();">
    @else
    <body>
        @endif
        
        <p style="margin-top: 20px;">Powered by http://logic-consultants.com</p>
<main >
    <div class="row" style="padding: 0px;margin: 0px;">
        <div class="col-md-12" style="padding: 0px;margin: 0px;">
            <div style="padding: 0px;">
                <table cellpadding="0" cellspacing="0">
                    <tr class="top">
                        <td colspan="2">
                            <table>
                                <tr>
                                    <td style="width: 60%;" align="center">
                                       
                                        <br>
                                        <!--
                                        <img src="{{ get_department_logo(@$department->id,'school_logo') }}" style="width:100%;"> 
                                        -->
                                         <center><img src="{{ get_logo()}}" style="width:100px;height:80px;">  </center>
                                        <b><h2 class="pm-0">{{ get_option("school_name") }}</h2></b>
                                        <small>{{ get_option("address") }}
                                        {{ _lang('Ph')." : ".get_option("phone") }}</small>
                                       
                                        <br/>

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><h2 class="pm-0" align="center">{{ _lang('Pay Slip') }}</h2></td>
                    </tr>
                    <?php //dd($transaction, $invoice, $studentpayment); ?>
                    <tr>
                        <td colspan="2" class="text-center pt-3"><span class="pm-0">{{ @$department->department_name }}</span></td>
                    </tr>
                    <tr class="brk-10">
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td class="pt-3 pb-3" colspan="2"><b class="pm-0">{{ _lang("Name")}}:</b><strong> {{ $student->first_name." ".$student->last_name }}</strong></td>
                    </tr>
                    
                    <tr>
                        <td class="pt-3 pb-3" class="text-left" width="50%"><b class="pm-0"> {{ _lang("Floor") }}:</b> <strong>{{isset($section_class) ? $section_class->class_name:$invoice->class_name}}</strong></td>
                        <td class="pt-3 pb-3" class="text-left" width="50%"><b class="pm-0"> {{ _lang("Room") }}:</b> <strong>{{isset($section) ? $section->section_name:$invoice->section_name}}</strong></td>
                    </tr>

                    <tr class="brk-10">
                        <td colspan="2"></td>
                    </tr>
                </table>
                <div style="margin-top: 10px;"> 
                    <fieldset>
                        <legend>Fee Details:</legend>
                        @if(!empty($invoice))
                        <b>{{ _lang('Periods') }}:</b> 
                        <span>
                            {{ $invoice->title }}
                        </span>
                        <table class="table-data" style="margin-top: 5px;margin-bottom: 5px;">
                            <tbody>    
                                   <small><?php //dd($invoiceItems); ?></small>

                                @foreach($invoiceItems as $item)
                                   <tr>
                                     <td class="text-left" width="70%"><b>{{ @$item->account_name }}</b></td>
                                     <td class="text-right">{{ $currency." ".decimalPlace($item->amount-$item->discount) }}</td>
                                   </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <hr/>
                        <p class="text-right" style="margin: 3px;"> 
                        <b>
                            {{_lang('Paid Amount')}}: {{ $currency." ".decimalPlace($invoice->paid) }}
                        </b>
                        </p>

                        <p class="text-right" style="margin: 3px;"> 
                        <b>@if($total_balance>0)
                            {{_lang('Remaining Balance')}}: {{ $currency." ".decimalPlace(@$total_balance) }}
                        
                        @endif
                        </b>
                        </p>
                        <hr/>
                        
                        @if($invoice->payment_date)
                        <b>{{_lang('Payment Date')}}:</b> 
                        <span>
                            {{date('l, F d, Y',strtotime($invoice->payment_date))}}
                        </span>
                        @endif
                         @if($receipt_no)
                        <b>{{_lang('Receipt No')}}:</b> 
                        <span>
                            {{ $receipt_no }}
                        </span>
                        @endif
                        @endif
                    </fieldset>
                </div>
            </div>
        </div>        
    </div>
</main>

</body>
</html>
<script>
    window.onafterprint = function() {
    // Delay redirect by 300ms to allow loader to show
    document.getElementById("preloader").style.display = "block";


    // Delay redirect by 300ms to allow loader to show
    setTimeout(function() {
        window.location.href = "{{ url('/invoices') }}";
    },
    100);
};

    window.onload = function() {
        window.print();
    };

    window.onpopstate = function() {
        window.location.href = "{{ url('/invoices') }}";
    };
</script>

