@extends('layouts.backend')

@section('content')
<div class="row">
    <div class="col-md-4"></div>
	<div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading text-center"><b>{{ _lang('Add Master Account') }}</b></div>

            <div class="panel-body">
                <form method="post" class="validate" autocomplete="off" action="{{route('update.master.account', $edit_master_account['id'])}}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    
                    <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label">{{ _lang('Master Account Name') }}</label>						
                        <input type="text" class="form-control" name="master_account" value="{{$edit_master_account['master_account']}}" required>
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

@endsection