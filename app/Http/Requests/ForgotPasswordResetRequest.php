<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordResetRequest extends FormRequest
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
            'password' => 'required|min:8|strong_pass|confirmed|max:255',
            'password_confirmation' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'password.required' => __('Password field can not be empty'),
            'password.min' => __('Password length must be minimum 8 characters'),
            'password.strong_pass' => __('Password must be consist of one uppercase, one lowercase and one number'),
            'password_confirmation.required' => __('Confirm password field can not be empty!')
        ];
    }
}
