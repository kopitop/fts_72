<div class="radio">
    @foreach ($question['answers'] as $answer)
        <label>
            {!! Form::radio('exam[' . $key . '][answer]', $answer->id) !!}
            {{ $answer->content }}
      </label>
    @endforeach
</div>