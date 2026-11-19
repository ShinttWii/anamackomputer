<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KerusakanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kode' => 'K001', 'nama' => 'Kerusakan Baterai',
             'deskripsi' => 'Baterai MacBook tidak dapat menyimpan daya dengan baik, mengalami penurunan kapasitas, atau tidak dapat terisi sama sekali. Kondisi ini umumnya terjadi akibat pemakaian jangka panjang atau kerusakan sel baterai.'],
            ['kode' => 'K002', 'nama' => 'Layar Tidak Menyala',
             'deskripsi' => 'Layar MacBook tidak menampilkan gambar meskipun perangkat dalam kondisi menyala. Dapat disebabkan oleh kerusakan backlight, kabel layar, atau komponen GPU.'],
            ['kode' => 'K003', 'nama' => 'MacBook Tidak Menyala',
             'deskripsi' => 'MacBook tidak merespons sama sekali saat tombol power ditekan. Tidak ada suara, indikator, maupun tanda-tanda kehidupan lainnya.'],
            ['kode' => 'K004', 'nama' => 'Keyboard Tidak Berfungsi',
             'deskripsi' => 'Sebagian atau seluruh tombol keyboard tidak merespons saat ditekan. Dapat terjadi akibat kerusakan mekanis, masuknya cairan, atau kerusakan konektor keyboard.'],
            ['kode' => 'K005', 'nama' => 'Overheating',
             'deskripsi' => 'MacBook mengalami panas berlebih yang menyebabkan kinerja menurun, kipas berputar kencang, atau perangkat mati mendadak untuk melindungi komponen internal.'],
            ['kode' => 'K006', 'nama' => 'WiFi Tidak Terdeteksi',
             'deskripsi' => 'MacBook tidak dapat mendeteksi jaringan WiFi atau kartu WiFi tidak dikenali oleh sistem operasi. Dapat disebabkan oleh kerusakan kartu WiFi atau antena.'],
            ['kode' => 'K007', 'nama' => 'Speaker Tidak Berfungsi',
             'deskripsi' => 'Tidak ada suara yang keluar dari speaker MacBook meskipun volume telah diatur. Dapat disebabkan oleh kerusakan speaker, konektor audio, atau komponen logika board.'],
            ['kode' => 'K008', 'nama' => 'Kamera Tidak Terdeteksi',
             'deskripsi' => 'FaceTime camera tidak dikenali oleh sistem atau tidak berfungsi saat digunakan. Dapat disebabkan oleh kerusakan kamera atau kabel konektor.'],
            ['kode' => 'K009', 'nama' => 'MacBook Sering Hang/Freeze',
             'deskripsi' => 'MacBook tiba-tiba berhenti merespons, kursor tidak bergerak, atau aplikasi tidak dapat ditutup. Dapat disebabkan oleh masalah RAM, penyimpanan, atau sistem operasi.'],
            ['kode' => 'K010', 'nama' => 'Port USB/Thunderbolt Tidak Berfungsi',
             'deskripsi' => 'Port USB atau Thunderbolt pada MacBook tidak mengenali perangkat yang dihubungkan. Dapat disebabkan oleh kerusakan fisik port atau kerusakan controller.'],
        ];

        foreach ($data as $item) {
            DB::table('kerusakans')->insert(array_merge($item, ['created_at' => now(), 'updated_at' => now()]));
        }
    }
}
