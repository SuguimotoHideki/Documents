<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewNotificationController extends Controller
{
    //
    public function indexRead()
    {
        $user = Auth::user();
        if($user->hasRole('admin'))
        {
            $notifications = $user->readNotifications;
            return view('notifications.indexUnread', ['notifications' => $notifications]);
        }
        return redirect()->back()->with('error', 'Você não tem permissão para acessar essa página.');
    }

    public function indexUnread()
    {
        $user = Auth::user();
        if($user->hasRole('admin'))
        {
            $notifications = $user->unreadNotifications;
            return view('notifications.index', ['notifications' => $notifications]);
        }
        return redirect()->back()->with('error', 'Você não tem permissão para acessar essa página.');
    }

    public function markNotif($id)
    {
        $notification = Auth::user()->unreadNotifications->where('id', $id)->first();
        if($notification)
        {
            $notification->markAsRead();
            return redirect()->back();
        }
    }
}
