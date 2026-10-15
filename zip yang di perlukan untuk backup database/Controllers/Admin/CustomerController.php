<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // ================= INDEX =================
    public function index()
    {
        $customer = Customer::latest()->get();

        return view(
            'backend.customer.index',
            compact('customer')
        );
    }

    // ================= CREATE =================
    public function create()
    {
        return view('backend.customer.create');
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $request->validate([
            'nama_customer' => 'required',
            'email' => 'nullable|email',
            'nomor_telepon' => 'nullable',
            'alamat' => 'nullable'
        ]);

        Customer::create([
            'nama_customer' => $request->nama_customer,
            'email' => $request->email,
            'nomor_telepon' => $request->nomor_telepon,
            'alamat' => $request->alamat
        ]);

        return redirect('/admin/customer')
            ->with('success', 'Customer berhasil ditambahkan');
    }

    // ================= EDIT =================
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);

        return view(
            'backend.customer.edit',
            compact('customer')
        );
    }

    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'nama_customer' => 'required',
            'email' => 'nullable|email',
            'nomor_telepon' => 'nullable',
            'alamat' => 'nullable'
        ]);

        $customer->update([
            'nama_customer' => $request->nama_customer,
            'email' => $request->email,
            'nomor_telepon' => $request->nomor_telepon,
            'alamat' => $request->alamat
        ]);

        return redirect('/admin/customer')
            ->with('success', 'Customer berhasil diupdate');
    }

    // ================= DELETE =================
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);

        $customer->delete();

        return redirect('/admin/customer')
            ->with('success', 'Customer berhasil dihapus');
    }
}