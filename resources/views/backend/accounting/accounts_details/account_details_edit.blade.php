@extends('layouts.backend')

@section('content')
<div class="row">
    <div class="col-md-4"></div>
	<div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading text-center"><b>{{ _lang('Add Account Type') }}</b></div>
            
            <div class="panel-body">
                <form method="post" class="validate" autocomplete="off" action="{{route('update_account_detail.update',  $accounts->id)}}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">{{ _lang('Account Name') }}</label>						
                                <input type="text" class="form-control" name="account_name" value="{{$accounts->account_name}}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">{{ _lang('Account Number') }}</label>						
                                <input type="text" class="form-control" name="account_number" value="{{$accounts->account_number}}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">{{ _lang('Please select Type') }}</label>
                                <select class="form-control" name="account_type" required>
                                    <option value="">{{ _lang('Please Select Type') }}</option>
                                    @foreach ($master_account_level as $level)
                                        <option value="{{ $level->id }}" 
                                            {{ old('account_type', $accounts->account_type) == $level->id ? 'selected' : '' }}>
                                            {{ $level->account_type }}
                                        </option>
                                    @endforeach
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