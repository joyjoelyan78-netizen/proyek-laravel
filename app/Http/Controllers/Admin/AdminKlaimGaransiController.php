<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\KlaimGaransi;
use App\Models\Customer;
use App\Models\Produk;
use App\Models\SerialProduk;
use App\Models\TiketTeknisi;

class AdminKlaimGaransiController extends Controller
{
    /**
     * =========================
     * INDEX
     * =========================
     */
    public function index()
    {
        $klaim = KlaimGaransi::with(['customer', 'produk', 'serial', 'tiket', 'uploadFoto'])
            ->latest('created_at')
            ->get();

        return view('backend.klaim-garansi.index', compact('klaim'));
    }

    /**
     * =========================
     * DETAIL — lihat data klaim dari frontend
     * =========================
     */
    public function detail($id)
    {
        $klaim = KlaimGaransi::with(['serial.produk', 'tiket', 'uploadFoto'])
            ->findOrFail($id);

        return view('backend.klaim-garansi.detail', compact('klaim'));
    }

    /**
     * =========================
     * TERIMA — admin setujui klaim
     * =========================
     */
    public function terima($id)
    {
        $klaim = KlaimGaransi::with(['serial', 'tiket'])->findOrFail($id);

        // Update status klaim
        $klaim->update([
            'status_klaim' => 'diterima'
        ]);

        // Update tiket
        if ($klaim->tiket) {
            $klaim->tiket->update([
                'status_tiket' => 'diproses'
            ]);
        }

        // Update serial produk
        if ($klaim->serial) {
            $klaim->serial->update([
                'status_klaim' => 'diklaim'
            ]);
        }

        return redirect()
            ->route('klaim-garansi.detail', $id)
            ->with('success', 'Klaim garansi berhasil diterima.');
    }

    /**
     * =========================
     * TOLAK — admin tolak klaim
     * =========================
     */
    public function tolak(Request $request, $id)
    {
        $request->validate([
            'alasan_tolak' => 'required|string|max:500',
        ]);

        $klaim = KlaimGaransi::with([
            'serial',
            'tiket'
        ])->findOrFail($id);

        $klaim->update([
            'status_klaim' => 'ditolak',
            'alasan_tolak' => $request->alasan_tolak,
        ]);

        // Update status tiket jika ada
        if ($klaim->tiket) {
            $klaim->tiket->update([
                'status_tiket' => 'ditolak'
            ]);
        }

        // Klaim ditolak, produk boleh diajukan lagi
        if ($klaim->serial) {

            $klaim->serial->update([
                'status_klaim' => 'belum'
            ]);
        
        }

        return redirect()
            ->route('klaim-garansi.detail', $id)
            ->with(
                'success',
                'Klaim garansi berhasil ditolak.'
            );
    }

    /**
     * =========================
     * CREATE
     * =========================
     */
    public function create()
    {
        $customer = Customer::orderBy('nama_customer', 'asc')->get();
        $produk   = Produk::orderBy('nama_produk', 'asc')->get();
        $serial   = SerialProduk::orderBy('kode_unik', 'asc')->get();

        return view('backend.klaim-garansi.create', compact('customer', 'produk', 'serial'));
    }

    /**
     * =========================
     * STORE
     * =========================
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_customer' => 'required',
            'id_produk'   => 'required',
            'id_serial'   => 'required|unique:klaim_garansi,id_serial',
            'status_klaim'=> 'required',
        ]);

        KlaimGaransi::create([
            'id_customer'       => $request->id_customer,
            'id_produk'         => $request->id_produk,
            'id_serial'         => $request->id_serial,
            'tanggal_pengajuan' => now(),
            'status_klaim'      => $request->status_klaim,
            'perhatian'         => $request->perhatian,
        ]);

        return redirect()->route('klaim-garansi.index')->with('success', 'Klaim garansi berhasil ditambahkan');
    }

    /**
     * =========================
     * EDIT
     * =========================
     */
    public function edit($id)
    {
        $klaim    = KlaimGaransi::findOrFail($id);
        $customer = Customer::all();
        $produk   = Produk::all();
        $serial   = SerialProduk::all();

        return view('backend.klaim-garansi.edit', compact('klaim', 'customer', 'produk', 'serial'));
    }

    /**
     * =========================
     * UPDATE
     * =========================
     */
    public function update(Request $request, $id)
    {
        $klaim = KlaimGaransi::findOrFail($id);

        $request->validate([
            'id_customer' => 'required',
            'id_produk'   => 'required',
            'id_serial'   => 'required',
            'status_klaim'=> 'required',
        ]);

        $klaim->update([
            'id_customer'  => $request->id_customer,
            'id_produk'    => $request->id_produk,
            'id_serial'    => $request->id_serial,
            'status_klaim' => $request->status_klaim,
            'perhatian'    => $request->perhatian,
        ]);

        return redirect()->route('klaim-garansi.index')->with('success', 'Klaim berhasil diupdate');
    }

    /**
     * =========================
     * DELETE
     * =========================
     */
    public function destroy($id)
    {
        $klaim = KlaimGaransi::findOrFail($id);
        $klaim->delete();

        return redirect()->route('klaim-garansi.index')->with('success', 'Klaim berhasil dihapus');
    }
}