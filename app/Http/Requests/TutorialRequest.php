<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TutorialRequest extends FormRequest
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

    public function rules()
    {
        switch ($this->method()) {
                // CREATE
            case 'POST':
                return [
                    'title'       => 'required|min:3',
                    'order' => 'required|integer',
                    'content'        => 'required|min:3',
                    // 'category_id' => 'required|numeric',
                ];
                // UPDATE
            case 'PUT':
            case 'PATCH': {
                    return [
                        'title'       => 'required|min:3',
                        'order' => 'required|number',
                        'content'        => 'required|min:3',
                    ];
                }
            case 'GET':
            case 'DELETE':
            default: {
                    return [];
                };
        }
    }

    // public function messages()
    // {
    //     return [
    //         // 'name.min' => '仓库名称必须至少两个字符',
    //         // 'descrption.min' => '仓库描述必须至少三个字符',
    //     ];
    // }
}
