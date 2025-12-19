@extends('layouts.backend')
@section('content')
<style>
    @media print {
        
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
        }
        .container {
            display: flex;
            justify-content: space-between;
            page-break-before: always;
			text-align: center;
        }
        .column {
            width: 100%;
        }
        h2 {
            text-align: center;
            margin: 0 0 10px 0;
            page-break-after: avoid;
            page-break-inside: avoid;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            page-break-inside: avoid;
            table-layout: fixed; /* Ensures the table takes up available space */
        }
        th, td {
            border: 1px solid black;
            /* padding: 5px; */
            text-align: left;
            word-wrap: break-word; /* Ensures text wraps correctly within the cells */
        }
        th {
            background-color: #f2f2f2;
        }
    }
</style>
<form action="{{ url('/reports/account_balance') }}" method="get" autocomplete="off" target="_blank">
	<div class="row">			
        <h3 class="text-primary text-center" style="margin-right:150px; font-weight:700;">Financial Report</h3>
				<div class="col-md-5">
						<div class="form-group">
							<label class="control-label">{{ _lang('Date From') }}</label>
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
								<input type="date" class="form-control date_from" name="date_from" id="date_from" value="">
							</div>
						</div>
				</div>
					
				<div class="col-md-5">
						<div class="form-group">
							<label class="control-label">{{ _lang('Date To') }}</label>
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
								<input type="date" class="form-control date_to" name="date_to" id="date_to" value="">
							</div>
						</div>
				</div>

			<div class="col-md-2">
				<div class="form-group pull-right">
					<button type="button" onclick="getAllRecordsForTable();" style="margin-top:24px;" class="btn btn-success rect-btn">{{_lang('Generate')}}</button>
				</div>
			</div>
	</div>
</form>


<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="panel-title">{{ _lang('Financial Account Balance') }}</span>

                <div class="text-right mb-3">
                    <button onclick="printDiv('printableArea')" class="btn btn-primary">
                        <i class="fa fa-print"></i> {{ _lang('Print Report') }}
                    </button>
                </div>
            </div>

            <div class="panel-body">
                <div id="printableArea">
                    <div class="row">
                        @if(isset($report_income))
						<div class="col-md-6">
                            <h3 class="text-center">Receipts</h3>
                            @php $income_total = 0; $currency = get_option('currency_symbol'); @endphp
                            <table id ="tblIncomeRecords" class="table table-bordered" >
                                <thead>
                                    <tr>
                                        <th>{{ _lang('Account Name') }}</th>
                                        <th>{{ _lang('Balance') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
								<tfoot>
								<tr>
									<th>Total</th>
									<th></th> <!-- Total will be injected here -->
								</tr>
							</tfoot>
													</table>
						</div>
                        @endif
                        @if(isset($report_expense))
						<div class="col-md-6">
                        <h3 class="text-center">Payments</h3>
                            @php $expense_total = 0; $currency = get_option('currency_symbol'); @endphp
                            <table id="tblExpenseRecords" class="table table-bordered" >
                                <thead>
                                    <tr>
                                        <th>{{ _lang('Account Name') }}</th>
                                        <th>{{ _lang('Balance') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
								<tfoot>
									<tr>
										<th>Total</th>
										<th></th> <!-- Total will be injected here -->
									</tr>
								</tfoot>
							</table>
                        @endif
                    </div> <!-- end row -->
                </div> <!-- end printableArea -->
            </div>
        </div>
    </div>
</div>
@endsection
<script>
    function getAllRecordsForTable() {
        $("#preloader").css("display", "block");
        var url = "{{ url('/reports/account_balance') }}";
        url += "?date_from=" + $('#date_from').val() + "&date_to=" + $('#date_to').val();

        $.fn.dataTable.ext.errMode = 'none';

        $('#tblIncomeRecords').DataTable().destroy();
        $('#tblExpenseRecords').DataTable().destroy();
        $("#tblIncomeRecords").DataTable({
            processing: true,
            serverSide: false,
            filter: false,
            orderMulti: false,
            pageLength: 25,
            responsive: true,
            autoWidth: false,
            initComplete: function () {
                $("#preloader").css("display", "none");
            },
            ajax: {
                url: url,
                type: "GET",
                dataType: "json",
                dataSrc: "income"
            },
            columns: [
        { data: "c_type", width: '70%' },
        { data: "current_amount", width: '30%', className: 'text-right' }
    ],
        order: [[0, "asc"]],

		footerCallback: function (row, data, start, end, display) {
        var api = this.api();
        var total = api
            .column(1)
            .data()
            .reduce(function (a, b) {
                return parseFloat(a) + parseFloat(b);
            }, 0);
        $(api.column(1).footer()).html(total.toFixed(2));
    }
    });
    $("#tblExpenseRecords").DataTable({
        processing: true,
        serverSide: false,
        filter: false,
        orderMulti: false,
        pageLength: 25,
        responsive: true,
        autoWidth: false,
        initComplete: function () {
            $("#preloader").css("display", "none");
        },
        ajax: {
            url: url,
            type: "GET",
            dataType: "json",
            dataSrc: "expense"
        },
        columns: [
    { data: "c_type", width: '70%' },
    { data: "current_amount", width: '30%', className: 'text-right' }
],
        order: [[0, "asc"]],

		footerCallback: function (row, data, start, end, display) {
        var api = this.api();
        var total = api
            .column(1)
            .data()
            .reduce(function (a, b) {
                return parseFloat(a) + parseFloat(b);
            }, 0);
        $(api.column(1).footer()).html(total.toFixed(2));
    }
    });
}

function printDiv(divName) {
  
    
    setTimeout(function () {
    var incomeTable = $("#tblIncomeRecords").clone();
    var expenseTable = $("#tblExpenseRecords").clone();

    var now = new Date();
    var formattedDate = now.toLocaleDateString();
    var formattedTime = now.toLocaleTimeString();
    var printedBy = "{{ Auth::user()->name }}";

    var panelTitle = $('.panel-title').text().trim();
    var dateFrom = $('#date_from').val();
    var dateTo = $('#date_to').val();

    var dateRangeText = '';
    if (dateFrom && dateTo) {
        dateRangeText = `(${dateFrom} to ${dateTo})`;
    } else if (dateFrom) {
        dateRangeText = `(From ${dateFrom})`;
    } else if (dateTo) {
        dateRangeText = `(Up to ${dateTo})`;
    }

    var printWindow = window.open('', '', 'height=800,width=1200');
    printWindow.document.write(`
                    <div style="margin-bottom: 20px; border-bottom: 1px solid #000; padding-bottom: 10px; page-break-after: avoid; page-break-inside: avoid;">
                    <div style="text-align: right; margin-bottom: 5px;">
                <p>Powerd by: https://logic-consultants.com</p>
            </div>   
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="flex: 1;">
                                
                            </div>
                            <div style="flex: 2; text-align: center;">
                                <h2 style="margin: 0; font-size: 22px; font-weight: bold;">{{get_school_name()}}</h2>
                                <p style="margin: 2px 0;">{{ get_option('address')}}</p>
                            </div>
                            <div style="flex: 1;"></div>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-top: 15px;">
                            <div style="font-size: 14px;">${panelTitle}</div>
                            <div style="font-size: 14px;">${dateRangeText}</div>
                        </div>
                    </div>
                    `);

    // Add styles
    printWindow.document.write('<html><head><style>');
    printWindow.document.write('@media print { @page { size: landscape; margin: 10mm; } }');
    printWindow.document.write('body { font-family: Arial, sans-serif; font-size: 12px; margin: 0; }');
    printWindow.document.write('.container { display: flex; justify-content: space-between; }');
    printWindow.document.write('h1 { text-align: center; margin: 0 0 10px 0; page-break-after: avoid; }');
    printWindow.document.write('.row { width: 100%; }');
    printWindow.document.write('.column { width: 48%; }');
    printWindow.document.write('h2 { text-align: center; margin: 0 0 10px 0; }');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }');
    printWindow.document.write('th, td { border: 1px solid black; padding: 5px; text-align: left; }');
    printWindow.document.write(`
    td:nth-child(2), th:nth-child(2) {
        text-align: right;`);
    printWindow.document.write('th { background-color: #f2f2f2; }');
    printWindow.document.write('</style></head><body>');

  
    printWindow.document.write('<div class="container">');
    printWindow.document.write('<div class="column"><h2>Receipts</h2>');
    printWindow.document.write(incomeTable.prop('outerHTML'));
    printWindow.document.write('</div>');

    printWindow.document.write('<div class="column"><h2>Payments</h2>');
    printWindow.document.write(expenseTable.prop('outerHTML'));
    printWindow.document.write('</div>');

    printWindow.document.write(`</div></body></html>`);

    printWindow.document.close();
    printWindow.focus();

    setTimeout(function () {
        printWindow.print();
        printWindow.close();

    }, 500);
});

}
</script>

