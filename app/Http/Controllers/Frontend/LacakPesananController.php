<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pesanan;
use App\Models\TrackingPesanan;

class LacakPesananController extends Controller
{
    /*
    |------------------------------------------------------------------
    | HALAMAN INPUT INVOICE
    |------------------------------------------------------------------
    */

    public function index()
    {
        return view('frontend.lacak.index');
    }

    /*
    |------------------------------------------------------------------
    | CARI INVOICE
    |------------------------------------------------------------------
    */

    public function cari(Request $request)
    {
        $request->validate([

            'nomor_invoice' =>
                'required'

        ]);

        $pesanan = Pesanan::where(
            'nomor_invoice',
            $request->nomor_invoice
        )->first();

        if (!$pesanan) {

            return back()->with(
                'error',
                'Nomor invoice tidak ditemukan'
            );
        }

        return redirect()->route(
            'lacak-pesanan.show',
            $pesanan->nomor_invoice
        );
    }

    /*
    |------------------------------------------------------------------
    | DETAIL TRACKING
    |------------------------------------------------------------------
    */

    public function show($invoice)
    {
        /*
        |--------------------------------------------------------------------------
        | DATA PESANAN
        |--------------------------------------------------------------------------
        */

        $pesanan = Pesanan::with([

            'customer'

        ])
        ->where(
            'nomor_invoice',
            $invoice
        )
        ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | SEMUA MASTER STATUS TRACKING
        |--------------------------------------------------------------------------
        */

        $statusTracking = \App\Models\StatusTracking::orderBy(
            'urutan',
            'asc'
        )->get();

        /*
        |--------------------------------------------------------------------------
        | TRACKING PESANAN YANG SUDAH ADA
        |--------------------------------------------------------------------------
        */

        $trackingPesanan = TrackingPesanan::with(
            'statusTracking'
        )
        ->where(
            'id_pesanan',
            $pesanan->id_pesanan
        )
        ->get()
        ->keyBy('id_status_tracking');

        /*
        |--------------------------------------------------------------------------
        | HITUNG PROGRESS
        |--------------------------------------------------------------------------
        */

        $totalTahapan = $statusTracking->count();

        $selesai = $trackingPesanan
            ->where('status', 'selesai')
            ->count();

        $progress = 0;

        if ($totalTahapan > 0) {

            $progress = round(
                ($selesai / $totalTahapan) * 100
            );
        }

        /*
        |--------------------------------------------------------------------------
        | KIRIM KE VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'frontend.lacak.show',
            compact(
                'pesanan',
                'statusTracking',
                'trackingPesanan',
                'progress'
            )
        );
    }
}