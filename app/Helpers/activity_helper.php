<?php

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

if (!function_exists('activity_log')) {

    function activity_log(
        $aktivitas,
        $tabel = null,
        $idData = null
    ) {

        if (!Auth::check()) {
            return;
        }

        ActivityLog::create([
            'id_user'        => Auth::id(),
            'aktivitas'      => $aktivitas,
            'tabel_terkait'  => $tabel,
            'id_data'        => $idData,
            'ip_address'     => request()->ip(),
        ]);
    }
}