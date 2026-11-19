<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            KerusakanSeeder::class,
            GejalaSeeder::class,
            PenyebabSeeder::class,
            SolusiSeeder::class,
            AturanSeeder::class,
        ]);
    }
}
