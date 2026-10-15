<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kapal;

class KapalController extends Controller
{
    public function index()
    {
        $kapal = Kapal::orderBy('created_at', 'desc')->get();

        return view('backend.kapal.index', compact('kapal'));
    }

    public function create()
    {
        return view('backend.kapal.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kapal' => 'required',
            'jenis_kapal' => 'required'
        ]);

        Kapal::create([
            'nama_kapal' => $request->nama_kapal,
            'jenis_kapal' => $request->jenis_kapal
        ]);

        return redirect()
            ->route('kapal.index')
            ->with('success', 'Data kapal berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kapal = Kapal::findOrFail($id);

        return view('backend.kapal.edit', compact('kapal'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kapal' => 'required',
            'jenis_kapal' => 'required'
        ]);

        $kapal = Kapal::findOrFail($id);

        $kapal->update([
            'nama_kapal' => $request->nama_kapal,
            'jenis_kapal' => $request->jenis_kapal
        ]);

        return redirect()
            ->route('kapal.index')
            ->with('success', 'Data kapal berhasil diupdate');
    }

    public function destroy($id)
    {
        $kapal = Kapal::findOrFail($id);

        $kapal->delete();

        return redirect()
            ->route('kapal.index')
            ->with('success', 'Data kapal berhasil dihapus');
    }
}