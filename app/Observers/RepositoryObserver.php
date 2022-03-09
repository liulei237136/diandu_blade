<?php

namespace App\Observers;

use App\Models\Repository;

class RepositoryObserver
{
    public function saving(Repository $repository)
    {
        $repository->excerpt = make_excerpt($repository->description);
    }
}
