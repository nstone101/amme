<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PortfolioRequest extends FormRequest
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
        $url = '/((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/';
        $rule=[
            'title'=>'required|max:255',
            'category_id'=>'required|exists:portfolio_categories,id',
            'description'=>'required',
            'status'=>'required|integer',
            'date'=>'required|date|date_format:Y-m-d'
        ];
        if ($this->demo) {
            $rule['demo'] = ['max:200','regex:'.$url];
        }
        if ($this->image) {
            $rule['image.*'] = 'image|mimes:jpeg,jpg,JPG,png,PNG,gif|max:3000';
        }
        return $rule;
    }
}
