@extends('layouts.backend')

@section('content')
<style>
  th.sorting, th.sorting_asc, th.sorting_desc {
    pointer-events: none;
    background-image: none !important;
}

@media print { 
    @page { 
        size: landscape;
    } 
}

    </style>
<script>

	var totalIncome = 0;
	var totalExpense = 0;
	
</script>
<form action="{{ url('/transactions/accounting/cashbook') }}" method="get" autocomplete="off" target="_blank">
	<div class="row">			
        
<h3 class="text-primary text-center" style="margin-right:150px; font-weight:700;">Cash Book</h3>
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
					<button type="button" onclick="getAllRecordsForIncomeTable();" style="margin-top:24px;" class="btn btn-success rect-btn">{{_lang('Generate')}}</button>
				</div>
			</div>
	</div>
</form>


<div class="row" style="margin-top:10px;">
        <div class="col-md-6">		
            
        <h4 class="text-success text-center" style="margin-right:150px;">Income</h4>	 	 
            <table id="tblIncomeRecords" class="table table-bordered">
                <thead>            
                    <tr>
                        <!-- <th>{{ _lang('ID') }}</th> -->
                        <th class="sorting_disabled">{{ _lang('Date') }}</th>
                        <th>{{ _lang('Account') }}</th>
                    	<th>{{ _lang('Description') }}</th>
                        <th>{{ _lang('Amount') }}</th>
                        <th>{{ _lang('Total') }}</th>
                    </tr>
                    <tr>
            <td colspan="4"><strong>Opening Balance:</strong></td>
            <td id="prevIncome"><strong>0.00</strong></td>
        </tr>
                </thead>
                <tbody></tbody>
            </table>
            
        </div>
	 
        <div class="col-md-6" style="margin: left 20%;">
            
        <h4 class="text-danger text-center" style="margin-right:150px;">Expense</h4>	
            <table id="tblExpenseRecords" class="table table-bordered">
                    <thead>
                        <tr>
                            <!-- <th>{{ _lang('ID') }}</th> -->
                            <th>{{ _lang('Date') }}</th>
                            <th>{{ _lang('Account') }}</th>
                            <th>{{ _lang('Description') }}</th>
                            <th>{{ _lang('Amount') }}</th>
                        	<th>{{ _lang('Total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        </tbody>
                        <tfoot>
        <tr>
            <th colspan="3">Closing Balance</th>
            <th id="lbBalance"></th> <!-- Total Expense -->
            <th id="finalClosing">0.00</th> <!-- Closing Balance -->
        </tr>
    </tfoot>

            </table>
        </div>
</div>
<button id="printRecords" class="btn btn-primary">Print CashBook</button>

@endsection


@section('js-script')
<script>
function getAllRecordsForIncomeTable() {
    $("#preloader").css("display", "block");
    var url = "{{url('/transactions/income')}}";
    url += "?date_from=" + $('#date_from').val() + "&date_to=" + $('#date_to').val();

    $('#tblIncomeRecords').DataTable().destroy();
    $.fn.dataTable.ext.errMode = 'none';

    let runningTotal = 0; // Reset running total
    let openingBalance = 0; // Initialize opening balance

    $("#tblIncomeRecords").DataTable({
        "processing": true,
        "filter": false,
        "orderMulti": false,
        "pageLength": 25,
        "ordering": false,
        "order": [],
        "ajax": {
            "url": url,
            "type": "GET",
            "datatype": "json",
            "dataSrc": function (json) {
                openingBalance = Number(json.balance) || 0; // Get the opening balance
                runningTotal = openingBalance; // Start running total with opening balance
                return json.data;
            }
        },
        "columns": [
            { "data": "trans_date", "width": "5px" },
            { "data": "f_type", "width": "5px" },
            { 
                "data": null, 
                "width": "5px", 
                "render": function (data, type, full, meta) {
                    return full.first_name + ' (' + full.section_name + ')';
                } 
            },
            { "data": "amount", "width": "5px" },
            {
                "data": null,
                "width": "5px",
                "render": function (data, type, row, meta) {
                    runningTotal += Number(row.amount); // Increment running total with transaction amount
                    return runningTotal.toFixed(2); // Show cumulative total
                }
            }
        ],
        "initComplete": function (settings, json) {
            let totalIncome = 0;
            $.each(json.data, function (index, item) {
                totalIncome += Number(item.amount);
            });

            let closingBalance = openingBalance + totalIncome; // Calculate Closing Balance

            $("#prevIncome").html("<strong>" + openingBalance.toFixed(2) + "</strong>");
            $("#lbIncome").text("Income: " + totalIncome.toFixed(2));

            $("#preloader").css("display", "none");

            // Fetch expenses and update closing balance
            getAllRecordsForExpenseTable(openingBalance, totalIncome);
        }
        
    });
    $("#tblIncomeRecords").on('init.dt', function () {
    $("#tblIncomeRecords th").removeClass("sorting sorting_asc sorting_desc");
});

}

function getAllRecordsForExpenseTable(openingBalance, totalIncome) {
    $("#preloader").css("display", "block");
    var url = "{{url('/transactions/expense')}}";
    url += "?date_from=" + $('#date_from').val() + "&date_to=" + $('#date_to').val();

    $('#tblExpenseRecords').DataTable().destroy();
    $.fn.dataTable.ext.errMode = 'none';

    let runningTotal = 0; // Reset running total

    $("#tblExpenseRecords").DataTable({
        "processing": true,
        "filter": false,
        "orderMulti": false,
        "pageLength": 25,
        "ordering": false,
        "order": [], // Ensure no default order
        "ajax": {
            "url": url,
            "type": "GET",
            "datatype": "json"
        },
        "columns": [
            { "data": "trans_date", "width": "5px" },
            { "data": "c_type", "width": "5px" },
            { 
                "data": null, 
                "width": "5px", 
                "render": function (data, type, full, meta) {
                    return full.c_type + ", " + full.note;
                } 
            },
            { "data": "amount", "width": "5px" },
            {
                "data": null,
                "width": "5px",
                "render": function (data, type, row, meta) {
                    runningTotal += Number(row.amount); // Increment running total
                    return runningTotal.toFixed(2); // Show cumulative total
                }
            }
        ],
        "footerCallback": function (row, data, start, end, display) {
            let totalExpense = 0;

            $.each(data, function (index, item) {
                totalExpense += Number(item.amount);
            });

            let closingBalance = openingBalance + totalIncome - totalExpense; // Calculate final closing balance

            // Insert values into the footer row
            $(row).find("th").eq(0).html("<strong>Closing Balance:</strong>");
            $(row).find("th").eq(1).html(""); // Empty column
            $(row).find("th").eq(2).html(""); // Empty column
            $(row).find("th").eq(3).html("<strong>" + totalExpense.toFixed(2) + "</strong>");
            $(row).find("th").eq(4).html("<strong>" + closingBalance.toFixed(2) + "</strong>");
            let finalClosing = totalExpense + closingBalance;
            console.log(finalClosing);
            // Also update the UI labels
            $("#lbExpense").text("Expense: " + totalExpense.toFixed(2));
            $("#lbBalance").text( closingBalance.toFixed(2));
            $("#finalClosing").text(finalClosing.toFixed(2));

            $("#preloader").css("display", "none");
        }
    });
    $("#tblExpenseRecords").on('init.dt', function () {
    $("#tblExpenseRecords th").removeClass("sorting sorting_asc sorting_desc");
});

}

$("#printRecords").on("click", function() {
    var incomeDT = $('#tblIncomeRecords').DataTable();
    var expenseDT = $('#tblExpenseRecords').DataTable();

    // Set DataTables to show ALL rows
    incomeDT.page.len(-1).draw(false);
    expenseDT.page.len(-1).draw(false);

    setTimeout(function() { // slight delay to ensure table is fully updated
        var incomeTable = $("#tblIncomeRecords").clone();
        var expenseTable = $("#tblExpenseRecords").clone();
        var now = new Date();
        var formattedDate = now.toLocaleDateString();
        var formattedTime = now.toLocaleTimeString();
        var printedBy = "{{ Auth::user()->name }}";

        var panelTitle = $('.panel-title').text().trim();    // Get date range values
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
        var logoUrl = "{{ asset(get_logo() ?? 'images/default-logo.png') }}"; // Fallback to default logo

        // Add styles
        printWindow.document.write(`
                    <div style="margin-bottom: 20px; border-bottom: 1px solid #000; padding-bottom: 10px; page-break-after: avoid; page-break-inside: avoid;">
                     <div style="text-align: right; margin-bottom: 5px; page-break-after: avoid; page-break-inside: avoid; ">
                <p>Powerd by: https://logic-consultants.com</p>
            </div>    
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="flex: 1;">
                                <img src="${logoUrl}" style="height: 50px;" alt="Logo">
                            </div>
                            <div style="flex: 2; text-align: center;">
                                <h2 style="margin: 0; font-size: 22px; font-weight: bold;">{{get_school_name()}}</h2>
                                <p style="margin: 2px 0;">{{ get_option('address')}}</p>
                            </div>
                            <div style="flex: 1;"></div>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-top: 15px;">
                            <div style="font-size: 14px;">CashBook</div>
                            <div style="font-size: 14px;">${dateRangeText}</div>
                        </div>
                    </div>
                    `);
        printWindow.document.write('<style>');
        printWindow.document.write('@media print { @page { size: landscape; margin: 10mm; } }');
        printWindow.document.write('body { font-family: Arial, sans-serif; font-size: 12px; margin: 0; }');
        printWindow.document.write('.container { display: flex; justify-content: space-between; }');
        printWindow.document.write('h1 { text-align: center; margin: 0 0 10px 0; page-break-after: avoid; page-break-inside: avoid; }');
        printWindow.document.write('.row { width: 100%; }');
        printWindow.document.write('.column { width: 48%; }');
        printWindow.document.write('h2 { text-align: center; margin: 0 0 10px 0; page-break-after: avoid; page-break-inside: avoid; }');
        printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-bottom: 10px; page-break-inside: avoid; }');
        printWindow.document.write('th, td { border: 1px solid black; padding: 5px; text-align: left; }');
        printWindow.document.write('th { background-color: #f2f2f2; }');
        printWindow.document.write('</style>');

        printWindow.document.write('</head><body>');

        // printWindow.document.write('<div class="row">');
        // // printWindow.document.write('<h1>CashBook</h1>');
        // printWindow.document.write('</div>');
        printWindow.document.write('<div class="container">');
        printWindow.document.write('<div class="column">');
        printWindow.document.write('<h2>Income Records</h2>');
        printWindow.document.write(incomeTable.prop('outerHTML'));
        printWindow.document.write('</div>');

        printWindow.document.write('<div class="column">');
        printWindow.document.write('<h2>Expense Records</h2>');
        printWindow.document.write(expenseTable.prop('outerHTML'));
        printWindow.document.write('</div>');

        printWindow.document.write(`</div></body></html>`);

        printWindow.document.close();
        printWindow.focus();
        setTimeout(function () {
            printWindow.print();
            printWindow.close();

            // After printing, reset page length to 25 (or your normal setting)
            incomeDT.page.len(25).draw(false);
            expenseDT.page.len(25).draw(false);
        }, 500);
    }, 500); // wait for tables to fully update
});





$(document).ready(function () {

//Date settings
var now = new Date();
var day = ("0" + now.getDate()).slice(-2);
var month = ("0" + (now.getMonth() + 1)).slice(-2);
var date_from = now.getFullYear()+"-"+(month)+"-"+("01");
var date_to = now.getFullYear()+"-"+(month)+"-"+(day);
$('#date_from').val(date_from);
$('#date_to').val(date_to);

});

</script>
@stop