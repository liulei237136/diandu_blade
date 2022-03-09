<?php

namespace App\Http\Controllers;

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
        return view('repositories.create_and_edit', compact('repository'));
    }

    public function store(RepositoryRequest $request, Repository $repository)
    {
        $repository->fill($request->all());
        $repository->user_id = auth()->id();
        $repository->save();

        return redirect()->route('repositories.show', $repository->id)->with('success', '仓库创建成功！');
    }

    public function show(Repository $repository)
    {
        return view('repositories.show', compact('repository'));
    }


    public function edit(Repository $repository)
    {
        //
    }

    public function update(RepositoryRequest $request, Repository $repository)
    {
        //
    }

    public function destroy(Repository $repository)
    {
        //
    }
}
