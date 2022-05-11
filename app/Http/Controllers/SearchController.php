<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $q = trim($request->q);

        if (!empty($q)) {
            $repositories = Repository::withOrder($request->order)
                ->with('user')  // 预加载防止 N+1 问题
                ->where('name', 'like', '%' . trim($request->q) . '%')
                ->paginate(15);
        }else{
            $repositories = [];
        }
        // $active_users = $user->getActiveUsers();

        return view('search', compact('repositories'));
    }
}
