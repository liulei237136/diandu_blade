<?php

namespace App\Http\Controllers;

use App\Models\Star;
use App\Http\Requests\StoreStarRequest;
use App\Http\Requests\UpdateStarRequest;
use App\Models\Repository;

class StarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Repository $repository)
    {
        $repository->star(auth()->id());

        $repository->updateStarCount();

        return response([], 201);
    }

    public function destroy(Repository $repository)
    {
        $repository->unstar(auth()->id());

        $repository->updateStarCount();

        return response([], 201);
    }
}
