<?php

namespace App\Observers;

use App\Models\Produk;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ProdukObserver
{
    public function created(Produk $produk)
    {
        ActivityLog::create([
            'id_user'       => Auth::id(),
            'aktivitas'     => 'Menambahkan produk',
            'tabel_terkait' => 'produk',
            'id_data'       => $produk->id_produk,
            'ip_address'    => request()->ip(),
            'created_at'    => now()
        ]);
    }

    public function updated(Produk $produk)
    {
        ActivityLog::create([
            'id_user'       => Auth::id(),
            'aktivitas'     => 'Mengupdate produk',
            'tabel_terkait' => 'produk',
            'id_data'       => $produk->id_produk,
            'ip_address'    => request()->ip(),
            'created_at'    => now()
        ]);
    }

    public function deleted(Produk $produk)
    {
        ActivityLog::create([
            'id_user'       => Auth::id(),
            'aktivitas'     => 'Menghapus produk',
            'tabel_terkait' => 'produk',
            'id_data'       => $produk->id_produk,
            'ip_address'    => request()->ip(),
            'created_at'    => now()
        ]);
    }
}