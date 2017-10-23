<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'title'         => 'required|min:3',
            'subtitle'      => 'required|min:3',
            'content'       => 'required',
            'category_id'   => 'required',
            'published_at'  => 'required',
            'tag'           => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required'        => '标题必填',
            'title.min'             => '标题最少三个字符',
            'subtitle.required'     => '副标题必填',
            'subtitle.min'          => '副标题最少三个字符',
            'content.required'      => '内容必填',
            'category_id.required'  => '分类必填',
            'published_at.required' => '发布时间必填',
            'tag.required'          => '标签必选',
        ];
    }
}
