<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::with('kategori')
                    ->latest('id_produk')
                    ->get();

        return view('backend.produk.index', compact('produk'));
    }

    public function create()
    {
        $kategori = KategoriProduk::all();

        return view('backend.produk.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori'   => 'required',
            'kode_produk'   => 'required|unique:produk,kode_produk',
            'nama_produk'   => 'required',
            'gambar_produk' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $gambar = null;

        if ($request->hasFile('gambar_produk')) {

            $file = $request->file('gambar_produk');

            $nama = time() . '.' . $file->getClientOriginalExtension();

            $gambar = $file->storeAs(
                'produk',
                $nama,
                'public'
            );
        }

        Produk::create([
            'id_kategori'        => $request->id_kategori,
            'kode_produk'        => $request->kode_produk,
            'nama_produk'        => $request->nama_produk,
            'seri_produk'        => $request->seri_produk,
            'slug'               => Str::slug($request->nama_produk),
            'deskripsi'          => $request->deskripsi,
            'catatan_ppn'        => $request->catatan_ppn,
            'berat'              => $request->berat,
            'dimensi'            => $request->dimensi,
            'standar_kualitas'   => $request->standar_kualitas,
            'lingkungan_operasi' => $request->lingkungan_operasi,
            'tanggal_produksi'   => $request->tanggal_produksi,
            'masa_garansi_bulan' => $request->masa_garansi_bulan,
            'komposisi_material' => $request->komposisi_material,
            'gambar_produk'      => $gambar,
            'link_whatsapp'      => $request->link_whatsapp,
            'status_produk'      => $request->status_produk,
        ]);

        return redirect('/admin/produk')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    public function show($id)
    {
        $produk = Produk::with('kategori')
                    ->findOrFail($id);

        return view('backend.produk.show', compact('produk'));
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);

        $kategori = KategoriProduk::all();

        return view('backend.produk.edit', compact(
            'produk',
            'kategori'
        ));
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'id_kategori'   => 'required',
            'kode_produk'   => 'required|unique:produk,kode_produk,' . $id . ',id_produk',
            'nama_produk'   => 'required',
            'gambar_produk' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'id_kategori'        => $request->id_kategori,
            'kode_produk'        => $request->kode_produk,
            'nama_produk'        => $request->nama_produk,
            'seri_produk'        => $request->seri_produk,
            'slug'               => Str::slug($request->nama_produk),
            'deskripsi'          => $request->deskripsi,
            'catatan_ppn'        => $request->catatan_ppn,
            'berat'              => $request->berat,
            'dimensi'            => $request->dimensi,
            'standar_kualitas'   => $request->standar_kualitas,
            'lingkungan_operasi' => $request->lingkungan_operasi,
            'tanggal_produksi'   => $request->tanggal_produksi,
            'masa_garansi_bulan' => $request->masa_garansi_bulan,
            'komposisi_material' => $request->komposisi_material,
            'link_whatsapp'      => $request->link_whatsapp,
            'status_produk'      => $request->status_produk,
        ];

        if ($request->hasFile('gambar_produk')) {

            if ($produk->gambar_produk) {
                Storage::disk('public')
                    ->delete($produk->gambar_produk);
            }

            $file = $request->file('gambar_produk');

            $nama = time() . '.' . $file->getClientOriginalExtension();

            $data['gambar_produk'] = $file->storeAs(
                'produk',
                $nama,
                'public'
            );
        }

        $produk->update($data);

        return redirect('/admin/produk')
            ->with('success', 'Produk berhasil diupdate');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->gambar_produk) {
            Storage::disk('public')
                ->delete($produk->gambar_produk);
        }

        $produk->delete();

        return redirect('/admin/produk')
            ->with('success', 'Produk berhasil dihapus');
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

        $allKategori = KategoriProduk::all();

        return view('frontend.produk.index', compact(
            'products',
            'kategoriData',
            'allKategori'
        ));
    }

    public function semuaProduk(Request $request)
    {
        $search = $request->search;

        $products = Produk::with('kategori')
            ->when($search, function ($query) use ($search) {
                $query->where(
                    'nama_produk',
                    'LIKE',
                    "%{$search}%"
                );
            })
            ->latest('id_produk')
            ->get();

        $kategori = KategoriProduk::all();

        return view('frontend.produk.index', compact(
            'products',
            'kategori',
            'search'
        ));
    }

    public function searchAjax(Request $request)
    {
        $search = $request->search;

        $products = Produk::where(
            'nama_produk',
            'LIKE',
            "%{$search}%"
        )
        ->take(5)
        ->get();

        return response()->json($products);
    }

    public function detail($slug)
    {
        $produk = Produk::with('kategori')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('frontend.produk.produk', compact('produk'));
    }
}