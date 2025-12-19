@extends('layouts.backend')

@section('content')

<div class="row">
	<form>
		<div class="col-md-12">
			
		</div>
	</form>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
			  <span class="panel-title">{{ _lang('List Schools') }}</span>
			</div>
			
			<div class="panel-body">
				@if (\Session::has('success'))
				<div class="alert alert-success">
					<p>{{ \Session::get('success') }}</p>
				</div>
				<br />
				@endif
				
				<a class="btn btn-primary btn-sm pull-left" style="margin-top:10px;margin-bottom:10px;" data-title="{{ _lang('Add New School') }}" href="{{route('school.create')}}">{{ _lang('Add New School') }}</a>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>{{ _lang('ID') }}</th>
							<th>{{ _lang('School Name') }}</th>
							<th>{{ _lang('Address') }} / {{ _lang('Room') }}</th>
							<th>{{ _lang('Phone No') }}</th>
							<th>{{ _lang('Register No') }}</th>
							<th>{{ _lang('Active') }}</th>
							<th>{{ _lang('Action') }}</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection

