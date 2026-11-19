<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kerusakan;
use Illuminate\Http\Request;

class KerusakanController extends Controller
{
    public function index(Request $request)
    {
        $query = Kerusakan::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%");
            });
        }

        $kerusakans = $query->orderBy('kode')->paginate(10)->withQueryString();

        return view('admin.kerusakan.index', compact('kerusakans'));
    }

    public function create()
    {
        $nextKode = 'K' . str_pad(Kerusakan::count() + 1, 3, '0', STR_PAD_LEFT);
        return view('admin.kerusakan.create', compact('nextKode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode'     => 'required|string|max:10|unique:kerusakans,kode',
            'nama'     => 'required|string|max:150',
            'deskripsi'=> 'nullable|string',
        ], [
            'kode.unique' => 'Kode kerusakan sudah digunakan.',
            'nama.required' => 'Nama kerusakan wajib diisi.',
        ]);

        Kerusakan::create($request->only('kode', 'nama', 'deskripsi'));

        return redirect()->route('admin.kerusakan.index')
            ->with('success', 'Data kerusakan berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $kerusakan = Kerusakan::findOrFail($id);
        return view('admin.kerusakan.edit', compact('kerusakan'));
    }

    public function update(Request $request, string $id)
    {
        $kerusakan = Kerusakan::findOrFail($id);

        $request->validate([
            'kode'     => 'required|string|max:10|unique:kerusakans,kode,' . $id,
            'nama'     => 'required|string|max:150',
            'deskripsi'=> 'nullable|string',
        ]);

        $kerusakan->update($request->only('kode', 'nama', 'deskripsi'));

        return redirect()->route('admin.kerusakan.index')
            ->with('success', 'Data kerusakan berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $kerusakan = Kerusakan::findOrFail($id);
        $kerusakan->delete();

        return redirect()->route('admin.kerusakan.index')
            ->with('success', 'Data kerusakan berhasil dihapus.');
    }
}
