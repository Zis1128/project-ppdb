<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DokumenSiswa extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'pendaftaran_id',
        'persyaratan_id',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'status_verifikasi',
        'verified_by',
        'verified_at',
        'catatan',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    public function persyaratan()
    {
        return $this->belongsTo(Persyaratan::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function scopePending($query)
    {
        return $query->where('status_verifikasi', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status_verifikasi', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status_verifikasi', 'rejected');
    }
}