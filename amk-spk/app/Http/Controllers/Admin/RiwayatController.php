<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Konsultasi;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $query = Konsultasi::with('kerusakan');

        if ($request->filled('status')) {
            $query->where('status_diagnosis', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('model_macbook', 'like', "%{$search}%")
                  ->orWhereHas('kerusakan', fn($r) => $r->where('nama', 'like', "%{$search}%"));
            });
        }

        $konsultasis = $query->latest()->paginate(15)->withQueryString();
        return view('admin.riwayat.index', compact('konsultasis'));
    }

    public function show(string $id)
    {
        $konsultasi = Konsultasi::with([
            'gejalas',
            'kerusakan.penyebabs',
            'kerusakan.solusIs',
        ])->findOrFail($id);

        return view('admin.riwayat.show', compact('konsultasi'));
    }
}
