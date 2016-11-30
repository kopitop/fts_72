@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{ trans('admin/exams.subject') . ': ' . $data['exam']->subject->name }}</h3>
                    <p>{{ trans('admin/exams.time') . ': ' . $data['exam']->created_at }}</p>
                    <p>{{ trans('admin/exams.score') }}: {{ $data['exam']->score ? $data['exam']->score : '' }} | {{ $data['exam']->subject->number_of_question }}</p>
                </div>
                @include('layouts.includes.messages')

                <div class="panel-body">

                    {!! Form::open([
                        'action' => ['Admin\ExamsController@check', $data['exam']->id],
                        'id' => 'exam'
                    ]) !!}

                        @foreach ($data['questions'] as $key => $question)

                        <div class="answer-container">
                            <div class="form-group">
                                <p class="form-control-static">
                                    {{ ++$key . '. ' .$question['content']->content }} 
                                    <span class="btn btn-default">
                                        {!!
                                            is_null($question['result']->is_correct) ?
                                            'unchecked' : trans('answer.correct.'.$question['result']->is_correct) 
                                        !!}
                                    </span>
                                </p>
                                {!! Form::hidden('exam[' . $key . '][question]', $question['content']->id) !!}
                                @include(
                                    'web/includes.answers-question-type-' . config(
                                        'exam.question-type.' . $question['content']->type
                                    )
                                )
                                {!! Form::hidden('exam[' . $key . '][result][id]', $question['result']->id) !!}
                                @if ($question['content']->type == config('question.type.text'))
                                    <p class="form-control-static">
                                        <strong>
                                            {{ $question['content']->systemAnswers()->first()->content }}
                                        </strong>
                                    </p>
                                    <div class="checkbox">
                                        <label>
                                            {!! 
                                                Form::hidden(
                                                    'exam[' . $key . '][result][correct]', config('answer.correct.false')
                                                )
                                            !!}
                                            {!!
                                                Form::checkbox(
                                                    'exam[' . $key . '][result][correct]',
                                                    config('answer.correct.true'),
                                                    $question['result']->is_correct,
                                                    ['class' => 'check-text']
                                                )
                                            !!}
                                            {{ trans('common/labels.correct') }}
                                        </label>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        @endforeach

                            <div class="form-group">
                                {!! Form::submit(trans('common/buttons.check'), [
                                    'class' => 'btn btn-primary',
                                    'name' => 'commit',
                                    'id' => 'check'
                                ]) !!}
                            </div>

                    {!! Form::close() !!}

                    <div id="clock"></div>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var isTesting = "{{ $data['exam']->status == config('exam.status.testing') }}";
    var isChecked = "{{ $data['exam']->status == config('exam.status.checked') }}";
</script>
@endsection
