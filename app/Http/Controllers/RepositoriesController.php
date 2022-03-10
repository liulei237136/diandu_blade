<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\RepositoryDescriptionRequest;
use App\Http\Requests\RepositoryRequest;
use App\Models\Repository;
use App\Models\User;
use Illuminate\Http\Request;

class RepositoriesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }


    public function index(Request $request)
    {
        $repositories = Repository::withOrder($request->order)
            ->with('user')  // 预加载防止 N+1 问题
            ->paginate(20);

        return view('repositories.index', compact('repositories'));
    }

    public function create(Repository $repository)
    {
        return view('repositories.create', compact('repository'));
    }

    public function store(RepositoryRequest $request, Repository $repository)
    {
        $repository->fill($request->all());
        $repository->user_id = auth()->id();
        $repository->save();

        return redirect($repository->link())->with('success', '仓库创建成功！');
    }

    public function show(Repository $repository, Request $request)
    {
        // URL 矫正
        if (!empty($repository->slug) && $repository->slug != $request->slug) {
            return redirect($repository->link(), 301);
        }

        return view('repositories.show', compact('repository'));
    }


    public function edit(Repository $repository)
    {
        //
    }

    public function update(RepositoryRequest $request, Repository $repository)
    {
    }

    public function destroy(Repository $repository)
    {
        $this->authorize('delete', $repository);

        $repository->delete();

        return redirect()->route('repositories.index')->with('success', '成功删除！');
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
            $result = $uploader->save($file, 'repositories', auth()->id(), 1024);
            // 图片保存成功的话
            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg']       = "上传成功!";
                $data['success']   = true;
            }
        }
        return $data;
    }

    public function editDescription(Repository $repository, $request)
    {
        $this->authorize('update', $repository);
        // URL 矫正
        if (!empty($repository->slug) && $repository->slug != $request->slug) {
            return redirect($repository->link('repositories.edit_description'), 301);
        }

        return view('repositories.edit_description', compact('repository'));
    }

    public function updateDescription(RepositoryRequest $request, Repository $repository)
    {
        $this->authorize('update', $repository);

        $repository->update($request->all());

        return redirect()->to($repository->link())->with('success', '更新成功！');
    }

    public function updateName(RepositoryRequest $request, Repository $repository)
    {
        $this->authorize('update', $repository);

        $repository->update($request->all());

        return back()->with('success', '仓库名更新成功！');
    }


    public function showSetting(Repository $repository, Request $request)
    {
        $this->authorize('update', $repository);

        // URL 矫正
        if (!empty($repository->slug) && $repository->slug != $request->slug) {
            return redirect($repository->link('repository_setting.show'), 301);
        }


        return view('repositories.setting', compact('repository'));
    }
}
