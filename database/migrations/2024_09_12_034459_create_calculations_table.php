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
            $table->string('name');
            $table->string('school');
            $table->integer('age');
            $table->string('address');
            $table->string('phone');
            $table->json('dimensions')->nullable(); // Mengizinkan nilai null            $table->string('result'); // Kolom untuk hasil perhitungan, pastikan tipe data sesuai
            $table->string('bangun_datar')->nullable();
            $table->string('bangun_ruang')->nullable();
            $table->timestamps(); // Menyimpan timestamp created_at dan updated_at
            $table->string('shape')->nullable();         // Tambahkan kolom 'shape'
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
