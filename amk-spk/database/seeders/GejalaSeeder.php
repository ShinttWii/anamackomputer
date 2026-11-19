<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GejalaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kode' => 'G001', 'nama' => 'Baterai tidak bertambah persentasenya saat dicas',
             'deskripsi' => 'Ketika charger terhubung, indikator baterai tidak menunjukkan pengisian daya'],
            ['kode' => 'G002', 'nama' => 'MacBook hanya menyala saat terhubung charger',
             'deskripsi' => 'Perangkat tidak dapat beroperasi tanpa charger terhubung'],
            ['kode' => 'G003', 'nama' => 'Kapasitas baterai menurun drastis',
             'deskripsi' => 'Baterai cepat habis meski baru diisi penuh, kapasitas jauh di bawah normal'],
            ['kode' => 'G004', 'nama' => 'Baterai menggembung atau bengkak',
             'deskripsi' => 'Bagian bawah MacBook terlihat atau terasa tidak rata akibat baterai membengkak'],
            ['kode' => 'G005', 'nama' => 'Layar gelap total saat dinyalakan',
             'deskripsi' => 'Tidak ada tampilan pada layar meskipun perangkat menyala (terdengar suara boot)'],
            ['kode' => 'G006', 'nama' => 'Layar retak atau pecah',
             'deskripsi' => 'Terdapat keretakan fisik pada panel layar'],
            ['kode' => 'G007', 'nama' => 'Backlight layar mati (gelap tapi ada bayangan gambar)',
             'deskripsi' => 'Gambar masih ada namun sangat gelap, hanya terlihat jika diterangi cahaya'],
            ['kode' => 'G008', 'nama' => 'Layar berkedip-kedip',
             'deskripsi' => 'Tampilan layar tidak stabil, berkedip secara tidak teratur'],
            ['kode' => 'G009', 'nama' => 'MacBook tidak merespons saat tombol power ditekan',
             'deskripsi' => 'Tidak ada reaksi apapun saat menekan tombol power'],
            ['kode' => 'G010', 'nama' => 'Tidak ada lampu indikator atau suara saat dinyalakan',
             'deskripsi' => 'Tidak ada tanda kehidupan sama sekali pada perangkat'],
            ['kode' => 'G011', 'nama' => 'MacBook mati mendadak saat digunakan',
             'deskripsi' => 'Perangkat tiba-tiba mati tanpa peringatan saat sedang digunakan'],
            ['kode' => 'G012', 'nama' => 'Beberapa tombol keyboard tidak merespons',
             'deskripsi' => 'Satu atau beberapa tombol tidak berfungsi saat ditekan'],
            ['kode' => 'G013', 'nama' => 'Seluruh keyboard tidak berfungsi',
             'deskripsi' => 'Tidak ada tombol keyboard yang merespons sama sekali'],
            ['kode' => 'G014', 'nama' => 'Keyboard mengetik sendiri atau double karakter',
             'deskripsi' => 'Karakter muncul tanpa ditekan atau satu tekanan menghasilkan dua karakter'],
            ['kode' => 'G015', 'nama' => 'MacBook sangat panas saat digunakan',
             'deskripsi' => 'Suhu bodi MacBook sangat tinggi, terasa panas saat disentuh'],
            ['kode' => 'G016', 'nama' => 'Kipas berputar sangat kencang terus-menerus',
             'deskripsi' => 'Suara kipas sangat keras dan tidak berhenti meski aktivitas ringan'],
            ['kode' => 'G017', 'nama' => 'MacBook mati mendadak karena panas',
             'deskripsi' => 'Perangkat mati tiba-tiba dan menampilkan pesan thermal shutdown'],
            ['kode' => 'G018', 'nama' => 'WiFi tidak muncul di daftar jaringan',
             'deskripsi' => 'Tidak ada jaringan WiFi yang terdeteksi sama sekali'],
            ['kode' => 'G019', 'nama' => 'Ikon WiFi menampilkan tanda seru atau tidak tersedia',
             'deskripsi' => 'Sistem menunjukkan WiFi hardware tidak ditemukan'],
            ['kode' => 'G020', 'nama' => 'Tidak ada suara dari speaker',
             'deskripsi' => 'Volume normal namun tidak ada suara keluar dari speaker'],
            ['kode' => 'G021', 'nama' => 'Suara speaker pecah atau mendistorsi',
             'deskripsi' => 'Suara keluar namun kualitasnya buruk, pecah, atau bergetar tidak normal'],
            ['kode' => 'G022', 'nama' => 'Kamera tidak terdeteksi di aplikasi',
             'deskripsi' => 'FaceTime, Photo Booth, atau aplikasi lain tidak mendeteksi kamera'],
            ['kode' => 'G023', 'nama' => 'Kamera menampilkan layar hijau atau hitam',
             'deskripsi' => 'Kamera terdeteksi namun hanya menampilkan warna hijau atau hitam solid'],
            ['kode' => 'G024', 'nama' => 'MacBook sering freeze atau tidak merespons',
             'deskripsi' => 'Sistem tiba-tiba berhenti merespons, kursor tidak bisa digerakkan'],
            ['kode' => 'G025', 'nama' => 'Aplikasi sering crash sendiri',
             'deskripsi' => 'Aplikasi menutup sendiri secara tiba-tiba tanpa perintah'],
            ['kode' => 'G026', 'nama' => 'MacBook sangat lambat',
             'deskripsi' => 'Kinerja sistem sangat lambat, bahkan untuk tugas ringan sekalipun'],
            ['kode' => 'G027', 'nama' => 'Port USB tidak mengenali perangkat yang dihubungkan',
             'deskripsi' => 'Flash drive, mouse, atau perangkat USB lain tidak terdeteksi'],
            ['kode' => 'G028', 'nama' => 'Port Thunderbolt tidak berfungsi',
             'deskripsi' => 'Monitor eksternal, docking station, atau perangkat Thunderbolt tidak dikenali'],
            ['kode' => 'G029', 'nama' => 'Perangkat terkadang terdeteksi lalu hilang',
             'deskripsi' => 'Koneksi perangkat tidak stabil, terkadang muncul lalu hilang'],
        ];

        foreach ($data as $item) {
            DB::table('gejalas')->insert(array_merge($item, ['created_at' => now(), 'updated_at' => now()]));
        }
    }
}
