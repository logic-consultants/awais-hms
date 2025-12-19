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
    @php $grandTotal=0; @endphp
    @foreach($classes as $class_row)
    <p><b>Floor : </b> {{$class_row->class_name}}</p>
    <table class="table" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th style="text-align: left;" width="5%">{{_lang('SL#')}}</th>
            <th style="text-align: left;" width="10%">{{_lang('Reg No#')}}</th>
            <th style="text-align: left;" width="25%">{{_lang('Student Information')}}</th>
            <th style="text-align: left;" width="15%">{{_lang('Room')}}</th>
            <th style="text-align: left;" width="20%">{{_lang('Contact')}}</th>
            <th class="text-center" width="10%">{{_lang('Months')}}</th>
            <th class="text-right" width="10%">{{_lang('Total')}}</th>
        </tr>
        </thead>
        <tbody>
            @php $subTotal=0; @endphp
            @if(count($invoices)>0)
            @php $count=0; @endphp
            @foreach($invoices as $key => $invoice)
            @if($invoice[0]->class_id==$class_row->id)
            <tr>
                <th style="text-align: left;">{{++$count}}</th>
                <th style="text-align: left;">{{$invoice[0]->register_no}}</th>
                <th style="text-align: left;">{{$invoice[0]->first_name}}</th>
                <th style="text-align: left;">{{$invoice[0]->section_name}}</th>
                <td style="text-align: left;">{{$invoice[0]->phone}}<br/>
                    @if($invoice[0]->home_phone)
                    {{_lang('Home Phone')}} : {{$invoice[0]->home_phone}}
                    @endif
                </td>
                <td>{{count($invoice)}} {{('months')}}</td>
                <td class="text-right">
                    {{collect($invoice)->sum('total')-collect($invoice)->sum('paid')}}
                    @php $subTotal= $subTotal + (collect($invoice)->sum('total')-collect($invoice)->sum('paid')); @endphp
                </td>
            </tr>
            @endif
            @endforeach
            @endif            
            <tr>
                <th colspan="6">Floor Total: </th>
                <th colspan="">@php echo $subTotal; @endphp </th>
                @php $grandTotal=$grandTotal+$subTotal; @endphp
            </tr>
        </tbody>
    </table>
    @endforeach
    <br><br>
    <h1>@php echo "Grand Total: ".$grandTotal; @endphp </h1>
</main>
@include('backend.pdf.layouts.footer')
</body>
</html>
