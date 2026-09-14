<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inspection_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pm_schedule_id')->unique()->constrained('pm_schedules')->cascadeOnDelete();
            $table->enum('kategori', ['mekanik', 'elektrik', 'instrumentasi']);
            $table->json('parameter_teknis')->nullable();
            $table->text('deskripsi_temuan')->nullable();
            $table->text('tindakan')->nullable();
            $table->text('rekomendasi')->nullable();
            $table->unsignedInteger('downtime_menit')->default(0);
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
        });

        Schema::create('sparepart_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspection_report_id')->constrained('inspection_reports')->cascadeOnDelete();
            $table->string('nama');
            $table->decimal('jumlah', 10, 2)->default(0);
            $table->string('satuan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sparepart_usages');
        Schema::dropIfExists('inspection_reports');
    }
};
