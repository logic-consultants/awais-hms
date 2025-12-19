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


    <table class="table text-center" id="feeSummaryTableWithDues" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th>Room#</th>
            <th>Date</th>
            <th>Student Information</th>
            @foreach ($feesTypes as $feeType)
                <th>{{ $feeType->fee_type }}</th>
            @endforeach
            <th>Total Paid Balance</th>
        </tr>
    </thead>
        <tbody>

        	@foreach ($transactions as $row)
            <tr>
                <td>{{ $row['Room#'] }}</td>
                <td>{{ $row['Date'] }}</td>
                <td>{{ $row['Student Information'] }}</td>
                @foreach ($feesTypes as $feeType)
                    <td>{{ $row[$feeType->fee_type] ?? 0 }}</td>
                @endforeach
                <td>{{ $row['paid'] }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3">Totals</td>
            @foreach ($feesTypes as $feeType)
                <td>{{ $transactions->sum($feeType->fee_type) }}</td>
            @endforeach
            <td>{{ $transactions->sum('paid') }} </td>
            <td>{{ number_format($transactions->sum('balance'), 2) }}</td>
        </tr>
        



        </tbody>
    </table>
</main>
@include('backend.pdf.layouts.footer')
</body>
</html>