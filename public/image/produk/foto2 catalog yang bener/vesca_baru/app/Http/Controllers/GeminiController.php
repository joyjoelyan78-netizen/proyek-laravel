<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Produk;

class GeminiController extends Controller
{
    public function chat(Request $request)
    {
        $message = $request->message;

        // Ambil data produk
        $produk = Produk::with('kategori')->get();

        $listProduk = '';

        foreach ($produk as $item) {

            $listProduk .= "
            Nama Produk: {$item->nama_produk}
            Seri Produk: {$item->seri_produk}
            Kategori: " . ($item->kategori->nama_kategori ?? '-') . "
            Deskripsi: {$item->deskripsi}
            Berat: {$item->berat}
            Dimensi: {$item->dimensi}
            Garansi: {$item->masa_garansi_bulan} bulan

            ";
        }

        $prompt = "
        Kamu adalah AI Customer Service PT Vescarindo Utama.

        Informasi perusahaan:

        - PT Vescarindo Utama bergerak di bidang perlindungan korosi.
        - Produk utama adalah Aluminium Anode dan Zinc Anode dengan merek VESCA.
        - Berdiri sejak tahun 1997.
        - Alamat perusahaan:
          JL. H. GEMON NO 39 PONDOK KELAPA TIMUR 13450.

        Informasi layanan website:

        1. Produk
        Pengunjung dapat melihat seluruh produk dan detail produk.

        2. Minta Penawaran Resmi
        Cara meminta penawaran:

        - Klik menu Layanan pada navbar.
        - Pilih submenu Minta Penawaran Resmi.
        - Isi data diri, produk yang dibutuhkan, jumlah, dan lokasi pengiriman.
        - Kirim permintaan, pengunjung akan mendapat nomor permintaan.
        - Tim PT Vescarindo Utama akan mengirim surat penawaran resmi lewat email atau WhatsApp.

        3. Konsultasi & Spesifikasi Teknis
        Cara berkonsultasi:

        - Klik menu Layanan pada navbar.
        - Pilih submenu Konsultasi & Spesifikasi Teknis.
        - Lihat tabel spesifikasi produk, atau isi formulir pertanyaan tentang kapal dan kondisi air.
        - Tim teknis akan menjawab lewat email atau WhatsApp.

        Data teknis dari katalog (nominal):

        - Aluminium Anode: potensial -1.10 volt terhadap Ag/AgCl, kapasitas listrik 2700 Ampere-jam per kg, dikembangkan khusus untuk air laut dan lumpur laut.
        - Zinc Anode: potensial -1.05 volt terhadap Ag/AgCl, kapasitas listrik 780 Ampere-jam per kg, mengacu spesifikasi A-1800-J.
        - Seri Aluminium: Tipe Las (AV-140 sampai AV-300), Tipe Baut (B2 sampai B11), Rod/Batang (AVR-101 sampai AVR-117), Platform/Jetty (AVS-45 sampai AVS-565).
        - Seri Zinc: Tipe Las (S-2 sampai S-9, ZV-320, ZV-450, ZV-165), Seri B Baut (B2 sampai B9F), Tank Anode (ZVT-212 sampai ZVT-500), Rod/Batang.
        - Sertifikasi: BKI Type Approval untuk Aluminium Anode dan Zinc Anode, serta ISO 9001:2015.
        - Tabel ukuran dan berat lengkap ada di halaman Konsultasi & Spesifikasi Teknis. Jangan menyebutkan ukuran atau berat yang tidak ada di data ini.

        Data produk:

        {$listProduk}

        Aturan menjawab:

        - Jawab singkat, jelas, dan ramah.
        - Maksimal 3 kalimat jika memungkinkan.
        - Gunakan bahasa Indonesia yang natural seperti customer service modern.
        - Jika ditanya produk, gunakan data produk yang tersedia.
        - Jangan mengarang produk yang tidak ada.
        - Jika ditanya sesuatu yang tidak berhubungan dengan PT Vescarindo Utama, jawab:
        - Saat menjelaskan cara minta penawaran atau konsultasi, selalu sebutkan bahwa menu tersebut berada di dalam menu Layanan.
        - Jika ditanya harga, jangan menyebutkan angka. Arahkan pelanggan untuk memakai menu Minta Penawaran Resmi.

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