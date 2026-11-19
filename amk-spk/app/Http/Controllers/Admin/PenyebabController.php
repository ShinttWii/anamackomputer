<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penyebab;
use App\Models\Kerusakan;
use Illuminate\Http\Request;

class PenyebabController extends Controller
{
    public function index(Request $request)
    {
        $query = Penyebab::with('kerusakan');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kerusakan_id')) {
            $query->where('kerusakan_id', $request->kerusakan_id);
        }

        $penyebabs  = $query->orderBy('kode')->paginate(10)->withQueryString();
        $kerusakans = Kerusakan::orderBy('kode')->get();

        return view('admin.penyebab.index', compact('penyebabs', 'kerusakans'));
    }

    public function create()
    {
        $nextKode   = 'P' . str_pad(Penyebab::count() + 1, 3, '0', STR_PAD_LEFT);
        $kerusakans = Kerusakan::orderBy('kode')->get();
        return view('admin.penyebab.create', compact('nextKode', 'kerusakans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode'         => 'required|string|max:10|unique:penyebabs,kode',
            'kerusakan_id' => 'required|exists:kerusakans,id',
            'deskripsi'    => 'required|string',
        ]);

        Penyebab::create($request->only('kode', 'kerusakan_id', 'deskripsi'));

        return redirect()->route('admin.penyebab.index')
            ->with('success', 'Data penyebab berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $penyebab   = Penyebab::findOrFail($id);
        $kerusakans = Kerusakan::orderBy('kode')->get();
        return view('admin.penyebab.edit', compact('penyebab', 'kerusakans'));
    }

    public function update(Request $request, string $id)
    {
        $penyebab = Penyebab::findOrFail($id);

        $request->validate([
            'kode'         => 'required|string|max:10|unique:penyebabs,kode,' . $id,
            'kerusakan_id' => 'required|exists:kerusakans,id',
            'deskripsi'    => 'required|string',
        ]);

        $penyebab->update($request->only('kode', 'kerusakan_id', 'deskripsi'));

        return redirect()->route('admin.penyebab.index')
            ->with('success', 'Data penyebab berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        Penyebab::findOrFail($id)->delete();
        return redirect()->route('admin.penyebab.index')
            ->with('success', 'Data penyebab berhasil dihapus.');
    }
}
