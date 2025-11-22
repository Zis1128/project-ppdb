<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->nullable()->after('email');
            $table->string('no_hp')->nullable()->after('username');
            $table->string('foto')->nullable()->after('no_hp');
            $table->boolean('is_active')->default(true)->after('foto');
            $table->timestamp('last_login')->nullable()->after('is_active');
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'no_hp', 'foto', 'is_active', 'last_login']);
            $table->dropSoftDeletes();
        });
    }
};