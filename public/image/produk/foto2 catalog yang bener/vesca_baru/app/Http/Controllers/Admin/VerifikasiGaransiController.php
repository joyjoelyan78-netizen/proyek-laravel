<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\VerifikasiGaransi;
use App\Models\KlaimGaransi;
use App\Models\Teknisi;

class VerifikasiGaransiController extends Controller
{
    /**
     * =========================
     * INDEX
     * =========================
     */
    public function index()
    {
        $verifikasi = VerifikasiGaransi::with([
            'klaim.customer',
            'klaim.produk',
            'teknisi',
            'user'
        ])
        ->latest('tanggal_verifikasi')
        ->get();

        return view(
            'backend.verifikasi-garansi.index',
            compact('verifikasi')
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
                'serial.produk'
            ])
            ->where('status_klaim', 'diterima')
            ->doesntHave('verifikasi')
            ->get();

        $teknisi = Teknisi::where(
            'status_teknisi',
            'aktif'
        )->get();

        return view(
            'backend.verifikasi-garansi.create',
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
            'id_klaim'          => 'required',
            'id_teknisi'        => 'required',
            'garansi_mulai'     => 'required|date',
            'tanggal_kunjungan' => 'required|date',
            'jam_kunjungan'     => 'required',
            'status_kunjungan'  => 'required',
        ]);

        // Cegah jadwal ganda
        $cek = VerifikasiGaransi::where(
            'id_klaim',
            $request->id_klaim
        )->exists();

        if ($cek) {
            return back()->with(
                'error',
                'Klaim ini sudah memiliki jadwal verifikasi.'
            );
        }

        VerifikasiGaransi::create([
            'id_klaim'            => $request->id_klaim,
            'id_teknisi'          => $request->id_teknisi,
            'id_user_verifikasi'  => auth()->user()->id_user,

            'tanggal_verifikasi'  => now(),

            'garansi_mulai'       => $request->garansi_mulai,

            // Menunggu hasil teknisi
            'status_verifikasi'   => null,

            'catatan_verifikasi'  => $request->catatan_verifikasi,

            'tanggal_kunjungan'   => $request->tanggal_kunjungan,
            'jam_kunjungan'       => $request->jam_kunjungan,
            'status_kunjungan'    => $request->status_kunjungan,

            'hasil_pemeriksaan'   => null,
        ]);

        KlaimGaransi::where(
            'id_klaim',
            $request->id_klaim
        )->update([
            'status_klaim' => 'diproses'
        ]);

        return redirect()
            ->route('verifikasi-garansi.index')
            ->with(
                'success',
                'Jadwal kunjungan teknisi berhasil dibuat.'
            );
    }

    /**
     * =========================
     * EDIT
     * =========================
     */
    public function edit($id)
    {
        $verifikasi = VerifikasiGaransi::findOrFail($id);

        $klaim = KlaimGaransi::with([
            'customer',
            'serial.produk'
        ])->get();

        $teknisi = Teknisi::all();

        return view(
            'backend.verifikasi-garansi.edit',
            compact(
                'verifikasi',
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
    public function update(Request $request, $id)
    {
        $verifikasi = VerifikasiGaransi::findOrFail($id);

        $request->validate([
            'id_klaim' => 'required',
            'id_teknisi' => 'required',
        ]);

        $verifikasi->update([
            'id_klaim'            => $request->id_klaim,
            'id_teknisi'          => $request->id_teknisi,

            'garansi_mulai'       => $request->garansi_mulai,

            'status_verifikasi'   => $request->status_verifikasi,
            'catatan_verifikasi'  => $request->catatan_verifikasi,

            'tanggal_kunjungan'   => $request->tanggal_kunjungan,
            'jam_kunjungan'       => $request->jam_kunjungan,
            'status_kunjungan'    => $request->status_kunjungan,

            'hasil_pemeriksaan'   => $request->hasil_pemeriksaan,
        ]);

        // Klaim diterima
        if ($request->status_verifikasi == 'valid') {

            $verifikasi->klaim->update([
                'status_klaim' => 'selesai'
            ]);
        
            if ($verifikasi->klaim->tiket) {
                $verifikasi->klaim->tiket->update([
                    'status_tiket' => 'selesai'
                ]);
            }
        
            if ($verifikasi->klaim->serial) {
                $verifikasi->klaim->serial->update([
                    'status_klaim'   => 'selesai',
                    'status_garansi' => 'expired'
                ]);
            }
        
        }
        elseif ($request->status_verifikasi == 'tidak_valid') {
        
            $verifikasi->klaim->update([
                'status_klaim' => 'ditolak'
            ]);
        
            if ($verifikasi->klaim->tiket) {
                $verifikasi->klaim->tiket->update([
                    'status_tiket' => 'ditolak'
                ]);
            }
        
            if ($verifikasi->klaim->serial) {
                $verifikasi->klaim->serial->update([
                    'status_klaim' => 'aktif'
                ]);
            }
        }

        return redirect()
            ->route('verifikasi-garansi.index')
            ->with(
                'success',
                'Verifikasi berhasil diupdate'
            );
    }

    /**
     * =========================
     * DELETE
     * =========================
     */
    public function destroy($id)
    {
        $verifikasi = VerifikasiGaransi::findOrFail($id);

        $verifikasi->delete();

        return redirect()
            ->route('verifikasi-garansi.index')
            ->with(
                'success',
                'Verifikasi berhasil dihapus'
            );
    }
}