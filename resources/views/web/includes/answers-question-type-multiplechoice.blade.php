<div class="checkbox">
    @foreach ($question['answers'] as $answer)
        <label>
            {!! Form::checkbox(
                'exam[' . $key . '][answer][]',
                $answer->id,
                (!is_null($question['result']->examAnswers) && in_array($answer->id, $question['result']->examAnswers->pluck('system_answer_id')->toArray())) ? 'checked' : ''
            ) !!}
            {{ $answer->content }}
      </label>
    @endforeach
</div>
