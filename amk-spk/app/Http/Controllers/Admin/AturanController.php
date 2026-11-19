<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aturan;
use App\Models\Kerusakan;
use App\Models\Gejala;
use Illuminate\Http\Request;

class AturanController extends Controller
{
    public function index(Request $request)
    {
        $query = Aturan::with(['kerusakan', 'gejalas']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('kode', 'like', "%{$search}%")
                  ->orWhereHas('kerusakan', fn($q) => $q->where('nama', 'like', "%{$search}%"));
        }

        $aturans = $query->orderBy('kode')->paginate(10)->withQueryString();
        return view('admin.aturan.index', compact('aturans'));
    }

    public function create()
    {
        $nextKode   = 'R' . str_pad(Aturan::count() + 1, 3, '0', STR_PAD_LEFT);
        $kerusakans = Kerusakan::orderBy('kode')->get();
        $gejalas    = Gejala::orderBy('kode')->get();
        return view('admin.aturan.create', compact('nextKode', 'kerusakans', 'gejalas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode'         => 'required|string|max:10|unique:aturans,kode',
            'kerusakan_id' => 'required|exists:kerusakans,id',
            'gejala_ids'   => 'required|array|min:1',
            'gejala_ids.*' => 'exists:gejalas,id',
        ], [
            'gejala_ids.required' => 'Pilih minimal satu gejala kondisi.',
            'gejala_ids.min'      => 'Pilih minimal satu gejala kondisi.',
        ]);

        $aturan = Aturan::create($request->only('kode', 'kerusakan_id'));
        $aturan->gejalas()->sync($request->gejala_ids);

        return redirect()->route('admin.aturan.index')
            ->with('success', 'Aturan diagnosis berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $aturan     = Aturan::with('gejalas')->findOrFail($id);
        $kerusakans = Kerusakan::orderBy('kode')->get();
        $gejalas    = Gejala::orderBy('kode')->get();
        $selectedGejala = $aturan->gejalas->pluck('id')->toArray();
        return view('admin.aturan.edit', compact('aturan', 'kerusakans', 'gejalas', 'selectedGejala'));
    }

    public function update(Request $request, string $id)
    {
        $aturan = Aturan::findOrFail($id);

        $request->validate([
            'kode'         => 'required|string|max:10|unique:aturans,kode,' . $id,
            'kerusakan_id' => 'required|exists:kerusakans,id',
            'gejala_ids'   => 'required|array|min:1',
            'gejala_ids.*' => 'exists:gejalas,id',
        ]);

        $aturan->update($request->only('kode', 'kerusakan_id'));
        $aturan->gejalas()->sync($request->gejala_ids);

        return redirect()->route('admin.aturan.index')
            ->with('success', 'Aturan diagnosis berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        Aturan::findOrFail($id)->delete();
        return redirect()->route('admin.aturan.index')
            ->with('success', 'Aturan diagnosis berhasil dihapus.');
    }
}
