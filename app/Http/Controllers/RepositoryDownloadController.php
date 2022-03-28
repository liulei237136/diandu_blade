<?php

namespace App\Http\Controllers;

use App\Models\RepositoryDownload;
use App\Http\Requests\StoreRepositoryDownloadRequest;
use App\Http\Requests\UpdateRepositoryDownloadRequest;
use App\Models\Repository;

class RepositoryDownloadController extends Controller
{
    public function index(Repository $repository)
    {
        // $repository->load('downloads');
        $downloads = RepositoryDownload::where(
            'repository_id',
            $repository->id
        )->paginate();

        return view('repositories.downloads.index', compact('repository', 'downloads'));
    }

    public function create(Repository $repository)
    {
        return view('repositories.downloads.create', compact('repository'));
    }
}
