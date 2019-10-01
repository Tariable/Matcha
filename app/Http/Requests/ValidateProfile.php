<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateProfile extends FormRequest
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
            'name' => 'required|alpha|min:2|max:20',
            'date_of_birth' => 'required|date_format:"Y-m-d"|after:-100 years|before:-18 years',
            'description' => 'max:150|required',
            'gender' => 'required|in:male,female',
            'latitude' => 'numeric|max:180|min:-180',
            'longitude' => 'numeric|max:90|min:-90',
        ];
    }

    public function messages()
    {
        return [
            'date_of_birth.after' => 'Your age must be less than 100 years old',
            'date_of_birth.before' => 'Your age must be more than 18',
        ];
    }
}
