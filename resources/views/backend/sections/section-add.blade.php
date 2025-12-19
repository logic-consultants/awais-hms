@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<span class="panel-title" >
					{{_lang('Add New Room')}}
				</span>
			</div>
			<div class="panel-body">
				<form action="{{route('sections.store')}}" autocomplete="off" class="form-horizontal form-groups-bordered validate" enctype="multipart/form-data" method="post" accept-charset="utf-8">
					@csrf
					<div class="form-group">
					    <div class="col-sm-12">
						    <label class="control-label">{{_lang('Name')}}</label>						
							<input type="text" class="form-control" name="section_name" required value="{{old('section_name')}}">
						</div>
					</div>
					
					<div class="form-group">
					   <div class="col-sm-12">
						    <label class="control-label">Floor</label>
							<select name="class_id" class="form-control select2" required>
								<option value="">Select One</option>
								{{ create_option('classes','id','class_name',old('class_id')) }}
							</select>
						</div>
					</div>
					
					<div class="form-group">
					    <div class="col-sm-12">
						    <label class="control-label">{{_lang('Capacity')}}</label>						
							<input type="number" class="form-control" min="1" name="capacity" value="{{ old('capacity') }}" required>
						</div>
					</div>

					
					<div class="form-group">
					    <div class="col-sm-12">
						    <label class="control-label">{{_lang('Room No/Name')}}</label>						
							<input type="text" class="form-control" name="room_no" value="{{ old('room_no') }}">
						</div>
					</div>

					<div class="form-group">
					    <div class="col-sm-12">
						    <label class="control-label">{{_lang('Room Rent')}}</label>						
							<input type="text" class="form-control" name="room_rent" value="{{ old('room_rent') }}">
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-5">
							<button type="submit" class="btn btn-info">{{_lang('Add Room')}}</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-8">
	    <div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<span class="panel-title" >
					{{_lang('Room List')}}
				</span>
				
				<select id="class" class="select_class pull-right" onchange="showClass(this);">
				   <option value="">{{ _lang('Select Floor') }}</option>
				   {{ create_option('classes','id','class_name',$class) }}
				</select>
			</div>
			<div class="panel-body no-export">
				<table class="table table-bordered data-table">
					<thead>
						<th>{{_lang('Floor Name')}}</th>
						<th>{{_lang('Room Name')}}</th>
						<th>{{_lang('Capacity')}}</th>
						<th>{{_lang('Rent')}}</th>
						<th>{{_lang('Action')}}</th>
					</thead>
					<tbody>
						@foreach($sections AS $data)
						 <tr>
							<td>{{$data->class_name}}</td>
							<td>{{$data->section_name}}</td>
							<td>{{$data->capacity}}</td>
							<td>{{$data->room_rent}}</td>
							<td>
								<form action="{{route('sections.destroy',$data->id)}}" method="post">
								    <a href="{{route('sections.edit',$data->id)}}" class="btn btn-warning btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i></a>
									{{ method_field('DELETE') }}
    								@csrf
    								<button type="submit" class="btn btn-danger btn-xs btn-remove"><i class="fa fa-eraser" aria-hidden="true"></i></button>
								</form>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection

@section('js-script')
<script>
function showClass(elem){
	if($(elem).val() == ""){
		return;
	}
	window.location = "<?php echo url('sections/class') ?>/"+$(elem).val();
}
</script>
@stop