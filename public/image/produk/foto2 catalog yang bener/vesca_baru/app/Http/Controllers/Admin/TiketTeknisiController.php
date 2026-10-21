<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\TiketTeknisi;
use App\Models\KlaimGaransi;
use App\Models\Teknisi;

class TiketTeknisiController extends Controller
{
    /**
     * =========================
     * INDEX
     * =========================
     */

    public function index()
    {
        $tiket = TiketTeknisi::with([
            'klaim.customer',
            'klaim.produk',
            'teknisi'
        ])
        ->latest('created_at')
        ->get();

        return view(
            'backend.tiket-teknisi.index',
            compact('tiket')
        );
    }

    /**
     * =========================
     * CREATE
     * =========================
     */

    public function create()
    {
        $klaim = KlaimGaransi::with([
            'customer',
            'produk'
        ])->get();

        $teknisi = Teknisi::orderBy(
            'nama_teknisi',
            'asc'
        )->get();

        return view(
            'backend.tiket-teknisi.create',
            compact(
                'klaim',
                'teknisi'
            )
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
            'id_klaim' => 'required|unique:tiket_teknisi,id_klaim',
            'nomor_tiket' => 'required|unique:tiket_teknisi,nomor_tiket',
            'status_tiket' => 'required'
        ]);

        TiketTeknisi::create([
            'id_klaim' => $request->id_klaim,
            'nomor_tiket' => $request->nomor_tiket,
            'id_teknisi' => $request->id_teknisi,
            'estimasi_kunjungan' => $request->estimasi_kunjungan,
            'status_tiket' => $request->status_tiket,
            'created_at' => now()
        ]);

        return redirect()
            ->route('tiket-teknisi.index')
            ->with(
                'success',
                'Tiket teknisi berhasil dibuat'
            );
    }

    /**
     * =========================
     * EDIT
     * =========================
     */

    public function edit($id)
    {
        $tiket = TiketTeknisi::findOrFail($id);

        $klaim = KlaimGaransi::with([
            'customer',
            'produk'
        ])->get();

        $teknisi = Teknisi::all();

        return view(
            'backend.tiket-teknisi.edit',
            compact(
                'tiket',
                'klaim',
                'teknisi'
            )
        );
    }

    /**
     * =========================
     * UPDATE
     * =========================
     */

    public function update(
        Request $request,
        $id
    ) {

        $tiket = TiketTeknisi::findOrFail($id);

        $request->validate([
            'id_klaim' => 'required',
            'nomor_tiket' => 'required',
            'status_tiket' => 'required'
        ]);

        $tiket->update([
            'id_klaim' => $request->id_klaim,
            'nomor_tiket' => $request->nomor_tiket,
            'id_teknisi' => $request->id_teknisi,
            'estimasi_kunjungan' => $request->estimasi_kunjungan,
            'status_tiket' => $request->status_tiket
        ]);

        return redirect()
            ->route('tiket-teknisi.index')
            ->with(
                'success',
                'Tiket berhasil diupdate'
            );
    }

    /**
     * =========================
     * DELETE
     * =========================
     */

    public function destroy($id)
    {
        $tiket = TiketTeknisi::findOrFail($id);

        $tiket->delete();

        return redirect()
            ->route('tiket-teknisi.index')
            ->with(
                'success',
                'Tiket berhasil dihapus'
            );
    }
}