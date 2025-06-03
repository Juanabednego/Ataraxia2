<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminNotification;

class ReservationController extends Controller
{
    public function form() {
        return view('reservation');
    }

    public function store(Request $request) {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'people' => 'required|integer|min:1',
            'note' => 'nullable|string'
        ]);

        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'phone' => Auth::user()->phone ?? '-',
            'date' => $request->date,
            'time' => $request->time,
            'people' => $request->people,  // Simpan jumlah kursi total (integer)
            'note' => $request->note,
            'status' => 'pending',
        ]);

        AdminNotification::create([
            'type' => 'reservation',
            'reference_id' => $reservation->id,
            'title' => 'Reservasi Baru',
            'message' => 'Reservasi oleh ' . Auth::user()->name . ' untuk ' . $reservation->date,
        ]);

        return redirect()->route('reservation.form')->with('success', 'Reservation submitted and awaiting admin confirmation.');
    }
}
