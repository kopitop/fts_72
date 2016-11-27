@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>{{ trans('front-end/exams.') }}</h3></div>
                @include('layouts.includes.messages')

                <div class="panel-body">
                    <div class="subject-list">

                        {!! Form::open(['action' => ['Web\ExamsController@store'],
                            'class' => 'form-inline'
                        ]) !!}
                            <div class="form-group">
                                {!! Form::select('subject', $subjectList, null, [
                                    'placeholder' => trans('common/placeholders.options'),
                                    'class' => 'form-control'
                                ]) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::submit(trans('common/buttons.create'), [
                                    'class' => 'btn btn-default',
                                ]) !!}
                            </div>
                        {!! Form::close() !!}

                    </div>

                    <div class="exam-list">
                    @if (count($examsOfUser))
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>{{ trans('front-end/exam.created-date') }}</td>
                                    <td>{{ trans('front-end/exam.subject') }}</td>
                                    <td>{{ trans('front-end/exam.status') }}</td>
                                    <td>{{ trans('front-end/exam.duration') }}</td>
                                    <td>{{ trans('front-end/exam.quantity') }}</td>
                                    <td>{{ trans('front-end/exam.time-spent') }}</td>
                                    <td>{{ trans('front-end/exam.score') }}</td>
                                    <td>{{ trans('front-end/exam.action') }}</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($examsOfUser as $exam)
                                    <tr>
                                        <td>{{ $exam->created_at }}</td>
                                        <td>{{ $exam->subject->name }}</td>
                                        <td>{{ trans('front-end/exam.states.' . $exam->status) }}</td>
                                        <td>{{ trans('options.duration.' . $exam->subject->duration) }}</td>
                                        <td>{{ $exam->subject->number_of_question }}</td>
                                        <td>{{ gmdate("H:i:s", $exam->time_spent) }}</td>
                                        <td>{{ $exam->score }}</td>
                                        <td>
                                            {!! link_to_action('Web\ExamsController@show', trans('common/buttons.do'), [ 
                                                'id' => $exam->id 
                                            ], [
                                                'class' => 'btn btn-default'
                                            ]) !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-warning" role="alert">
                            {{ trans('common/messages.empty-list') }}
                        </div>   
                    @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
