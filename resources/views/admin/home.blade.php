@extends('admin.master')

@section('sub-view')
    <div class="panel panel-default">
        <div class="panel-heading">{{ $title }}</div>

        <div class="panel-body">
            {{ trans('admin/home.info.welcome') }}
        </div>
    </div>
@endsection
