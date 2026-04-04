<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about() { return view('pages.about'); }
    public function delivery() { return view('pages.delivery'); }
    public function privacy() { return view('pages.privacy'); }
    public function terms() { return view('pages.terms'); }
    public function contact() { return view('pages.contact'); }
    public function support() { return view('pages.support'); }
    public function faq() { return view('pages.faq'); }
    
    public function complaint() { return view('pages.complaint'); }
    
    public function returnRequest() { 
        return view('pages.return_request'); 
    }
    
    public function processReturnRequest(Request $request) {
        $request->validate([
            'order_code' => 'required|string',
        ]);
        
        if (!\Illuminate\Support\Facades\Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk mengajukan retur.');
        }

        $order = \App\Models\Order::where('order_code', $request->order_code)
            ->where('customer_id', \Illuminate\Support\Facades\Auth::id())
            ->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Nomor Pesanan tidak ditemukan atau bukan milik Anda.');
        }

        return redirect()->route('returns.create', $order->id);
    }
    
    public function submitComplaint(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'order_number' => 'nullable|string|max:255',
            'complaint_type' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
        
        $validated['user_id'] = \Illuminate\Support\Facades\Auth::id();
        
        \App\Models\Complaint::create($validated);
        
        return redirect()->route('customer.complaints.index')->with('success', 'Keluhan Anda telah berhasil dikirim. Tim kami akan segera menindaklanjutinya.');
    }
}
