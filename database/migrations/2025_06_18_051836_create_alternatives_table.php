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
        Schema::create('alternatives', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique(); // A1, A2, A3, ..., A10
            $table->string('name'); // Nama merek makanan
            $table->text('description')->nullable(); // Deskripsi produk
            $table->decimal('protein', 5, 2); // Kandungan protein (%)
            $table->decimal('fat', 5, 2); // Kandungan lemak (%)
            $table->decimal('fiber', 5, 2); // Kandungan serat (%)
            $table->decimal('moisture', 5, 2); // Kadar air (%)
            $table->integer('price'); // Harga dalam Rupiah
            $table->string('brand')->nullable(); // Merek
            $table->string('size')->nullable(); // Ukuran kemasan
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alternatives');
    }
};
