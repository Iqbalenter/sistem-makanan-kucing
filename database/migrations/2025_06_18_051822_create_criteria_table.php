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
        Schema::create('criteria', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique(); // C1, C2, C3, C4, C5
            $table->string('name'); // Nama kriteria
            $table->text('description')->nullable(); // Deskripsi kriteria
            $table->enum('type', ['benefit', 'cost']); // Jenis kriteria
            $table->integer('weight')->default(0); // Bobot dalam persen (0-100)
            $table->decimal('normalized_weight', 8, 4)->default(0); // Bobot ternormalisasi
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criteria');
    }
};
