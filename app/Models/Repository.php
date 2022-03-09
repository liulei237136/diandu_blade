<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repository extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'decription', 'user_id', 'excerpt', 'slug'];

    public function link($params = [])
    {
        return route('repositories.show', array_merge([$this->id, $this->slug], $params));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
