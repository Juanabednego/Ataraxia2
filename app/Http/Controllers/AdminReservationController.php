<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminReservationController extends Controller
{
public function index(Request $request)
{
    $perPage = 10; // Sesuaikan dengan jumlah per halaman
    $query = Reservation::latest();

    $reservationId = $request->get('reservation_id');
    if ($reservationId) {
        // Ambil semua ID sesuai urutan paginasi
        $ids = $query->pluck('id')->toArray();
        $index = array_search($reservationId, $ids);

        if ($index !== false) {
            // Hitung page
            $page = floor($index / $perPage) + 1;
            // Redirect ke page yang benar jika perlu
            if ($request->get('page', 1) != $page) {
                return redirect()->route('admin.kelola-reservation.index', [
                    'reservation_id' => $reservationId,
                    'page' => $page
                ]);
            }
        }
    }

    $reservations = $query->paginate($perPage);
    return view('admin.kelola-reservation', compact('reservations'));
}


    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        // Cegah update berulang
        if ($reservation->status !== 'pending') {
            return redirect()->back()->with('success', 'Aksi hanya dapat dilakukan sekali.');
        }

        $data = ['status' => $request->status];

        // Validasi alasan jika status cancelled
        if ($request->status === 'cancelled') {
            $request->validate([
                'reason' => 'required|string|max:255'
            ]);
            $data['reason'] = $request->reason;
        }

        $reservation->update($data);
        return redirect()->route('admin.index')->with('success', 'Status reservasi berhasil diperbarui.');
    }

    public function getNotifikasiReservation()
    {
        $userId = Auth::id();

        $reservations = Reservation::where('user_id', $userId)
                        ->where('status', 'confirmed')
                        ->latest()
                        ->take(5)
                        ->get();

        $notifications = $reservations->map(function ($reservation) {
            return [
                'message' => "Reservasi Anda pada " . $reservation->date . " jam " . $reservation->time . " telah dikonfirmasi.",
                'created_at' => $reservation->updated_at->diffForHumans()
            ];
        });

        return response()->json($notifications);
    }
}
