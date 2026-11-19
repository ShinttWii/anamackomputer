<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Solusi;
use App\Models\Kerusakan;
use Illuminate\Http\Request;

class SolusiController extends Controller
{
    public function index(Request $request)
    {
        $query = Solusi::with('kerusakan');

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

        $solusIs    = $query->orderBy('kode')->paginate(10)->withQueryString();
        $kerusakans = Kerusakan::orderBy('kode')->get();

        return view('admin.solusi.index', compact('solusIs', 'kerusakans'));
    }

    public function create()
    {
        $nextKode   = 'S' . str_pad(Solusi::count() + 1, 3, '0', STR_PAD_LEFT);
        $kerusakans = Kerusakan::orderBy('kode')->get();
        return view('admin.solusi.create', compact('nextKode', 'kerusakans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode'         => 'required|string|max:10|unique:solusis,kode',
            'kerusakan_id' => 'required|exists:kerusakans,id',
            'deskripsi'    => 'required|string',
        ]);

        Solusi::create($request->only('kode', 'kerusakan_id', 'deskripsi'));

        return redirect()->route('admin.solusi.index')
            ->with('success', 'Data solusi berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $solusi     = Solusi::findOrFail($id);
        $kerusakans = Kerusakan::orderBy('kode')->get();
        return view('admin.solusi.edit', compact('solusi', 'kerusakans'));
    }

    public function update(Request $request, string $id)
    {
        $solusi = Solusi::findOrFail($id);

        $request->validate([
            'kode'         => 'required|string|max:10|unique:solusis,kode,' . $id,
            'kerusakan_id' => 'required|exists:kerusakans,id',
            'deskripsi'    => 'required|string',
        ]);

        $solusi->update($request->only('kode', 'kerusakan_id', 'deskripsi'));

        return redirect()->route('admin.solusi.index')
            ->with('success', 'Data solusi berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        Solusi::findOrFail($id)->delete();
        return redirect()->route('admin.solusi.index')
            ->with('success', 'Data solusi berhasil dihapus.');
    }
}
