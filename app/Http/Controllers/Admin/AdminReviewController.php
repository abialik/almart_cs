<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
    /**
     * Display a listing of all customer reviews.
     */
    public function index()
    {
        $reviews = Review::with(['user', 'product', 'order'])
                         ->latest()
                         ->paginate(15);

        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Delete a review (moderation).
     */
    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
