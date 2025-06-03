<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Reservation; // Pastikan model Reservation sudah dibuat dan benar namespace-nya
use Illuminate\Support\Facades\Auth;

class HistoriController extends Controller
{
    public function index()
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $userId = Auth::id();

        // Ambil data booking tiket beserta relasi payment untuk user yang login
        $bookings = Booking::with(['payment'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil data reservasi restoran user yang login
        $reservations = Reservation::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('histori', [
            'bookings' => $bookings,
            'reservations' => $reservations,
            'statusLabels' => [
                'pending' => 'Menunggu Pembayaran',
                'waiting_payment_confirmation' => 'Menunggu Konfirmasi',
                'confirmed' => 'Dikonfirmasi',
                'cancelled' => 'Dibatalkan'
            ],
            'statusClasses' => [
                'pending' => 'status-diproses',
                'waiting_payment_confirmation' => 'status-diproses',
                'confirmed' => 'status-selesai',
                'cancelled' => 'status-hubungi'
            ],
            // Status reservasi, jika berbeda dengan booking
            'reservationStatusLabels' => [
                'pending' => 'Diproses',
                'confirmed' => 'Diterima',
                'cancelled' => 'Dibatalkan',
            ],
        ]);
    }
}
