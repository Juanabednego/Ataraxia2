<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Event;
use App\Models\Makanan;
use App\Models\Review;
use App\Models\AboutSection;
use App\Models\Reservation;
use App\Models\SeatLayout;

class IndexAdminController extends Controller
{
    public function index()
    {
        $pesananBaruCount  = Booking::count();
        $eventCount        = Event::count();
        $menuCount         = Makanan::count();
        $reviewCount       = Review::count();
        $aboutCount        = AboutSection::count();
        $reservationCount  = Reservation::count();
        $kursiCount        = SeatLayout::count();

        return view('admin.indexadmin', compact(
            'pesananBaruCount', 'eventCount', 'menuCount', 'reviewCount',
            'aboutCount', 'reservationCount', 'kursiCount'
        ));
    }
}
