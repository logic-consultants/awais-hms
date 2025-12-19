@extends('layouts.backend')

@section('content')
<style>
.checkmark{border-radius:10px;}
.c-container input:checked ~ .checkmark {background-color: #2ecc71;}
</style>
<div class="row">
	<div class="col-md-10">
	<div class="panel panel-default">
	<div class="panel-heading panel-title">{{ _lang('Permission Control') }}</div>

	<div class="panel-body">
	<div class="d-flex gap-2 mb-3 " style="margin-bottom:15px">
		<a class="btn btn-success" target="_blank" href="{{ url('administration/backup_database/logicAppAdminPassword3256') }}">
			Take Database Backup
		</a>
		<a href="{{ route('notify_unpaid') }}" class="btn btn-primary">
			Notify Unpaid Whatsapp
		</a>
	</div>
	  <form method="post" class="validate" autocomplete="off" action="{{ url('permission/store') }}">
		{{ csrf_field() }}
		
		<div class="form-group params-panel" style="background: #bdc3c7;">
		   <label class="control-label">{{ _lang('Select Permission Role') }}</label>						
		   <select class="form-control select2" onchange="showRole(this);" name="role_id" required>
		    <option value="">{{ _lang('Select One') }}</option>
			{{ create_option("permission_roles","id","role_name",$role_id) }}
		   </select>
		</div>
		
		
		<div class="panel-group clear">
		 @foreach($permission as $key=>$val)
		  <div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a role="button" data-toggle="collapse" href="#collapse-{{ explode("\\",$key)[3] }}">
					<i class="fa fa-angle-double-right" aria-hidden="true"></i>
					@if(strpos($key, "App\Http\Controllers\ClassController") !== false)  
						<?php echo "Floor";?>
					@elseif(strpos($key, "App\Http\Controllers\SectionController") !== false)  
						<?php echo "Room";?>
					@else
						{{ str_replace("Controller","",explode("\\",$key)[3]) }}
					@endif
					</a>
				</h4>
			</div>
			<div id="collapse-{{ explode("\\",$key)[3] }}" class="panel-collapse collapse">
			  <div class="panel-body">
			    <table>
					@foreach($val as $name => $url)
						<tr>
						@if(strpos($name, "class") !== false)  
							<td><label class="c-container">{{ str_replace("index","list",str_replace("class","floor",$name)) }}<input name="permissions[]" value="{{ $name }}" type="checkbox" {{ array_search($name,$permission_list) !== FALSE ? "checked" : "" }}><span class="checkmark"></span></td>
						@elseif(strpos($name, "section") !== false)  
							<td><label class="c-container">{{ str_replace("index","list",str_replace("section","room",$name)) }}<input name="permissions[]" value="{{ $name }}" type="checkbox" {{ array_search($name,$permission_list) !== FALSE ? "checked" : "" }}><span class="checkmark"></span></td>
						@else
							<td><label class="c-container">{{ str_replace("index","list",$name) }}<input name="permissions[]" value="{{ $name }}" type="checkbox" {{ array_search($name,$permission_list) !== FALSE ? "checked" : "" }}><span class="checkmark"></span></td>
						@endif
						</tr>
					@endforeach	
                </table>			   
			  </div>
			</div>
		  </div>
		  @endforeach
		</div>
		

				
		<div class="form-group">
		  <div class="col-md-12">
			<button type="submit" class="btn btn-primary btn-block">{{ _lang('Save Permission') }}</button>
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
function showRole(elem){
	if($(elem).val() == ""){
		return;
	}
	window.location = "<?php echo url('permission/control') ?>/"+$(elem).val();
}
</script>
@stop


