@if (isset($question['answers']))
<div class="radio">
    @foreach ($question['answers'] as $answer)
        <label>
            {!! Form::radio('exam[' . $key . '][answer][0]',
                $answer->id,
                (count($question['result']->examAnswers)) ? $answer->id == $question['result']->examAnswers->first()->system_answer_id : ''
            ) !!}
            {{ $answer->content }}
      </label>
    @endforeach
</div>
@endif