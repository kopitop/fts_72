@extends('admin.master')

@section('sub-view')
    <div class="panel panel-default">
        <div class="panel-heading">{{ $title }}</div>

        <div class="panel-body">
            @if (count($subjects))
            <table class="table table-bordered">
                <tr>
                    <td>{{ trans('common/labels.id') }}</td>
                    <td>{{ trans('common/labels.name') }}</td>
                    <td>{{ trans('admin/subject.duration') }}</td>
                    <td>{{ trans('admin/subject.quantity') }}</td>
                    <td>{{ trans('common/labels.action') }}</td>
                </tr>
                @foreach ($subjects as $subject)
                <tr>
                    <td>{{ $subject->id }}</td>
                    <td>{{ $subject->name }}</td>
                    <td>{{ gmdate(config('subject.time-format'), $subject->duration) }}</td>
                    <td>{{ $subject->number_of_question }}</td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a class="btn btn-default">{{ trans('common/buttons.edit') }}</a>
                            <a class="btn btn-danger">{{ trans('common/buttons.delete') }}</a>
                          </div>
                    </td>
                </tr>
                @endforeach
            </table>
            {!! $subjects->links() !!}
            @else
            <div class="alert alert-warning" role="alert">
                {{ trans('common/messages.empty-list') }}
            </div>    
            @endif
        </div>
    </div>
@endsection
