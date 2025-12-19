@extends('layouts.backend')

@section('content')

<form action="{{ url('/transactions/expense') }}" method="get" autocomplete="off" target="_blank">
	<div class="row">			
    <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">{{ _lang('Date From') }}</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    <input type="date" class="form-control date_from" name="date_from" id="date_from" value="">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">{{ _lang('Date To') }}</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    <input type="date" class="form-control date_to" name="date_to" id="date_to" value="">
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group" style="margin-top: 30px;">
            <label for="pageSize">paginate:</label>
                <select id="pageSize">
                
                <option value="5">5</option>
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="50">100</option>
                <option value="50">500</option>
                </select>
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
			
			<div class="panel-heading"><span class="panel-title">{{ _lang('List Expense') }}</span>
			
		</div>
		<a style="margin:10px;" class="btn btn-primary btn-sm pull-left" data-title="{{ _lang('Add Expense') }}" href="{{ url('transactions/add_expense') }}">{{ _lang('Add New') }}</a>

			<div class="panel-body">
			 <!-- @if (\Session::has('success'))
			  <div class="alert alert-success">
				<p>{{ \Session::get('success') }}</p>
			  </div>
			  <br />
			 @endif -->

				<table id="tblRecords" class="table table-bordered">
						<thead>
							<tr>
								<!-- <th>{{ _lang('ID') }}</th> -->
								<th width="7%">{{ _lang('Date') }}</th>
								<th width="10%">{{ _lang('Account Title') }}</th>
								<th width="10%">{{ _lang('Payment Method') }}</th>
								<th width="43%">{{ _lang('Description') }}</th>
								<th width="10%">{{ _lang('Amount') }}</th>
								<th width="20%">{{ _lang('Action') }}</th>
							</tr>
						</thead>
						<tbody></tbody>
						<tfoot>
       <tr>
            <td colspan="4" style="text-align:right"><strong>Total Amount:</strong></td>
            <td id="totalAmount"><strong>0.00</strong></td>
            <td ></td>
        </tr></th>
        </tr>
    </tfoot>
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
    var url = "{{url('/transactions/expense')}}";
    url += "?date_from=" + $('#date_from').val() + "&date_to=" + $('#date_to').val();
    var selectedPageSize = parseInt($('#pageSize').val());
       
    $('#tblRecords').DataTable().destroy();
    $.fn.dataTable.ext.errMode = 'none';

    var table = $("#tblRecords").DataTable({
        "processing": true,
        "serverSide":true,
        "filter": true,
        "orderMulti": false,
        "pageLength": selectedPageSize,
        "responsive": true, // Enable responsive feature
        "autoWidth": false, // Prevent fixed column width issues
        "initComplete": function (settings, json) {
            $("#preloader").css("display", "none");
        },
        "ajax": {
            "url": url,
            "type": "GET",
            "datatype": "json",
            "dataSrc": function (json) {
                let totalAmount = json.data.reduce((sum, record) => sum + parseFloat(record.amount || 0), 0);
                $("#totalAmount").html('<strong>' + totalAmount.toFixed(2) + '<strong>'); 
                return json.data;
            }
        },
        "columns": [                   
            { "data": "trans_date", width: '7%' },
            { "data": "c_type", width: '10%' },
            { "data": "account_name", width: '10%' },
            { 
                "data": null, 
                width: '48%',
                "render": function (data, type, full, meta) {
                    return full.c_type + ", " + full.note;
                }
            },
            { "data": "amount", width: '10%' },
            {
                "data": null,
                width: '15%',
                "render": function (data, type, full, meta) {
                    id = full["id"];
                    var url = "{{ url('transactions') }}";
                    
                    var formRoute = url + "/" + id;
                    var editRoute = url + "/edit_expense/" + id;
                    var showRoute = url + "/" + id;

                    var form = '<form action="'+url+'/'+id+'" method="post">';
					form += '<a href="'+editRoute+'" class="btn btn-warning btn-xs"><i class="fa fa-pencil" aria-hidden = "true"></i></a>';
					form += '<a href="'+showRoute+'" class="btn btn-info btn-xs ajax-modal"><i class="fa fa-eye" aria-hidden = "true"></i></a>';
					form += '{{ method_field('DELETE') }}';
					form += '@csrf';
					form += '<button type="submit" class="btn btn-danger btn-xs btn-remove"><i class="fa fa-trash" aria-hidden = "true"></i></button>';
					form += '</form>';

                    return form;
                },
                "orderable": false,
                "searchable": false
            },
        ],
        "order": [[0, "asc"]],
        "dom": '<"top"lf>rt<"bottom"Bip><"clear">',
        "buttons": [
            {
                extend: 'copy',
                exportOptions: { columns: [0, 1, 2, 3, 4] },
                text: '<i class="fa fa-clone"></i> Copy'
            },
            {
                extend: 'excel',
                exportOptions: { columns: [0, 1, 2, 3, 4] },
                text: '<i class="fa fa-file-excel-o"></i> Excel'
            },
            {
                extend: 'csv',
                exportOptions: { columns: [0, 1, 2, 3, 4] },
                text: '<i class="fa fa-file"></i> CSV',
            },
            {
                extend: 'pdf',
                exportOptions: { columns: [0, 1, 2, 3, 4] },
                text: '<i class="fa fa-file-pdf-o"></i> PDF'
            },
            {
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
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
                         <div style="text-align: right; margin-bottom: 5px; page-break-after: avoid; page-break-inside: avoid;git ">
                <p>Powerd by: https://logic-consultants.com</p>
            </div>
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
                            <div style="font-size: 14px;">${panelTitle}</div>
                            <div style="font-size: 14px;">${dateRangeText}</div>
                        </div>
                    </div>
                    `);
                 
                        }


                },
            'colvis'
        ],
    });
}
$('#pageSize').on('change', function() {
 
 getAllRecordsForTable(); // Reload DataTable with new page size
});
$(document).ready(function () {
    // Ensure the DataTable is initialized with responsiveness
    $('#tblRecords').DataTable({
        "responsive": true,
        "autoWidth": false
    });

    // Date settings
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var date_from = now.getFullYear() + "-" + month + "-01";
    var date_to = now.getFullYear() + "-" + month + "-" + day;
    $('#date_from').val(date_from);
    $('#date_to').val(date_to);
});

</script>
@stop