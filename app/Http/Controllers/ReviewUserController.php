<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\AdminNotification;
use App\Models\Event;
use App\Models\AboutSection; // Pastikan model About sudah ada
use Illuminate\Support\Facades\Auth;

class ReviewUserController extends Controller
{
     public function index()
    {
       $reviews = Review::with('user')
    ->where('status', 'approved')
    ->where('is_hidden', false)
    ->latest()
    ->get();
    $events = Event::where('status', 'active')
    ->where('is_hidden', false)
    ->latest(); 

    $about = AboutSection::first();    // Ambil data tentang kita
return view('index', compact('reviews', 'events', 'about'));
    }
    // Simpan review
    public function store(Request $request)
    {
        if (!auth()->check()) {
            return back()->withErrors(['error' => 'Anda harus login terlebih dahulu untuk mengirimkan review.']);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        try {
            Review::create([
                'user_id' => auth()->id(),
                'rating' => $validated['rating'],
                'comment' => $validated['comment'],
                'status' => 'pending',
            ]);

            return redirect()->to(url()->previous() . '#review-form')
        ->with('success', 'Review berhasil dikirim dan sedang menunggu persetujuan');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat mengirimkan review.']);
        }

            AdminNotification::create([
    'type' => 'review',
    'reference_id' => $review->id,
    'title' => 'Review Baru',
    'message' => 'Review dari ' . auth()->user()->name . ': ' . \Str::limit($review->comment, 50),
]);
    }


}