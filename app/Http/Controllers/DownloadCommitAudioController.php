<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commit;
use Illuminate\Support\Facades\Storage;
use ZipStream\ZipStream;

class DownloadCommitAudioController extends Controller
{
    public function all(Commit $commit)
    {
        $commitId = $commit->id;
        // "http://localhost:8000/storage/commits/202203/15/1647313960_lNLodp6sbE.csv"
        $commit_file_path = strstr($commit->file_path, 'commits/');

        // $commit_file_path = 'commits/' . $commit->file_path;

        $exist = Storage::disk('public')->exists($commit_file_path);
        $canRead = Storage::disk('public')->getVisibility($commit_file_path);
        if (!$exist || !$canRead) abort(500, 'can not read commit file');

        $content =  Storage::disk('public')->get($commit_file_path);
        $rows = explode("\n", $content);
        array_shift($rows); //去掉第一行
        $audioFiles = [];
        foreach ($rows as $row) {
            $rowSections = explode(',', $row);
            $file_name =  $rowSections[0];
            if (!$file_name) continue;

            $url =  $rowSections[1];
            if (!$url) continue;

            // ^ "http://localhost:8000/uploads/audio/202203/15/1_1647313959_QqhoRzBsyH.mp3"
            // dd($url);
            // $urlSections = explode('/', $url);
            // $userId = $urlSections[5];
            // $hashName = $urlSections[6];
            // $file_path = public_path() . '/uploads/audio/' . $userId . '/' . $hashName;
            // http://localhost:8000/storage/audio/1/uaY7CLfO6GmLoDT6ndxMsFYsJKfPiKOq0OpIwzgd.mp3
            $file_path = public_path() . '/uploads/' . strstr($url, '/audio/');
            // dd($file_path);

            array_push($audioFiles, [
                'file_name' => $file_name,
                // 'file_path' => $file_path,
                'file_path' => $file_path,
            ]);
        }

        try {
            $opt = new  \ZipStream\Option\Archive();
            $opt->setSendHttpHeaders(true);
            $opt->setDeflateLevel(-1);
            $zip = new ZipStream($commit->title . '.zip', $opt);
            foreach ($audioFiles as $file) {
                // dd($file);
                // C:\Users\liulei\test\diandu_blade\public/storage/audio/202203/1
                $zip->addFileFromPath($file['file_name'], $file['file_path']);
            }
            $zip->finish();
        } catch (\Exception $e) {
            return $e->getMessage();
            abort(501, $e->getMessage());
        }
    }
}
