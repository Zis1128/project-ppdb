<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jurusans', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique(); // TKJ, RPL, MM, dll
            $table->string('nama'); // Teknik Komputer Jaringan
            $table->text('deskripsi')->nullable();
            $table->string('icon')->nullable(); // path icon/logo jurusan
            $table->integer('kuota')->default(0);
            $table->decimal('passing_grade', 5, 2)->default(0); // 75.50
            $table->boolean('is_active')->default(true);
            $table->integer('urutan')->default(0); // untuk sorting
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jurusans');
    }
};