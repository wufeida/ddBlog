<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LinkRequest extends FormRequest
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
            'name' => 'required|min:2',
            'link' => 'required|min:2'
        ];
    }

    public function messages(){
        return [
            'name.required' => '链接名必填',
            'name.min'      => '链接名最少两个字符',
            'link.required' => '链接必填',
            'link.min'      => '链接最少两个字符',
        ];
    }
}
