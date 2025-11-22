<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JalurMasuk extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama',
        'kode',
        'deskripsi',
        'persyaratan',
        'kuota_persen',
        'is_active',
    ];

    protected $casts = [
        'persyaratan' => 'array',
        'is_active' => 'boolean',
    ];

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}