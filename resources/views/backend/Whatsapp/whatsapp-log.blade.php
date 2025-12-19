@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title" >
					{{_lang('WhatsApp Log')}}
				</span>
				<a href="{{ url('Whatsapp/create-whatsapp') }}" class="btn btn-primary btn-sm pull-right">{{_lang('New whatsApp')}}</a>
			</div>
			<div class="panel-body no-export">
				<table id="tblRecords" class="table table-bordered">
					<thead>
						<th>{{ _lang('Date') }}</th>
						<th>{{ _lang('Mobile') }}</th>
						<th>{{ _lang('Message') }}</th>
						<th>{{ _lang('Sender') }}</th>
					</thead>
					<tbody>
						@foreach($messages as $data)
						<tr>
							<td>{{ date('d/M/Y - H:m', strtotime($data->created_at)) }}</td>
							<td>{{ $data->receiver }}</td>
							<td>{{ $data->message }}</td>
							<td>{{ $data->sender }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				
				<div class="pull-right">
					{{ $messages->links() }}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('js-script')
<script>
	$(document).ready(function () {
		var table = $('#tblRecords').DataTable();

	$('#customSearchBox').on('keyup', function () {
    table.search(this.value).draw();
});
$("#tblRecords").on('init.dt', function () {
    $("#tblRecords th").removeClass("sorting sorting_asc sorting_desc");
});
	});
</script>
@stop