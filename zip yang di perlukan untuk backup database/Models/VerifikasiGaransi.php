<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class VerifikasiGaransi extends Model
{
    protected $table = 'verifikasi_garansi';

    protected $primaryKey = 'id_verifikasi';

    use LogsActivity;

    public $timestamps = false;

    protected $fillable = [
        'id_klaim',
        'id_teknisi',
        'id_user_verifikasi',
        'tanggal_verifikasi',
        'garansi_mulai',
        'status_verifikasi',
        'catatan_verifikasi',
    
        'tanggal_kunjungan',
        'jam_kunjungan',
        'status_kunjungan',
        'hasil_pemeriksaan'
    ];

    public function klaim()
    {
        return $this->belongsTo(
            KlaimGaransi::class,
            'id_klaim',
            'id_klaim'
        );
    }

    public function teknisi()
    {
        return $this->belongsTo(
            Teknisi::class,
            'id_teknisi'
        );
    }

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'id_user_verifikasi',
            'id_user'
        );
    }

    public function terima($id)
    {
        $klaim = KlaimGaransi::with(['serial','tiket'])
                    ->findOrFail($id);

        $klaim->update([
            'status_klaim' => 'diterima'
        ]);

        VerifikasiGaransi::firstOrCreate(
            [
                'id_klaim' => $klaim->id_klaim
            ],
            [
                'status_verifikasi' => 'pending',
                'tanggal_verifikasi' => now(),
                'id_user' => auth()->id()
            ]
        );

        if ($klaim->tiket) {
            $klaim->tiket->update([
                'status_tiket' => 'verifikasi'
            ]);
        }

        if ($klaim->serial) {
            $klaim->serial->update([
                'status_klaim' => 'diklaim'
            ]);
        }

        return redirect()
            ->route('klaim-garansi.detail', $id)
            ->with('success', 'Klaim berhasil diterima dan masuk ke verifikasi.');
    }
}