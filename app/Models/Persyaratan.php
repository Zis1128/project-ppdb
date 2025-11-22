<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Persyaratan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama',
        'deskripsi',
        'jenis_file',
        'max_size',
        'is_wajib',
        'is_active',
        'urutan',
    ];

    protected $casts = [
        'is_wajib' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function dokumenSiswas()
    {
        return $this->hasMany(DokumenSiswa::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('urutan');
    }

    public function scopeWajib($query)
    {
        return $query->where('is_wajib', true);
    }
}