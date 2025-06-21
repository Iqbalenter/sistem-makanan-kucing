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
        Schema::create('calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alternative_id')->constrained('alternatives')->onDelete('cascade');
            $table->decimal('final_score', 8, 6); // Skor akhir hasil perhitungan SMART
            $table->integer('rank'); // Peringkat berdasarkan skor
            $table->json('calculation_details')->nullable(); // Detail perhitungan untuk debugging
            $table->timestamp('calculated_at'); // Kapan perhitungan dilakukan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calculations');
    }
};
