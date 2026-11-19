<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Kerusakan;
use App\Models\Gejala;
use App\Models\Aturan;
use App\Models\Konsultasi;
use App\Models\SiteSetting;

class BerandaController extends Controller
{
    public function index()
    {
        $stats = [
            'kerusakan'  => Kerusakan::count(),
            'gejala'     => Gejala::count(),
            'aturan'     => Aturan::count(),
            'konsultasi' => Konsultasi::count(),
        ];

        // Ambil semua settings sekaligus (efficient — 1 query)
        $settings = SiteSetting::all()->keyBy('kunci');

        return view('customer.beranda', compact('stats', 'settings'));
    }
}
