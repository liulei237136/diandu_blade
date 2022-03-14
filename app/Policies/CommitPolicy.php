<?php

namespace App\Policies;

use App\Models\Commit;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommitPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Commit $commit)
    {

    }

}
