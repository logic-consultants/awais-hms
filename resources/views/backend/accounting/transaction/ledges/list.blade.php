@extends('layouts.backend')

@section('content')
<style>
    .dataTables_filter {
        display: none;
    }
    th.sorting, th.sorting_asc, th.sorting_desc {
    pointer-events: none;
    background-image: none !important;
}
</style>
<form action="{{ url('/transaction/ledges') }}" method="get" autocomplete="off" target="_blank">
	<div class="row">			
				<div class="col-md-3">
						<div class="form-group">
							<label class="control-label">{{ _lang('Date From') }}</label>
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
								<input type="date" class="form-control date_from" name="date_from" id="date_from" value="">
							</div>
						</div>
				</div>
					
				<div class="col-md-3">
						<div class="form-group">
							<label class="control-label">{{ _lang('Date To') }}</label>
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
								<input type="date" class="form-control date_to" name="date_to" id="date_to" value="">
							</div>
						</div>
				</div>

                    <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">{{ _lang('Accounts') }}</label>						
                    <select class="form-control select2" name="account_id" id="account_id">
                        @foreach($accounts as $account)
                        <option value="{{ $account['id'] }}">{{ $account['account_name'] }}</option>
                        @endforeach
                    </select>
                </div>
                    </div>
			<div class="col-md-3">
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
                <div class="row">
                <div class="col-md-6"><span class="panel-title">{{ _lang('Ledgers List') }}</span></div>
                <div class="col-md-6">
        <input type="text" id="customSearchBox" class="form-control" placeholder="Search records..." />
</div>
</div>
		</div>
			<div class="panel-body">
	<table id="tblRecords" class="table table-bordered">
		<thead>
			<tr>
				<th colspan="5" > {{_lang('Openning Balance')}}</th>
				<th colspan = "3" id="openingBalanceHeader">0.00</th>
			</tr>
			<tr>
                <th width= "10%">{{ _lang('Sr#') }}
				<th width= "15%">{{ _lang('TID') }}</th>
				<th width= "15%">{{ _lang('Date') }}</th>
				<th width= "25%">{{_lang('Description')}}
				<th width= "5%">{{ _lang('CR/DR') }}</th>
                <th width= "15%">{{_lang('Amount')}}</th>
                <th width= "15%">{{_lang('Balance')}}</th>
				<th width= "10%">{{ _lang('Action') }}</th>
			</tr>
		</thead>
   </table>

			</div>
		</div>
	</div>
</div>

@endsection


@section('js-script')
<script>
function getAllRecordsForTable() 
{
    $("#preloader").css("display", "block");

    var url = "{{url('/transactions/ledges')}}";
    url += "?date_from=" + $('#date_from').val() + "&date_to=" + $('#date_to').val() + "&account_id=" + $('#account_id').val();

    $('#tblRecords').DataTable().destroy();
    $.fn.dataTable.ext.errMode = 'none'; // Suppress warnings

    let openingBalance = 0;
    let runningBalance = 0;

    $("#tblRecords").DataTable({
        "processing": true,
        "filter": true,
        "orderMulti": false,
        "pageLength": 25,
        "ajax": {
            "url": url,
            "type": "GET",
            "datatype": "json",
            "dataSrc": function (json) {
                openingBalance = Number(json.balance) || 0; // Opening Balance from server
                runningBalance = openingBalance; // Initialize Running Balance
                return json.data;
            }
        },
        "columns": [
            {
                "data": null,
                "class": 'center',
                "width": '5%',
                "render": function (data, type, full, meta) {
                    return meta.row + 1;
                }
            },
            { "data": "id", "width": '5%' },
            { "data": "trans_date", "width": '15%' },
            {
                "data": null,
                "width": '25%',
                "render": function (data, type, full, meta) {
                    return full.first_name + ' (' + full.section_name + ')';
                }
            },
            { "data": "dr_cr", "width": '5%' },
            {
                "data": "amount",
                "width": '15%',
                "render": function (data, type, full, meta) {
                    return parseFloat(full.amount).toFixed(2);
                }
            },
            {
                "data": null,
                "width": '15%',
                "render": function (data, type, full, meta) {
                    let amount = parseFloat(full.amount) || 0;
                    let drCr = (full.dr_cr || '').toLowerCase();

                    if (drCr === 'dr') {
                        runningBalance -= amount;
                    } else if (drCr === 'cr') {
                        runningBalance += amount;
                    }

                    return runningBalance.toFixed(2);
                }
            },
            {
                "data": null,
                "width": '5%',
              "render": function (data, type, full, meta) {
    var id = full["id"];
    var drCr = (full["dr_cr"] || '').toLowerCase();
    
    // Change URL based on dr_cr value
    var url = drCr === 'dr' 
        ? "{{ url('transactions/edit_expense') }}/" + id 
        : "{{ url('transactions') }}/" + id + "/edit";
    
    return '<a href="' + url + '" class="btn btn-warning btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
},

                "orderable": false,
                "searchable": false
            }
        ],
        "order": [[0, "asc"]],
        "dom": '<"top"lf>rt<"bottom"Bip><"clear">',
        "buttons": [
            {
                extend: 'copy',
                text: '<i class="fa fa-clone"></i> Copy',
                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
            },
            {
                extend: 'excel',
                text: '<i class="fa fa-file-excel-o"></i> Excel',
                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
            },
            {
                extend: 'csv',
                text: '<i class="fa fa-file"></i> CSV',
                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
            },
            {
                extend: 'pdf',
                text: '<i class="fa fa-file-pdf-o"></i> PDF',
                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
            },
            {
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    },
                    text: '<i class="fa fa-print"></i> Print',
                    title: '',

                    customize: function (win) {
                        var now = new Date();
                        var formattedDate = now.toLocaleDateString();
                        var formattedTime = now.toLocaleTimeString();
                        var printedBy = "{{ Auth::user()->name }}";

                        var panelTitle = $('.panel-title').text().trim();    // Get date range values
                        var dateFrom = $('#date_from').val();
                        var dateTo = $('#date_to').val();
                        var account_id = $('#account_id option:selected').text();


                        var dateRangeText = '';
                        if (dateFrom && dateTo) {
                            dateRangeText = `(${dateFrom} to ${dateTo})`;
                        } else if (dateFrom) {
                            dateRangeText = `(From ${dateFrom})`;
                        } else if (dateTo) {
                            dateRangeText = `(Up to ${dateTo})`;
                        }


                        var logoUrl = "{{ asset(get_logo() ?? 'images/default-logo.png') }}"; // Fallback to default logo

                        $(win.document.body).prepend(`
                    <div style="margin-bottom: 20px; border-bottom: 1px solid #000; padding-bottom: 10px;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="flex: 1;">
                                <img src="${logoUrl}" 
                                    style="height: 50px;" alt="Logo">
                            </div>
                            <div style="flex: 2; text-align: center;">
                                <h2 style="margin: 0; font-size: 22px; font-weight: bold;">{{get_school_name()}}</h2>
                                <p style="margin: 2px 0;">{{ get_option('address')}}</p>
                            </div>
                            <div style="flex: 1;"></div>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-top: 15px;">
                            <div style="font-size: 14px;">Ledger of Account: ${account_id}</div>
                            <div style="font-size: 14px;">${dateRangeText}</div>
                        </div>
                    </div>
                    `);
                    $(win.document.body).append(`
            <div style="text-align: left; margin-top: 5px;">
                <p>Powerd by:https://logic-consultants.com</p>
            </div>`
        );
                        }


                },
            'colvis'
        ],
        "initComplete": function () {
            $("#preloader").css("display", "none");

            // Show Opening Balance
            $("#openingBalanceHeader").html(" <strong>" + openingBalance.toFixed(2) + "</strong>"
            );

            // Optionally show closing balance after last row if needed
            let table = $('#tblRecords').DataTable();
            let closingBalance = runningBalance;

            $("#closingBalanceFooter").html(
                "{{ _lang('Closing Balance') }}: <strong>" + closingBalance.toFixed(2) + "</strong>"
            );
        }
    });
    

    var table =  $("#tblRecords").DataTable({
        "processing": true,
        "filter": true,
        "orderMulti": false,
        "pageLength": 25,
        "ordering": false,
        "order": [],
        "ajax": {
            "url": url,
            "type": "GET",
            "datatype": "json",
            "dataSrc": function (json) {
                openingBalance = Number(json.balance) || 0; // Opening Balance from server
                runningBalance = openingBalance; // Initialize Running Balance
                return json.data;
            }
        },
        "columns": [
            {
                "data": null,
                "class": 'center',
                "width": '5%',
                "render": function (data, type, full, meta) {
                    return meta.row + 1;
                }
            },
            { "data": "id", "width": '5%' },
            { "data": "trans_date", "width": '15%' },
            {
                "data": null,
                "width": '25%',
                "render": function (data, type, full, meta) {
                    return full.first_name + ' (' + full.section_name + ')';
                }
            },
            { "data": "dr_cr", "width": '5%' },
            {
                "data": "amount",
                "width": '15%',
                "render": function (data, type, full, meta) {
                    return parseFloat(full.amount).toFixed(2);
                }
            },
            {
                "data": null,
                "width": '15%',
                "render": function (data, type, full, meta) {
                    let amount = parseFloat(full.amount) || 0;
                    let drCr = (full.dr_cr || '').toLowerCase();

                    if (drCr === 'dr') {
                        runningBalance -= amount;
                    } else if (drCr === 'cr') {
                        runningBalance += amount;
                    }

                    return runningBalance.toFixed(2);
                }
            },
            {
                "data": null,
                "width": '5%',
                "render": function (data, type, full, meta) {
                    var id = full["id"];
                    var url = "{{ url('transactions') }}";
                    var editRoute = url + "/" + id + "/edit";
                    return '<a href="' + editRoute + '" class="btn btn-warning btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
                },
                "orderable": false,
                "searchable": false
            }
        ],
        "order": [[0, "asc"]],
        "dom": '<"top"lf>rt<"bottom"Bip><"clear">',
        "buttons": [
            {
                extend: 'copy',
                text: '<i class="fa fa-clone"></i> Copy',
                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
            },
            {
                extend: 'excel',
                text: '<i class="fa fa-file-excel-o"></i> Excel',
                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
            },
            {
                extend: 'csv',
                text: '<i class="fa fa-file"></i> CSV',
                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
            },
            {
                extend: 'pdf',
                text: '<i class="fa fa-file-pdf-o"></i> PDF',
                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
            },
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i> Print',
                exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] }
            },
            'colvis'
        ],
        "initComplete": function () {
            $("#preloader").css("display", "none");

            // Show Opening Balance
            $("#openingBalanceHeader").html(" <strong>" + openingBalance.toFixed(2) + "</strong>"
            );

            // Optionally show closing balance after last row if needed
            let table = $('#tblRecords').DataTable();
            let closingBalance = runningBalance;

            $("#closingBalanceFooter").html(
                "{{ _lang('Closing Balance') }}: <strong>" + closingBalance.toFixed(2) + "</strong>"
            );
        }
    });

$('#customSearchBox').on('keyup', function () {
    table.search(this.value).draw();
});
$("#tblRecords").on('init.dt', function () {
    $("#tblRecords th").removeClass("sorting sorting_asc sorting_desc");
});
}



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