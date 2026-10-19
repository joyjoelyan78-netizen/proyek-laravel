<?php

namespace App\Http\Controllers;

use App\Support\KatalogVesca;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| HALAMAN PRODUK (publik)
|--------------------------------------------------------------------------
| Data produk TIDAK lagi diambil dari database / halaman admin, tetapi dari
| kode: config/katalog_vesca.php. Satu produk = satu seri di katalog
| (misalnya "Zinc Anode Tipe Las"), berisi semua tipe dan ukurannya.
*/

class ProdukController extends Controller
{
    /** Daftar semua produk. Bisa difilter: ?search=kata */
    public function semuaProduk(Request $request)
    {
        $search   = trim((string) $request->query('search'));
        $products = KatalogVesca::daftarProduk(null, $search);

        return view('frontend.produk.index', [
            'products'   => $products,
            'search'     => $search,
            'bahanAktif' => null,
        ]);
    }

    /** Filter per bahan: /produk/kategori/aluminium  atau  /produk/kategori/zinc */
    public function kategori($slug)
    {
        $slug = strtolower($slug);

        if (!in_array($slug, ['aluminium', 'zinc'], true)) {
            abort(404);
        }

        return view('frontend.produk.index', [
            'products'   => KatalogVesca::daftarProduk($slug),
            'search'     => '',
            'bahanAktif' => $slug,
        ]);
    }

    /** Halaman detail satu produk (seri). */
    public function detail(Request $request, $slug)
    {
        $produk = KatalogVesca::produkBySlug($slug);

        if (!$produk) {
            abort(404);
        }

        $tipeDipilih = trim((string) $request->query('tipe'));

        return view('frontend.produk.produk', [
            'produk'       => $produk,
            'rekomendasi'  => KatalogVesca::rekomendasi($produk['key'], 4),
            'bahanInfo'    => KatalogVesca::bahan()[$produk['bahan']] ?? [],
            'tipeDipilih'  => $tipeDipilih,
        ]);
    }

    /** Pencarian cepat di navbar (JSON). */
    public function searchAjax(Request $request)
    {
        $hasil = KatalogVesca::cariCepat((string) $request->query('search'), 8);

        return response()->json(array_map(function ($item) {

            $url = '/produk/' . $item['slug'];

            if ($item['tipe']) {
                $url .= '?tipe=' . rawurlencode($item['tipe']) . '#spesifikasi';
            }

            return ['label' => $item['label'], 'url' => $url];

        }, $hasil));
    }
}
