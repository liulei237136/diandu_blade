<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\Suggestion;
use App\Http\Requests\StoreSuggestionRequest;
use App\Http\Requests\SuggestionRequest;
use App\Http\Requests\UpdateSuggestionRequest;
use Illuminate\Http\Request;

class SuggestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    public function index()
    {
        $suggestions = Suggestion::latest()->with('user')->paginate(5);

        return view('suggestions.index', compact('suggestions'));
    }

    public function show(Suggestion $suggestion)
    {
        return view('suggestions.show', compact('suggestion'));
    }

    public function create(Suggestion $suggestion)
    {

        return view('suggestions.create', compact('suggestion'));
    }

    public function store(SuggestionRequest $request, Suggestion $suggestion)
    {

        $suggestion->title = $request->title;
        $suggestion->content = $request->content;
        $suggestion->user_id = auth()->id();
        $suggestion->save();

        return redirect()->route('suggestions.index')->with('success', '成功新建建议');
    }
    public function edit(Suggestion $suggestion)
    {
        $this->authorize('update', $suggestion);

        return view('suggestions.edit', compact('suggestion'));
    }

    public function update(SuggestionRequest $request, Suggestion $suggestion)
    {
        $this->authorize('update', $suggestion);

        $suggestion->title = $request->title;
        $suggestion->content = $request->content;
        $suggestion->save();

        return back()->with('success', '更新成功');
    }
    public function destroy(Suggestion $suggestion)
    {
        $this->authorize('delete', $suggestion);

        $suggestion->delete();

        return redirect()->route('suggestions.index')->with('success', '成功删除建议');
    }

    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        // 初始化返回数据，默认是失败的
        $data = [
            'success'   => false,
            'msg'       => '上传失败!',
            'file_path' => ''
        ];
        // 判断是否有上传文件，并赋值给 $file
        if ($file = $request->upload_file) {
            // 保存图片到本地
            $result = $uploader->save($file, 'suggestions', auth()->id());
            // 图片保存成功的话
            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg']       = "上传成功!";
                $data['success']   = true;
            }
        }
        return $data;
    }
}
