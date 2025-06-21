<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alternative_id')->constrained('alternatives')->onDelete('cascade');
            $table->foreignId('criteria_id')->constrained('criteria')->onDelete('cascade');
            $table->decimal('raw_value', 10, 2); // Nilai asli dari data
            $table->decimal('utility_value', 8, 6); // Nilai utility hasil normalisasi (0-1)
            $table->decimal('weighted_value', 8, 6); // Nilai setelah dikali bobot
            $table->timestamps();
            
            // Unique constraint untuk memastikan satu alternatif-kriteria hanya ada satu record
            $table->unique(['alternative_id', 'criteria_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
