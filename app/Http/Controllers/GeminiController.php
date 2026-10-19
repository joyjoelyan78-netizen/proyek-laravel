<?php

namespace App\Http\Controllers;

use App\Support\KatalogVesca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GeminiController extends Controller
{
    public function chat(Request $request)
    {
        $message = $request->message;

        // Data produk diambil dari katalog di kode (config/katalog_vesca.php)
        $listProduk = '';

        foreach (KatalogVesca::produk() as $produk) {

            $listProduk .= "\nProduk: {$produk['nama']} ({$produk['bahan_nama']})\n";
            $listProduk .= "Keterangan: {$produk['ringkas']}\n";
            $listProduk .= "Tipe yang tersedia:\n";

            foreach ($produk['seri']['baris'] as $baris) {

                $tipe = KatalogVesca::cariTipe($produk['key'], $baris[0]);

                $listProduk .= "- {$baris[0]}: " . ($tipe['ringkas'] ?? '') . "\n";
            }
        }

        // Data performa tiap bahan
        $dataTeknis = '';

        foreach (KatalogVesca::bahan() as $bahan) {

            $dataTeknis .= "- {$bahan['nama']}: ";

            $bagian = [];

            foreach ($bahan['performa'] as $label => $nilai) {
                $bagian[] = "{$label} {$nilai}";
            }

            $dataTeknis .= implode('; ', $bagian) . ". {$bahan['ringkasan']}\n";
        }

        $alamat  = implode(', ', config('vesca.alamat'));
        $telepon = collect(config('vesca.kontak_wa'))->pluck('label')->implode(' / ');
        $email   = config('vesca.email');

        $prompt = "
        Kamu adalah AI Customer Service PT Vescarindo Utama.

        Informasi perusahaan:

        - PT Vescarindo Utama bergerak di bidang perlindungan korosi.
        - Produk utama adalah Aluminium Anode dan Zinc Anode dengan merek VESCA.
        - Berdiri sejak tahun 1997.
        - Alamat perusahaan: {$alamat}.
        - Kontak WhatsApp / telepon: {$telepon}.
        - Email: {$email}.

        Informasi layanan website:

        1. Produk
        Pengunjung dapat melihat seluruh produk dan detail produk. Setiap halaman
        produk berisi tabel semua tipe, tombol WhatsApp, dan rekomendasi produk lain.

        2. Minta Penawaran Resmi
        Cara meminta penawaran:

        - Klik menu Layanan pada navbar.
        - Pilih submenu Minta Penawaran Resmi.
        - Pilih seri dan tipe produk, isi jumlah, data diri, dan lokasi pengiriman.
        - Kirim permintaan, pengunjung akan mendapat nomor permintaan.
        - Tim PT Vescarindo Utama akan mengirim surat penawaran resmi lewat email atau WhatsApp.

        3. Konsultasi & Spesifikasi Teknis
        Cara berkonsultasi:

        - Klik menu Layanan pada navbar.
        - Pilih submenu Konsultasi & Spesifikasi Teknis.
        - Lihat tabel spesifikasi produk, atau isi formulir pertanyaan tentang kapal dan kondisi air.
        - Tim teknis akan menjawab lewat email atau WhatsApp.

        Data teknis dari katalog (nominal):

        {$dataTeknis}
        - Sertifikasi: BKI Type Approval untuk Aluminium Anode dan Zinc Anode, serta ISO 9001:2015.
        - Jangan menyebutkan ukuran atau berat yang tidak ada di data produk di bawah ini.

        Data produk:

        {$listProduk}

        Aturan menjawab:

        - Jawab singkat, jelas, dan ramah.
        - Maksimal 3 kalimat jika memungkinkan.
        - Gunakan bahasa Indonesia yang natural seperti customer service modern.
        - Jika ditanya produk, gunakan data produk yang tersedia.
        - Jangan mengarang produk yang tidak ada.
        - Saat menjelaskan cara minta penawaran atau konsultasi, selalu sebutkan bahwa menu tersebut berada di dalam menu Layanan.
        - Jika ditanya harga, jangan menyebutkan angka. Arahkan pelanggan untuk memakai menu Minta Penawaran Resmi.
        - Jika ditanya sesuatu yang tidak berhubungan dengan PT Vescarindo Utama, jawab:
          'Maaf, saya hanya dapat membantu informasi seputar produk dan layanan PT Vescarindo Utama.'

        Pertanyaan pelanggan:

        {$message}
        ";

        try {

            $response = Http::timeout(30)
                ->post(
                    'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . env('GEMINI_API_KEY'),
                    [
                        'contents' => [
                            [
                                'parts' => [
                                    [
                                        'text' => $prompt
                                    ]
                                ]
                            ]
                        ]
                    ]
                );

            $result = $response->json();

            return response()->json([
                'reply' =>
                    $result['candidates'][0]['content']['parts'][0]['text']
                    ?? 'Maaf, saya tidak dapat menjawab saat ini.'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'reply' => 'Maaf, layanan AI sedang mengalami gangguan.'
            ]);
        }
    }
}
