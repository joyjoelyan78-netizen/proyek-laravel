<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\KonsultasiTeknis;
use App\Support\KatalogVesca;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class KonsultasiTeknisController extends Controller
{
    /*
    |------------------------------------------------------------------
    | HALAMAN INFORMASI + FORMULIR
    |------------------------------------------------------------------
    | Semua data teknis diambil dari config/katalog_vesca.php
    | (disalin dari katalog PDF PT Vescarindo Utama).
    */

    public function index(Request $request)
    {
        $bahan       = KatalogVesca::bahan();
        $seriList    = KatalogVesca::seri();
        $sertifikat  = KatalogVesca::sertifikat();
        $pilihanSeri = KatalogVesca::daftarSeri();

        $seriTerpilih = (string) $request->query('seri');

        if (!isset($pilihanSeri[$seriTerpilih])) {

            $seriTerpilih = null;
        }

        return view(
            'frontend.konsultasi.index',
            compact('bahan', 'seriList', 'sertifikat', 'pilihanSeri', 'seriTerpilih')
        );
    }

    /*
    |------------------------------------------------------------------
    | SIMPAN PERTANYAAN KONSULTASI
    |------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        // Kolom jebakan untuk bot.
        if ($request->filled('website')) {

            return redirect()->route('konsultasi.index');
        }

        $data = $request->validate([

            'nama_pengirim'     => 'required|string|max:100',
            'nama_perusahaan'   => 'nullable|string|max:150',
            'email'             => 'required|email|max:150',
            'nomor_telepon'     => ['required', 'string', 'max:30', 'regex:/^[0-9+\-\s()]{8,30}$/'],

            'produk_diminati'   => ['nullable', Rule::in(array_keys(KatalogVesca::daftarSeri()))],
            'jenis_kapal'       => 'required|string|max:150',
            'ukuran_kapal'      => 'nullable|string|max:150',
            'bagian_dilindungi' => 'nullable|string|max:150',
            'kondisi_air'       => 'required|in:laut,payau,tawar,belum_tahu',
            'pertanyaan'        => 'required|string|min:10|max:3000',

        ], [

            'nama_pengirim.required'  => 'Nama lengkap wajib diisi.',
            'email.required'          => 'Email wajib diisi.',
            'email.email'             => 'Format email belum benar.',
            'nomor_telepon.required'  => 'Nomor telepon / WhatsApp wajib diisi.',
            'nomor_telepon.regex'     => 'Nomor telepon hanya boleh berisi angka, spasi, tanda + - ( ), minimal 8 karakter.',
            'jenis_kapal.required'    => 'Jenis kapal wajib diisi, misalnya tanker, tongkang, atau kapal feri.',
            'kondisi_air.required'    => 'Pilih kondisi air tempat kapal beroperasi.',
            'pertanyaan.required'     => 'Tuliskan pertanyaan atau kebutuhan Anda.',
            'pertanyaan.min'          => 'Pertanyaan minimal 10 karakter supaya tim kami bisa memahaminya.',
        ]);

        $data['status'] = 'baru';

        
        $konsultasi = KonsultasiTeknis::buatDenganNomor($data);

        try {
            $isiEmail =
                "Konsultasi Teknis Baru\n\n" .
                "Nomor Konsultasi: {$konsultasi->nomor_konsultasi}\n" .
                "Nama: {$data['nama_pengirim']}\n" .
                "Perusahaan: " . ($data['nama_perusahaan'] ?? '-') . "\n" .
                "Email: {$data['email']}\n" .
                "Telepon: {$data['nomor_telepon']}\n" .
                "Jenis Kapal/Struktur: {$data['jenis_kapal']}\n" .
                "Ukuran Kapal: " . ($data['ukuran_kapal'] ?? '-') . "\n" .
                "Bagian Dilindungi: " . ($data['bagian_dilindungi'] ?? '-') . "\n" .
                "Kondisi Air: {$data['kondisi_air']}\n" .
                "Produk Diminati: " . ($data['produk_diminati'] ?? '-') . "\n\n" .
                "Pertanyaan:\n{$data['pertanyaan']}";

            Mail::raw($isiEmail, function ($message) use ($data, $konsultasi) {
                $message->to('vescarindo12@gmail.com')
                    ->subject(
                        '[Konsultasi Teknis] ' . $konsultasi->nomor_konsultasi
                    )
                    ->replyTo($data['email'], $data['nama_pengirim']);
            });
        } catch (\Throwable $e) {
            Log::error('Gagal mengirim email konsultasi teknis', [
                'nomor' => $konsultasi->nomor_konsultasi,
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->route('konsultasi.sukses')
                ->with('nomor', $konsultasi->nomor_konsultasi)
                ->with('email_warning',
                    'Data konsultasi tersimpan, tetapi notifikasi email gagal dikirim.');
        }

        return redirect()
            ->route('konsultasi.sukses')
            ->with('nomor', $konsultasi->nomor_konsultasi)
            ->with('email_success', true);

            }

    /*
    |------------------------------------------------------------------
    | HALAMAN TERIMA KASIH
    |------------------------------------------------------------------
    */

    public function sukses()
    {
        if (!session('nomor')) {

            return redirect()->route('konsultasi.index');
        }

        return view('frontend.konsultasi.sukses', [
            'nomor' => session('nomor'),
        ]);
    }
}
