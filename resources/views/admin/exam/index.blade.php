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
                        @php $isChecked = $exam->status == config('exam.status.checked') @endphp
                        @php $isUnchecked = $exam->status == config('exam.status.unchecked') @endphp
                        <tr>
                            <td>{{ $exam->subject->name }}</td>
                            <td>{{ trans('front-end/exam.states.' . $exam->status) }}</td>
                            <td>{{ trans('options.duration.' . $exam->subject->duration) }}</td>
                            <td>{{ $exam->subject->number_of_question }}</td>
                            <td>{{ gmdate("H:i:s", $exam->time_spent) }}</td>
                            <td>{{ $exam->score }}</td>
                            <td>
                                {!! link_to_action('Admin\ExamsController@show', $isChecked ? trans('common/buttons.view') : ($isUnchecked ? trans('common/buttons.check') : trans('common/buttons.inprogress')), [ 
                                    'id' => $exam->id 
                                ], [
                                    'class' => $isChecked ? 'btn btn-info btn-xs' : ($isUnchecked ? 'btn btn-warning btn-xs' : 'btn btn-success btn-xs')
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
