<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriProdukController extends Controller
{
    public function index()
    {
        $kategori = KategoriProduk::latest('id_kategori')->get();

        return view('backend.kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('backend.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|max:100',
            'deskripsi'     => 'nullable'
        ]);

        KategoriProduk::create([
            'nama_kategori' => $request->nama_kategori,
            'slug'          => Str::slug($request->nama_kategori),
            'deskripsi'     => $request->deskripsi
        ]);

        return redirect('/kategori-produk')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function show($id)
    {
        $kategori = KategoriProduk::findOrFail($id);

        return view('backend.kategori.show', compact('kategori'));
    }

    public function edit($id)
    {
        $kategori = KategoriProduk::findOrFail($id);

        return view('backend.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriProduk::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|max:100',
            'deskripsi'     => 'nullable'
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'slug'          => Str::slug($request->nama_kategori),
            'deskripsi'     => $request->deskripsi
        ]);

        return redirect('/admin/kategori-produk')
            ->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy($id)
    {
        $kategori = KategoriProduk::findOrFail($id);

        $kategori->delete();

        return redirect('/admin/kategori-produk')
            ->with('success', 'Kategori berhasil dihapus');
    }

    public function kategori($slug)
    {
        $kategoriData = KategoriProduk::where(
            'slug',
            $slug
        )->firstOrFail();

        $products = Produk::where(
            'id_kategori',
            $kategoriData->id_kategori
        )->latest('id_produk')->get();

        $kategori = KategoriProduk::all();

        return view('frontend.produk.index', compact(
            'products',
            'kategori',
            'kategoriData'
        ));
    }
}