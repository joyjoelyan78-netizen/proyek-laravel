<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KonsultasiTeknis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminKonsultasiTeknisController extends Controller
{
    /*
    |------------------------------------------------------------------
    | DAFTAR KONSULTASI
    |------------------------------------------------------------------
    | Filter: ?status=baru  dan pencarian: ?q=kata
    */

    public function index(Request $request)
    {
        $status = $request->query('status');
        $cari   = trim((string) $request->query('q'));

        $konsultasi = KonsultasiTeknis::query()
            ->when(
                $status && array_key_exists($status, KonsultasiTeknis::STATUS),
                fn ($q) => $q->where('status', $status)
            )
            ->when($cari !== '', function ($q) use ($cari) {

                $q->where(function ($sub) use ($cari) {

                    $sub->where('nomor_konsultasi', 'like', "%{$cari}%")
                        ->orWhere('nama_pengirim', 'like', "%{$cari}%")
                        ->orWhere('nama_perusahaan', 'like', "%{$cari}%")
                        ->orWhere('email', 'like', "%{$cari}%");
                });
            })
            ->latest('id_konsultasi')
            ->paginate(15)
            ->withQueryString();

        $jumlah = KonsultasiTeknis::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view(
            'backend.konsultasi.index',
            compact('konsultasi', 'jumlah', 'status', 'cari')
        );
    }

    /*
    |------------------------------------------------------------------
    | DETAIL
    |------------------------------------------------------------------
    */

    public function show($id)
    {
        $konsultasi = KonsultasiTeknis::with('userBalas')
            ->findOrFail($id);

        return view('backend.konsultasi.show', compact('konsultasi'));
    }

    /*
    |------------------------------------------------------------------
    | SIMPAN BALASAN / UBAH STATUS
    |------------------------------------------------------------------
    | Balasan dicatat di sini sebagai arsip. Pengiriman ke pelanggan
    | dilakukan admin lewat tombol Email / WhatsApp di halaman detail.
    */

    public function update(Request $request, $id)
    {
        $konsultasi = KonsultasiTeknis::findOrFail($id);

        $data = $request->validate([

            'status'        => 'required|in:' . implode(',', array_keys(KonsultasiTeknis::STATUS)),
            'balasan_admin' => 'nullable|string|max:5000',

        ]);

        if ($data['status'] === 'dibalas' && blank($data['balasan_admin'] ?? null)) {

            return back()
                ->withErrors(['balasan_admin' => 'Isi catatan balasan dulu sebelum status diubah menjadi Sudah Dibalas.'])
                ->withInput();
        }

        $balasanBerubah = ($data['balasan_admin'] ?? null) !== $konsultasi->balasan_admin;

        if (filled($data['balasan_admin'] ?? null) && $balasanBerubah) {

            $data['dibalas_pada'] = now();
            $data['id_user_balas'] = Auth::id();
        }

        $konsultasi->update($data);

        return redirect()
            ->route('admin.konsultasi.show', $konsultasi->id_konsultasi)
            ->with('success', 'Konsultasi berhasil diperbarui.');
    }

    /*
    |------------------------------------------------------------------
    | HAPUS
    |------------------------------------------------------------------
    */

    public function destroy($id)
    {
        KonsultasiTeknis::findOrFail($id)->delete();

        return redirect()
            ->route('admin.konsultasi.index')
            ->with('success', 'Konsultasi berhasil dihapus.');
    }
}
