<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aturan_gejalas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aturan_id')->constrained('aturans')->cascadeOnDelete();
            $table->foreignId('gejala_id')->constrained('gejalas')->cascadeOnDelete();
            $table->unique(['aturan_id', 'gejala_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aturan_gejalas');
    }
};
