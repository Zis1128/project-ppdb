<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jalur_masuks', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Reguler, Prestasi, Afirmasi
            $table->string('kode')->unique(); // REG, PRES, AFI
            $table->text('deskripsi')->nullable();
            $table->text('persyaratan')->nullable(); // JSON array persyaratan khusus
            $table->integer('kuota_persen')->default(0); // persentase dari kuota jurusan
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jalur_masuks');
    }
};