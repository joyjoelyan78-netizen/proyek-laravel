<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Data awal minimal supaya website bisa login lagi.
     * Memakai DB::table agar tidak memicu trait LogsActivity pada Model.
     */
    public function run(): void
    {
        // ================= ROLE =================
        // Nama 'Super Admin' wajib persis, dipakai SuperAdminMiddleware & User::hasPermission()

        DB::table('roles')->updateOrInsert(
            ['nama_role' => 'Super Admin'],
            ['deskripsi' => 'Akses penuh ke seluruh fitur']
        );

        $idRole = DB::table('roles')->where('nama_role', 'Super Admin')->value('id_role');

        // ================= AKUN ADMIN =================
        // Email/password bisa diatur lewat .env: SEED_ADMIN_EMAIL, SEED_ADMIN_PASSWORD.
        // Kalau password tidak diatur, dibuat acak dan ditampilkan sekali di terminal.

        $email    = env('SEED_ADMIN_EMAIL', 'admin@vesca.test');
        $password = env('SEED_ADMIN_PASSWORD') ?: Str::random(12);

        if (!DB::table('users')->where('email', $email)->exists()) {

            $idUser = DB::table('users')->insertGetId([
                'nama'       => 'Super Admin',
                'email'      => $email,
                'password'   => Hash::make($password),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('role_user')->insert([
                'id_user' => $idUser,
                'id_role' => $idRole,
            ]);

            $this->command?->info("Akun admin dibuat -> email: {$email} | password: {$password}");
            $this->command?->warn('Simpan password ini dan segera ganti setelah login.');
        }

        // ================= TAHAPAN TRACKING (CONTOH) =================
        // Nama tahapan asli tidak bisa dipulihkan dari kode. Ini hanya contoh, ubah lewat
        // halaman admin. Catatan: TrackingPesananController mengaktifkan garansi serial saat
        // status = 'selesai' ATAU nama tahapan mengandung kata "diterima".

        foreach ([
            ['Pesanan Diterima', 1],
            ['Produksi', 2],
            ['Quality Control', 3],
            ['Pengiriman', 4],
            ['Selesai', 5],
        ] as [$nama, $urutan]) {
            DB::table('status_tracking')->updateOrInsert(
                ['nama_status' => $nama],
                ['urutan' => $urutan]
            );
        }
    }
}
