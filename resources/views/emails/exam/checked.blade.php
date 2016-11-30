{!! trans('messages.exam-checked', [
    'user' => $exam->user->name,
    'score' => $exam->score,
    'quantity' => $exam->subject->number_of_question,
]) !!}
