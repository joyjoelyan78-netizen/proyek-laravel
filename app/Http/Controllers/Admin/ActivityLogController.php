<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    /**
     * =========================
     * INDEX
     * =========================
     */
    public function index()
    {
        $logs = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view(
            'backend.activity-log.index',
            compact('logs')
        );
    }

    /**
     * =========================
     * SHOW
     * =========================
     */
    public function show($id)
    {
        $log = ActivityLog::with('user')
            ->findOrFail($id);

        return view(
            'backend.activity-log.show',
            compact('log')
        );
    }

    /**
     * =========================
     * DELETE
     * =========================
     */
    public function destroy($id)
    {
        $log = ActivityLog::findOrFail($id);

        $log->delete();

        return redirect()
            ->route('activity-log.index')
            ->with(
                'success',
                'Activity log berhasil dihapus'
            );
    }
}