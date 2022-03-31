<?php

namespace App\Http\Controllers;

use App\Models\RepositoryDownload;
use App\Http\Requests\StoreRepositoryDownloadRequest;
use App\Http\Requests\UpdateRepositoryDownloadRequest;
use App\Models\Commit;
use App\Models\Repository;
use Qcloud\Cos\Client;


class RepositoryDownloadController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth'], ['except' => ['index']]);
    }

    public function index(Repository $repository)
    {
        // $repository->load('downloads');
        $downloads = RepositoryDownload::with('commit', 'user')->where(
            'repository_id',
            $repository->id
        )->latest()->paginate(10);

        return view('repositories.downloads.index', compact('repository', 'downloads'));
    }

    public function show(RepositoryDownload $download)
    {
        $download->load('user', 'repository', 'commit');

        $repository = $download->repository;

        return view('repositories.downloads.show', compact('download', 'repository'));
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
        $download->file_name = $request->file_name;

        $download->save();

        return redirect()->route('repository-downloads.index', $repository->id);
    }

    public function getTempUrl(RepositoryDownload $download)
    {
        $secretId = config('services.qcloud.secretId');
        $secretKey = config('services.qcloud.secretKey');
        $bucket = config('services.qcloud.bucket');
        $region = config('services.qcloud.region');
        $expire = '+10 seconds';

        $cosClient = new Client(
            array(
                'region' => $region,
                // 'schema' => 'https', //协议头部，默认为http
                'schema' => 'http', //协议头部，默认为http
                'credentials' => array(
                    'secretId'  => $secretId,
                    'secretKey' => $secretKey
                )
            )
        );

        try {
            // $key = "dir/101.tar";  //此处的 key 为对象键，对象键是对象在存储桶中的唯一标识
            // $signedUrl = $cosClient->getObjectUrl($bucket, $key, '+10 minutes');
            $signedUrl = $cosClient->getObjectUrl($bucket, $download->file_path, $expire);
            return [
                'success' => true,
                'data' => $signedUrl . 'response-content-disposition=attachment',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' =>  '获取下载出错，请稍后再试',
            ];
        }
    }
}
