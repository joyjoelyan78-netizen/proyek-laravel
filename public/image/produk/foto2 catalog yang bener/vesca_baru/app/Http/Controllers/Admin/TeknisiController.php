<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teknisi;
use Illuminate\Http\Request;

class TeknisiController extends Controller
{
    public function index()
    {
        $teknisi = Teknisi::latest('id_teknisi')->get();

        return view('backend.teknisi.index', compact('teknisi'));
    }

    public function create()
    {
        return view('backend.teknisi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_teknisi' => 'required',
        ]);

        Teknisi::create($request->all());

        return redirect()
            ->route('teknisi.index')
            ->with('success', 'Teknisi berhasil ditambahkan');
    }

    public function edit($id)
    {
        $teknisi = Teknisi::findOrFail($id);

        return view('backend.teknisi.edit', compact('teknisi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_teknisi' => 'required',
        ]);

        $teknisi = Teknisi::findOrFail($id);

        $teknisi->update($request->all());

        return redirect()
            ->route('teknisi.index')
            ->with('success', 'Teknisi berhasil diupdate');
    }

    public function destroy($id)
    {
        $teknisi = Teknisi::findOrFail($id);

        $teknisi->delete();

        return redirect()
            ->route('teknisi.index')
            ->with('success', 'Teknisi berhasil dihapus');
    }
}