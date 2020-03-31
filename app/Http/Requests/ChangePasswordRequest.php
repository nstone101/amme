<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'old_password' => 'required',
            'password' => 'required|min:8|strong_pass|max:255',
            'password_confirmation' => 'required|same:password|max:255',
        ];
    }

    public function messages()
    {
        return [
            'password_confirmation.same' => 'The password confirmation does not match.',
            'password.required' => __('Password field is required.'),
            'old_password.required' => __('Old Password field is required.'),
            'password_confirmation.required' => __('Password confirmed field is required.'),
            'password.min' => __('Password length must be minimum 8 characters.'),
            'password.strong_pass' => __('Password must be consist of one uppercase, one lowercase and one number.'),
        ];
    }
}
