<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('persyaratans', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Foto 3x4, Ijazah, KK, dll
            $table->text('deskripsi')->nullable();
            $table->enum('jenis_file', ['image', 'pdf', 'document'])->default('image');
            $table->integer('max_size')->default(2048); // KB
            $table->boolean('is_wajib')->default(true);
            $table->boolean('is_active')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('persyaratans');
    }
};