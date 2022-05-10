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
                    'description'        => 'max:30720',
                    'commit_id' => 'required|integer|exists:commits,id',
                    'file_path' => 'required|string|max:255',
                    'file_name' => 'required|string|max:255',
                ];
                // UPDATE
            case 'PUT':
            case 'PATCH': {
                    return [
                        'name'       => 'min:3',
                        'description'        => 'max:30720',
                        'file_path' => 'string|max:255',
                        'file_name' => 'string|max:255',
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
            'descrption.max' => '下载描述不能超过30720个字符',
        ];
    }
}
