<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Gejala;
use App\Models\Konsultasi;
use App\Services\ForwardChainingService;
use Illuminate\Http\Request;

class KonsultasiController extends Controller
{
    public function __construct(private ForwardChainingService $fc) {}

    public function index()
    {
        $gejalas = Gejala::orderBy('kode')->get();
        return view('customer.konsultasi', compact('gejalas'));
    }

    public function proses(Request $request)
    {
        $request->validate([
            'gejala_ids'   => 'required|array|min:1',
            'gejala_ids.*' => 'integer|exists:gejalas,id',
        ], [
            'gejala_ids.required' => 'Pilih minimal satu gejala untuk memulai diagnosis.',
            'gejala_ids.min'      => 'Pilih minimal satu gejala untuk memulai diagnosis.',
        ]);

        $gejalaIds    = $request->input('gejala_ids');
        $modelMacbook = $request->input('model_macbook');

        // Jalankan Forward Chaining
        $hasilList = $this->fc->diagnosa($gejalaIds);

        // Ambil hasil pertama (kerusakan paling relevan)
        $hasilKerusakan   = $hasilList[0] ?? null;
        $statusDiagnosis  = $hasilKerusakan ? 'terdiagnosis' : 'tidak_terdiagnosis';

        // Simpan konsultasi ke database
        $konsultasi = Konsultasi::create([
            'model_macbook'      => $modelMacbook ?: null,
            'hasil_kerusakan_id' => $hasilKerusakan?->id,
            'status_diagnosis'   => $statusDiagnosis,
        ]);

        // Simpan gejala yang dipilih
        $konsultasi->gejalas()->attach($gejalaIds);

        // Simpan ke session untuk halaman hasil
        session(['konsultasi_id' => $konsultasi->id]);

        return redirect()->route('hasil');
    }
}
