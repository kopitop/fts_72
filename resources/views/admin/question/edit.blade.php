@extends('admin.master')

@section('sub-view')
    <div class="panel panel-default">
        <div class="panel-heading">{{ $title }}</div>

        <div class="panel-body">
            {!! Form::open([
                'action' => ['Admin\QuestionsController@update', $question->id],
                'method' => 'PUT',
                'class' => 'form-horizontal'
            ]) !!}
                <div class="form-group">
                    {!! Form::label('subject', trans('common/labels.subject'), ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::select('subject', $subjectsList, $question->subject->id, [
                            'placeholder' => trans('common/placeholders.options'),
                            'class' => 'form-control',
                        ]) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('content', trans('common/labels.content'), ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::textarea('content', old('content') ? old('content') : $question->content, [
                            'class' => 'form-control',
                            'placeholder' => trans('common/placeholders.content')
                        ]) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('type', trans('common/labels.type'), ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::select('type', getOptions('options.question-type'), $question->type, [
                            'placeholder' => trans('common/placeholders.options'),
                            'class' => 'form-control',
                            'id' =>  'question-type'
                        ]) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-10 col-sm-offset-2">
                        <div class="checkbox">
                            <label>
                                {!! Form::hidden('active', 0) !!}
                                {!! Form::checkbox('active', 1, $question->status ? 'checked' : old('active') ? 'checked' : '') !!}
                                {{ trans('common/placeholders.active') }}
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Answers section -->
                <div id="answer-section">

                @if (old('answer'))
                    @foreach (old('answer') as $key => $answer)

                        <div class="form-group">
                            {!! Form::label('answer', trans('common/labels.answer'), ['class' => 'col-sm-2 control-label']) !!}
                            <div class="col-sm-6">
                                {!! Form::text('answer[' . $key . '][content]', $answer['content'], [
                                    'class' => 'form-control',
                                    'placeholder' => trans('common/placeholders.content')
                                ]) !!}
                            </div>

                            <div class="checkbox-remove">
                                <div class="col-sm-2">
                                    <div class="checkbox">
                                        <label>
                                            <input type="hidden" value="0" name="answer[{{ $key }}][is_correct]">
                                            {!! Form::checkbox('answer[' . $key . '][is_correct]', 1, $answer['is_correct'] ?  'checked' : '', ['class' => 'is_correct']) !!}
                                            {{ trans('common/placeholders.is-correct') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <button class="remove-answer btn btn-default" onclick="javascript:;">{{ trans('common/buttons.remove-answer') }}</button>
                                </div>
                            </div>
                            
                        </div>
                    @endforeach
                @else
                    @foreach ($question->systemAnswers as $key => $answer)
                    <div class="form-group">
                        {!! Form::label('answer', trans('common/labels.answer'), ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-6">
                            {!! Form::text('answer[' . $key . '][content]', $answer->content, [
                                'class' => 'form-control',
                                'placeholder' => trans('common/placeholders.content')
                            ]) !!}
                        </div>

                        <div class="checkbox-remove">
                            <div class="col-sm-2">
                                <div class="checkbox">
                                    <label>
                                        {!! Form::hidden('answer[' . $key . '][is_correct]', 0) !!}
                                        {!! Form::checkbox('answer[' . $key . '][is_correct]', 1, $answer->is_correct ?  'checked' : '', ['class' => 'is_correct']) !!}
                                        {{ trans('common/placeholders.is-correct') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <button class="remove-answer btn btn-default" onclick="javascript:;">{{ trans('common/buttons.remove-answer') }}</button>
                            </div>
                        </div>
                        
                    </div>
                    @endforeach
                @endif
                </div>
                <!-- End of answers section -->

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button id="add-answer" class="btn btn-default">{{ trans('common/buttons.add-answer') }}</button>
                        {!! Form::submit(trans('common/buttons.edit'), [
                            'class' => 'btn btn-primary'
                        ]) !!}
                    </div>
                </div>
            {!! Form::close() !!}

        </div>
    </div>

    <script>
        @foreach (config('options.question-type') as $key => $value)
            var {{ $key }} = {{ $value }}
        @endforeach

        var remove = "{{ trans('common/buttons.remove-answer') }}";
        var answer = "{{ trans('common/labels.answer') }}";
        var content = "{{ trans('common/placeholders.content') }}";
        var is_correct = "{{ trans('common/placeholders.is-correct') }}";
    </script>
@endsection
