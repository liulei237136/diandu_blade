<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\TutorialRequest;
use App\Models\Tutorial;
use Illuminate\Http\Request;

class TutorialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]);
    }
    public function index()
    {
        $tutorials = Tutorial::orderBy('order', 'asc')->paginate(5);

        return view('tutorials.index', compact('tutorials'));
    }

    public function show(Tutorial $tutorial)
    {
        return view('tutorials.show', compact('tutorial'));
    }

    public function create(Tutorial $tutorial){

        return view('tutorials.create', compact('tutorial'));
    }

    public function store(TutorialRequest $request, Tutorial $tutorial)
    {
        $this->authorize('update', new Tutorial());

        $tutorial->title = $request->title;
        $tutorial->order = $request->order;
        $tutorial->content = $request->content;
        $tutorial->save();

        return redirect()->route('tutorials.index')->with('success', 'create success');
    }

    public function edit(Tutorial $tutorial)
    {
        $this->authorize('update', $tutorial);

        return view('tutorials.edit', $tutorial);
    }

    public function update(TutorialRequest $request, Tutorial $tutorial)
    {
        $this->authorize('update', $tutorial);

        $tutorial->title = $request->title;
        $tutorial->order = $request->order;
        $tutorial->content = $request->content;
        $tutorial->save();

        return back()->with('success', '更新成功');
    }

    public function destroy(Tutorial $tutorial)
    {
        $this->authorize('update', $tutorial);

        $tutorial->delete();

        return redirect()->route('tutorials.index')->with('success', '成功删除建议');
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
            $result = $uploader->save($file, 'tutorials', auth()->id());
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
