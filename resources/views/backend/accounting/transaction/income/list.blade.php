@extends('layouts.backend')

@section('content')
<form action="{{ url('/transactions/income') }}" method="get" autocomplete="off" target="_blank">
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
                <button type="button" onclick="getAllRecordsForTable();" style="margin-top:24px;"
                    class="btn btn-success rect-btn">{{_lang('Generate')}}</button>
            </div>
        </div>
    </div>
</form>

<div class="row">

    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><span class="panel-title">{{ _lang('List Income') }}</span>
            </div>
            <a style="margin:10px;" class="btn btn-primary btn-sm pull-left" data-title="{{ _lang('Add Income') }}"
                href="{{ url('transactions/add_income') }}">{{ _lang('Add New') }}</a>

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
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr style="border-top:2px solid #ccc;">
                            <td colspan="4"style="text-align:right"><strong>Total Amount:</strong></td>
                            <td id="totalAmount"><strong>0.00</strong></td>
                            <td></td>
                        </tr>
                        <tr class="bg-info" style="color: #fff;">
                            <td colspan="4" style="text-align:right"><strong>{{ _lang('Grand Total') }}:</strong></td>
                            <td id="grandTotal"><strong>0.00</strong></td>
                            <td></td>
                        </tr>
                    </tfoot>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

@endsection


@section('js-script')
<script>
    function getAllRecordsForTable() {
        $("#preloader").css("display", "block");
        
        var url = "{{ url('/transactions/income') }}";
        url += "?date_from=" + $('#date_from').val() + "&date_to=" + $('#date_to').val();
        var selectedPageSize = parseInt($('#pageSize').val());

        // Destroy existing table if it exists
        if ($.fn.DataTable.isDataTable('#tblRecords')) {
            $('#tblRecords').DataTable().destroy();
        }
        
        $.fn.dataTable.ext.errMode = 'none';

        var table = $("#tblRecords").DataTable({
            "processing": true,
            "serverSide": true,
            "filter": true,
            "orderMulti": false,
            "pageLength": selectedPageSize,
            "responsive": true,
            "autoWidth": false,
            "initComplete": function(settings, json) {
                $("#preloader").css("display", "none");
            },
            "ajax": {
                "url": url,
                "type": "GET",
                "dataType": "json"
            },
            "columns": [
                { "data": "trans_date", "width": "7%" },
                { "data": "f_type", "width": "10%" },
                { "data": "account_name", "width": "10%" },
                {
                    "data": null,
                    "width": "43%",
                    "render": function(data, type, full, meta) {
                        return full.first_name + ' (' + full.section_name + ')';
                    }
                },
                { "data": "amount", "width": "10%" },
                {
                    "data": null,
                    "width": "20%",
                    "orderable": false,
                    "searchable": false,
                    "render": function(data, type, full, meta) {
                        var id = full["id"];
                        var base_url = "{{ url('transactions') }}";
                        
                        var form = '<form action="' + base_url + '/' + id + '" method="post" style="display:inline-block;">';
                        form += '<a href="' + base_url + '/' + id + '/edit" class="btn btn-warning btn-xs" title="Edit"><i class="fa fa-pencil"></i></a> ';
                        form += '<a href="' + base_url + '/' + id + '" class="btn btn-info btn-xs ajax-modal" title="View"><i class="fa fa-eye"></i></a> ';
                        form += '{{ method_field("DELETE") }}';
                        form += '@csrf';
                        form += '<button type="submit" class="btn btn-danger btn-xs btn-remove" title="Delete"><i class="fa fa-trash"></i></button>';
                        form += '</form>';
                        return form;
                    }
                }
            ],
            "order": [[0, "asc"]],
            "dom": '<"top"lf>rt<"bottom"Bip><"clear">',
            "buttons": ['copy', 'excel', 'csv', 'pdf', 'print'],

            "footerCallback": function(row, data, start, end, display) {
                var api = this.api();

                var json = api.ajax.json();
                var grandTotal = (json && json.grand_total) ? parseFloat(json.grand_total) : 0;

                // 2. Calculate Page Total (JS sum of visible rows)
                var pageTotal = api
                    .column(4, { page: 'current' })
                    .data()
                    .reduce(function(a, b) {
                        var val = typeof b === 'string' ? b.replace(/,/g, '') : b;
                        return parseFloat(a) + parseFloat(val || 0);
                    }, 0);

                // 3. Update the specific Footer Cell by ID
                $("#totalAmount").html(
                    '<div style="font-size: 14px; color: #666; white-space:nowrap;">This Page: ' + pageTotal.toFixed(1) + '</div>'
                    // '<div style="font-size: 16px; font-weight: bold; border-top:1px solid #ccc; white-space:nowrap;">Total: ' + grandTotal.toFixed(1) + '</div>'
                );
                $("#grandTotal").html('<strong>' + grandTotal.toFixed(2) + '</strong>');
            }
        });
    }

    // Handle Page Size Change
    $('#pageSize').on('change', function() {
        getAllRecordsForTable();
    });

    // Initialize on Page Load
    $(document).ready(function() {
        // Set Default Dates
        var now = new Date();
        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);
        var date_from = now.getFullYear() + "-" + (month) + "-" + ("01");
        var date_to = now.getFullYear() + "-" + (month) + "-" + (day);
        
        $('#date_from').val(date_from);
        $('#date_to').val(date_to);

        // Load Table Immediately
        getAllRecordsForTable();
    });
</script>
@stop