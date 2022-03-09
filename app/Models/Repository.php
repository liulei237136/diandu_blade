<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repository extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'decription', 'user_id', 'excerpt', 'slug'];

    public function scopeWithOrder($query, $order)
    {
        // 不同的排序，使用不同的数据读取逻辑
        switch ($order) {
            case 'favorite':
                $query->favorite();
                break;

            default:
                $query->recent();
                break;
        }
    }

    public function scopefavorite($query)
    {
        return $query->orderBy('favorite_count', 'desc');
    }

    // public function scopeRecentReplied($query)
    // {
    //     // 当话题有新回复时，我们将编写逻辑来更新话题模型的 reply_count 属性，
    //     // 此时会自动触发框架对数据模型 updated_at 时间戳的更新
    //     return $query->orderBy('updated_at', 'desc');
    // }

    public function scopeRecent($query)
    {
        // 按照创建时间排序
        return $query->orderBy('created_at', 'desc');
    }

    public function link($params = [])
    {
        return route('repositories.show', array_merge([$this->id, $this->slug], $params));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}