@extends('admin.master')

@section('sub-view')
    <div class="panel panel-default">
        <div class="panel-heading">{{ $title }}</div>

        <div class="panel-body">
            @if (count($exams))
            <table class="table table-bordered">
                <tr>
                    <td>{{ trans('front-end/exam.subject') }}</td>
                    <td>{{ trans('front-end/exam.status') }}</td>
                    <td>{{ trans('front-end/exam.duration') }}</td>
                    <td>{{ trans('front-end/exam.quantity') }}</td>
                    <td>{{ trans('front-end/exam.time-spent') }}</td>
                    <td>{{ trans('front-end/exam.score') }}</td>
                    <td>{{ trans('front-end/exam.action') }}</td>
                </tr>
                <tbody>
                    @foreach ($exams as $exam)
                        <tr>
                            <td>{{ $exam->subject->name }}</td>
                            <td>{{ trans('front-end/exam.states.' . $exam->status) }}</td>
                            <td>{{ trans('options.duration.' . $exam->subject->duration) }}</td>
                            <td>{{ $exam->subject->number_of_question }}</td>
                            <td>{{ gmdate("H:i:s", $exam->time_spent) }}</td>
                            <td>{{ $exam->score }}</td>
                            <td>
                                {!! link_to_action('Admin\ExamsController@show', trans('common/buttons.check'), [ 
                                    'id' => $exam->id 
                                ], [
                                    'class' => 'btn btn-info btn-xs'
                                ]) !!}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $exams->links() !!}
            @else
            <div class="alert alert-warning" role="alert">
                {{ trans('common/messages.empty-list') }}
            </div>    
            @endif
        </div>
    </div>
@endsection
