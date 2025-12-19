<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Fee Summary Report</title>
    @include('backend.pdf.layouts.css')
</head>
<body>
@include('backend.pdf.layouts.report-header')
<main>

    <table class="table" id="feeSummaryTable" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th style="text-align: left;" width="15%">{{_lang('Room#')}}</th>
            <th style="text-align: left;" width="15%">{{_lang('Date')}}</th>
            <th style="text-align: left;" width="35%">{{_lang('Student Information')}}</th>
            @if(count($fees) > 0)
                @foreach($fees as $fee)
                    <th class="text-right" width="7%">{{$fee->fee_type}}</th>
                @endforeach
                <th class="text-right" width="10%">{{_lang('Total')}}</th>
                <th class="text-right" width="10%">{{_lang('Paid')}}</th>
                <th class="text-right" width="10%">{{_lang('Balance')}}</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @php
            $tot_Paid = 0;
            $tot_Total = 0;
            $tot_Balance = 0;
            $eachList = [];

            foreach($fees as $fee) {
                $eachList[$fee->id] = 0;
            }
        @endphp

        @if(count($invoices) > 0)
            @foreach($invoices as $invoice)
                <tr>
                    <th style="text-align: left;">{{$invoice->section_name}}</th>
                    <th style="text-align: left;">{{date('d-M-Y', strtotime($invoice->payment_date))}}</th>
                    <th style="text-align: left;">
                        {{$invoice->register_no}}-{{$invoice->first_name}}-{{$invoice->class_name}}-{{$invoice->title}}
                    </th>

                    @if(count($fees) > 0)
                        @php $total = 0; @endphp

                        @foreach($fees as $fee)
                            @php $item_price = 0; @endphp

                            @if(count($invoice->invoice_item) > 0)
                                @foreach($invoice->invoice_item as $item)
                                    @if($item->fee_id == $fee->id)
                                        @php
                                            $item_price = $item->amount - $item->discount;
                                            $eachList[$fee->id] += $item_price;
                                        @endphp
                                    @endif
                                @endforeach
                            @endif

                            @php $total += $item_price; @endphp
                            <td class="text-right">{{$item_price}}</td>
                        @endforeach

                        <td class="text-right">{{$total}}</td>

                        @php
                            $tot_Total += $total;
                            $tot_Paid += $invoice->paid;
                            $tot_Balance += ($total - $invoice->paid);
                        @endphp

                        <td class="text-right">{{$invoice->paid}}</td>
                        <td class="text-right">{{$total - $invoice->paid}}</td>
                    @endif
                </tr>
            @endforeach
        @endif

        <!-- Totals row -->
        <tr>
            <td colspan="3"><b>Totals</b></td>
            @foreach($fees as $fee)
                <td class="text-right"><b>{{$eachList[$fee->id]}}</b></td>
            @endforeach
            <td class="text-right"><b>{{$tot_Total}}</b></td>
            <td class="text-right"><b>{{$tot_Paid}}</b></td>
            <td class="text-right"><b>{{$tot_Balance}}</b></td>
        </tr>
        </tbody>
    </table>
</main>
@include('backend.pdf.layouts.footer')
</body>
</html>
