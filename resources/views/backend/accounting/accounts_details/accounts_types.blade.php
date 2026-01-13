@extends('layouts.backend')

@section('content')
<div class="row">
    <div class="col-md-4"></div>
	<div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading text-center"><b>{{ _lang('Add Account Type') }}</b></div>

            <div class="panel-body">
                <form method="post" class="validate" autocomplete="off" action="{{route('save.account.types')}}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    
                    <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label">{{ _lang('Account Type Name') }}</label>						
                        <input type="text" class="form-control" name="account_name"  required>
                    </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">{{ _lang('Please Select Master Account') }}</label>						
                            <select class="form-control" name="account_level" required>
                            <option value=""> {{ _lang('Please Select Master Account') }}</option>
                                @foreach($master_account as $master)
                                <option value="{{$master->id}}">{{ $master->master_account }}</option>
                                @endforeach
                                <!-- <option value=""> {{ _lang('Please Select Master Account') }}</option>
                                <option value="liabilities">{{ _lang('Liabilities') }}</option>
                                <option value="assets">{{ _lang('Assets') }}</option>
                                <option value="expenses">{{ _lang('Expenses') }}</option>
                                <option value="income"> {{ _lang('Income') }}</option> -->
                            </select>
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
    <div class="col-md-4"></div>
</div>
<div class="row"> 
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading text-center"><b>{{ _lang('Displaying Account Types') }}</b></div>
            <div class="panel-body">
                <table class="table table-bordered data-table">
                    <thead>
                    <tr>
                        <th>{{ _lang('Account Type') }}</th>
                        <th>{{ _lang('Master Accounts') }}</th> 
                        <th>{{ _lang('Action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($account_types as $account_type)
                    <tr>
                        <td>{{ $account_type->account_type }}</td>
                        <td>{{ $account_type->masterAccount ? $account_type->masterAccount->master_account : '' }}</td>
                        <td> <a href="{{ route('edit_account_types.edit', $account_type->id) }}" class="btn btn-warning btn-sm">{{ _lang('Edit') }}</a>
                        <form action="{{ route('delete_account_type.destroy', $account_type->id) }}" method="POST" style="display: inline-block;">
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