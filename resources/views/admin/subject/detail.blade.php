@extends('admin.master')

@section('sub-view')
    <div class="panel panel-default">
        <div class="panel-heading">{{ $title }}</div>

        <div class="panel-body">

            <form class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-2 control-label">{{ trans('common/labels.name') }}</label>
                    <div class="col-sm-10">
                        <p class="form-control-static">{{ $subject->name }}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="subject_duration" class="col-sm-2 control-label">{{ trans('common/labels.duration') }}</label>
                    <div class="col-sm-10">
                        <p class="form-control-static">{{ $subject->duration }}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="subject_quantity" class="col-sm-2 control-label">{{ trans('common/labels.quantity') }}</label>
                    <div class="col-sm-10">
                        <p class="form-control-static">{{ $subject->number_of_question }}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="subject_created" class="col-sm-2 control-label">{{ trans('common/labels.created-at') }}</label>
                    <div class="col-sm-10">
                        <p class="form-control-static">{{ $subject->created_at }}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="subject_updated" class="col-sm-2 control-label">{{ trans('common/labels.updated-at') }}</label>
                    <div class="col-sm-10">
                        <p class="form-control-static">{{ $subject->updated_at }}</p>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
