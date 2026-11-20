<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan foreign key checks agar truncate aman
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('aturan_gejalas')->truncate();
        DB::table('konsultasi_gejalas')->truncate();
        DB::table('konsultasis')->truncate();
        DB::table('aturans')->truncate();
        DB::table('solusis')->truncate();
        DB::table('penyebabs')->truncate();
        DB::table('gejalas')->truncate();
        DB::table('kerusakans')->truncate();
        DB::table('site_settings')->truncate();
        // admins: pakai updateOrInsert, tidak di-truncate

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->call([
            AdminSeeder::class,
            KerusakanSeeder::class,
            GejalaSeeder::class,
            PenyebabSeeder::class,
            SolusiSeeder::class,
            AturanSeeder::class,
            SiteSettingSeeder::class,
        ]);
    }
}
