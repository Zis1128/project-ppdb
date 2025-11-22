<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jurusan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'icon',
        'kuota',
        'passing_grade',
        'is_active',
        'urutan',
    ];

    protected $casts = [
        'passing_grade' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function pendaftaransPilihan1()
    {
        return $this->hasMany(Pendaftaran::class, 'jurusan_pilihan_1');
    }

    public function pendaftaransPilihan2()
    {
        return $this->hasMany(Pendaftaran::class, 'jurusan_pilihan_2');
    }

    public function pendaftaransDiterima()
    {
        return $this->hasMany(Pendaftaran::class, 'jurusan_diterima');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('urutan');
    }
}