<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        // Check if already exists
        $exists = NewsletterSubscription::where('email', $request->email)->exists();

        if ($exists) {
            return response()->json([
                'success' => true,
                'message' => 'Alamat email ini sudah terdaftar sebelumnya.'
            ]);
        }

        NewsletterSubscription::create([
            'email' => $request->email
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih! Anda telah terdaftar dalam buletin kami.'
        ]);
    }

    public function index(Request $request)
    {
        $query = NewsletterSubscription::latest();

        if ($request->filled('search')) {
            $query->where('email', 'like', '%' . $request->search . '%');
        }

        $subscriptions = $query->paginate(20)->withQueryString();
        return view('admin.newsletters.index', compact('subscriptions'));
    }

    public function destroy(NewsletterSubscription $subscription)
    {
        $subscription->delete();
        return redirect()->back()->with('success', 'Email berhasil dihapus dari daftar berlangganan.');
    }
}
