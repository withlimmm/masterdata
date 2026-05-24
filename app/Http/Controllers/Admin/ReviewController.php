<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        // Membaca dari tabel reviews, bukan clients
        $reviews = Review::latest()->get();
        return view('admin.reviews.index', compact('reviews'));
    }

    public function update(Request $request, Review $review)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $review->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status ulasan berhasil diperbarui!');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->back()->with('success', 'Ulasan berhasil dihapus!');
    }
}
