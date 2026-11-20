<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('admins')->updateOrInsert(
            ['username' => 'admin'],
            [
                'password'     => Hash::make('admin123'),
                'nama_lengkap' => 'Administrator aMK',
                'email'        => 'dewishinta0128@gmail.com',
                'created_at'   => now(),
                'updated_at'   => now(),
            ]
        );

        // Verifikasi langsung setelah insert
        $count = DB::table('admins')->count();
        echo "AdminSeeder: {$count} admin(s) in DB\n";
    }
}
