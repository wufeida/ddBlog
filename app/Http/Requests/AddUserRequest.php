<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddUserRequest extends FormRequest
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
            'name' => 'required|between:3,30|unique:users',
            'password' => 'required|between:6,30|confirmed',
        ];
    }

    public function messages(){
        return [
            'name.required' => '用户名必填',
            'name.unique'  => '用户名重复',
            'name.between' => '用户名是3-30个字符',
            'password.required'  => '密码必填',
            'password.between'  => '密码是6-30个字符',
            'password.confirmed' => '两次密码不一致',
        ];
    }
}
