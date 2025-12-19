@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-12">
	<div class="panel panel-default">
	<div class="panel-heading">{{ _lang('Add Department') }}</div>

	<div class="panel-body">
	  <form method="post" class="validate" autocomplete="off" action="{{url('departments')}}" enctype="multipart/form-data">
		{{ csrf_field() }}
		
		<div class="col-md-12">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Department Name') }}</label>						
			<input type="text" class="form-control" name="department_name" value="{{ old('department_name') }}" required>
		  </div>
		</div>
		<div class="col-md-12">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Bank Name') }}</label>						
			<input type="text" class="form-control" name="bank_name" value="{{ old('bank_name') }}" required>
		  </div>
		</div>
		<div class="col-md-12">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Bank Account') }}</label>						
			<input type="text" class="form-control" name="bank_account" value="{{ old('bank_account') }}" required>
		  </div>
		</div>
		<div class="col-md-6">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Bank Logo') }}</label>						
			<input type="file" class="form-control dropify" name="bank_logo" data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG">
		  </div>
		</div>
		<div class="col-md-6">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Hostel Logo') }}</label>						
			<input type="file" class="form-control dropify" name="school_logo" data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG">
		  </div>
		</div>
				
		<div class="form-group">
		  <div class="col-md-12">
		    <button type="reset" class="btn btn-danger">{{ _lang('Reset') }}</button>
			<button type="submit" class="btn btn-primary">{{ _lang('Save') }}</button>
		  </div>
		</div>
	  </form>
	</div>
  </div>
 </div>
</div>
@endsection


