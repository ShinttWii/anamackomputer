<?php

namespace App\Services;

use App\Models\Aturan;
use App\Models\Kerusakan;

class ForwardChainingService
{
    /**
     * Menjalankan proses inferensi Forward Chaining
     *
     * @param array $gejalaIds  ID gejala yang dipilih customer
     * @return array  Array of Kerusakan yang terdiagnosis
     */
    public function diagnosa(array $gejalaIds): array
    {
        // Ambil semua aturan beserta gejala kondisi dan kerusakan
        $aturans = Aturan::with([
            'gejalas',
            'kerusakan.penyebabs',
            'kerusakan.solusIs',
        ])->get();

        // Fakta awal = gejala yang dipilih user
        $fakta = array_map('intval', $gejalaIds);

        // Hasil diagnosis (kerusakan yang ditemukan)
        $hasilDiagnosis = [];   // [kerusakan_id => Kerusakan]
        $aturanFired    = [];   // aturan yang sudah terpenuhi

        // Iterasi forward chaining sampai tidak ada rule baru yang terpenuhi
        do {
            $newRuleFired = false;

            foreach ($aturans as $aturan) {
                // Skip aturan yang sudah diproses
                if (in_array($aturan->id, $aturanFired)) {
                    continue;
                }

                // Ambil ID gejala kondisi aturan ini
                $kondisiIds = $aturan->gejalas->pluck('id')->map(fn($id) => (int)$id)->toArray();

                if (empty($kondisiIds)) {
                    continue;
                }

                // Cek apakah SEMUA kondisi gejala ada dalam fakta
                $gejalaMatch = array_intersect($kondisiIds, $fakta);
                $terpenuhi   = count($gejalaMatch) === count($kondisiIds);

                if ($terpenuhi) {
                    $aturanFired[] = $aturan->id;
                    $kerusakanId   = $aturan->kerusakan_id;

                    // Tambahkan ke hasil jika belum ada
                    if (!isset($hasilDiagnosis[$kerusakanId])) {
                        $hasilDiagnosis[$kerusakanId] = $aturan->kerusakan;
                        $newRuleFired = true;
                    }
                }
            }
        } while ($newRuleFired);

        return array_values($hasilDiagnosis);
    }
}
