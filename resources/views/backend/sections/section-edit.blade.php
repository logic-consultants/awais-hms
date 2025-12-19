@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title" >
					{{_lang('Update Room')}}
				</div>
			</div>
			<div class="panel-body">
				<form action="{{route('sections.update',$section->id)}}" autocomplete="off" class="form-horizontal form-groups-bordered validate" enctype="multipart/form-data" method="post" accept-charset="utf-8">
					@csrf
					{{ method_field('PATCH') }}
					<div class="form-group">
					    <div class="col-sm-12">
						    <label class="control-label">{{_lang('Name')}}</label>
							<input type="text" class="form-control" name="section_name" value="{{ $section->section_name }}" required>
						</div>
					</div>
					
					<div class="form-group">
					    <div class="col-sm-12">
						    <label class="control-label">Floor</label>
							<select name="class_id" class="form-control select2" required>
								<option value="">Select One</option>
								{{ create_option('classes','id','class_name',$section->class_id) }}
							</select>
						</div>
					</div>
					
					<div class="form-group">
					    <div class="col-sm-12">
						    <label class="control-label">{{_lang('Capacity')}}</label>						
							<input type="number" class="form-control" min="1" name="capacity" value="{{ $section->capacity }}" required>
						</div>
					</div>
					
					<div class="form-group">
					    <div class="col-sm-12">
						    <label class="control-label">{{_lang('Room No/Name')}}</label>						
							<input type="text" class="form-control" name="room_no" value="{{ $section->room_no }}">
						</div>
					</div>

					<div class="form-group">
					    <div class="col-sm-12">
						    <label class="control-label">{{_lang('Room Rent')}}</label>						
							<input type="text" class="form-control" name="room_rent" value="{{ $section->room_rent }}">
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-12">
							<button type="submit" class="btn btn-info">{{_lang('Update Room')}}</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection