<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->string('email', 150)->unique()->nullable()->after('nama_lengkap');
            // Untuk verifikasi email baru saat ganti email
            $table->string('email_pending', 150)->nullable()->after('email');
            $table->string('email_verify_token', 100)->nullable()->after('email_pending');
            $table->timestamp('email_verify_expires_at')->nullable()->after('email_verify_token');
        });
    }

    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn(['email', 'email_pending', 'email_verify_token', 'email_verify_expires_at']);
        });
    }
};
