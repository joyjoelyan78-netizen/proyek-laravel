<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrackingPesanan;
use App\Models\Pesanan;
use App\Models\StatusTracking;
use App\Models\SerialProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackingPesananController extends Controller
{
    /**
     * =========================================================
     * INDEX
     * =========================================================
     */
    public function index()
    {
        $tracking = TrackingPesanan::with([
            'pesanan',
            'statusTracking',
            'user'
        ])
        ->orderBy('created_at', 'desc')
        ->get();

        return view(
            'backend.tracking.index',
            compact('tracking')
        );
    }

    /**
     * =========================================================
     * CREATE
     * =========================================================
     */
    public function create()
    {
        $pesanan = Pesanan::orderBy(
            'created_at',
            'desc'
        )->get();

        $statusTracking = StatusTracking::orderBy(
            'urutan',
            'asc'
        )->get();

        return view(
            'backend.tracking.create',
            compact(
                'pesanan',
                'statusTracking'
            )
        );
    }

    /**
     * =========================================================
     * STORE
     * =========================================================
     */
    public function store(Request $request)
    {
        $request->validate([

            'id_pesanan'         => 'required',

            'id_status_tracking' => 'required',

            'status'             => 'required',

            'tanggal_mulai'      => 'nullable',

            'tanggal_selesai'    => 'nullable',

            'estimasi_selesai'   => 'nullable',

            'deskripsi'          => 'nullable',

            'pic'                => 'nullable|max:100'

        ]);

        /*
        |----------------------------------------------------------------------
        | SIMPAN TRACKING
        |----------------------------------------------------------------------
        */

        $tracking = TrackingPesanan::create([

            'id_pesanan'         => $request->id_pesanan,

            'id_status_tracking' => $request->id_status_tracking,

            'id_user_update'     => Auth::user()->id_user,

            'status'             => $request->status,

            'tanggal_mulai'      => $request->tanggal_mulai,

            'tanggal_selesai'    => $request->tanggal_selesai,

            'estimasi_selesai'   => $request->estimasi_selesai,

            'deskripsi'          => $request->deskripsi,

            'pic'                => $request->pic

        ]);

        /*
        |----------------------------------------------------------------------
        | CEK STATUS TRACKING
        |----------------------------------------------------------------------
        |
        | Garansi aktif jika:
        | 1. status tracking = selesai
        | 2. nama status tracking mengandung "diterima"
        |
        */

        $statusTracking = StatusTracking::find(
            $request->id_status_tracking
        );

        $namaStatus = strtolower(
            $statusTracking->nama_status ?? ''
        );

        $trackingSelesai = $request->status == 'selesai';

        $sudahDiterima = str_contains(
            $namaStatus,
            'diterima'
        );

        /*
        |----------------------------------------------------------------------
        | AKTIFKAN GARANSI OTOMATIS
        |----------------------------------------------------------------------
        */

        if ($trackingSelesai && $sudahDiterima) {

            SerialProduk::where(

                'id_pesanan',
                $tracking->id_pesanan

            )->update([

                /*
                |--------------------------------------------------------------
                | STATUS AKTIVASI
                |--------------------------------------------------------------
                */

                'status_aktivasi' => 'aktif',

                /*
                |--------------------------------------------------------------
                | STATUS GARANSI
                |--------------------------------------------------------------
                */

                'status_garansi'  => 'aktif',

                /*
                |--------------------------------------------------------------
                | TANGGAL AKTIVASI
                |--------------------------------------------------------------
                */

                'tanggal_aktivasi' => now(),

                /*
                |--------------------------------------------------------------
                | MASA BERLAKU GARANSI
                |--------------------------------------------------------------
                */

                'masa_berlaku_sampai' => now()->addYear()

            ]);
        }

        return redirect()
            ->route('tracking-pesanan.index')
            ->with(
                'success',
                'Tracking pesanan berhasil ditambahkan'
            );
    }

    /**
     * =========================================================
     * EDIT
     * =========================================================
     */
    public function edit($id)
    {
        $tracking = TrackingPesanan::findOrFail($id);

        $pesanan = Pesanan::orderBy(
            'created_at',
            'desc'
        )->get();

        $statusTracking = StatusTracking::orderBy(
            'urutan',
            'asc'
        )->get();

        return view(
            'backend.tracking.edit',
            compact(
                'tracking',
                'pesanan',
                'statusTracking'
            )
        );
    }

    /**
     * =========================================================
     * UPDATE
     * =========================================================
     */
    public function update(Request $request, $id)
    {
        $request->validate([

            'id_pesanan'         => 'required',

            'id_status_tracking' => 'required',

            'status'             => 'required',

            'tanggal_mulai'      => 'nullable',

            'tanggal_selesai'    => 'nullable',

            'estimasi_selesai'   => 'nullable',

            'deskripsi'          => 'nullable',

            'pic'                => 'nullable|max:100'

        ]);

        $tracking = TrackingPesanan::findOrFail($id);

        /*
        |----------------------------------------------------------------------
        | UPDATE TRACKING
        |----------------------------------------------------------------------
        */

        $tracking->update([

            'id_pesanan'         => $request->id_pesanan,

            'id_status_tracking' => $request->id_status_tracking,

            'status'             => $request->status,

            'tanggal_mulai'      => $request->tanggal_mulai,

            'tanggal_selesai'    => $request->tanggal_selesai,

            'estimasi_selesai'   => $request->estimasi_selesai,

            'deskripsi'          => $request->deskripsi,

            'pic'                => $request->pic

        ]);

        /*
        |----------------------------------------------------------------------
        | CEK STATUS TRACKING
        |----------------------------------------------------------------------
        */

        $statusTracking = StatusTracking::find(
            $request->id_status_tracking
        );

        $namaStatus = strtolower(
            $statusTracking->nama_status ?? ''
        );

        $trackingSelesai = $request->status == 'selesai';

        $sudahDiterima = str_contains(
            $namaStatus,
            'diterima'
        );

        /*
        |----------------------------------------------------------------------
        | AKTIFKAN GARANSI OTOMATIS
        |----------------------------------------------------------------------
        */

        if ($trackingSelesai && $sudahDiterima) {

            SerialProduk::where(

                'id_pesanan',
                $tracking->id_pesanan

            )->update([

                'status_aktivasi' => 'aktif',

                'status_garansi'  => 'aktif',

                'tanggal_aktivasi' => now(),

                'masa_berlaku_sampai' => now()->addYear()

            ]);
        }

        return redirect()
            ->route('tracking-pesanan.index')
            ->with(
                'success',
                'Tracking pesanan berhasil diupdate'
            );
    }

    /**
     * =========================================================
     * DELETE
     * =========================================================
     */
    public function destroy($id)
    {
        $tracking = TrackingPesanan::findOrFail($id);

        $tracking->delete();

        return redirect()
            ->route('tracking-pesanan.index')
            ->with(
                'success',
                'Tracking pesanan berhasil dihapus'
            );
    }
}