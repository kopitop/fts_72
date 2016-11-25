@extends('admin.master')

@section('sub-view')
    <div class="panel panel-default">
        <div class="panel-heading">{{ $title }}</div>

        <div class="panel-body">

            <form class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-2 control-label">{{ trans('common/labels.subject') }}</label>
                    <div class="col-sm-10">
                        <p class="form-control-static">{{ $question->subject->name }}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">{{ trans('common/labels.content') }}</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" readonly>{{ $question->content }}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">{{ trans('common/labels.type') }}</label>
                    <div class="col-sm-10">
                        <p class="form-control-static">{{ trans('options.question-type.' . $question->type) }}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="subject_created" class="col-sm-2 control-label">{{ trans('common/labels.created-at') }}</label>
                    <div class="col-sm-10">
                        <p class="form-control-static">{{ $question->created_at }}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="subject_updated" class="col-sm-2 control-label">{{ trans('common/labels.updated-at') }}</label>
                    <div class="col-sm-10">
                        <p class="form-control-static">{{ $question->updated_at }}</p>
                    </div>
                </div>
                
                <!-- answers -->
                @foreach ($question->systemAnswers as $answer)
                    <div class="form-group">
                        <label class="col-sm-2 control-label">{{ trans('common/labels.answer') }}</label>
                        <div class="col-sm-6">
                            <p class="form-control-static">{{ $answer->content }}</p>
                        </div>

                        <div class="checkbox-remove">
                            <div class="col-sm-2">
                                <div class="checkbox disabled">
                                    <label>
                                        <input type="checkbox" disabled {{ ($answer->is_correct) ? 'checked' : '' }}>
                                        {{ trans('common/placeholders.is-correct') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- end of answers -->

            </form>

        </div>
    </div>
@endsection
