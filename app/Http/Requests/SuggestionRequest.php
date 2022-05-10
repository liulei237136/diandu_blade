<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuggestionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        switch ($this->method()) {
                // CREATE
            case 'POST':
                return [
                    'title'       => 'required|min:3|max:60',
                    'content'        => 'required|min:14|max:30720', //30*1024 //<p>xxx<br></p>
                ];
                // UPDATE
            case 'PUT':
            case 'PATCH':
                return [
                    'title'       => 'required|min:3|max:60',
                    'content'        => 'required|min:14|max:30720',
                ];

            case 'GET':
            case 'DELETE':
            default: {
                    return [];
                };
        }
    }

    public function messages()
    {
        return [
            'title.min' => '建议名称最少3个字',
            'title.max' => '建议名称最多60个字',
            'content.min' => '建议描述最少3个字',
            'content.max' => '建议描述最多30720个字',
        ];
    }
}
