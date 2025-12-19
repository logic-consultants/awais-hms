<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Fee Definition Report(Student Wise)</title>
    @include('backend.pdf.layouts.css')
</head>
<body >
@include('backend.pdf.layouts.report-header')
<main>


    <table class="table" width="100%" cellspacing="0">
        <thead>
        <tr>
        	<th style="text-align: left;" width="15%">{{_lang('SL#')}}</th>
        	<th style="text-align: left;" width="35%">{{_lang('Student Information')}}</th>
            <th style="text-align: left;" width="15%">{{_lang('Father Name')}}</th>
            <th style="text-align: left;" width="15%">{{_lang('Amount')}}</th>
        </tr>
        </thead>
        <tbody>
        	@if(count($studentFeeAssign) > 0)
            @php $grand_total = 0; @endphp

            @foreach($studentFeeAssign as $key => $student)
                @php $grand_total += $student->amount; @endphp
                <tr>
                    <td style="text-align: left;">{{ $key + 1 }}</td>
                    <td style="text-align: left;">{{ $student->first_name }} - {{ $student->class_name }} - {{ $student->section_name }}</td>
                    <td style="text-align: left;">{{ $student->father_name }}</td>
                    <td style="text-align: left;">{{ number_format($student->amount, 2) }}</td>
                </tr>
                @endforeach
            <tr>
                <td colspan="3" style="text-align: right; font-weight: bold;">Grand Total:</td>
                <td style="text-align: left; font-weight: bold;">{{ number_format($grand_total, 2) }}</td>
            </tr>
            @endif

        </tbody>
    </table>


</main>
@include('backend.pdf.layouts.footer')
</body>
</html>