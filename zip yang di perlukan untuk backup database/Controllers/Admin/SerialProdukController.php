<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SerialProduk;
use Illuminate\Http\Request;

class SerialProdukController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $serial = SerialProduk::with([
            'produk',
            'customer'
        ])
        ->orderBy('id_serial', 'desc')
        ->get();

        return view(
            'backend.serial.index',
            compact('serial')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $serial = SerialProduk::with([
            'produk',
            'customer'
        ])->findOrFail($id);

        return view(
            'backend.serial.show',
            compact('serial')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $serial = SerialProduk::with([
            'produk',
            'customer'
        ])->findOrFail($id);

        return view(
            'backend.serial.edit',
            compact('serial')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $serial = SerialProduk::findOrFail($id);

        $request->validate([

            'status_aktivasi' => 'required',

            'status_klaim' => 'required',

            'status_garansi' => 'required',

            'masa_berlaku_sampai' => 'nullable|date'

        ]);

        $serial->update([

            'status_aktivasi' => $request->status_aktivasi,

            'status_klaim' => $request->status_klaim,

            'status_garansi' => $request->status_garansi,

            'masa_berlaku_sampai' => $request->masa_berlaku_sampai

        ]);

        return redirect()
            ->route('serial-produk.index')
            ->with(
                'success',
                'Serial produk berhasil diupdate'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $serial = SerialProduk::findOrFail($id);

        $serial->delete();

        return redirect()
            ->route('serial-produk.index')
            ->with(
                'success',
                'Serial produk berhasil dihapus'
            );
    }
}