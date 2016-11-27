@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>{{ trans('front-end/exams.subject') . ': ' . $data['exam']->subject->name }}</h3>
                    <p>{{ trans('front-end/exams.time') . ': ' . $data['exam']->created_at }}</p>
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
                                <p class="form-control-static">{{ ++$key . '. ' .$question['content']->content }}</p>
                                {!! Form::hidden('exam[' . $key . '][question]', $question['content']->id) !!}
                                @include('web/includes.answers-question-type-'.config('exam.question-type.' . $question['content']->type))
                                {!! Form::hidden('exam[' . $key . '][result]', $question['result']->id) !!}
                            </div>
                        </div>
                        
                        @endforeach

                        {!! Form::hidden('exam[time_spent]', $data['exam']['time_spent'], [
                            'id' => 'time_spent'
                        ]) !!}

                        <div class="form-group">
                            {!! Form::submit(trans('common/buttons.save'), [
                                'class' => 'btn btn-default',
                                'name' => 'commit'
                            ]) !!}
                            {!! Form::submit(trans('common/buttons.finish'), [
                                'class' => 'btn btn-primary confirm',
                                'name' => 'commit'
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
    var remainingTime = "{{ ($data['exam']->subject->duration - $data['exam']['time_spent']) }}"
    var duration = "{{ $data['exam']->subject->duration }}"
</script>
@endsection
