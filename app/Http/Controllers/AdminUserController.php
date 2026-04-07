<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminUserController extends Controller
{
    /**
     * Display a listing of members and petugas.
     */
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'member'); // Default to member
        $role = $tab === 'petugas' ? 'petugas' : 'customer';

        $query = User::where('role', $role)->latest();

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        // Calculate orders count and total spent for customers (Only successful/paid orders)
        if ($role === 'customer') {
            $query->withCount(['orders' => function($q) {
                $q->whereIn('status', ['paid', 'processing', 'delivering', 'delivered']);
            }])->withSum(['orders' => function($q) {
                $q->whereIn('status', ['paid', 'processing', 'delivering', 'delivered']);
            }], 'total');
        }

        $users = $query->paginate(12)->appends(request()->query());

        // Stats Calculation
        $allUsers = User::all();
        $totalMember = $allUsers->where('role', 'customer')->count();
        $totalPetugas = $allUsers->where('role', 'petugas')->count();
        $memberAktif = $allUsers->where('role', 'customer')->where('is_active', true)->count();
        
        $startOfMonth = Carbon::now()->startOfMonth();
        $memberBaru = $allUsers->where('role', 'customer')->where('created_at', '>=', $startOfMonth)->count();

        return view('admin.users.index', compact(
            'users', 
            'tab', 
            'totalMember', 
            'totalPetugas', 
            'memberAktif', 
            'memberBaru'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $role = $request->get('role', 'petugas');
        return view('admin.users.create', compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,petugas,customer',
            'is_active' => 'boolean'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.users.index', ['tab' => $user->role])
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        $user->loadCount(['orders' => function($q) {
            $q->whereIn('status', ['paid', 'processing', 'delivering', 'delivered']);
        }])->loadSum(['orders' => function($q) {
            $q->whereIn('status', ['paid', 'processing', 'delivering', 'delivered']);
        }], 'total');
        
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,petugas,customer',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index', ['tab' => $user->role])
            ->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Don't delete self or other admins easily
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun Anda sendiri.');
        }

        // Cegah penghapusan jika User memiliki riwayat pesanan (menghindari hilangnya data penjualan/financial loss)
        if ($user->orders()->exists()) {
             return redirect()->back()->with('error', 'User tidak dapat dihapus karena memiliki riwayat pesanan aktif. Penghapusan akan ikut menghapus riwayat transaksi mereka.');
        }

        $tab = $user->role;
        $user->delete();

        return redirect()->route('admin.users.index', ['tab' => $tab])
            ->with('success', 'User berhasil dihapus.');
    }
}
