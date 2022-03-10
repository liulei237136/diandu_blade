<?php

namespace App\Observers;

use App\Handlers\SlugTranslateHandler;
use App\Jobs\TranslateSlug;
use App\Models\Repository;

class RepositoryObserver
{
    public function saving(Repository $repository)
    {
        // XSS 过滤
        $repository->description = clean($repository->description);

         // 生成仓库摘录
        $repository->excerpt = make_excerpt($repository->description);

        // 如 slug 字段无内容，即使用翻译器对 title 进行翻译
        if (!$repository->slug || $repository->isDirty('name')) {
            // $repository->slug = app(SlugTranslateHandler::class)->translate($repository->name);

            // 推送任务到队列
            dispatch(new TranslateSlug($repository));
        }
    }
}
