<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Review;


class ReviewController extends Controller
{
    // app/Http/Controllers/ReviewController.php

public function index(Request $request)
{
    $perPage = 10; // sesuaikan dengan pagination anda
    $query = Review::with('user')->orderBy('id', 'desc'); // atau sesuaikan sort
    
    // cek apakah ada parameter review_id
    if ($request->has('review_id')) {
        $reviewId = $request->get('review_id');
        $allIds = $query->pluck('id')->toArray();
        $index = array_search($reviewId, $allIds);

        if ($index !== false) {
            // hitung page review_id
            $page = floor($index / $perPage) + 1;
            if ($request->get('page', 1) != $page) {
                // redirect ke page yang benar
                return redirect()->route('admin.kelola-review.index', [
                    'review_id' => $reviewId,
                    'page' => $page
                ]);
            }
        }
    }

    $reviews = $query->paginate($perPage);

    return view('admin.kelola-review', compact('reviews'));
}

public function store(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'required|integer|exists:users,id',
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string',
    ]);

    DB::table('reviews')->insert([
        'user_id' => $validated['user_id'],
        'rating' => $validated['rating'],
        'comment' => $validated['comment'] ?? null,
        'status' => 'pending',
        'is_hidden' => false,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->back()->with('success', 'Feedback berhasil dikirim.');
}
  public function update($id, Request $request)
{
    $review = Review::findOrFail($id);

    // Jika ada parameter aksi, proses sesuai aksi
    if ($request->action === 'approve') {
        $review->status = 'approved';
        $review->is_hidden = false;
    } elseif ($request->action === 'hide') {
        $review->is_hidden = true;
    }
    $review->save();

    return redirect()->route('admin.kelola-review.index')->with('success', 'Status review berhasil diperbarui.');
}

}

