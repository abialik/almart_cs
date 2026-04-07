<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class AdminComplaintController extends Controller
{
    public function index(Request $request)
    {
        $query = Complaint::latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('order_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $complaints = $query->paginate(10)->withQueryString();
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
