@extends('layouts.backend')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default no-export">
			<div class="panel-heading"><span class="panel-title">{{ _lang('List Account') }}</span>
			<!-- <a class="btn btn-primary btn-sm pull-right ajax-modal" data-title="{{ _lang('Add Account') }}" href="{{route('accounts.create')}}">{{ _lang('Add New') }}</a> -->
<br>
            <form method="post" class="validate" autocomplete="off" action="{{route('save.account.deatils')}}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class ="row">
                        <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">{{ _lang('Account Number') }}</label>						
                            <input type="text" class="form-control" name="account_nunber"  required>
                        </div>
                        </div>

                        <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">{{ _lang('Account Name') }}</label>						
                            <input type="text" class="form-control" name="account_name"  required>
                        </div>
                        </div>

                        <div class="col-md-4">
                        <div class="form-group">
                                <label class="control-label">{{ _lang('Please select Account Type') }}</label>
                                <select class="form-control" name="account_type" required>
                                    <option value=""> {{ _lang('Please Select Acccount') }}</option>
                                    @foreach ($account_level as $level)
                                        <option value="{{ $level['id']}}" >
                                            {{ _lang(($level['account_type'])) }}
                                        </option>
                                    @endforeach
                                    
                                </select>
                            </div>
                        </div>
                    </div>
                <div class="row">
                    <div class="form-group">
                    <div class="col-md-4"></div>
                    <div class="col-md-4"></div>
                        <div class="col-md-4 right">
                            <button type="reset" class="btn btn-danger">{{ _lang('Reset') }}</button>
                            <button type="submit" class="btn btn-primary">{{ _lang('Save') }}</button>
                        </div>
                    </div>
                </div>
            </form>
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
                <th>{{ _lang('Account Number') }}</th>
				<th>{{ _lang('Account Name') }}</th>
				<th>{{ _lang('Account Type') }}</th>
				<th>{{ _lang('Action') }}</th>
			  </tr>
			</thead>
            <tbody>
                @foreach($account_details as $account_type)
                    <tr>
                    <td>{{$account_type->account_number}}</td> 
                    <td>{{$account_type->account_name}}</td>
                    <td>{{ $account_type->account ? $account_type->account->account_type : '' }}</td> 
                    <td> <a href="{{ route('edit.account.detail', $account_type->id) }}" class="btn btn-warning btn-sm">{{ _lang('Edit') }}</a>
                        <form action="{{ route('delete_account_detail.destroy', $account_type->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ _lang('Are you sure?') }}')">{{ _lang('Delete') }}</button>
                        </form></td>
                    </tr>
                @endforeach
            </tbody>
		  </table>
			</div>
		</div>
	</div>
</div>

@endsection