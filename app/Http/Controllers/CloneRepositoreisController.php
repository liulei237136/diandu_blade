<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Repository;
use Illuminate\Support\Facades\Redirect;

class CloneRepositoreisController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => []]);
    }

    public function store(Repository $repository)
    {

        $this->authorize('clone', $repository);

        //todo 涉及到几张表，最好用事务
        $child = $repository->clone(auth()->user());

        // return Redirect::route('repositories.show', ['repository' => $child]);
        $repository->updateCloneCount();

        return [
            'success' => true,
            'data' => $child->id,
        ];
    }
}
