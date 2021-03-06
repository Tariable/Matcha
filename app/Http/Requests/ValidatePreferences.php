<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidatePreferences extends FormRequest
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
            'lowerAge' => 'required|numeric|min:18|max:97',
            'upperAge' => 'required|numeric|min:21|max:100',
            'distance' => 'required|numeric|min:5|max:100',
            'sex' => ['required',
                Rule::in(['female', 'male', '%ale']),]
        ];
    }

    public function messages()
    {
        return [
            'lowerAge' => 'Lower age must be between 18 and 97',
            'upperAge' => 'Upper age must be between 21 and 100',
            'distance' => 'Distance must be less than 100 km and more than 5 km',
            'sex.required' => 'Sex preferences field is required',
            'sex.in' => 'Sex preferences can be only male, female or bisexual',
        ];
    }
}
