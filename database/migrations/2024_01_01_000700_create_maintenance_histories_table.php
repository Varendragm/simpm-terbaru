<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Riwayat maintenance gabungan: hasil PM tervalidasi (source=pm)
     * dan sinkronisasi dari SIPPM (source=sippm) — lihat design.md §4.5.
     */
    public function up(): void
    {
        Schema::create('maintenance_histories', function (Blueprint $table) {
            $table->id();
            $table->string('no_laporan')->unique();
            $table->foreignId('machine_id')->constrained('machines')->cascadeOnDelete();
            $table->foreignId('pm_schedule_id')->nullable()->constrained('pm_schedules')->nullOnDelete();
            $table->enum('source', ['pm', 'sippm'])->default('pm');
            $table->string('kategori')->nullable(); // Mekanik | Elektrik | Instrumentasi
            $table->string('pekerjaan');
            $table->string('pelaksana')->nullable();
            $table->unsignedInteger('downtime_menit')->default(0);
            $table->string('hasil')->nullable(); // Baik / Perlu Tindak Lanjut / dsb.
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_histories');
    }
};
