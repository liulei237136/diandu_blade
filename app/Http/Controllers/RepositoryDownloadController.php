<?php

namespace App\Http\Controllers;

use App\Models\RepositoryDownload;
use App\Http\Requests\StoreRepositoryDownloadRequest;
use App\Http\Requests\UpdateRepositoryDownloadRequest;
use App\Models\Commit;
use App\Models\Repository;
use QCloud\COSSTS\Sts;

class RepositoryDownloadController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth'], ['except' => ['index']]);
    }

    public function index(Repository $repository)
    {
        // $repository->load('downloads');
        $downloads = RepositoryDownload::where(
            'repository_id',
            $repository->id
        )->paginate();

        return view('repositories.downloads.index', compact('repository', 'downloads'));
    }

    public function create(Repository $repository, RepositoryDownload $download)
    {
        $this->authorize('update', $repository);

        $repository->load('commits');


        return view('repositories.downloads.create', compact('repository', 'download'));
    }

    public function store(Repository $repository, RepositoryDownload $download, StoreRepositoryDownloadRequest $request)
    {
        // dd($request->all());
        $this->authorize('update', $repository);

        $download->repository_id = $repository->id;
        $download->user_id = auth()->id();
        $download->commit_id = $request->commit_id;
        $download->name = $request->name;
        if (isset($request->description)) {
            $request->description = $request->description;
        }
        $download->file_path = $request->file_path;

        $download->save();

        return redirect()->route('repository-downloads.index', $repository->id);
    }
}
