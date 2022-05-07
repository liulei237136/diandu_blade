<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repository extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'excerpt', 'slug'];

    // protected $appends = ['is_stared'];

    public function scopeWithOrder($query, $order)
    {
        // 不同的排序，使用不同的数据读取逻辑
        switch ($order) {
            case 'star':
                $query->star();
                break;
            case 'recent':
                $query->recent();
                break;
            default:
                $query->recent();
                break;
        }
    }

    public function scopeStar($query)
    {
        return $query->orderBy('star_count', 'desc');
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

    public function link($route = 'repositories.show', $params = [])
    {
        return route($route, array_merge([$this->id, $this->slug], $params));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commits()
    {
        return $this->hasMany(Commit::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function updateCommentCount()
    {
        $this->comment_count = $this->comments()->count();
        $this->save();
    }

    public function stars()
    {
        return $this->hasMany(Star::class);
    }

    public function updateStarCount()
    {
        $this->star_count = $this->stars()->count();

        $this->save();
    }

    public function star($userId)
    {
        $this->stars()->create([
            'user_id' => $userId
        ]);

        return $this;
    }

    public function unstar($userId)
    {
        $this->stars()
            ->where('user_id', $userId)
            ->delete();

        return $this;
    }

    public function isStaredBy($user)
    {
        if (!$user) {
            return false;
        }

        return $this->stars()
            ->where('user_id', $user->id)
            ->exists();
    }

    // protected function isStared(): Attribute
    // {
    //     return new Attribute(
    //         get: fn () => $this->isStaredBy(auth()->user()),
    //     );
    // }
    public function parent()
    {
        return $this->belongsTo(Repository::class, 'parent_id');
    }

    public function clones()
    {
        return $this->hasMany(Repository::class, 'parent_id');
    }


    public function clonedBy($user)
    {
        if (!$user) {
            return false;
        }

        return $this->clones()
            ->where('user_id', $user->id)
            ->exists();
    }

    function clone($user)
    {
        //todo validate
        if (is_null($user)) {
            return false;
        }

        $child = new Repository();
        $child->name = $this->name;
        $child->description = $this->description;
        $child->user()->associate($user);
        $child->parent()->associate($this);
        $child->save();

        // $child->commits()->attach($this->commits);
        $newCommits = [];
        $this->commits->each(function ($commit) use ($child) {
            $newCommits[] = [
                'title' => $commit->title,
                'description' => $commit->description,
                'creator_id' => $commit->creator_id,
                'owner_id' => auth()->id(),
                'repository_id' => $child->id,
                'file_path' => $commit->file_path,
                'created_at' => $commit->created_at,
                'updated_at' => $commit->updated_at,
            ];
        });

        Commit::insert($newCommits);


        return $child;
    }

    public function updateCloneCount()
    {
        $this->clone_count = $this->clones()->count();

        $this->save();
    }

    public function downloads()
    {
        return $this->hasMany(RepositoryDownload::class);
    }
}
