<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerComplaintController extends Controller
{
    public function index(Request $request)
    {
        $query = Complaint::where('user_id', Auth::id())->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $complaints = $query->paginate(10)->withQueryString();

        return view('customer.complaints.index', compact('complaints'));
    }
}
