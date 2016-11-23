@extends('admin.master')

@section('sub-view')
    <div class="panel panel-default">
        <div class="panel-heading">{{ $title }}</div>

        <div class="panel-body">
            
            {!! Form::open([
                'action' => ['Admin\SubjectsController@update', $subject->id],
                'method' => 'PUT',
                'class' => 'form-horizontal'
            ]) !!}
                <div class="form-group">
                    {!! Form::label('name', trans('common/labels.name'), ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('name', old('name') ? old('name') : $subject->name, [
                            'class' => 'form-control',
                            'placeholder' => trans('common/placeholders.name')
                        ]) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('duration', trans('common/labels.duration'), ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::select('duration', getOptions('options.duration'), 
                            old('duration') ? old('duration') : $subject->duration, [
                            'placeholder' => trans('common/placeholders.options'),
                            'class' => 'form-control'
                        ]) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('number_of_question', trans('common/labels.quantity'), ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::select('number_of_question', getOptions('options.quantity'),
                            old('number_of_question') ? old('number_of_question') : $subject->number_of_question, [
                            'placeholder' => trans('common/placeholders.options'),
                            'class' => 'form-control'
                        ]) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        {!! Form::submit(trans('common/buttons.edit'), [
                            'class' => 'btn btn-default confirm',
                        ]) !!}
                    </div>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection
