@extends('layouts.backend')

@section('content')
<div class="row">
    <div class="col-md-4"></div>
	<div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading text-center"><b>{{ _lang('Add Master Account') }}</b></div>

            <div class="panel-body">
                <form method="post" class="validate" autocomplete="off" action="{{route('save.master.account')}}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    
                    <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label">{{ _lang('Master Account Name') }}</label>						
                        <input type="text" class="form-control" name="master_account"  required>
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
        <th>{{ _lang('Master Account Name') }}</th>
        <th>{{ _lang('Action') }}</th>
      </tr>
    </thead>
    <tbody>
      @foreach($master_account as $account_type)
      <tr>
        <td>{{ $account_type->master_account }}</td>
        <td>
        <a href="{{ route('edit.master.account', $account_type->id) }}" class="btn btn-warning btn-sm">{{ _lang('Edit') }}</a>
                        <form action="{{ route('delete.master.account', $account_type->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ _lang('Are you sure?') }}')">{{ _lang('Delete') }}</button>
                        </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
</div>
@endsection