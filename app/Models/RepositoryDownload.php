<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepositoryDownload extends Model
{
    use HasFactory;

    public function url(){
        return public_path($this->file_path);
    }
}
