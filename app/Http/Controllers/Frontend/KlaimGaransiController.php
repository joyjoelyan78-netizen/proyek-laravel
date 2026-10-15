<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SerialProduk;
use App\Models\KlaimGaransi;
use App\Models\UploadFoto;
use App\Models\TiketTeknisi;

use Illuminate\Support\Str;

class KlaimGaransiController extends Controller
{

    // -------------------------------------------------------------------------
    // HELPER — eager load yang dipakai berulang
    // -------------------------------------------------------------------------

    private function withRelasi()
    {
        return KlaimGaransi::with([
            'serial.produk',
            'tiket',
            'uploadFoto',
            'verifikasi.teknisi'
        ]);
    }


    // -------------------------------------------------------------------------
    // STEP 1 — Halaman input kode unik
    // -------------------------------------------------------------------------

    public function index()
    {
        return view('frontend.klaim.index');
    }


    // -------------------------------------------------------------------------
    // STEP 1 — POST: cek kode unik
    //
    // Alur:
    // 1. Kode tidak ada           → error balik ke form
    // 2. Garansi tidak aktif      → error balik ke form
    // 3. Sudah pernah klaim:
    //    - status selesai/aktif/verified → redirect ke halaman HASIL
    //    - status pending                → redirect ke halaman TIKET
    //    - status ditolak                → hapus klaim lama, tampil detail produk
    // 4. Belum pernah klaim       → tampil detail produk
    // -------------------------------------------------------------------------

    public function cekKode(Request $request)
    {
        $request->validate([
            'kode_unik' => 'required|string',
        ]);

        $serial = SerialProduk::with([
            'produk',
            'customer',
            'pesanan'
        ])
        ->where('kode_unik', $request->kode_unik)
        ->first();

        if (!$serial) {
            return back()->with(
                'error',
                'Kode unik tidak ditemukan.'
            );
        }

        // CEK DULU APAKAH SUDAH ADA KLAIM
        $klaim = KlaimGaransi::with([
            'serial.produk',
            'tiket',
            'uploadFoto',
            'verifikasi.teknisi'
        ])
        ->where('id_serial', $serial->id_serial)
        ->latest()
        ->first();

        if ($klaim) {

            if ($klaim->status_klaim == 'selesai') {
        
                return redirect()->route(
                    'klaim.garansi.hasil',
                    $klaim->id_klaim
                );
            }
        
            if (in_array($klaim->status_klaim, [
                'pending',
                'diterima',
                'diproses'
            ])) {
        
                return redirect()->route(
                    'klaim.garansi.tiket',
                    $klaim->id_klaim
                );
            }
        
            // Jika klaim ditolak, hapus riwayat klaim lama
            // dan izinkan user mengajukan ulang
        
            if ($klaim->status_klaim == 'ditolak') {

                return view(
                    'frontend.klaim.detail',
                    compact('serial')
                )->with(
                    'error',
                    'Klaim sebelumnya ditolak. Silakan ajukan klaim kembali.'
                );
            }
        }

        // BARU CEK STATUS GARANSI
        if ($serial->status_garansi !== 'aktif') {

            return back()->with(
                'error',
                'Garansi produk tidak aktif.'
            );
        }

        return view(
            'frontend.klaim.detail',
            compact('serial')
        );
    }


    // -------------------------------------------------------------------------
    // STEP 2 — GET: tampil form klaim
    // -------------------------------------------------------------------------

    public function form($kode)
    {
        $serial = SerialProduk::with(['produk', 'customer', 'pesanan'])
            ->where('kode_unik', $kode)
            ->firstOrFail();

        return view('frontend.klaim.form', compact('serial'));
    }


    // -------------------------------------------------------------------------
    // STEP 2 — POST: proses klaim, cek nama, buat tiket jika valid
    // -------------------------------------------------------------------------

    public function store(Request $request)
    {
        $request->validate([
            'id_serial'     => 'required|integer',
            'kode_unik'     => 'required|string',
            'nama_pembeli'  => 'required|string',
            'email'         => 'required|email',
            'nomor_telepon' => 'required|string',
            'foto_bukti'    => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        // Ambil serial
        $serial = SerialProduk::with(['customer', 'produk'])
            ->findOrFail($request->id_serial);

        // Validasi kode unik cocok
        if ($serial->kode_unik !== $request->kode_unik) {
            return back()->with('error', 'Kode unik tidak sesuai.');
        }

        // Cegah double klaim (hanya blok jika status bukan ditolak)
        $klaimAda = KlaimGaransi::where(
            'id_serial',
            $serial->id_serial
        )
        ->latest()
        ->first();
        
        if ($klaimAda) {
        
            if (
                in_array(
                    $klaimAda->status_klaim,
                    [
                        'pending',
                        'diterima',
                        'diproses',
                        'selesai'
                    ]
                )
            ) {
                return back()->with(
                    'error',
                    'Produk ini sudah memiliki pengajuan klaim garansi.'
                );
            }
        }

        // Bandingkan nama pembeli dengan nama di invoice
        $namaInvoice = strtolower(trim($serial->customer->nama_customer));
        $namaInput   = strtolower(trim($request->nama_pembeli));
        $namaSesuai  = ($namaInvoice === $namaInput);

        if (!$namaSesuai) {

    return back()
        ->withInput()
        ->with(
            'error',
            'Nama pembeli tidak sesuai dengan nama pada invoice. Silakan periksa kembali.'
        );
}

        // Upload foto bukti
        $pathFoto = $request->file('foto_bukti')->store('klaim-garansi', 'public');

        // Simpan data klaim
        $klaim = KlaimGaransi::create([
            'id_serial'         => $serial->id_serial,
            'id_customer'       => $serial->id_customer,
            'id_produk'         => $serial->id_produk,
            'nama_pembeli'      => $request->nama_pembeli,
            'email'             => $request->email,
            'nomor_telepon'     => $request->nomor_telepon,
            'judul_keluhan'     => 'Klaim Garansi Produk',
            'deskripsi_keluhan' => 'Klaim garansi dari customer',
            'status_klaim'      => 'pending',
            'tanggal_klaim'     => now(),
        ]);

        // Simpan foto
        UploadFoto::create([
            'id_klaim'  => $klaim->id_klaim,
            'file_foto' => $pathFoto,
        ]);

        // Jika nama sesuai → buat tiket & update status serial
        if ($namaSesuai) {

            TiketTeknisi::create([
                'id_klaim'     => $klaim->id_klaim,
                'nomor_tiket'  => 'TKT-' . strtoupper(Str::random(10)),
                'status_tiket' => 'diterima',
            ]);

            $serial->update([
                'status_klaim' => 'pending'
            ]);
        }

        // Redirect ke halaman tiket (sukses atau gagal)
        return redirect()->route('klaim.garansi.tiket', $klaim->id_klaim);
    }


    // -------------------------------------------------------------------------
    // STEP 3 — GET: halaman tiket
    // Tampil setelah submit form, atau kalau sudah pernah klaim
    // tapi admin belum verifikasi (status pending / ditolak)
    // -------------------------------------------------------------------------

    public function tiket($id)
    {
        $klaim = $this->withRelasi()->findOrFail($id);

        return view('frontend.klaim.tiket', compact('klaim'));
    }


    // -------------------------------------------------------------------------
    // STEP 4 — GET: halaman hasil verifikasi
    // Tampil setelah admin verifikasi (status selesai / aktif / verified)
    // -------------------------------------------------------------------------

    public function hasil($id)
    {
        $klaim = KlaimGaransi::with([
            'serial.produk',
            'tiket',
            'uploadFoto',
            'verifikasi.teknisi'
        ])->findOrFail($id);

        return view('frontend.klaim.hasil', compact('klaim'));
    }

}