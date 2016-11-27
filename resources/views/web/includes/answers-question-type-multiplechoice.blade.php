<div class="checkbox">
    @foreach ($question['answers'] as $answer)
        <label>
            {!! Form::checkbox('exam[' . $key . '][answer][]', $answer->id) !!}
            {{ $answer->content }}
      </label>
    @endforeach
</div>