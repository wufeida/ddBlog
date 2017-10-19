<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
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
            'tag'              => 'required|unique:tags',
            'title'            => 'required',
            'meta_description' => 'required'
        ];
    }

    public function messages(){
        return [
            'tag.required'              => '标签必填',
            'tag.unique'                => '标签重复',
            'title.required'            => '标题必填',
            'meta_description.required' => '主要描述必填',
        ];
    }
}
