<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Customer;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $pesanan = Pesanan::with([
            'customer'
        ])
        ->orderBy('id_pesanan', 'desc')
        ->get();

        return view(
            'backend.pesanan.index',
            compact('pesanan')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $customer = Customer::orderBy(
            'nama_customer',
            'asc'
        )->get();

        return view(
            'backend.pesanan.create',
            compact('customer')
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

            'id_customer' => 'required',

        ]);

        /*
        |--------------------------------------------------------------------------
        | Generate Nomor Invoice Otomatis
        |--------------------------------------------------------------------------
        */

        $tanggal = now()->format('Ymd');

        $lastPesanan = Pesanan::latest('id_pesanan')->first();

        if ($lastPesanan) {

            $lastId = $lastPesanan->id_pesanan + 1;

        } else {

            $lastId = 1;
        }

        $nomorInvoice =
            'INV-' .
            $tanggal .
            '-' .
            str_pad($lastId, 4, '0', STR_PAD_LEFT);

        /*
        |--------------------------------------------------------------------------
        | Simpan Pesanan
        |--------------------------------------------------------------------------
        */

        Pesanan::create([

            'id_customer'      => $request->id_customer,

            'nomor_invoice'    => $nomorInvoice,

            'tanggal_order'    => $request->tanggal_order,

            'estimasi_selesai' => $request->estimasi_selesai,

            'status_pesanan'   => $request->status_pesanan,

            'catatan'          => $request->catatan,

        ]);

        return redirect()
            ->route('pesanan.index')
            ->with(
                'success',
                'Pesanan berhasil ditambahkan'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $pesanan = Pesanan::with([
            'customer',
            'detailPesanan.produk'
        ])->findOrFail($id);

        return view(
            'backend.pesanan.show',
            compact('pesanan')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        $customer = Customer::orderBy(
            'nama_customer',
            'asc'
        )->get();

        return view(
            'backend.pesanan.edit',
            compact(
                'pesanan',
                'customer'
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
        $pesanan = Pesanan::findOrFail($id);

        $request->validate([

            'id_customer' => 'required',

            'nomor_invoice' =>
                'required|unique:pesanan,nomor_invoice,' .
                $id .
                ',id_pesanan',

            'tanggal_order' => 'required',

            'status_pesanan' => 'required'

        ]);

        $pesanan->update([

            'id_customer' => $request->id_customer,

            'nomor_invoice' => $request->nomor_invoice,

            'tanggal_order' => $request->tanggal_order,

            'estimasi_selesai' =>
                $request->estimasi_selesai,

            'status_pesanan' =>
                $request->status_pesanan,

            'catatan' => $request->catatan

        ]);

        return redirect()
            ->route('pesanan.index')
            ->with(
                'success',
                'Pesanan berhasil diupdate'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        $pesanan->delete();

        return redirect()
            ->route('pesanan.index')
            ->with(
                'success',
                'Pesanan berhasil dihapus'
            );
    }
}