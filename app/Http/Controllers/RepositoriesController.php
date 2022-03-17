<?php

namespace App\Http\Controllers;

use App\Handlers\AudioUploadHandler;
use App\Handlers\ImageUploadHandler;
use App\Http\Requests\RepositoryDescriptionRequest;
use App\Http\Requests\RepositoryRequest;
use App\Models\Commit;
use App\Models\Repository;
use App\Models\User;
use Illuminate\Http\Request;

class RepositoriesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show', 'showAudio', 'showComments']]);
    }


    public function index(Request $request, User $user)
    {
        $repositories = Repository::withOrder($request->order)
            ->with('user')  // 预加载防止 N+1 问题
            ->paginate(20);
        $active_users = $user->getActiveUsers();

        return view('repositories.index', compact('repositories', 'active_users'));
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

        // return redirect($repository->link())->with('success', '仓库创建成功！');
        return redirect(route('repositories.init', $repository->fresh()->id));
    }

    public function show(Repository $repository, Request $request)
    {
        // URL 矫正
        if (!empty($repository->slug) && $repository->slug != $request->slug) {
            return redirect($repository->link(), 301);
        }

        $repository->loadCount('stars');

        //$isStared = $repository->isStaredBy(auth()->id());

        return view('repositories.show', compact('repository'));
    }

    public function showAudio(Repository $repository, Request $request)
    {
        //todo commit->link()
        // // URL 矫正
        // if (!empty($repository->slug) && $repository->slug != $request->slug) {
        //     return redirect($repository->link(), 301);

        // }
        $repository->load(['commits' => function($query){
            $query->latest();
        }, 'stars']);

        $commit_id = $request->commit;

        if ($commit_id) {
            $commit = Commit::findOrFail($commit_id);
        } else if ($repository->commits->isNotEmpty()) {
            $commit = $repository->commits->first();
        }else{
            $commit = null;
        }
        //$isStared = $repository->isStaredBy(auth()->id());

        // dd($repository);
        return view('repositories.showAudio ', compact('repository', 'commit'));
    }

    public function editAudio(Repository $repository, Request $request)
    {
        //todo commit->link()
        // // URL 矫正
        // if (!empty($repository->slug) && $repository->slug != $request->slug) {
        //     return redirect($repository->link(), 301);
        // }
        $this->authorize('update', $repository);

        $repository->load(['commits' => function($query){
            $query->with('user')->latest();
        }, 'stars']);

        $commit_id = $request->commit;

        if ($commit_id) {
            $commit = Commit::findOrFail($commit_id);
            $commit->load('user');
        } else if ($repository->commits->isNotEmpty()) {
            $commit = $repository->commits->first();
        }else{
            $commit = null;
        }
        //$isStared = $repository->isStaredBy(auth()->id());



        return view('repositories.editAudio ', compact('repository', 'commit'));
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

    public function uploadAudio(Request $request, AudioUploadHandler $uploader)
    {
        // 初始化返回数据，默认是失败的
        $data = [
            'success'   => false,
            'msg'       => '上传失败!',
            'file_path' => '',
            'file_name' => '',
        ];
        // 判断是否有上传文件，并赋值给 $file
        if ($file = $request->upload_file) {
            // 保存图片到本地
            $result = $uploader->save($file, auth()->id());
            // $result = $uploader->save($file, 'repositories', auth()->id(), 1024);
            // 图片保存成功的话
            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg']       = "上传成功!";
                $data['success']   = true;
            }
        }
        return $data;
    }

    public function editDescription(Repository $repository, Request $request)
    {
        $this->authorize('update', $repository);
        // URL 矫正
        // dump($repository->slug);
        if (!empty($repository->slug) && $repository->slug != $request->slug) {
            return redirect($repository->link('repositories.edit_description'), 301);
        }

        //$isStared = $repository->isStaredBy(auth()->id());


        return view('repositories.edit_description', compact('repository', 'isStared'));
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

        $repository->loadCount('stars');

        // URL 矫正
        if (!empty($repository->slug) && $repository->slug != $request->slug) {
            return redirect($repository->link('repository_setting.show'), 301);
        }


        return view('repositories.setting', compact('repository'));
    }

    public function showComments(Repository $repository)
    {
        $comments = $repository->comments()->with('user', 'repository')->latest()->paginate(7);

        $repository->loadCount('stars');

        return view('repositories.comments', compact('repository', 'comments'));
    }

    // protected function loadCommon(Repository $repository){
    //     $repository->load('user')
    //     return $repository;
    // }
    public function init(Repository $repository)
    {
        //必须是作者
        $this->authorize('update', $repository);

        //如果已经有commit了，就返回其页面
        if ($repository->commits->count() > 0) {
            return redirect($repository->link());
        }

        return view('repositories.init', compact('repository'));
    }
}
