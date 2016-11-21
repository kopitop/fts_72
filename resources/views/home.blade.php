@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('front-end/home.dialog-title.dashboard') }}</div>

                <div class="panel-body">
                    {{ trans('front-end/home.info.welcome') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
