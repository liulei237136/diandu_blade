<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRepositoryDownloadRequest extends FormRequest
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
                    'name'       => 'required|min:3',
                    'description'        => 'string|max:2048',
                    'commit_id' => 'required|number|exists:commits,id',
                    'file_path' => 'required|string|url|max:100',
                ];
                // UPDATE
            case 'PUT':
            case 'PATCH': {
                    return [
                        'name'       => 'required|min:3',
                        'description'        => 'string|max:2048',
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
            'name.min' => '下载名称必须至少3个字符',
            'descrption.max' => '下载描述不能超过2048个字符',
        ];
    }
}
