<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminNotification;

class AdminNotificationController extends Controller
{
    public function index()
    {
        $notifications = AdminNotification::latest()->get();
        return view('admin.notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notif = AdminNotification::findOrFail($id);
        $notif->is_read = true;
        $notif->save();

        return redirect()->route('admin.notifications.index');
    }
}
