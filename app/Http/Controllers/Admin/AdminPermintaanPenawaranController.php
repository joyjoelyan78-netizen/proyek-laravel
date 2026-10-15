<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PermintaanPenawaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminPermintaanPenawaranController extends Controller
{
    /*
    |------------------------------------------------------------------
    | DAFTAR PERMINTAAN
    |------------------------------------------------------------------
    | Filter: ?status=baru  dan pencarian: ?q=kata
    */

    public function index(Request $request)
    {
        $status = $request->query('status');
        $cari   = trim((string) $request->query('q'));

        $permintaan = PermintaanPenawaran::with('produk')
            ->when(
                $status && array_key_exists($status, PermintaanPenawaran::STATUS),
                fn ($q) => $q->where('status', $status)
            )
            ->when($cari !== '', function ($q) use ($cari) {

                $q->where(function ($sub) use ($cari) {

                    $sub->where('nomor_permintaan', 'like', "%{$cari}%")
                        ->orWhere('nama_pemohon', 'like', "%{$cari}%")
                        ->orWhere('nama_perusahaan', 'like', "%{$cari}%")
                        ->orWhere('email', 'like', "%{$cari}%");
                });
            })
            ->latest('id_penawaran')
            ->paginate(15)
            ->withQueryString();

        // jumlah per status untuk ringkasan di atas tabel
        $jumlah = PermintaanPenawaran::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view(
            'backend.penawaran.index',
            compact('permintaan', 'jumlah', 'status', 'cari')
        );
    }

    /*
    |------------------------------------------------------------------
    | DETAIL
    |------------------------------------------------------------------
    */

    public function show($id)
    {
        $penawaran = PermintaanPenawaran::with(['produk', 'userProses'])
            ->findOrFail($id);

        return view('backend.penawaran.show', compact('penawaran'));
    }

    /*
    |------------------------------------------------------------------
    | UBAH STATUS + CATATAN INTERNAL
    |------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $penawaran = PermintaanPenawaran::findOrFail($id);

        $data = $request->validate([

            'status'        => 'required|in:' . implode(',', array_keys(PermintaanPenawaran::STATUS)),
            'catatan_admin' => 'nullable|string|max:3000',

        ]);

        $data['id_user_proses'] = Auth::id();

        $penawaran->update($data);

        return redirect()
            ->route('admin.penawaran.show', $penawaran->id_penawaran)
            ->with('success', 'Permintaan penawaran berhasil diperbarui.');
    }

    /*
    |------------------------------------------------------------------
    | HAPUS
    |------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $penawaran = PermintaanPenawaran::findOrFail($id);

        if ($penawaran->file_lampiran) {

            Storage::disk('public')->delete($penawaran->file_lampiran);
        }

        $penawaran->delete();

        return redirect()
            ->route('admin.penawaran.index')
            ->with('success', 'Permintaan penawaran berhasil dihapus.');
    }
}
