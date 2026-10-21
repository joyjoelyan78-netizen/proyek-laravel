<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PermintaanPenawaran;
use App\Support\KatalogVesca;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PermintaanPenawaranController extends Controller
{
    /*
    |------------------------------------------------------------------
    | HALAMAN FORMULIR
    |------------------------------------------------------------------
    | Bisa dibuka dengan item terpilih, misalnya dari tabel spesifikasi:
    |   /minta-penawaran?seri=zinc_las&tipe=S-3
    */

    public function index(Request $request)
    {
        $picker = KatalogVesca::untukDropdown();

        $awal = old('items');

        if (!is_array($awal) || empty($awal)) {

            $seri = (string) $request->query('seri');
            $tipe = (string) $request->query('tipe');

            $awal = [[
                'seri'   => isset($picker[$seri]) ? $seri : '',
                'tipe'   => isset($picker[$seri]) ? $tipe : '',
                'jumlah' => '',
            ]];
        }

        return view(
            'frontend.penawaran.index',
            compact('picker', 'awal')
        );
    }

    /*
    |------------------------------------------------------------------
    | SIMPAN PERMINTAAN
    |------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        // Kolom jebakan untuk bot: manusia tidak melihat dan tidak mengisinya.
        if ($request->filled('website')) {

            return redirect()->route('penawaran.index');
        }

        $data = $request->validate([

            'nama_pemohon'       => 'required|string|max:100',
            'nama_perusahaan'    => 'nullable|string|max:150',
            'email'              => 'required|email|max:150',
            'nomor_telepon'      => ['required', 'string', 'max:30', 'regex:/^[0-9+\-\s()]{8,30}$/'],

            'items'              => 'required|array|min:1|max:20',
            'items.*.seri'       => ['required', Rule::in(KatalogVesca::kodeSeriValid())],
            'items.*.tipe'       => 'required|string|max:150',
            'items.*.jumlah'     => 'required|integer|min:1|max:100000',

            'jenis_kapal'        => 'nullable|string|max:150',
            'lokasi_pengiriman'  => 'required|string|max:200',
            'tanggal_dibutuhkan' => 'nullable|date|after_or_equal:today',

            'file_lampiran'      => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx|max:5120',
            'catatan'            => 'nullable|string|max:2000',

        ], [

            'nama_pemohon.required'       => 'Nama lengkap wajib diisi.',
            'email.required'              => 'Email wajib diisi.',
            'email.email'                 => 'Format email belum benar.',
            'nomor_telepon.required'      => 'Nomor telepon / WhatsApp wajib diisi.',
            'nomor_telepon.regex'         => 'Nomor telepon hanya boleh berisi angka, spasi, tanda + - ( ), minimal 8 karakter.',
            'items.required'              => 'Tambahkan minimal satu item produk.',
            'items.max'                   => 'Maksimal 20 item per permintaan.',
            'items.*.seri.required'       => 'Pilih seri produk pada setiap item.',
            'items.*.seri.in'             => 'Seri produk tidak dikenali.',
            'items.*.tipe.required'       => 'Pilih tipe (atau tulis ukuran) pada setiap item.',
            'items.*.jumlah.required'     => 'Isi jumlah pada setiap item.',
            'items.*.jumlah.integer'      => 'Jumlah harus berupa angka bulat.',
            'items.*.jumlah.min'          => 'Jumlah minimal 1.',
            'lokasi_pengiriman.required'  => 'Lokasi pengiriman wajib diisi.',
            'tanggal_dibutuhkan.after_or_equal' => 'Tanggal dibutuhkan tidak boleh sebelum hari ini.',
            'file_lampiran.mimes'         => 'Lampiran harus berupa PDF, gambar (JPG/PNG), Word, atau Excel.',
            'file_lampiran.max'           => 'Ukuran lampiran maksimal 5 MB.',
        ]);

        // ---- rapikan item dan cocokkan dengan katalog ----
        $item = $this->normalkanItem($data['items']);

        $bahan = collect($item)->pluck('bahan')->unique()->values();

        $simpan = collect($data)->except(['items', 'file_lampiran'])->all();

        $simpan['rincian_item'] = $item;
        $simpan['jenis_produk'] = $bahan->count() > 1 ? 'campuran' : $bahan->first();
        $simpan['jumlah']       = collect($item)->sum('jumlah');
        $simpan['satuan']       = 'pcs';
        $simpan['tipe_ukuran']  = Str::limit(collect($item)->pluck('tipe')->implode(', '), 240, '...');
        $simpan['status']       = 'baru';

        if ($request->hasFile('file_lampiran')) {

            $simpan['file_lampiran'] = $request
                ->file('file_lampiran')
                ->store('penawaran', 'public');
        }

        
        $penawaran = PermintaanPenawaran::buatDenganNomor($simpan);

        try {
            $isiEmail =
                "Permintaan Penawaran Baru\n\n" .
                "Nomor Permintaan: {$penawaran->nomor_permintaan}\n" .
                "Nama: {$data['nama_pemohon']}\n" .
                "Perusahaan: " . ($data['nama_perusahaan'] ?? '-') . "\n" .
                "Email: {$data['email']}\n" .
                "Telepon: {$data['nomor_telepon']}\n" .
                "Jenis Kapal/Struktur: " . ($data['jenis_kapal'] ?? '-') . "\n" .
                "Lokasi Pengiriman: {$data['lokasi_pengiriman']}\n" .
                "Tanggal Dibutuhkan: " . ($data['tanggal_dibutuhkan'] ?? '-') . "\n\n" .
                "Rincian Produk:\n" .
                json_encode(
                    $item,
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
                ) . "\n\n" .
                "Catatan:\n" . ($data['catatan'] ?? '-');

            Mail::raw($isiEmail, function ($message) use (
                $data,
                $penawaran,
                $simpan
            ) {
                $message->to('vescarindo12@gmail.com')
                    ->subject(
                        '[Minta Penawaran] ' . $penawaran->nomor_permintaan
                    )
                    ->replyTo($data['email'], $data['nama_pemohon']);

                $pathLampiran = $simpan['file_lampiran'] ?? null;

                if (
                    $pathLampiran &&
                    Storage::disk('public')->exists($pathLampiran)
                ) {
                    $message->attach(
                        Storage::disk('public')->path($pathLampiran)
                    );
                }
            });
        } catch (\Throwable $e) {
            Log::error('Gagal mengirim email permintaan penawaran', [
                'nomor' => $penawaran->nomor_permintaan,
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->route('penawaran.sukses')
                ->with('nomor', $penawaran->nomor_permintaan)
                ->with('email_warning',
                    'Permintaan tersimpan, tetapi notifikasi email gagal dikirim.');
        }

        return redirect()
            ->route('penawaran.sukses')
            ->with('nomor', $penawaran->nomor_permintaan)
            ->with('email_success', true);

    }

    /*
    |------------------------------------------------------------------
    | HALAMAN TERIMA KASIH
    |------------------------------------------------------------------
    | Nomor hanya dibawa lewat session (bukan lewat alamat), supaya
    | orang lain tidak bisa menebak nomor permintaan orang lain.
    */

    public function sukses()
    {
        if (!session('nomor')) {

            return redirect()->route('penawaran.index');
        }

        return view('frontend.penawaran.sukses', [
            'nomor' => session('nomor'),
        ]);
    }

    /*
    |------------------------------------------------------------------
    | Cocokkan setiap item dengan katalog.
    | Item katalog: tipe harus ada di seri yang dipilih.
    | Item custom : tipe berupa tulisan bebas.
    |------------------------------------------------------------------
    */

    protected function normalkanItem(array $items): array
    {
        $hasil = [];

        foreach (array_values($items) as $i => $baris) {

            $seri  = $baris['seri'];
            $tipe  = trim($baris['tipe']);
            $bahan = KatalogVesca::bahanDariSeri($seri);

            $rincian = [
                'bahan'       => $bahan,
                'seri'        => $seri,
                'seri_label'  => KatalogVesca::labelSeri($seri),
                'tipe'        => $tipe,
                'spesifikasi' => null,
                'jumlah'      => (int) $baris['jumlah'],
                'berat_nett'  => null,
                'custom'      => isset(KatalogVesca::CUSTOM[$seri]),
            ];

            if (!$rincian['custom']) {

                $cocok = KatalogVesca::cariTipe($seri, $tipe);

                if (!$cocok) {

                    throw ValidationException::withMessages([
                        "items.{$i}.tipe" => 'Item ' . ($i + 1) . ': tipe "' . $tipe . '" tidak ada di seri yang dipilih.',
                    ]);
                }

                $rincian['tipe']        = $cocok['kode'];
                $rincian['spesifikasi'] = $cocok['ringkas'];
                $rincian['berat_nett']  = $cocok['berat_nett'];
            }

            $hasil[] = $rincian;
        }

        return $hasil;
    }
}
