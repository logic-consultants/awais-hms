@extends('layouts.backend')
@section('content')
<style>
    /* Styling for the Summary/Balance Box */
    .balance-box {
        margin-top: 15px;
        border: 2px solid #333;
        background-color: #f9f9f9;
        padding: 0;
    }
    .balance-box table {
        margin-bottom: 0;
        width: 100%;
    }
    .balance-box td {
        padding: 8px;
        border-bottom: 1px solid #ddd;
    }
    .balance-box .net-balance {
        background-color: #e0e0e0;
        font-weight: bold;
        font-size: 1.1em;
    }

    @media print {
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .container { display: flex; justify-content: space-between; }
        /* Ensure columns float for PDF/Print generation if flex fails */
        .column-print { width: 48%; float: left; } 
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 4px; }
        /* Force the balance box to appear correctly in print */
        .balance-box { border: 2px solid black !important; margin-top: 10px; }
    }
</style>

<form action="{{ url('/reports/account_balance') }}" method="get" autocomplete="off" target="_blank">
    <div class="row">
        <h3 class="text-primary text-center" style="margin-right:150px; font-weight:700;">Financial Report</h3>
        <div class="col-md-5">
            <div class="form-group">
                <label class="control-label">{{ _lang('Date From') }}</label>
                <input type="date" class="form-control date_from" name="date_from" id="date_from" value="">
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label class="control-label">{{ _lang('Date To') }}</label>
                <input type="date" class="form-control date_to" name="date_to" id="date_to" value="">
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
                    <div class="row" style="display: flex; flex-wrap: wrap;">
                        
                        <div class="col-md-6 column-print" id="income-wrapper">
                            <h3 class="text-center">Receipts</h3>
                            <div id="income-content">
                                <table id="tblIncomeRecords" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>{{ _lang('Account Name') }}</th>
                                            <th class="text-right">{{ _lang('Amount') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Total Receipts</th>
                                            <th class="text-right" id="income-footer-total">0.00</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div id="income-balance-container"></div>
                        </div>

                        <div class="col-md-6 column-print" id="expense-wrapper">
                            <h3 class="text-center">Payments</h3>
                            <div id="expense-content">
                                <table id="tblExpenseRecords" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>{{ _lang('Account Name') }}</th>
                                            <th class="text-right">{{ _lang('Amount') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Total Payments</th>
                                            <th class="text-right" id="expense-footer-total">0.00</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div id="expense-balance-container"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    var globalIncomeTotal = 0;
    var globalExpenseTotal = 0;

    function getAllRecordsForTable() {
        $("#preloader").css("display", "block");
        var url = "{{ url('/reports/account_balance') }}";
        url += "?date_from=" + $('#date_from').val() + "&date_to=" + $('#date_to').val();

        $.fn.dataTable.ext.errMode = 'none';

        if ($.fn.DataTable.isDataTable('#tblIncomeRecords')) { $('#tblIncomeRecords').DataTable().destroy(); }
        if ($.fn.DataTable.isDataTable('#tblExpenseRecords')) { $('#tblExpenseRecords').DataTable().destroy(); }

        // Clear previous balance
        $('#income-balance-container').html('');
        $('#expense-balance-container').html('');

        // 1. Load Income
        var incomePromise = new Promise(function(resolve, reject) {
            $("#tblIncomeRecords").DataTable({
                processing: true,
                serverSide: false,
                filter: false,
                paging: false, // Must be disabled to calculate full height
                info: false,
                ajax: { url: url, type: "GET", dataSrc: "income" },
                columns: [
                    { data: "c_type", width: '70%' },
                    { data: "current_amount", width: '30%', className: 'text-right', render: $.fn.dataTable.render.number(',', '.', 2) }
                ],
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();
                    globalIncomeTotal = api.column(1).data().reduce((a, b) => parseFloat(a) + parseFloat(b), 0);
                    $(api.column(1).footer()).html(globalIncomeTotal.toFixed(2));
                },
                initComplete: function() { resolve(); }
            });
        });

        // 2. Load Expense
        var expensePromise = new Promise(function(resolve, reject) {
            $("#tblExpenseRecords").DataTable({
                processing: true,
                serverSide: false,
                filter: false,
                paging: false,
                info: false,
                ajax: { url: url, type: "GET", dataSrc: "expense" },
                columns: [
                    { data: "c_type", width: '70%' },
                    { data: "current_amount", width: '30%', className: 'text-right', render: $.fn.dataTable.render.number(',', '.', 2) }
                ],
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();
                    globalExpenseTotal = api.column(1).data().reduce((a, b) => parseFloat(a) + parseFloat(b), 0);
                    $(api.column(1).footer()).html(globalExpenseTotal.toFixed(2));
                },
                initComplete: function() { resolve(); }
            });
        });

        // 3. Compare Heights and Inject
        Promise.all([incomePromise, expensePromise]).then(function() {
            $("#preloader").css("display", "none");
            injectBalanceBasedOnHeight();
        });
    }

    function injectBalanceBasedOnHeight() {
        // Measure pixel height of the table content
        var incomeHeight = $('#income-content').outerHeight();
        var expenseHeight = $('#expense-content').outerHeight();
        
        var netBalance = globalIncomeTotal - globalExpenseTotal;
        var label = netBalance >= 0 ? "Net Surplus" : "Net Deficit";
        var color = netBalance >= 0 ? "green" : "red";

        // Create a summary box that looks good regardless of which side it is on
        var balanceHtml = `
            <div class="balance-box">
                <table>
                    <tr>
                        <td width="70%">Total Receipts</td>
                        <td width="30%" class="text-right">${globalIncomeTotal.toFixed(2)}</td>
                    </tr>
                    <tr>
                        <td>Total Payments</td>
                        <td class="text-right">${globalExpenseTotal.toFixed(2)}</td>
                    </tr>
                    <tr class="net-balance">
                        <td style="color:${color}">${label} (Balance)</td>
                        <td class="text-right" style="color:${color}">${netBalance.toFixed(2)}</td>
                    </tr>
                </table>
            </div>
        `;

        // LOGIC: Put it in the container with the smaller height
        if (incomeHeight < expenseHeight) {
            // Income list is shorter, put balance under Income
            $('#income-balance-container').html(balanceHtml);
        } else {
            // Expense list is shorter (or equal), put balance under Expense
            $('#expense-balance-container').html(balanceHtml);
        }
    }

    function printDiv(divName) {
        // We get the HTML exactly as it appears on screen (with balance already injected in the correct spot)
        var printContents = document.getElementById(divName).innerHTML;
        var dateText = $('#date_from').val() ? `(${$('#date_from').val()} to ${$('#date_to').val()})` : '';
        
        var printWindow = window.open('', '', 'height=800,width=1200');
        printWindow.document.write('<html><head><title>Financial Report</title>');
        
        // Add Print CSS
        printWindow.document.write(`
            <style>
                @media print { 
                    @page { size: landscape; margin: 10mm; } 
                    body { font-family: sans-serif; -webkit-print-color-adjust: exact; }
                    .row { display: block; width: 100%; overflow: hidden; }
                    .column-print { width: 48%; float: left; margin-right: 1%; box-sizing: border-box; }
                    table { width: 100%; border-collapse: collapse; font-size: 11px; margin-bottom: 10px; }
                    th, td { border: 1px solid #444; padding: 4px; }
                    th { background-color: #eee; font-weight: bold; }
                    .text-right { text-align: right; }
                    .text-center { text-align: center; }
                    
                    /* CSS to make the Balance Box look distinct in print */
                    .balance-box { border: 2px solid #000; margin-top: 15px; page-break-inside: avoid; }
                    .balance-box td { border: none; border-bottom: 1px solid #ccc; }
                    .net-balance { background-color: #ddd !important; font-weight: bold; }
                }
            </style>
        `);
        
        printWindow.document.write('</head><body>');
        printWindow.document.write(`<h2 style="text-align:center">{{get_school_name()}}</h2>`);
        printWindow.document.write(`<h4 style="text-align:center">Financial Report ${dateText}</h4>`);
        
        printWindow.document.write('<div class="row">');
        printWindow.document.write(printContents);
        printWindow.document.write('</div>');
        
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.focus();

        setTimeout(function() {
            printWindow.print();
            printWindow.close();
        }, 500);
    }
</script>