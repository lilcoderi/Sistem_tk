<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotifikasiOrangTua;
use Illuminate\Support\Facades\Auth;

class NotifikasiOrangTuaController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $notifikasi = NotifikasiOrangTua::where('user_id', $userId)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return response()->json($notifikasi);
    }

    public function markAsRead($id)
    {
        $notif = NotifikasiOrangTua::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        $notif->update(['dibaca' => true]);

        return response()->json(['message' => 'Notifikasi ditandai sudah dibaca.']);
    }

    public function markAllAsRead()
    {
        NotifikasiOrangTua::where('user_id', Auth::id())->update(['dibaca' => true]);
        return response()->json(['message' => 'Semua notifikasi ditandai sudah dibaca.']);
    }

    public function countUnread()
    {
        $count = NotifikasiOrangTua::where('user_id', Auth::id())
                    ->where('dibaca', false)
                    ->count();

        return response()->json(['unread' => $count]);
    }
}
