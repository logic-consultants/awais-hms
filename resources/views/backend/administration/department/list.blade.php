@extends('layouts.backend')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading"><span class="panel-title">{{ _lang('List Department') }}</span>
			<a class="btn btn-primary btn-sm pull-right" data-title="{{ _lang('Add Department') }}" href="{{route('departments.create')}}">{{ _lang('Add New') }}</a>
			</div>

			<div class="panel-body">
			 @if (\Session::has('success'))
			  <div class="alert alert-success">
				<p>{{ \Session::get('success') }}</p>
			  </div>
			  <br />
			 @endif
			<table class="table table-bordered data-table">
			<thead>
			  <tr>
				<th>#</th>
				<th>{{ _lang('Department Name') }}</th>
				<th>{{ _lang('Bank Name') }}</th>
				<th>{{ _lang('Bank Account') }}</th>
				<th>{{ _lang('Bank Logo') }}</th>
				<th>{{ _lang('Hostel Logo') }}</th>
				<th>{{ _lang('Action') }}</th>
			  </tr>
			</thead>
			<tbody>
			  
			  @foreach($departments as $key => $department)
			  <tr id="row_{{ $department->id }}">
				<td class='id'>{{ ++$key }}</td>
				<td class='group_name'>{{ $department->department_name }}</td>
				<td class='group_name'>{{ $department->bank_name }}</td>
				<td class='group_name'>{{ $department->bank_account }}</td>
				<td class='group_name'><img src="{{ asset('uploads/'.$department->bank_logo) }}" width="120px" alt=""></td>
				<td class='group_name'><img src="{{ asset('uploads/'.$department->school_logo) }}" width="120px" alt=""></td>	
				<td>
				  <form action="{{action('DepartmentController@destroy', $department['id'])}}" method="post">
					<a href="{{action('DepartmentController@edit', $department['id'])}}" data-title="{{ _lang('Update Department') }}" class="btn btn-warning btn-sm">{{ _lang('Edit') }}</a>
					{{ csrf_field() }}
					<input name="_method" type="hidden" value="DELETE">
					<button class="btn btn-danger btn-sm btn-remove" type="submit">{{ _lang('Delete') }}</button>
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


