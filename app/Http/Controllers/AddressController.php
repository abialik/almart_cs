<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'label'     => 'required|string|max:50',
            'full_name' => 'required|string|max:255',
            'address'   => 'required|string|max:500',
            'city'      => 'required|string|max:100',
            'post_code' => 'required|string|max:10',
            'province'  => 'required|string|max:100',
            'phone'     => 'required|string|max:20',
        ]);

        $isDefault = Auth::user()->addresses()->count() === 0;

        Auth::user()->addresses()->create(array_merge($request->all(), [
            'is_default' => $isDefault
        ]));

        return back()->with('success', 'Alamat berhasil ditambahkan!');
    }

    public function update(Request $request, Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'label'     => 'required|string|max:50',
            'full_name' => 'required|string|max:255',
            'address'   => 'required|string|max:500',
            'city'      => 'required|string|max:100',
            'post_code' => 'required|string|max:10',
            'province'  => 'required|string|max:100',
            'phone'     => 'required|string|max:20',
        ]);

        $address->update($request->all());

        return back()->with('success', 'Alamat berhasil diperbarui!');
    }

    public function destroy(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $wasDefault = $address->is_default;
        $address->delete();

        if ($wasDefault) {
            $newDefault = Auth::user()->addresses()->first();
            if ($newDefault) {
                $newDefault->update(['is_default' => true]);
            }
        }

        return back()->with('success', 'Alamat berhasil dihapus!');
    }

    public function setDefault(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        Auth::user()->addresses()->update(['is_default' => false]);
        $address->update(['is_default' => true]);

        return back()->with('success', 'Alamat utama berhasil diubah!');
    }
}
