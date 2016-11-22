@extends('admin.master')

@section('sub-view')
    <div class="panel panel-default">
        <div class="panel-heading">{{ $title }}</div>

        <div class="panel-body">
            
            {!! Form::open(['action' => ['Admin\SubjectsController@store'], 'class' => 'form-horizontal']) !!}
                <div class="form-group">
                    {!! Form::label('name', trans('common/labels.name'), ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => trans('common/placeholders.name')]) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('duration', trans('common/labels.duration'), ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::select('duration', getOptions('options.duration'), null, ['placeholder' => trans('common/placeholders.options'), 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('number_of_question', trans('common/labels.quantity'), ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::select('number_of_question', getOptions('options.quantity'), null, ['placeholder' => trans('common/placeholders.options'), 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">{{ trans('common/buttons.create') }}</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
