<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'kunci'  => 'hero_judul',
                'nilai'  => 'Diagnosis Kerusakan MacBook Dengan Cepat',
                'tipe'   => 'text',
                'label'  => 'Judul Hero',
            ],
            [
                'kunci'  => 'hero_deskripsi',
                'nilai'  => 'Temukan kemungkinan kerusakan MacBook Anda berdasarkan gejala yang dialami. Sistem akan memberikan analisis awal lengkap dengan penyebab dan solusi penanganan.',
                'tipe'   => 'textarea',
                'label'  => 'Deskripsi Hero',
            ],
            [
                'kunci'  => 'tentang_deskripsi',
                'nilai'  => 'anaMac Komputer adalah toko layanan perbaikan MacBook terpercaya yang menggunakan sistem pakar untuk membantu diagnosis awal kerusakan.',
                'tipe'   => 'textarea',
                'label'  => 'Deskripsi Tentang',
            ],
            [
                'kunci'  => 'logo',
                'nilai'  => null,
                'tipe'   => 'image',
                'label'  => 'Logo',
            ],
            [
                'kunci'  => 'banner_hero',
                'nilai'  => null,
                'tipe'   => 'image',
                'label'  => 'Banner Hero',
            ],
        ];

        foreach ($settings as $setting) {
            DB::table('site_settings')->updateOrInsert(
                ['kunci' => $setting['kunci']],
                array_merge($setting, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
