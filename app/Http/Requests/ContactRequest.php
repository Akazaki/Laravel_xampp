<?php

namespace Laravel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
     /**
     * 戻り先のコントローラーのアクション名
        
    $redirect – URIでの指定
    $redirectRoute – 名前付きルートの名前での指定
    $redirectAction – コントローラーのアクションでの指定

     *
     * @var string
     */
    protected $redirectAction = 'ContactController@form';

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
            // 'name'  => 'required|max:50',
            // 'email' => 'required|email',
            // 'age' => 'required|array|in:1,2,3',
            // 'tel' => 'required|japantel',
            // 'zip' => 'required|zip',
            // 'prefecture' => 'required|numeric|between:1,47',
            // 'address' => 'required|max:100',
            // 'hobby.*' => 'in:1,2,3',
            // 'hobby' => 'required|array',
            // 'hobby.*' => 'in:1,2,3',
            // // 'upfile' => 'file|dimensions:min_width=10,min_height=10,max_width=4000,max_height=4000',
            // // 'img' => 'file|dimensions:min_width=10,min_height=10,max_width=4000,max_height=4000',
            // 'message' => 'present|max:1000',
        ];

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'name.required' => ':attributeを入力してください',
            'email.required'  => ':attributeを入力してください',
            'email.email'  => ':attributeを正しく入力してください',
            'tel.required'  => ':attributeを入力してください',
            'tel.japan_tel'  => ':attributeを正しく入力してください',
            'zip.required'  => ':attributeを入力してください',
            'zip.zip'  => ':attributeを正しく入力してください',
            'prefecture.required'  => ':attributeを選択してください',
            'prefecture.numeric'  => ':attributeを正しく入力してください',
            'prefecture.between'  => ':attributeを正しく入力してください',
            'address.required'  => ':attributeを入力してください',
            'address.max'  => ':attributeは:max文字以内で入力してください',
            'age.required'  => ':attributeを選択してください',
            'hobby.required'  => ':attributeを選択してください',
            'hobby.*.in' => '趣味を正しく選択してください',
            'message.max'  => ':attributeは:max文字以内で入力してください',
        ];

        return $messages;
    }
}
