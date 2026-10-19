<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KonsultasiTeknis;
use App\Models\PermintaanPenawaran;

class DashboardController extends Controller
{
    public function index()
    {
        return view('backend.dashboard.dashboard', [

            'penawaranBaru'   => PermintaanPenawaran::where('status', 'baru')->count(),
            'penawaranTotal'  => PermintaanPenawaran::count(),
            'konsultasiBaru'  => KonsultasiTeknis::where('status', 'baru')->count(),
            'konsultasiTotal' => KonsultasiTeknis::count(),

            'penawaranTerbaru'  => PermintaanPenawaran::latest('id_penawaran')->take(5)->get(),
            'konsultasiTerbaru' => KonsultasiTeknis::latest('id_konsultasi')->take(5)->get(),
        ]);
    }
}
