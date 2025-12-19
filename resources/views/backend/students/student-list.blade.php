@extends('layouts.backend')
@section('content')

<style>
	#tblStudents { font-size: 12px; }
	#tblStudents th, #tblStudents td { padding: 4px 6px !important; text-align: center; vertical-align: middle!important; }
	.btn-xs { padding: 1px 5px; font-size: 10px; }

</style>

<div class="row">
	<form>
		<div class="col-md-12">
			
			<div class="col-md-4">
				<div class="form-group">
				<label class="control-label">{{ _lang('Floor') }}</label>						
				<select name="class_id" id="class_id" class="form-control select2">
					<option value="all">{{ _lang('Select One') }}</option>
					<option value="all">{{ _lang('All Floors') }}</option>
					{{ create_option('classes','id','class_name',old('class_id')) }}
				</select>
				</div>
			</div>

			<div class="col-md-4">
				<div class="form-group">
				<label class="control-label">{{ _lang('Status') }}</label>						
				<select name="status_id" id="status_id" class="form-control select2">
				   <option value="all">{{ _lang('All') }}</option>
				   <option value="1">{{ _lang('Active') }}</option>
				   <option value="0">{{ _lang('Inactive') }}</option>
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
				<span class="panel-title">{{_lang('Students List')}}</span>
			</div>				
			<div class="panel-body">
				<a href="{{route('students.create')}}" style="margin-top:10px;margin-bottom:10px;" class="btn btn-primary btn-sm pull-left">{{_lang('Add New Student')}}</a>
				<br>	
				<table id="tblStudents" class="table table-bordered table-condensed" style="width: 100%;">
						<thead>
							<th>{{ _lang('Profile') }}</th>
						 	<!-- <th>{{ _lang('CNIC') }}</th> -->
							<th>{{ _lang('Name') }}</th>
							<th>{{ _lang('F.Name') }}</th>
							<th>{{ _lang('Address') }}</th>
							<th>{{ _lang('Rooms') }}</th>
							<!-- <th>{{ _lang('Cell #') }}</th> -->
							<th>{{ _lang('Admit Date') }}</th>
							<th>{{ _lang('Status') }}</th>
							<th>{{ _lang('ID Card') }}</th>
							<th>{{ _lang('Action') }}</th>
						</thead>
				</table>

			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="reasonModal" tabindex="-1" role="dialog" aria-labelledby="reasonModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="reasonModalLabel">Reason for Status Change</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <textarea class="form-control" id="statusReason" placeholder="Enter reason..." required></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="submitReason">Submit</button>
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
	var url="{{url('/students')}}";
	url += "?class_id="+$('select[name=class_id]').val()+"&status_id="+$('select[name=status_id]').val();

	$('#tblStudents').DataTable().destroy();
	$.fn.dataTable.ext.errMode = 'none';    //Suppressing Warnings in DataTables
	$("#tblStudents").DataTable(
	{
	"processing": true, // for show progress bar
	// "serverSide": true, // for process server side
	"filter": true, // this is for disable filter (search box)
	"orderMulti": false, // for disable multiple column at once
	"pageLength": 25,       
	"initComplete": function (settings, json) {

		$("#preloader").css("display","none");
		//console.log(json);
	},

	"ajax": {

	"url": url,
	"type": "GET",
	"datatype":"json"
	},
	"columns": [                   
	{
		"data": null, class:'',width: '5px',
		"render": function (data, type, full, meta) {

			var img="{{ asset('uploads/images') }}";
			img += "/"+full["image"];

			return '<img src="'+img+'" width="50px" alt="">';
		},
		"orderable": false,
		"searchable": false
	},
	// { "data": "activities", name: 'activities',width: '5px', },
	{ "data": "name", name: 'name', class:'',width: '5px', },
	{ "data": "father_name", name: 'father_name', class:'',width: '5px', },
	// { "data": "address", name: 'address',width: '5px', },
	{
		"data": null, class:'',width: '5px',
		"render": function (data, type, full, meta) {

			return (full["address"]+" - Cell#"+full["phone"]);
		},
		"orderable": true,
		"searchable": true
	},
	{ "data": "section_name", name: 'section_name',width: '5px' },
	// { "data": "phone", name: 'phone',width: '5px', },
	// { "data": "created_at", name: 'created_at',width: '5px', },	
	{
		"data": null, class:'',width: '5px',
		"render": function (data, type, full, meta) {

			return (full["created_at"].substring(0, 10));//showing only date not showing time
		},
		"orderable": true,
		"searchable": true
	},
	{
		"data": null, class:'',width: '5px',
		"render": function (data, type, full, meta) {

			if(full["status"])
				return '<b>Active</b>';
			else
				return '<b>Inactive</b>';
		},
		"orderable": false,
		"searchable": false
	},
	{
		"data": null, class:'',width: '5px',
		"render": function (data, type, full, meta) {

			var link="{{ url('students/id_card') }}";
			link += "/"+full["id"];

			return '<a href="'+link+'" class="btn btn-primary btn-sm ajax-modal">{{ _lang('View') }}</a>';
		},
		"orderable": false,
		"searchable": false
	},
	{
		"data": null, class:'',width: '5px',
		"render": function (data, type, full, meta) {

            id = full["id"];
            var url="{{ url('students') }}";

            var formRoute = url+"/"+id;
            var showRoute = url+"/"+id;
            var editRoute = url+"/"+id+"/edit";
            var formPrintStudent = url+"/print_student/"+id;
            var pdfRoute = url+"/student_detail/"+id;

            var form='<form action="'+formRoute+'" method="post" class="status-change-form">';
            form += '<a href="'+showRoute+'" class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i></a>';
            form += '<a href="'+pdfRoute+'" class="btn btn-info btn-xs"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>';
            form += '<a href="'+editRoute+'" class="btn btn-warning btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
            form += '<a href="'+formPrintStudent+'" target="_blank" class="btn btn-primary btn-xs"><i class="fa fa-print" aria-hidden="true"></i></a>';
            form += '{{ method_field('DELETE') }}';
            form += '@csrf';
            if(full["status"])
                form += '<button type="button" class="btn btn-success btn-xs btn-status-change" data-title="Are you sure you want to student inactive?" title="Active Student"><i class="fa fa-toggle-on" aria-hidden="true"></i></button>';
            else
                form += '<button type="button" class="btn btn-danger btn-xs btn-status-change" data-title="Are you sure you want to student active?" title="Inactive Student"><i class="fa fa-toggle-off" aria-hidden="true"></i></button>';
            form += '</form>';


			return form;
		},
		"orderable": false,
		"searchable": false
	},
	],
	"order": [[1, "asc", ]],
               "dom": '<"top"lf>rt<"bottom"Bip><"clear">',
               "buttons": [
                   {
                       extend: 'copy',
                       messageTop: '\n',
                       messageBottom: '\n',
					   exportOptions: {
                           //columns: ':visible'
                           columns: [0, 1, 2, 3, 4, 5, 6]
                       },
                       text:'<i class="fa fa-clone"></i> Copy'
                   },
                   {
                       extend: 'excel',
                       messageTop: '\n',
                       messageBottom: '\n',
					   exportOptions: {
                           //columns: ':visible'
                           columns: [0, 1, 2, 3, 4, 5, 6]
                       },
                       text: '<i class="fa fa-file-excel-o"></i> Excel'
                   },
                   {
                       extend: 'csv',
                       messageTop: '\n',
                       messageBottom: '\n',
					   exportOptions: {
                           //columns: ':visible'
                           columns: [0, 1, 2, 3, 4, 5, 6]
                       },
                       text: '<i class="fa fa-file"></i> CSV'
                   },
                   {
                       extend: 'pdf',
                       messageTop: '\n',
                       messageBottom: '\n',
					   exportOptions: {
                           //columns: ':visible'
                           columns: [0, 1, 2, 3, 4, 5, 6]
                       },
                       text: '<i class="fa fa-file-pdf-o"></i> PDF'
                   },
                   {
                       extend: 'print',
                       messageTop: '\n',
                       messageBottom: '\n',
					   exportOptions: {
                           //columns: ':visible'
                           columns: [0, 1, 2, 3, 4, 5, 6]
                       },
                       text: '<i class="fa fa-print"></i> Print'
                   },
                   'colvis'

               ],
               responsive: true

	});
}



            // JS to handle modal and form submission (add this in your scripts)
            $(document).on('click', '.btn-status-change', function(e) {
				e.preventDefault();
				var $form = $(this).closest('form');
				$('#reasonModal').appendTo('body').data('form', $form).modal('show');
			});

            $('#submitReason').on('click', function() {
                var reason = $('#statusReason').val();
                if(reason.trim() === '') {
                    alert('Please enter a reason.');
                    return;
                }
                var $form = $('#reasonModal').data('form');
                // Append reason as hidden input
                if($form.find('input[name="reason"]').length === 0) {
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'reason',
                        value: reason
                    }).appendTo($form);
                } else {
                    $form.find('input[name="reason"]').val(reason);
                }
                $('#reasonModal').modal('hide');
                $form.submit();
            });

</script>
@stop