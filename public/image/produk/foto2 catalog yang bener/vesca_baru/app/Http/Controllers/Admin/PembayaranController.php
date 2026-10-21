<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    /**
     * =========================
     * INDEX
     * =========================
     */
    public function index()
    {
        $pembayaran = Pembayaran::with([
            'pesanan.customer',
            'user'
        ])
        ->orderBy('created_at', 'desc')
        ->get();

        return view(
            'backend.pembayaran.index',
            compact('pembayaran')
        );
    }

    /**
     * =========================
     * CREATE
     * =========================
     */
    public function create()
    {
        $pesanan = Pesanan::with('customer')
            ->orderBy('created_at', 'desc')
            ->get();

        return view(
            'backend.pembayaran.create',
            compact('pesanan')
        );
    }

    /**
     * =========================
     * STORE
     * =========================
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_pesanan'           => 'required',
            'nominal'              => 'required|numeric',
            'metode_pembayaran'    => 'nullable|string|max:100',
            'status_pembayaran'    => 'required',
            'tanggal_pembayaran'   => 'nullable',
            'bukti_transfer'       => 'nullable|image|mimes:jpg,jpeg,png',
            'catatan'              => 'nullable'
        ]);

        $bukti = null;

        if ($request->hasFile('bukti_transfer')) {

            $bukti = $request
                ->file('bukti_transfer')
                ->store('pembayaran', 'public');
        }

        Pembayaran::create([

            'id_pesanan'         => $request->id_pesanan,

            'id_user_input'      => Auth::user()->id_user,

            'nominal'            => $request->nominal,

            'metode_pembayaran'  => $request->metode_pembayaran,

            'status_pembayaran'  => $request->status_pembayaran,

            'tanggal_pembayaran' => $request->tanggal_pembayaran,

            'bukti_transfer'     => $bukti,

            'catatan'            => $request->catatan

        ]);

        return redirect()
            ->route('pembayaran.index')
            ->with('success', 'Data pembayaran berhasil ditambahkan');
    }

    /**
     * =========================
     * EDIT
     * =========================
     */
    public function edit($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        $pesanan = Pesanan::with('customer')
            ->orderBy('created_at', 'desc')
            ->get();

        return view(
            'backend.pembayaran.edit',
            compact(
                'pembayaran',
                'pesanan'
            )
        );
    }

    /**
     * =========================
     * UPDATE
     * =========================
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_pesanan'           => 'required',
            'nominal'              => 'required|numeric',
            'metode_pembayaran'    => 'nullable|string|max:100',
            'status_pembayaran'    => 'required',
            'tanggal_pembayaran'   => 'nullable',
            'bukti_transfer'       => 'nullable|image|mimes:jpg,jpeg,png',
            'catatan'              => 'nullable'
        ]);

        $pembayaran = Pembayaran::findOrFail($id);

        $bukti = $pembayaran->bukti_transfer;

        if ($request->hasFile('bukti_transfer')) {

            if ($pembayaran->bukti_transfer &&
                Storage::disk('public')->exists($pembayaran->bukti_transfer)) {

                Storage::disk('public')
                    ->delete($pembayaran->bukti_transfer);
            }

            $bukti = $request
                ->file('bukti_transfer')
                ->store('pembayaran', 'public');
        }

        $pembayaran->update([

            'id_pesanan'         => $request->id_pesanan,

            'nominal'            => $request->nominal,

            'metode_pembayaran'  => $request->metode_pembayaran,

            'status_pembayaran'  => $request->status_pembayaran,

            'tanggal_pembayaran' => $request->tanggal_pembayaran,

            'bukti_transfer'     => $bukti,

            'catatan'            => $request->catatan

        ]);

        return redirect()
            ->route('pembayaran.index')
            ->with('success', 'Data pembayaran berhasil diupdate');
    }

    /**
     * =========================
     * DELETE
     * =========================
     */
    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        if ($pembayaran->bukti_transfer &&
            Storage::disk('public')->exists($pembayaran->bukti_transfer)) {

            Storage::disk('public')
                ->delete($pembayaran->bukti_transfer);
        }

        $pembayaran->delete();

        return redirect()
            ->route('pembayaran.index')
            ->with('success', 'Data pembayaran berhasil dihapus');
    }
}