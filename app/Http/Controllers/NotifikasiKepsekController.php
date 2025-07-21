<?php

namespace App\Http\Controllers;

use App\Models\NotifikasiKepsek;
use Illuminate\Http\Request;

class NotifikasiKepsekController extends Controller
{
    public function index()
    {
        $notifikasi = NotifikasiKepsek::latest()->limit(5)->get();
        $unreadCount = NotifikasiKepsek::where('dibaca', false)->count();

        return response()->json([
            'data' => $notifikasi,
            'unread' => $unreadCount,
        ]);
    }

    public function markAsRead($id)
    {
        $notif = NotifikasiKepsek::findOrFail($id);
        $notif->update(['dibaca' => true]);

        return response()->json(['message' => 'Notifikasi ditandai sudah dibaca.']);
    }

    public function markAllAsRead()
    {
        NotifikasiKepsek::where('dibaca', false)->update(['dibaca' => true]);
        return response()->json(['message' => 'Semua notifikasi ditandai sudah dibaca.']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe' => 'required|string',
            'pesan' => 'required|string',
        ]);

        NotifikasiKepsek::create([
            'tipe' => $request->tipe,
            'pesan' => $request->pesan,
            'dibaca' => false,
        ]);

        return response()->json(['message' => 'Notifikasi berhasil dibuat.']);
    }
}

