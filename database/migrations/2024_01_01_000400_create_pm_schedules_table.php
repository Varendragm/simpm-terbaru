<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pm_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machine_id')->constrained('machines')->cascadeOnDelete();
            $table->string('jenis'); // jenis pemeriksaan/PM
            $table->foreignId('technician_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('tanggal');
            $table->unsignedSmallInteger('interval_hari')->nullable();
            $table->enum('prioritas', ['rendah', 'sedang', 'tinggi'])->default('sedang');
            $table->enum('status', ['terjadwal', 'menunggu_validasi', 'selesai', 'ditolak'])->default('terjadwal');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pm_schedules');
    }
};
