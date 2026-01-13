@extends('layouts.backend')

@section('content')

<div class="row">
	<form>
		<div class="col-md-12">
			
			<div class="col-md-4">
				<div class="form-group">
				<label class="control-label">{{ _lang('Floors') }}</label>						
				<select name="class_id" id="class_id" class="form-control select2" onchange="getSection();">
					<option value="all">{{ _lang('All Floors') }}</option>
					{{ create_option('classes','id','class_name',old('class_id')) }}
				</select>
				</div>
			</div>

			<div class="col-md-4">
				<div class="form-group">
				<label class="control-label">{{ _lang('Rooms') }}</label>						
				<select name="section_id" id="section_id" class="form-control select2">
					<option value="all">{{_lang('All Rooms') }}</option>
				</select>
				</div>
			</div>

			<div class="col-md-2">
				<div class="form-group">
				<label class="control-label">{{ _lang('Status') }}</label>						
				<select name="status_id" id="status_id" class="form-control select2">
					<option value="all">{{_lang('All') }}</option>
					<option value="Unpaid">{{_lang('Unpaid') }}</option>
					<option value="Paid">{{_lang('Paid') }}</option>
				</select>
				</div>
			</div>

			<div class="col-md-2">
				<div class="form-group">
					<button type="button" style="margin-top:24px;" class="btn btn-success" onclick="getAllRecordsForTable();" id="">Fetch</button>
				</div>
			</div>
		</div>
	</form>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
			  <span class="panel-title">{{ _lang('List Invoice') }}</span>
			</div>
			
			<div class="panel-body">
				@if (\Session::has('success'))
				<div class="alert alert-success">
					<p>{{ \Session::get('success') }}</p>
				</div>
				<br />
				@endif
				
				<a class="btn btn-primary btn-sm pull-left" style="margin-top:10px;margin-bottom:10px;" data-title="{{ _lang('Add New Invoice') }}" href="{{route('invoices.create')}}">{{ _lang('Add New Invoice') }}</a>
				<table id="tblRecords" class="table table-bordered">
					<thead>
						<tr>
							<th>{{ _lang('ID') }}</th>
							<th>{{ _lang('Student') }}</th>
							<th>{{ _lang('Floor') }} / {{ _lang('Room') }}</th>
							<th>{{ _lang('Due Date') }}</th>
							<th>{{ _lang('Title') }}</th>
							<th>{{ _lang('Total') }}</th>
							<th>{{ _lang('Paid') }}</th>
							<th>{{ _lang('Due') }}</th>
							<th>{{ _lang('Status') }}</th>
							<th>{{ _lang('Action') }}</th>
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
	$("#preloader").css("display","block");
	var url="{{url('/invoices')}}";
	url += "?class_id="+$('select[name=class_id]').val()+"&section_id="+$('select[name=section_id]').val()+"&status_id="+$('select[name=status_id]').val();

	$('#tblRecords').DataTable().destroy();
	$.fn.dataTable.ext.errMode = 'none';    //Suppressing Warnings in DataTables
	$("#tblRecords").DataTable(
	{
	"processing": true, // for show progress bar
	// "serverSide": true, // for process server side
	"filter": true, // this is for disable filter (search box)
	"orderMulti": false, // for disable multiple column at once
	"pageLength": 25,               
	"initComplete": function (settings, json) {

		$("#preloader").css("display","none");
	},

	"ajax": {

	"url": url,
	"type": "GET",
	"datatype":"json"
	},
	"columns": [                   
	{ "data": "id", name: 'id' },
	{
		"data": null, class:'',
		"render": function (data, type, full, meta) {

			return (full["first_name"]);
		}
	},
	{
		"data": null, class:'',
		"render": function (data, type, full, meta) {

			return (full["class_name"]+" / "+full["section_name"]);
		}
	},
	{ "data": "due_date", name: 'due_date' },
	{ "data": "title", name: 'title' },
	{ "data": "total", name: 'total' },
	{ "data": "paid", name: 'paid' },
	{
		"data": null, class:'',
		"render": function (data, type, full, meta) {

			return (Number(full["total"])-Number(full["paid"]));
		}
	},
	{
		"data": null, class:'',
		"render": function (data, type, full, meta) {

			if(full["status"]=="Paid")
				return ('<i class="fa fa-circle paid"></i>'+full["status"]);
			else
				return ('<i class="fa fa-circle unpaid"></i>'+full["status"]);
			},
		"orderable": false,
		"searchable": false
	},
	{
		"data": null, class:'',
		"render": function (data, type, full, meta) {

			id = full["id"];
			
			var formRoute = "{{ url('invoices') }}"+"/"+id;
			var editLink = formRoute+"/edit";
			var paySllipLink = "{{ url('invoices/feebill') }}";
				paySllipLink += '/'+id+'?type=pay_sllip';

			var feeSllipLink = "{{ url('invoices/feebill') }}" + '/'+id+'?type=fee_bill';

			var paymentHistoryLink = "{{ url('student_payments/create') }}"+"/"+id;
			var addpaymentLink = "{{ url('student_payments/create') }}"+"/"+id;

			var form = '<div class="dropdown">';
			form += '<button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">Action';
			form += '<span class="caret"></span></button>';
			form += '<form action="'+formRoute+'" method="post">';		
			form += '{{ csrf_field() }}';		
			form += '<input name="_method" type="hidden" value="DELETE">';		
			form += '<ul class="dropdown-menu">';		
			if(full["status"]=="Paid" && Number(full["paid"]) > 0)
			{
				form += '<li><a href="'+editLink+'">{{ _lang('Edit') }}</a></li>';
				form += '<li><a href="'+paySllipLink+'" target="_blank">Pay Sllip</a></li>';
				form += '<li>';
				form += '<a href="'+paymentHistoryLink+'" data-title="{{ _lang('Add Payment') }}" class="ajax-modal">{{ _lang('Payment History') }}</a>';
			    form += '</li>';
			}
			else
			{
				form += '<li><a href="'+editLink+'">{{ _lang('Edit') }}</a></li>';
				form += '<li><a href="'+paySllipLink+'" target="_blank">Pay Sllip</a></li>';
				form += '<li><a href="'+feeSllipLink+'" target="_blank">{{ _lang('Fee Bill') }}</a></li>';
				form += '<li>';
				form += '<a href="'+addpaymentLink+'" data-title="{{ _lang('Add Payment') }}" class="ajax-modal">{{ _lang('Take Payment') }}</a>';
				form += '</li>';

				@if (Auth::User()->role_id==3)	
					form += '<li><button class="btn-remove link-btn" type="submit">{{ _lang('Delete') }}</button></li>';
            	@endif

			}				
			form += '</ul>';		
			form += ' </form>';		
			form += '</div>';		
			return form;
		},
		"orderable": false,
		"searchable": false
	},
	],
	"order": [[0, "asc", ]],
               "dom": '<"top"lf>rt<"bottom"Bip><"clear">',
               "buttons": [
                   {
                       extend: 'copy',
                       messageTop: '\n',
                       messageBottom: '\n',
					   exportOptions: {
                           //columns: ':visible'
                           columns: [0, 1, 2, 3, 4, 5, 6,7,8]
                       },
                       text:'<i class="fa fa-clone"></i> Copy'
                   },
                   {
                       extend: 'excel',
                       messageTop: '\n',
                       messageBottom: '\n',
					   exportOptions: {
                           //columns: ':visible'
                           columns: [0, 1, 2, 3, 4, 5, 6,7,8]
                       },
                       text: '<i class="fa fa-file-excel-o"></i> Excel'
                   },
                   {
                       extend: 'csv',
                       messageTop: '\n',
                       messageBottom: '\n',
					   exportOptions: {
                           //columns: ':visible'
                           columns: [0, 1, 2, 3, 4, 5, 6,7,8]
                       },
                       text: '<i class="fa fa-file"></i> CSV'
                   },
                   {
                       extend: 'pdf',
                       messageTop: '\n',
                       messageBottom: '\n',
					   exportOptions: {
                           //columns: ':visible'
                           columns: [0, 1, 2, 3, 4, 5, 6,7,8]
                       },
                       text: '<i class="fa fa-file-pdf-o"></i> PDF'
                   },
                   {
                       extend: 'print',
                       messageTop: '\n',
                       messageBottom: '\n',
					   exportOptions: {
                           //columns: ':visible'
                           columns: [0, 1, 2, 3, 4, 5, 6,7,8]
                       },
                       text: '<i class="fa fa-print"></i> Print'
                   },
                   'colvis'

               ],
               //responsive: true

	});
}

function getSection() 
{
		var _token=$('input[name=_token]').val();
		var class_id=$('select[name=class_id]').val();
		$.ajax({
			type: "POST",
			url: "{{ url('sections/section') }}",
			data:{_token:_token,class_id:class_id,all_section:'All'},
			beforeSend: function(){
			    $("#preloader").css("display","block");
			},success: function(data){
				$("#preloader").css("display","none");
				$('select[name=section_id]').html(data);				
			}
		});
}

</script>
@stop


