<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Fee Summary Report</title>
    @include('backend.pdf.layouts.css')
</head>
<body >
@include('backend.pdf.layouts.report-header')
<main>


    <table class="table" id="feeSummaryTableWithDues" width="100%" cellspacing="0">
        <thead>
        <tr>
            <!--Headings of columns-->
        	<th style="text-align: left;" width="10%">{{_lang('RoomNo#')}}</th>
        	<th style="text-align: left;" width="10%">{{_lang('Date')}}</th>
        	<th style="text-align: left;" width="20%">{{_lang('Student Information')}}</th>
        	<th class="text-right" width="10%">{{_lang('Prev.Dues')}}</th>
        	@if(count($fees)>0)
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
            	    $previTotal=0;
            	    $previBottomTotal=0;
                    $tot_Paid = 0;
                    $tot_Total = 0;
                    $tot_Balance = 0;
                    $listLength=count($fees);
                    $eachList = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
                @endphp
        	@if(count($invoices)>0)
        	@foreach($invoices as $invoice)
<tr>
    <td>{{ $invoice->section_name }}</td>
    <td>{{ $request->date_from ?? '' }}</td>
    <td>{{ $invoice->register_no }}-{{ $invoice->first_name }}-{{ $invoice->class_name }}</td>
    
    <td class="text-right">
        @php
            $prevDue = $previousInvoices->firstWhere('student_id', $invoice->student_id);
            $prevBalance = $prevDue->total_dues ?? 0;
        @endphp
        {{ $prevBalance }}
    </td>

    @php
        $total = 0;
    @endphp

    @foreach($fees as $fee)
        @php
            // Aggregate fee total from all invoice_items matching this student and fee
            $itemSum = \App\InvoiceItem::whereHas('invoice', function($q) use ($invoice, $request) {
                    $q->where('student_id', $invoice->student_id)
                      ->where('session_id', $request->session)
                      ->where('school_id', schoolId());
                    if (!empty($request->date_from)) {
                        $q->whereDate('due_date', '>=', now()->parse($request->date_from)->format('Y-m-d'));
                    }
                    if (!empty($request->date_to)) {
                        $q->whereDate('due_date', '<=', now()->parse($request->date_to)->format('Y-m-d'));
                    }
                })
                ->where('fee_id', $fee->id)
                ->sum(DB::raw('amount - discount'));

            $eachList[$fee->id] = ($eachList[$fee->id] ?? 0) + $itemSum;
            $total += $itemSum;
        @endphp
        <td class="text-right">{{ $itemSum }}</td>
    @endforeach

    <td class="text-right">{{ $total + $prevBalance }}</td>
    <td class="text-right">{{ $invoice->paid }}</td>
    <td class="text-right">{{ ($total + $prevBalance) - $invoice->paid }}</td>
</tr>
@endforeach

            @endif
            
            <!--Totals at the end-->
			<tr>
    <td colspan="3"><b>Totals ({{ count($invoices) }})</b></td>
    <td class="text-right"><b>@php echo $previBottomTotal; @endphp</b></td>
    @php
        $totalFeesSum = 0;
        foreach ($fees as $fee) {
            echo "<td class='text-right'><b>".($eachList[$fee->id] ?? 0)."</b></td>";
            $totalFeesSum += ($eachList[$fee->id] ?? 0);
        }
    @endphp
    <td class="text-right"><b>@php echo $totalFeesSum + $previBottomTotal; @endphp</b></td>
    <td class="text-right"><b>@php echo $tot_Paid; @endphp</b></td>
    <td class="text-right"><b>@php echo ($totalFeesSum + $previBottomTotal) - $tot_Paid; @endphp</b></td>
</tr>



        </tbody>
    </table>
</main>
@include('backend.pdf.layouts.footer')
</body>
</html>