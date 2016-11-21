@extends('admin.master')

@section('sub-view')
    <div class="panel panel-default">
        <div class="panel-heading">{{ trans('admin/home.dialog-title.dashboard') }}</div>

        <div class="panel-body">
            {{ trans('admin/home.info.welcome') }}
        </div>
    </div>
@endsection
