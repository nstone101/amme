<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'role' => 'required',
            'country' => 'required|max:255',
        ];
        if ($this->phone) {
            $rule['phone'] = 'numeric|phone_number';
        }
        return $rule;
    }

    public function messages()
    {
        return [
            'name.required' => __('The name field is required'),
            'role.required' => __('The role field is required'),
            'country.required' => __('The country field is required'),
            'phone.phone_number' => __('Invalid phone number'),
        ];
    }
}
