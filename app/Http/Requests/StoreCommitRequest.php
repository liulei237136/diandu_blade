<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommitRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:256'],
            'description' => ['nullable', 'string'],
            //1048576 1m
            'content' => ['required', 'string', 'min:2', 'max:1048576'],
        ];
    }

    public function messages()
    {
        return [
            'title.min' => '保存名最短3个字符',
            'title.max' => '保存名最长256个字符',
        ];
    }
}
