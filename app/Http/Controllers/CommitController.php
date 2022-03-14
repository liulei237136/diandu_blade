<?php

namespace App\Http\Controllers;

use App\Models\Commit;
use App\Http\Requests\StoreCommitRequest;
use App\Http\Requests\UpdateCommitRequest;
use App\Models\Repository;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use  Illuminate\Support\Str;

class CommitController extends Controller
{
    public function store(StoreCommitRequest $request, Repository $repository, Commit $commit)
    {
        $this->authorize('update', $repository);

        $filename = time() . '_' . Str::random(10) . '.csv';

        $folder_name = "commits/" . date("Ym/d", time());

        $saved = Storage::disk('public')->put($folder_name . '/' . $filename, $request->content);

        if (!$saved) {
            abort('500', '现在不能保存，请稍后再试');
        }

        $commit->title = $request->title;
        $commit->description = $request->description;
        $commit->repository_id = $repository->id;
        $commit->user_id = auth()->id();
        $commit->file_path = url("storage/" . $folder_name . '/' . $filename);
        $commit->save();

        return Redirect::route('repository.audio', ['repository' => $repository->id, 'commit' => $commit->id])->with('success', '保存成功');
    }
    public function destroy(Commit $commit)
    {
        //
    }
}
