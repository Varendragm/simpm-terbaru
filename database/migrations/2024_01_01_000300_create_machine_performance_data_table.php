<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Data operasional mentah per mesin per periode (bulan).
     * Indikator performa (OEE, Availability, MTTR, dst) DIHITUNG dari tabel ini
     * lewat App\Services\PerformanceCalculator — bukan disimpan sebagai angka jadi,
     * sesuai PRD §6.8 / design.md §5.
     */
    public function up(): void
    {
        Schema::create('machine_performance_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machine_id')->constrained('machines')->cascadeOnDelete();
            $table->char('period', 7); // format: YYYY-MM
            $table->unsignedInteger('planned_time_minutes')->default(0);
            $table->unsignedInteger('downtime_minutes')->default(0);
            $table->unsignedInteger('repair_time_minutes')->default(0);
            $table->unsignedInteger('failure_count')->default(0);
            $table->unsignedInteger('actual_output')->nullable();
            $table->unsignedInteger('ideal_output')->nullable();
            $table->unsignedInteger('good_output')->nullable();
            $table->timestamps();

            $table->unique(['machine_id', 'period']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('machine_performance_data');
    }
};
