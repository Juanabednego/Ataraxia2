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

  public function markAsRead(Request $request)
{
    $id = $request->id;
    $notif = AdminNotification::findOrFail($id);
    $notif->is_read = 1;
    $notif->save();
    return response()->json(['success' => true]);
}


    // Tambahkan method untuk tandai semua sudah dibaca (mark all as read)
    public function markAllAsRead(Request $request)
    {
        AdminNotification::where('is_read', false)->update(['is_read' => true]);

        // Jika AJAX request, balikan json
        if ($request->ajax()) {
            return response()->json(['message' => 'Semua notifikasi telah ditandai sudah dibaca']);
        }

        // Jika bukan AJAX, redirect kembali
        return redirect()->route('admin.notifications.index')->with('success', 'Semua notifikasi telah ditandai sudah dibaca');
    }
}
