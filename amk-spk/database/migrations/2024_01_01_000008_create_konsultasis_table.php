<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konsultasis', function (Blueprint $table) {
            $table->id();
            $table->string('model_macbook', 100)->nullable();
            $table->foreignId('hasil_kerusakan_id')->nullable()->constrained('kerusakans')->nullOnDelete();
            $table->enum('status_diagnosis', ['terdiagnosis', 'tidak_terdiagnosis'])->default('tidak_terdiagnosis');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konsultasis');
    }
};
