<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Jurusan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'kuota',
        'kuota_terpakai',
        'kompetensi',
        'prospek_kerja',
        'logo',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'kuota' => 'integer',
        'kuota_terpakai' => 'integer',
    ];

    // TAMBAHKAN INI - Append accessor ke JSON
    protected $appends = ['kuota_tersisa'];
    
    // Query Scopes
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeHasKuota(Builder $query): Builder
    {
        return $query->whereColumn('kuota_terpakai', '<', 'kuota');
    }

    // Relationship
    public function pendaftaranPilihan1()
    {
        return $this->hasMany(Pendaftaran::class, 'jurusan_pilihan_1');
    }

    public function pendaftaranPilihan2()
    {
        return $this->hasMany(Pendaftaran::class, 'jurusan_pilihan_2');
    }

    public function pendaftaranDiterima()
    {
        return $this->hasMany(Pendaftaran::class, 'jurusan_diterima');
    }

    // Accessor untuk kuota tersisa
    public function getKuotaTersisaAttribute(): int
    {
        return max(0, $this->kuota - $this->kuota_terpakai);
    }

    // Method untuk cek kuota
    public function kuotaHabis(): bool
    {
        return $this->kuota_terpakai >= $this->kuota;
    }

    // Method untuk increment kuota terpakai
    public function incrementKuotaTerpakai(): void
    {
        $this->increment('kuota_terpakai');
    }

    // Method untuk decrement kuota terpakai
    public function decrementKuotaTerpakai(): void
    {
        if ($this->kuota_terpakai > 0) {
            $this->decrement('kuota_terpakai');
        }
    }
}