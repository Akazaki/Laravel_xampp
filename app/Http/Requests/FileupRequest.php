<?php

namespace Laravel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileupRequest extends FormRequest
{
     /**
     * 戻り先のコントローラーのアクション名
        
    $redirect – URIでの指定
    $redirectRoute – 名前付きルートの名前での指定
    $redirectAction – コントローラーのアクションでの指定

     *
     * @var string
     */

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
        $rules = [
            'image' => 'image|max:3',
        ];

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'image' => 'The :attribute and :other must match.'
        ];

        return $messages;
    }
}
