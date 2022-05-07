<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RepositoryRequest extends FormRequest
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
                    'name'       => 'required|min:3|max:60',
                    'description'        => 'required|min:14|max:30720', //30*1024 //<p>xxx<br></p>
                    // 'category_id' => 'required|numeric',
                ];
                // UPDATE
            case 'PUT':
            case 'PATCH': {
                    return [
                        'name'       => 'min:3|max:60',
                        'description'        => 'min:14|max:30720',
                        // 'category_id' => 'required|numeric',
                    ];
                }
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
            'name.min' => '仓库名称最少3个字',
            'name.max' => '仓库名称最多60个字',
            'description.min' => '仓库描述最少3个字',
            'description.max' => '仓库描述最多30720个字',
        ];
    }
}
