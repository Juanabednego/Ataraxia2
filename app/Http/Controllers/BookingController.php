<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use App\Models\Event;
use App\Models\AdminNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
   public function index(Request $request)
{
    $eventId = $request->event_id;

    // Ambil semua kursi yang sudah dibooking
    $bookedSeats = Booking::where('event_id', $eventId)
        ->whereIn('status', ['confirmed'])
        ->pluck('seats')
        ->toArray();

    // Gabungkan semua kursi yang dibooking
    $formattedSeats = [];
    foreach ($bookedSeats as $seatString) {
        $formattedSeats = array_merge($formattedSeats, json_decode($seatString, true) ?? []);
    }

    // Jika AJAX (untuk refresh kursi via JS), kirim hanya kursi
    if ($request->ajax()) {
        return response()->json(['formattedSeats' => $formattedSeats]);
    }

    // Ambil harga kursi dari event
    $event = Event::findOrFail($eventId);
    $seatPrice = $event->harga;

    // Kirim semua data ke view
    return view('pilihkursi', compact('formattedSeats', 'eventId', 'seatPrice'));
}

   public function store(Request $request)
{
    // Validasi data yang dikirim
    $request->validate([
        'event_id' => 'required|exists:events,id', // Pastikan event_id valid
        'seats' => 'required|string',
        'total_price' => 'required|numeric|min:0', // Total price harus ada dan valid
    ]);

    // Pastikan user sudah login
    if (!Auth::check()) {
        return response()->json(['error' => 'Silakan login terlebih dahulu!'], 401);
    }

    // Ambil ID user yang sedang login
    $userId = Auth::id();
    // Ambil kursi yang dipilih
    $selectedSeats = explode(',', str_replace(' ', '', $request->seats));

    try {
        DB::beginTransaction();

        // Cek apakah ada kursi yang sudah dibooking
      $existingBookings = Booking::where('event_id', $request->event_id)
    ->where('status', 'confirmed')
    ->where(function ($query) use ($selectedSeats) {
        foreach ($selectedSeats as $seat) {
            $query->orWhereJsonContains('seats', $seat);
        }
    })
    ->exists();


        if ($existingBookings) {
            return response()->json(['error' => 'Beberapa kursi yang dipilih sudah dibooking.'], 400);
        }

        // Ambil harga dari tabel events berdasarkan event_id
        $event = Event::findOrFail($request->event_id);
        $seatPrice = $event->harga; // Harga per kursi
        $totalPrice = count($selectedSeats) * $seatPrice; // Hitung total harga berdasarkan jumlah kursi yang dipilih

        // Simpan booking baru ke dalam database
        $booking = Booking::create([
            'user_id' => $userId,
            'event_id' => $request->event_id,
            'seats' => json_encode($selectedSeats),
            'total_price' => $request->total_price, // Total price dihitung dari harga kursi
            'status' => 'pending' // Status booking masih pending sampai pembayaran terkonfirmasi
        ]);

            AdminNotification::create([
    'type' => 'booking',
    'reference_id' => $booking->id,
    'title' => 'Pemesanan Tiket Baru',
    'message' => 'User ' . Auth::user()->name . ' memesan tiket untuk event ID ' . $request->event_id,
]);
    

        DB::commit(); // Commit transaksi

        Log::info('Booking berhasil dibuat', ['booking_id' => $booking->id, 'seats' => $selectedSeats]);

        return response()->json(['booking_id' => $booking->id]);

    } catch (\Exception $e) {
        DB::rollBack(); // Jika ada error, rollback transaksi
        Log::error('Gagal menyimpan booking', ['error' => $e->getMessage()]);
        return response()->json(['error' => 'Terjadi kesalahan, silakan coba lagi.'], 500);
    }

}


public function getNotifikasiUser(Request $request)
{
    $userId = Auth::id();

    // Ambil booking user yang statusnya sudah confirmed
    $bookings = Booking::where('user_id', $userId)
                ->where('status', 'confirmed')
                ->latest()
                ->take(5)
                ->get();

    // Format data notifikasi
    $notifications = $bookings->map(function ($booking) {
        $kursi = json_decode($booking->seats);
        $kursiFormatted = implode(', ', $kursi);
    
        return [
            'message' => "Booking Anda dengan nomor kursi: $kursiFormatted",
            'created_at' => $booking->updated_at->diffForHumans()
        ];
    });


    return response()->json($notifications);
}


}
