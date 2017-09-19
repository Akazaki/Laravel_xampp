<?php

namespace Laravel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'name'  => 'required|max:50',
            'email' => 'required|email',
            'message' => 'present|max:1000'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ':attributeは必須です',
            'email.required'  => ':attributeは必須です',
            'email.email'  => ':attributeを正しく入力してください',
            'message.max'  => ':attributeは:max文字以内で入力してください',
        ];
    }
}
