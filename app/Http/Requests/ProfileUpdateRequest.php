<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
        $rule = [
            'name' => 'required|max:255',
            'country' => 'required|max:255',
        ];
        if ($this->phone) {
            $rule['phone'] = 'numeric|phone_number';
        }
        if ($this->photo) {
            $rule['photo'] = 'mimes:jpeg,jpg,JPG,png,PNG,gif|max:3000';
        }
        return $rule;
    }

    public function messages()
    {
        return [
            'name.required' => __('The name field can not empty'),
            'phone.phone_number' => __('Invalid phone number'),
        ];
    }
}
