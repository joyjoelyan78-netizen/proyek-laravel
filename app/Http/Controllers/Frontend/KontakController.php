<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class KontakController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'    => 'required|string|max:100',
            'email'   => 'required|email|max:150',
            'telepon' => 'required|string|max:30',
            'subjek'  => 'required|in:Informasi Produk,Permintaan Penawaran,Layanan,Klaim Garansi,Lainnya',
            'pesan'   => 'required|string|max:3000',
        ]);

        try {
            $isiEmail =
                "Pesan baru dari formulir Hubungi Kami\n\n" .
                "Nama: {$data['nama']}\n" .
                "Email: {$data['email']}\n" .
                "Telepon: {$data['telepon']}\n" .
                "Subjek: {$data['subjek']}\n\n" .
                "Pesan:\n{$data['pesan']}";

            Mail::raw($isiEmail, function ($message) use ($data) {
                $message->to('vescarindo12@gmail.com')
                    ->subject('[Hubungi Kami] ' . $data['subjek'])
                    ->replyTo($data['email'], $data['nama']);
            });
        } catch (\Throwable $e) {
            Log::error('Gagal mengirim email Hubungi Kami', [
                'error' => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->with('email_error',
                    'Pesan belum berhasil dikirim. Silakan coba kembali.');
        }

        return redirect()
            ->route('hubungi')
            ->with('success',
                'Terima kasih! Pesan Anda berhasil dikirim.');
    }
}
