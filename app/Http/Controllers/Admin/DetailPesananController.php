<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\DetailPesanan;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\SerialProduk;

class DetailPesananController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $detail = DetailPesanan::with([
            'pesanan',
            'produk'
        ])
        ->orderBy('id_detail', 'desc')
        ->get();

        return view(
            'backend.detail-pesanan.index',
            compact('detail')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $pesanan = Pesanan::orderBy(
            'created_at',
            'desc'
        )->get();

        $produk = Produk::orderBy(
            'nama_produk',
            'asc'
        )->get();

        return view(
            'backend.detail-pesanan.create',
            compact(
                'pesanan',
                'produk'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'id_pesanan'     => 'required',

            'id_produk.*'    => 'required',

            'qty.*'          => 'required|integer|min:1',

            'harga.*'        => 'required|numeric',

        ]);

        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA PESANAN
        |--------------------------------------------------------------------------
        */

        $pesanan = Pesanan::findOrFail(
            $request->id_pesanan
        );

        /*
        |--------------------------------------------------------------------------
        | LOOP SEMUA PRODUK
        |--------------------------------------------------------------------------
        */

        foreach ($request->id_produk as $index => $produk) {

            $qty = $request->qty[$index];

            $harga = $request->harga[$index];

            $berat =
                $request->berat_per_unit[$index] ?? 0;

            /*
            |--------------------------------------------------------------------------
            | SIMPAN DETAIL PESANAN
            |--------------------------------------------------------------------------
            */

            $detail = DetailPesanan::create([

                'id_pesanan' =>
                    $request->id_pesanan,

                'id_produk' =>
                    $produk,

                'qty' =>
                    $qty,

                'harga' =>
                    $harga,

                'subtotal' =>
                    $qty * $harga,

                'berat_per_unit' =>
                    $berat,

                'total_berat' =>
                    $qty * $berat,

            ]);

            /*
            |--------------------------------------------------------------------------
            | GENERATE SERIAL PRODUK OTOMATIS
            |--------------------------------------------------------------------------
            */

            for ($i = 1; $i <= $qty; $i++) {

                SerialProduk::create([

                    'id_produk' =>
                        $produk,

                    'id_customer' =>
                        $pesanan->id_customer,

                    'id_pesanan' =>
                        $pesanan->id_pesanan,

                    'id_detail_pesanan' =>
                        $detail->id_detail,

                    /*
                    |--------------------------------------------------------------------------
                    | KODE UNIK
                    |--------------------------------------------------------------------------
                    */

                    'kode_unik' =>

                        'VSCA-' .

                        strtoupper(

                            substr(
                                md5(
                                    uniqid(mt_rand(), true)
                                ),
                                0,
                                12
                            )

                        ),

                    /*
                    |--------------------------------------------------------------------------
                    | DEFAULT GARANSI
                    |--------------------------------------------------------------------------
                    */

                    'status_aktivasi' =>
                        'belum',

                    'status_klaim' =>
                        'belum',

                    'status_garansi' =>
                        'belum',

                    'tanggal_aktivasi' =>
                        null,

                    'tanggal_klaim' =>
                        null,

                    'masa_berlaku_sampai' =>
                        null,

                ]);

            }

        }

        return redirect()
            ->route('detail-pesanan.index')
            ->with(
                'success',
                'Detail pesanan berhasil ditambahkan'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $detail = DetailPesanan::findOrFail($id);

        $pesanan = Pesanan::all();

        $produk = Produk::all();

        return view(
            'backend.detail-pesanan.edit',
            compact(
                'detail',
                'pesanan',
                'produk'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $detail = DetailPesanan::findOrFail($id);

        $request->validate([

            'id_pesanan' =>
                'required',

            'id_produk' =>
                'required',

            'qty' =>
                'required|integer|min:1',

            'harga' =>
                'required|numeric',

        ]);

        $berat =
            $request->berat_per_unit ?? 0;

        /*
        |--------------------------------------------------------------------------
        | UPDATE DETAIL PESANAN
        |--------------------------------------------------------------------------
        */

        $detail->update([

            'id_pesanan' =>
                $request->id_pesanan,

            'id_produk' =>
                $request->id_produk,

            'qty' =>
                $request->qty,

            'harga' =>
                $request->harga,

            'subtotal' =>
                $request->qty * $request->harga,

            'berat_per_unit' =>
                $berat,

            'total_berat' =>
                $request->qty * $berat,

        ]);

        /*
        |--------------------------------------------------------------------------
        | NOTE:
        |--------------------------------------------------------------------------
        |
        | TIDAK generate ulang serial produk
        | agar tidak duplicate serial.
        |
        */

        return redirect()
            ->route('detail-pesanan.index')
            ->with(
                'success',
                'Detail pesanan berhasil diupdate'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $detail = DetailPesanan::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | HAPUS SERIAL TERKAIT
        |--------------------------------------------------------------------------
        */

        SerialProduk::where(
            'id_detail_pesanan',
            $detail->id_detail
        )->delete();

        /*
        |--------------------------------------------------------------------------
        | HAPUS DETAIL PESANAN
        |--------------------------------------------------------------------------
        */

        $detail->delete();

        return redirect()
            ->route('detail-pesanan.index')
            ->with(
                'success',
                'Detail pesanan berhasil dihapus'
            );
    }
}