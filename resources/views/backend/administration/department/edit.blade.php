@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">{{ _lang('Update Department') }}</div>

			<div class="panel-body">
			 <form method="post" class="validate" autocomplete="off" action="{{action('DepartmentController@update', $id)}}" enctype="multipart/form-data">
				{{ csrf_field()}}
				<input name="_method" type="hidden" value="PATCH">				
				<div class="col-md-12">
				  <div class="form-group">
					<label class="control-label">{{ _lang('Department Name') }}</label>						
					<input type="text" class="form-control" name="department_name" value="{{$department->department_name}}" required>
				  </div>
				</div>
				<div class="col-md-12">
				  <div class="form-group">
					<label class="control-label">{{ _lang('Bank Name') }}</label>						
					<input type="text" class="form-control" name="bank_name" value="{{$department->bank_name}}" required>
				  </div>
				</div>
				<div class="col-md-12">
				  <div class="form-group">
					<label class="control-label">{{ _lang('Bank Account') }}</label>						
					<input type="text" class="form-control" name="bank_account" value="{{$department->bank_account}}" required>
				  </div>
				</div>

				<div class="col-md-6">
				  <div class="form-group">
					<label class="control-label">{{ _lang('Bank Logo') }}</label>						
					<input type="file" class="form-control dropify" name="bank_logo" data-default-file="{{ asset('uploads/'.$department->bank_logo) }}" data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG">
				  </div>
				</div>
				<div class="col-md-6">
				  <div class="form-group">
					<label class="control-label">{{ _lang('Hostel Logo') }}</label>						
					<input type="file" class="form-control dropify" name="school_logo" data-default-file="{{ asset('uploads/'.$department->school_logo) }}" data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG">
				  </div>
				</div>
				<input type="hidden" name="remove_bank_logo" id="remove_bank_logo" value="0">
				<input type="hidden" name="remove_school_logo" id="remove_school_logo" value="0">
				<br>
				
				<div class="form-group">
				  <div class="col-md-12">
					<button type="submit" class="btn btn-primary">{{ _lang('Update') }}</button>
				  </div>
				</div>
			  </form>
			</div>
		</div>
	</div>
</div>

@endsection

@section('js-script')
<script>
  $('.dropify').on('dropify.afterClear', function(event, element){
	  var name = $(element.element).attr('name');
	  if(name == 'bank_logo'){
		  $('#remove_bank_logo').val(1);
	  } else if(name == 'school_logo'){
		  $('#remove_school_logo').val(1);
	  }
  });
</script>
@endsection

