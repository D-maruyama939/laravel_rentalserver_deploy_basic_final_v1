<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostSearchRequest extends FormRequest
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
            'prefecture_id' => ['exists:prefectures,id'],
            'tag_ids' => ['exists:tags,id'],
        ];
    }
    
    public function messages()
    {
        return [
            'prefecture_id.required' => '都道府県が未選択です。',
            'prefecture_id.exists' => '都道府県の値が不正です。',
        ];
    }
}
