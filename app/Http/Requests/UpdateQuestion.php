<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestion extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'subject' => 'exists:subjects,id',
            'type' => 'in:' . implode(',', config('options.question-type')),
            'answer.*.content' => 'required|max:255',
        ];
    }

    public function messages()
    {
        $messages = [];
        foreach($this->request->get('answer') as $key => $value) {
            $messages['answer.' . $key . '.content.max'] = 'The answer ' . $key . ' must be less than :max characters.';
            $messages['answer.' . $key . '.content.required'] = 'The answer ' . $key . ' must be required.';
        }

        return $messages;
    }
}
