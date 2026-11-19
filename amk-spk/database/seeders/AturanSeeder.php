<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AturanSeeder extends Seeder
{
    public function run(): void
    {
        // Aturan: [kode, kerusakan_id]
        $aturans = [
            ['kode'=>'R001','kerusakan_id'=>1],
            ['kode'=>'R002','kerusakan_id'=>1],
            ['kode'=>'R003','kerusakan_id'=>2],
            ['kode'=>'R004','kerusakan_id'=>2],
            ['kode'=>'R005','kerusakan_id'=>3],
            ['kode'=>'R006','kerusakan_id'=>4],
            ['kode'=>'R007','kerusakan_id'=>4],
            ['kode'=>'R008','kerusakan_id'=>5],
            ['kode'=>'R009','kerusakan_id'=>5],
            ['kode'=>'R010','kerusakan_id'=>6],
            ['kode'=>'R011','kerusakan_id'=>7],
            ['kode'=>'R012','kerusakan_id'=>8],
            ['kode'=>'R013','kerusakan_id'=>9],
            ['kode'=>'R014','kerusakan_id'=>9],
            ['kode'=>'R015','kerusakan_id'=>10],
        ];

        foreach ($aturans as $a) {
            DB::table('aturans')->insert(array_merge($a, ['created_at'=>now(),'updated_at'=>now()]));
        }

        // Kondisi gejala per aturan: [aturan_id, gejala_id]
        // Aturan ID urut dari insert di atas (1-15)
        $aturanGejala = [
            // R001 (id=1): G001,G002 → Kerusakan Baterai
            [1,1],[1,2],
            // R002 (id=2): G003,G004 → Kerusakan Baterai
            [2,3],[2,4],
            // R003 (id=3): G005,G007 → Layar Tidak Menyala
            [3,5],[3,7],
            // R004 (id=4): G006,G008 → Layar Tidak Menyala
            [4,6],[4,8],
            // R005 (id=5): G009,G010,G011 → MacBook Tidak Menyala
            [5,9],[5,10],[5,11],
            // R006 (id=6): G012 → Keyboard Tidak Berfungsi
            [6,12],
            // R007 (id=7): G013,G014 → Keyboard Tidak Berfungsi
            [7,13],[7,14],
            // R008 (id=8): G015,G016 → Overheating
            [8,15],[8,16],
            // R009 (id=9): G016,G017 → Overheating
            [9,16],[9,17],
            // R010 (id=10): G018,G019 → WiFi Tidak Terdeteksi
            [10,18],[10,19],
            // R011 (id=11): G020,G021 → Speaker Tidak Berfungsi
            [11,20],[11,21],
            // R012 (id=12): G022,G023 → Kamera Tidak Terdeteksi
            [12,22],[12,23],
            // R013 (id=13): G024,G025 → MacBook Sering Hang
            [13,24],[13,25],
            // R014 (id=14): G026,G024 → MacBook Sering Hang
            [14,26],[14,24],
            // R015 (id=15): G027,G028 → Port USB/Thunderbolt
            [15,27],[15,28],
        ];

        foreach ($aturanGejala as [$aturanId, $gejalaId]) {
            DB::table('aturan_gejalas')->insert([
                'aturan_id' => $aturanId,
                'gejala_id' => $gejalaId,
            ]);
        }
    }
}
