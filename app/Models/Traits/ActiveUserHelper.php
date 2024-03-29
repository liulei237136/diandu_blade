<?php

namespace App\Models\Traits;

use App\Models\Repository;
use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

trait ActiveUserHelper
{
    // 用于存放临时用户数据
    protected $users = [];

    // 配置信息
    protected $repository_weight = 4; // 仓库权重
    protected $comment_weight = 1; // 评论权重
    protected $pass_days = 7;    // 多少天内发表过内容
    protected $user_number = 6; // 取出来多少用户

    // 缓存相关配置
    protected $cache_key = 'diandu_active_users';
    protected $cache_expire_in_seconds = 65 * 60;

    public function getActiveUsers()
    {
        // 尝试从缓存中取出 cache_key 对应的数据。如果能取到，便直接返回数据。
        // 否则运行匿名函数中的代码来取出活跃用户数据，返回的同时做了缓存。
        return Cache::remember($this->cache_key, $this->cache_expire_in_seconds, function(){
            return $this->calculateActiveUsers();
        });
    }

    public function calculateAndCacheActiveUsers()
    {
        // 取得活跃用户列表
        $active_users = $this->calculateActiveUsers();
        // 并加以缓存
        $this->cacheActiveUsers($active_users);
    }

    private function calculateActiveUsers()
    {
        $this->calculateRepositoryScore();
        $this->calculateCommentScore();

        // 数组按照得分排序
        $users = Arr::sort($this->users, function ($user) {
            return $user['score'];
        });

        // 我们需要的是倒序，高分靠前，第二个参数为保持数组的 KEY 不变
        $users = array_reverse($users, true);

        // 只获取我们想要的数量
        $users = array_slice($users, 0, $this->user_number, true);

        // 新建一个空集合
        $active_users = collect();

        foreach ($users as $user_id => $user) {
            // 找寻下是否可以找到用户
            $user = $this->find($user_id);

            // 如果数据库里有该用户的话
            if ($user) {

                // 将此用户实体放入集合的末尾
                $active_users->push($user);
            }
        }

        // 返回数据
        return $active_users;
    }

    private function calculateRepositoryScore()
    {
        // 从仓库数据表里取出限定时间范围（$pass_days）内，有发表过仓库的用户
        // 并且同时取出用户此段时间内发布仓库的数量
        $repository_users = Repository::query()->select(DB::raw('user_id, count(*) as repository_count'))
                                     ->where('created_at', '>=', Carbon::now()->subDays($this->pass_days))
                                     ->groupBy('user_id')
                                     ->get();
        // 根据仓库数量计算得分
        foreach ($repository_users as $value) {
            $this->users[$value->user_id]['score'] = $value->repository_count * $this->repository_weight;
        }
    }

    private function calculateCommentScore()
    {
        // 从评论数据表里取出限定时间范围（$pass_days）内，有发表过评论的用户
        // 并且同时取出用户此段时间内发布评论的数量
        $comment_users = Comment::query()->select(DB::raw('user_id, count(*) as comment_count'))
                                     ->where('created_at', '>=', Carbon::now()->subDays($this->pass_days))
                                     ->groupBy('user_id')
                                     ->get();
        // 根据评论数量计算得分
        foreach ($comment_users as $value) {
            $comment_score = $value->comment_count * $this->comment_weight;
            if (isset($this->users[$value->user_id])) {
                $this->users[$value->user_id]['score'] += $comment_score;
            } else {
                $this->users[$value->user_id]['score'] = $comment_score;
            }
        }
    }

    private function cacheActiveUsers($active_users)
    {
        // 将数据放入缓存中
        Cache::put($this->cache_key, $active_users, $this->cache_expire_in_seconds);
    }
}
