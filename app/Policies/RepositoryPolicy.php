<?php

namespace App\Policies;

use App\Models\Repository;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RepositoryPolicy
{
    use HandlesAuthorization;

    public function update(User $user, repository $repository)
    {
        return $user->isAuthorOf($repository);
    }

    public function delete(User $user, repository $repository)
    {
        return $user->isAuthorOf($repository);
    }

}
