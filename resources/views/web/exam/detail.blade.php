@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{ trans('front-end/exam.subject') . ': ' . $data['exam']->subject->name }}</h3>
                    <p>{{ trans('front-end/exam.created-date') . ': ' . $data['exam']->created_at }}</p>
                    @if (isset($data['exam']->score))
                        <p>{{ trans('front-end/exam.score') . ': ' . $data['exam']->score }} </p>
                    @endif
                </div>
                @include('layouts.includes.messages')

                <div class="panel-body">

                    {!! Form::open([
                        'action' => ['Web\ExamsController@update', $data['exam']->id],
                        'method' => 'PUT',
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
                                            trans('answer.doing') : trans('answer.correct.' . $question['result']->is_correct)
                                        !!}
                                    </span>
                                </p>
                                {!! Form::hidden('exam[' . $key . '][question]', $question['content']->id) !!}
                                @include(
                                    'web/includes.answers-question-type-' . config('exam.question-type.' . $question['content']->type)
                                )
                                {!! Form::hidden('exam[' . $key . '][result]', $question['result']->id) !!}
                            </div>
                        </div>
                        
                        @endforeach

                        {!! Form::hidden('time_spent', $data['exam']['time_spent'], [
                            'id' => 'time_spent'
                        ]) !!}

                        @if ($data['exam']->status == config('exam.status.testing'))

                            <div class="form-group">
                                {!! Form::submit(trans('common/buttons.save'), [
                                    'class' => 'btn btn-default',
                                    'name' => 'commit'
                                ]) !!}
                                {!! Form::submit(trans('common/buttons.finish'), [
                                    'class' => 'btn btn-primary',
                                    'name' => 'commit'
                                ]) !!}
                            </div>

                        @endif

                    {!! Form::close() !!}

                    <div style="display: none" id="clock"></div>
                    @include('web.includes.clock')

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var remainingTime = "{{ ($data['exam']->subject->duration - $data['exam']['time_spent']) }}";
    var duration = "{{ $data['exam']->subject->duration }}";
    var link = "{{ action('Web\ExamsController@update', ['id' => $data['exam']->id]) }}";
    var alert = "{{ trans('messages.load-page') }}";
    var isTesting = "{{ $data['exam']->status == config('exam.status.testing') }}";
    var isChecked = "{{ $data['exam']->status == config('exam.status.checked') }}";

    //make color
    var makeColor = function () {
        this.h = Math.floor(remainingTime / 3600);
        this.i = Math.floor((remainingTime % 3600) / 60);
        this.s = remainingTime % 60;

        document.getElementsByClassName("hours")[0].setAttribute("data-init-value", this.h);
        document.getElementsByClassName("min")[0].setAttribute("data-init-value", this.i);
        document.getElementsByClassName("sec")[0].setAttribute("data-init-value", this.s);
    };

    makeColor();
</script>
@endsection
