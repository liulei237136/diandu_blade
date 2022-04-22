<?php

namespace App\Http\Controllers;

use App\Models\Tutorial;
use Illuminate\Http\Request;

class TutorialController extends Controller
{
    public function index()
    {
        return 1;
        $tutorials = Tutorial::with('user')->paginate(5);

        return view('tutorials.index', compact('tutorials'));
    }

    public function create(){
        return 'create';
    }
}
