<?php

namespace App\Observers;

use App\Models\Repository;

class RepositoryObserver
{
    public function saving(Repository $repository)
    {
        $repository->description = clean($repository->description);

        $repository->excerpt = make_excerpt($repository->description);
    }
}
