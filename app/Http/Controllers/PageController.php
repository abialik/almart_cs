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
        
        $complaint = \App\Models\Complaint::create($validated);
        
        // Dispatch Real-time Event
        event(new \App\Events\NewComplaintEvent($complaint));
        
        return redirect()->route('customer.complaints.index')->with('success', 'Keluhan Anda telah berhasil dikirim. Tim kami akan segera menindaklanjutinya.');
    }
}
