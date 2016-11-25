@extends('admin.master')

@section('sub-view')
    <div class="panel panel-default">
        <div class="panel-heading">{{ $title }}</div>

        <div class="panel-body">
            @if (count($questions))
            <table class="table table-bordered">
                <tr>
                    <td>{{ trans('common/labels.id') }}</td>
                    <td>{{ trans('admin/question.type') }}</td>
                    <td>{{ trans('admin/question.content') }}</td>
                    <td>{{ trans('admin/question.status') }}</td>
                    <td>{{ trans('admin/subject.subject') }}</td>
                    <td>{{ trans('admin/user.user') }}</td>
                    <td>{{ trans('common/labels.action') }}</td>
                </tr>
                @foreach ($questions as $question)
                <tr>
                    <td>
                        <a href="{{ action('Admin\QuestionsController@show', ['id' => $question->id]) }}">
                            {{ $question->id }}
                        </a>
                    </td>
                    <td>
                            {{ trans('admin/question.types.' . $question->type) }}
                    </td>
                    <td>{{ str_limit($question->content, 100) }}</td>
                    <td>{{ $question->status }}</td>
                    <td>{{ $question->subject->name }}</td>
                    <td>{{ str_limit($question->user->name) }}</td>
                    <td>
                        {!! Form::open([
                            'action' => ['Admin\QuestionsController@destroy', $question->id],
                            'method' =>  'DELETE'
                        ]) !!}
                            <div class="btn-group btn-group-sm">
                                {!! link_to_action('Admin\QuestionsController@edit', trans('common/buttons.edit'), [ 
                                    'id' => $question->id 
                                ], [
                                    'class' => 'btn btn-default'
                                ]) !!}

                                {!! Form::submit(trans('common/buttons.delete'), [
                                    'class' => 'btn btn-danger'
                                ])!!}  
                            </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            </table>
            {!! $questions->links() !!}
            @else
            <div class="alert alert-warning" role="alert">
                {{ trans('common/messages.empty-list') }}
            </div>    
            @endif
        </div>
    </div>
@endsection
