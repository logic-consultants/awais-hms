<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{@$title}}</title>
    @include('backend.pdf.layouts.css')
</head>
<body >
@include('backend.pdf.layouts.report-header')
<main>
    <table class="table" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th style="text-align: left;" width="5%">{{_lang('SL#')}}</th>
            <th style="text-align: left;" width="10%">{{_lang('Reg No#')}}</th>
            <th style="text-align: left;" width="25%">{{_lang('Student Information')}}</th>
            <th style="text-align: left;" width="15%">{{_lang('Floor')}}</th>
            <th style="text-align: left;" width="15%">{{_lang('Room')}}</th>
            <th style="text-align: left;" width="20%">{{_lang('Contact')}}</th>
            <th class="text-center" width="10%">{{_lang('Months')}}</th>
            <th class="text-right" width="10%">{{_lang('Total')}}</th>
        </tr>
        </thead>
        <tbody>
            @php $grandTotal=0; @endphp
            @if(count($invoices)>0)
            @php $count=0 @endphp
            @foreach($invoices as $key => $invoice)
            <tr>
                <th style="text-align: left;">{{++$count}}</th>
                <th style="text-align: left;">{{$invoice[0]->register_no}}</th>
                <th style="text-align: left;">{{$invoice[0]->first_name}}</th>
                <th style="text-align: left;">{{$invoice[0]->class_name}}</th>
                <th style="text-align: left;">{{$invoice[0]->section_name}}</th>
                <td style="text-align: left;">
                    {{$invoice[0]->phone}}<br/>
                    @if($invoice[0]->home_phone)
                    {{_lang('Home Phone')}} : {{$invoice[0]->home_phone}}
                    @endif
                </td>
                <td>{{count($invoice)}}</td>
                <td class="text-right">
                    {{collect($invoice)->sum('total')-collect($invoice)->sum('paid')}}
                    @php $grandTotal= $grandTotal + (collect($invoice)->sum('total')-collect($invoice)->sum('paid')); @endphp
                </td>
            </tr>
            @endforeach
            @endif
            <tr>
                <th colspan="7">Grand Total: </th>
                <th colspan="">@php echo $grandTotal; @endphp </th>
            </tr>
        </tbody>
    </table>
</main>
@include('backend.pdf.layouts.footer')
</body>
</html>
