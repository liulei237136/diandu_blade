<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // 获取登录用户的所有通知
        $notifications = auth()->user()->notifications()->paginate(20);
        // 标记为已读，未读数量清零
        auth()->user()->markAsRead();

        return view('notifications.index', compact('notifications'));
    }
}
