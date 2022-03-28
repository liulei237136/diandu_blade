<?php

namespace App\Policies;

use App\Models\Repository;
use App\Models\RepositoryDownload;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RepositoryDownloadPolicy
{
    use HandlesAuthorization;

    public function create(User $user, Repository $repository)
    {
        return  $user->id === $repository->user->id;
    }
}
