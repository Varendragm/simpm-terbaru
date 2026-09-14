<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('machines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('station_id')->constrained('stations')->cascadeOnDelete();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('type')->nullable();
            $table->string('capacity')->nullable();
            $table->unsignedSmallInteger('install_year')->nullable();
            $table->enum('status', ['normal', 'perhatian', 'perbaikan'])->default('normal');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('machines');
    }
};
