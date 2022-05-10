<?php

namespace App\Policies;

use App\Models\Suggestion;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SuggestionPolicy
{
    use HandlesAuthorization;



    public function update(User $user, Suggestion $suggestion)
    {
        return $user->id == $suggestion->user_id;
    }

    public function delete(User $user, Suggestion $suggestion)
    {
        return $user->id === $suggestion->user_id;
    }


}
