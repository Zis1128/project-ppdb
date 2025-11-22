<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->string('no_pendaftaran')->unique(); // Auto generate
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajarans');
            $table->foreignId('gelombang_id')->constrained('gelombangs');
            $table->foreignId('jalur_masuk_id')->constrained('jalur_masuks');
            
            // Data Pribadi
            $table->string('nisn')->unique();
            $table->string('nik')->unique();
            $table->string('nama_lengkap');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']);
            $table->text('alamat');
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('kelurahan');
            $table->string('kecamatan');
            $table->string('kota');
            $table->string('provinsi');
            $table->string('kode_pos')->nullable();
            $table->string('no_hp_siswa');
            $table->string('email_siswa');
            
            // Data Orang Tua
            $table->string('nama_ayah');
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('no_hp_ayah')->nullable();
            $table->string('nama_ibu');
            $table->string('pekerjaan_ibu')->nullable();
            $table->string('no_hp_ibu')->nullable();
            $table->string('nama_wali')->nullable();
            $table->string('pekerjaan_wali')->nullable();
            $table->string('no_hp_wali')->nullable();
            $table->decimal('penghasilan_ortu', 12, 2)->nullable();
            
            // Data Sekolah Asal
            $table->string('asal_sekolah');
            $table->string('npsn_sekolah')->nullable();
            $table->text('alamat_sekolah')->nullable();
            $table->year('tahun_lulus');
            $table->decimal('nilai_un', 5, 2)->nullable(); // Nilai rata-rata UN/Ijazah
            
            // Pilihan Jurusan
            $table->foreignId('jurusan_pilihan_1')->constrained('jurusans');
            $table->foreignId('jurusan_pilihan_2')->nullable()->constrained('jurusans');
            
            // Status
            $table->enum('status_pendaftaran', [
                'draft', 
                'submitted', 
                'verified', 
                'rejected', 
                'accepted', 
                'confirmed'
            ])->default('draft');
            
            $table->enum('status_verifikasi', [
                'pending', 
                'approved', 
                'rejected'
            ])->default('pending');
            
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->timestamp('verified_at')->nullable();
            $table->text('catatan_verifikasi')->nullable();
            
            // Hasil Seleksi
            $table->decimal('nilai_akhir', 5, 2)->nullable();
            $table->foreignId('jurusan_diterima')->nullable()->constrained('jurusans');
            $table->text('catatan_seleksi')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('no_pendaftaran');
            $table->index('status_pendaftaran');
            $table->index('status_verifikasi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftarans');
    }
};