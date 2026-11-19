<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gejala;
use Illuminate\Http\Request;

class GejalaController extends Controller
{
    public function index(Request $request)
    {
        $query = Gejala::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%");
            });
        }

        $gejalas = $query->orderBy('kode')->paginate(10)->withQueryString();

        return view('admin.gejala.index', compact('gejalas'));
    }

    public function create()
    {
        $nextKode = 'G' . str_pad(Gejala::count() + 1, 3, '0', STR_PAD_LEFT);
        return view('admin.gejala.create', compact('nextKode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode'      => 'required|string|max:10|unique:gejalas,kode',
            'nama'      => 'required|string|max:200',
            'deskripsi' => 'nullable|string',
        ]);

        Gejala::create($request->only('kode', 'nama', 'deskripsi'));

        return redirect()->route('admin.gejala.index')
            ->with('success', 'Data gejala berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $gejala = Gejala::findOrFail($id);
        return view('admin.gejala.edit', compact('gejala'));
    }

    public function update(Request $request, string $id)
    {
        $gejala = Gejala::findOrFail($id);

        $request->validate([
            'kode'      => 'required|string|max:10|unique:gejalas,kode,' . $id,
            'nama'      => 'required|string|max:200',
            'deskripsi' => 'nullable|string',
        ]);

        $gejala->update($request->only('kode', 'nama', 'deskripsi'));

        return redirect()->route('admin.gejala.index')
            ->with('success', 'Data gejala berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $gejala = Gejala::findOrFail($id);
        $gejala->delete();

        return redirect()->route('admin.gejala.index')
            ->with('success', 'Data gejala berhasil dihapus.');
    }
}
