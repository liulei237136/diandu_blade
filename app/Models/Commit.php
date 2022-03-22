<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commit extends Model
{
    use HasFactory;

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function creator(){
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function repository()
    {
        return $this->belongsTo(Repository::class);
    }
}
