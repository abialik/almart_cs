<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class AdminComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::latest()->paginate(10);
        return view('admin.complaints.index', compact('complaints'));
    }

    public function show(Complaint $complaint)
    {
        return view('admin.complaints.show', compact('complaint'));
    }

    public function respond(Request $request, Complaint $complaint)
    {
        $request->validate([
            'admin_response' => 'required|string',
            'status' => 'required|in:pending,responded,resolved',
        ]);

        $complaint->update([
            'admin_response' => $request->admin_response,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.complaints.show', $complaint)
            ->with('success', 'Tanggapan berhasil disimpan dan status diperbarui.');
    }
}
