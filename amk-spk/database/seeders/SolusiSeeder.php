<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SolusiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kode'=>'S001','kerusakan_id'=>1,'deskripsi'=>'Lakukan penggantian baterai dengan baterai original atau berkualitas tinggi yang sesuai model MacBook Anda'],
            ['kode'=>'S002','kerusakan_id'=>1,'deskripsi'=>'Selalu gunakan charger original Apple (MagSafe/USB-C) atau charger bersertifikat MFi'],
            ['kode'=>'S003','kerusakan_id'=>1,'deskripsi'=>'Bawa ke teknisi untuk pemeriksaan IC pengisian daya dan logika board'],
            ['kode'=>'S004','kerusakan_id'=>2,'deskripsi'=>'Hubungkan MacBook ke monitor eksternal untuk memastikan masalah ada di layar, bukan GPU'],
            ['kode'=>'S005','kerusakan_id'=>2,'deskripsi'=>'Bawa ke teknisi untuk penggantian kabel layar atau modul layar'],
            ['kode'=>'S006','kerusakan_id'=>2,'deskripsi'=>'Jika penyebab GPU, pertimbangkan perbaikan atau penggantian logika board'],
            ['kode'=>'S007','kerusakan_id'=>3,'deskripsi'=>'Coba reset SMC (System Management Controller) terlebih dahulu'],
            ['kode'=>'S008','kerusakan_id'=>3,'deskripsi'=>'Pastikan baterai terhubung dengan baik, coba cas beberapa saat sebelum menyalakan'],
            ['kode'=>'S009','kerusakan_id'=>3,'deskripsi'=>'Bawa ke teknisi untuk diagnosa dan perbaikan logika board'],
            ['kode'=>'S010','kerusakan_id'=>4,'deskripsi'=>'Segera matikan MacBook jika terkena cairan, jangan nyalakan sebelum dipastikan kering'],
            ['kode'=>'S011','kerusakan_id'=>4,'deskripsi'=>'Gunakan keyboard eksternal sebagai alternatif sementara'],
            ['kode'=>'S012','kerusakan_id'=>4,'deskripsi'=>'Bawa ke teknisi untuk pembersihan atau penggantian keyboard'],
            ['kode'=>'S013','kerusakan_id'=>5,'deskripsi'=>'Bersihkan ventilasi MacBook dari debu menggunakan udara bertekanan'],
            ['kode'=>'S014','kerusakan_id'=>5,'deskripsi'=>'Hindari meletakkan MacBook di permukaan yang menghalangi ventilasi (kasur, sofa)'],
            ['kode'=>'S015','kerusakan_id'=>5,'deskripsi'=>'Bawa ke teknisi untuk penggantian pasta termal dan servis kipas'],
            ['kode'=>'S016','kerusakan_id'=>6,'deskripsi'=>'Coba reset NVRAM/PRAM dan SMC terlebih dahulu'],
            ['kode'=>'S017','kerusakan_id'=>6,'deskripsi'=>'Bawa ke teknisi untuk pemeriksaan dan penggantian kartu WiFi atau antena'],
            ['kode'=>'S018','kerusakan_id'=>7,'deskripsi'=>'Periksa pengaturan suara di System Preferences, pastikan tidak dalam mode mute'],
            ['kode'=>'S019','kerusakan_id'=>7,'deskripsi'=>'Coba gunakan headphone untuk memastikan masalah ada di speaker, bukan software'],
            ['kode'=>'S020','kerusakan_id'=>7,'deskripsi'=>'Bawa ke teknisi untuk penggantian speaker atau perbaikan konektor audio'],
            ['kode'=>'S021','kerusakan_id'=>8,'deskripsi'=>'Restart MacBook dan periksa apakah kamera muncul di System Information'],
            ['kode'=>'S022','kerusakan_id'=>8,'deskripsi'=>'Reset SMC dan NVRAM, kemudian periksa ulang'],
            ['kode'=>'S023','kerusakan_id'=>8,'deskripsi'=>'Bawa ke teknisi untuk pemeriksaan kabel dan modul kamera'],
            ['kode'=>'S024','kerusakan_id'=>9,'deskripsi'=>'Tutup aplikasi yang tidak digunakan dan periksa Activity Monitor untuk proses berat'],
            ['kode'=>'S025','kerusakan_id'=>9,'deskripsi'=>'Kosongkan ruang penyimpanan minimal 10-15% dari total kapasitas SSD'],
            ['kode'=>'S026','kerusakan_id'=>9,'deskripsi'=>'Jalankan pemindaian malware dan pertimbangkan instal ulang macOS jika diperlukan'],
            ['kode'=>'S027','kerusakan_id'=>10,'deskripsi'=>'Periksa port secara fisik, bersihkan dari debu menggunakan sikat halus'],
            ['kode'=>'S028','kerusakan_id'=>10,'deskripsi'=>'Coba restart MacBook dan reset SMC'],
            ['kode'=>'S029','kerusakan_id'=>10,'deskripsi'=>'Bawa ke teknisi untuk perbaikan port atau controller USB/Thunderbolt'],
        ];

        foreach ($data as $item) {
            DB::table('solusis')->insert(array_merge($item, ['created_at'=>now(),'updated_at'=>now()]));
        }
    }
}
