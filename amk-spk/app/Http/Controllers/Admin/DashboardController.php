<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kerusakan;
use App\Models\Gejala;
use App\Models\Aturan;
use App\Models\Konsultasi;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'kerusakan'            => Kerusakan::count(),
            'gejala'               => Gejala::count(),
            'aturan'               => Aturan::count(),
            'konsultasi'           => Konsultasi::count(),
            'terdiagnosis'         => Konsultasi::where('status_diagnosis', 'terdiagnosis')->count(),
            'tidak_terdiagnosis'   => Konsultasi::where('status_diagnosis', 'tidak_terdiagnosis')->count(),
        ];

        $riwayatTerbaru = Konsultasi::with('kerusakan')
            ->latest()
            ->take(5)
            ->get();

        // 3 kerusakan paling sering terdiagnosis
        $topKerusakan = Konsultasi::select('hasil_kerusakan_id',
                \Illuminate\Support\Facades\DB::raw('COUNT(*) as total'))
            ->where('status_diagnosis', 'terdiagnosis')
            ->whereNotNull('hasil_kerusakan_id')
            ->groupBy('hasil_kerusakan_id')
            ->orderByDesc('total')
            ->take(3)
            ->with('kerusakan')
            ->get();

        return view('admin.dashboard', compact('stats', 'riwayatTerbaru', 'topKerusakan'));
    }
}
