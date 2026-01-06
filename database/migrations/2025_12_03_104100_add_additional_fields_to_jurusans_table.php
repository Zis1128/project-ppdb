<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jurusans', function (Blueprint $table) {
            if (!Schema::hasColumn('jurusans', 'kompetensi')) {
                $table->text('kompetensi')->nullable()->after('deskripsi');
            }
            if (!Schema::hasColumn('jurusans', 'prospek_kerja')) {
                $table->text('prospek_kerja')->nullable()->after('kompetensi');
            }
            if (!Schema::hasColumn('jurusans', 'logo')) {
                $table->string('logo')->nullable()->after('prospek_kerja');
            }
        });
    }

    public function down(): void
    {
        Schema::table('jurusans', function (Blueprint $table) {
            $table->dropColumn(['kompetensi', 'prospek_kerja', 'logo']);
        });
    }
};