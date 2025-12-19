@extends('layouts.backend')

@section('content')
<div class="row">
    <div class="col-md-4"></div>
	<div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading text-center"><b>{{ _lang('Add Account Type') }}</b></div>
            
            <div class="panel-body">
                <form method="post" class="validate" autocomplete="off" action="{{route('update_account_types.update',  $accounts->id)}}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">{{ _lang('Account Type Name') }}</label>						
                                <input type="text" class="form-control" name="account_name" value="{{$accounts->account_type}}" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">{{ _lang('Please select level') }}</label>
                                <select class="form-control" name="account_level" required>
                                <option value=""> {{ _lang('Please Select Master Account') }}</option>
@foreach($master_account as $master)
    <option value="{{ $master->id }}" 
        {{ old('master_account', $accounts->master_account ?? '') == $master->id ? 'selected' : '' }}>
        {{ $master->master_account }}
    </option>
@endforeach

                                    <!--<option value=""> {{ _lang('Please Select Level') }}</option>-->
                                    <!--<option value="liabilities" {{ old('account_level', $accounts->account_level ?? '') == 'liabilities' ? 'selected' : '' }}>-->
                                    <!--    {{ _lang('Liabilities') }}-->
                                    <!--</option>-->
                                    <!--<option value="assets" {{ old('account_level', $accounts->account_level ?? '') == 'assets' ? 'selected' : '' }}>-->
                                    <!--    {{ _lang('Assets') }}-->
                                    <!--</option>-->
                                    <!--<option value="expenses" {{ old('account_level', $accounts->account_level ?? '') == 'expenses' ? 'selected' : '' }}>-->
                                    <!--    {{ _lang('Expenses') }}-->
                                    <!--</option>-->
                                    <!--<option value="income" {{ old('account_level', $accounts->account_level ?? '') == 'income' ? 'selected' : '' }}>-->
                                    <!--    {{ _lang('Income') }}-->
                                    <!--</option>-->
                                </select>
                            </div>

                        </div>
                    <div class="col-md-12">
                        <div class="form-group">
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

@endsection