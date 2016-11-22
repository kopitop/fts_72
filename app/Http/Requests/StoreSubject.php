<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubject extends FormRequest
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
        $optionDuration = '';
        $optionQuantity = '';

        foreach (config('options.duration') as $option) {
            $optionDuration .= $option . ',';
        }

        foreach (config('options.quantity') as $option) {
            $optionQuantity .= $option . ',';
        }

        return [
            'name' => 'required|max:255',
            'duration' => 'required|in:'. $optionDuration,
            'number_of_question' => 'required|in:'. $optionQuantity,
        ];
    }
}
