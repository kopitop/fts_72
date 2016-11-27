<label>{{ trans('common/labels.answer') }}</label>
{!! Form::text('exam[' . $key . '][answer]',
    (count($question['result']->examAnswers)) ? $question['result']->examAnswers->first()->content : '',
    ['class' => 'form-control']) 
!!}