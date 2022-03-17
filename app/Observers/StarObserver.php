<?php

namespace App\Observers;

use App\Models\Star;

class StarObserver
{
    public function created(Star $star)
    {
        $star->repository->updateStarCount();
    }


    public function deleted(Star $star)
    {
        $star->repository->updateStarCount();
    }
}
