<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Konsultasi;

class HasilController extends Controller
{
    public function index()
    {
        $konsultasiId = session('konsultasi_id');

        if (!$konsultasiId) {
            return redirect()->route('konsultasi')
                ->with('error', 'Silakan lakukan konsultasi terlebih dahulu.');
        }

        $konsultasi = Konsultasi::with([
            'gejalas',
            'kerusakan.penyebabs',
            'kerusakan.solusIs',
        ])->findOrFail($konsultasiId);

        return view('customer.hasil', compact('konsultasi'));
    }
}
