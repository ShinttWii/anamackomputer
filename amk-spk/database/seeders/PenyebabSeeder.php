<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenyebabSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kode'=>'P001','kerusakan_id'=>1,'deskripsi'=>'Sel baterai mengalami penuaan alami setelah banyak siklus pengisian'],
            ['kode'=>'P002','kerusakan_id'=>1,'deskripsi'=>'Penggunaan charger tidak resmi atau daya tidak sesuai spesifikasi'],
            ['kode'=>'P003','kerusakan_id'=>1,'deskripsi'=>'Kerusakan pada IC pengatur pengisian daya (charging IC) di logika board'],
            ['kode'=>'P004','kerusakan_id'=>2,'deskripsi'=>'Kerusakan pada inverter atau backlight LED layar'],
            ['kode'=>'P005','kerusakan_id'=>2,'deskripsi'=>'Kabel layar (LVDS/eDP) putus atau longgar dari konektor'],
            ['kode'=>'P006','kerusakan_id'=>2,'deskripsi'=>'Kerusakan komponen GPU pada logika board'],
            ['kode'=>'P007','kerusakan_id'=>3,'deskripsi'=>'Kerusakan pada IC power management (PMU/SMC)'],
            ['kode'=>'P008','kerusakan_id'=>3,'deskripsi'=>'Konektor baterai longgar atau baterai sudah tidak berfungsi sama sekali'],
            ['kode'=>'P009','kerusakan_id'=>3,'deskripsi'=>'Kerusakan pada logika board yang menyebabkan tidak ada aliran daya'],
            ['kode'=>'P010','kerusakan_id'=>4,'deskripsi'=>'Masuknya cairan ke dalam keyboard yang merusak membran atau sirkuit'],
            ['kode'=>'P011','kerusakan_id'=>4,'deskripsi'=>'Debu atau kotoran menumpuk di bawah tombol keyboard'],
            ['kode'=>'P012','kerusakan_id'=>4,'deskripsi'=>'Kerusakan konektor keyboard pada logika board'],
            ['kode'=>'P013','kerusakan_id'=>5,'deskripsi'=>'Ventilasi tersumbat debu sehingga aliran udara terhambat'],
            ['kode'=>'P014','kerusakan_id'=>5,'deskripsi'=>'Pasta termal pada prosesor sudah kering dan tidak efektif'],
            ['kode'=>'P015','kerusakan_id'=>5,'deskripsi'=>'Kipas pendingin rusak atau tidak berputar optimal'],
            ['kode'=>'P016','kerusakan_id'=>6,'deskripsi'=>'Kartu WiFi (AirPort card) mengalami kerusakan fisik'],
            ['kode'=>'P017','kerusakan_id'=>6,'deskripsi'=>'Konektor atau kabel antena WiFi lepas atau rusak'],
            ['kode'=>'P018','kerusakan_id'=>7,'deskripsi'=>'Speaker mengalami kerusakan fisik akibat volume tinggi atau benturan'],
            ['kode'=>'P019','kerusakan_id'=>7,'deskripsi'=>'Konektor speaker pada logika board longgar atau rusak'],
            ['kode'=>'P020','kerusakan_id'=>8,'deskripsi'=>'Kabel konektor kamera putus atau longgar'],
            ['kode'=>'P021','kerusakan_id'=>8,'deskripsi'=>'Modul kamera FaceTime mengalami kerusakan internal'],
            ['kode'=>'P022','kerusakan_id'=>9,'deskripsi'=>'Kapasitas RAM tidak mencukupi untuk beban kerja yang diberikan'],
            ['kode'=>'P023','kerusakan_id'=>9,'deskripsi'=>'Penyimpanan (SSD) hampir penuh atau mengalami masalah'],
            ['kode'=>'P024','kerusakan_id'=>9,'deskripsi'=>'Adanya malware atau proses sistem yang berjalan berlebihan'],
            ['kode'=>'P025','kerusakan_id'=>10,'deskripsi'=>'Kerusakan fisik pada port akibat benturan atau benda asing'],
            ['kode'=>'P026','kerusakan_id'=>10,'deskripsi'=>'Kerusakan pada controller USB/Thunderbolt di logika board'],
        ];

        foreach ($data as $item) {
            DB::table('penyebabs')->insert(array_merge($item, ['created_at'=>now(),'updated_at'=>now()]));
        }
    }
}
