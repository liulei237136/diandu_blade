<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use App\Http\Requests\StoreRepositoryRequest;
use App\Http\Requests\UpdateRepositoryRequest;
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
        // if(is_null($request->order)){
        //     return redirect()->to($request->getUri() . '&order=recent');
        //     // $request->order = 'recent';
        // }
        $repositories = Repository::withOrder($request->order)
            ->with('user')  // 预加载防止 N+1 问题
            ->paginate(20);

        return view('repositories.index', compact('repositories'));
    }

    public function create()
    {
        //
    }

    public function store(StoreRepositoryRequest $request)
    {
        //
    }

    public function show(Repository $repository)
    {
        //
    }


    public function edit(Repository $repository)
    {
        //
    }

    public function update(UpdateRepositoryRequest $request, Repository $repository)
    {
        //
    }

    public function destroy(Repository $repository)
    {
        //
    }
}
