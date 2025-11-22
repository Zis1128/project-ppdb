<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pendaftaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'no_pendaftaran',
        'user_id',
        'tahun_ajaran_id',
        'gelombang_id',
        'jalur_masuk_id',
        'nisn',
        'nik',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'alamat',
        'rt',
        'rw',
        'kelurahan',
        'kecamatan',
        'kota',
        'provinsi',
        'kode_pos',
        'no_hp_siswa',
        'email_siswa',
        'nama_ayah',
        'pekerjaan_ayah',
        'no_hp_ayah',
        'nama_ibu',
        'pekerjaan_ibu',
        'no_hp_ibu',
        'nama_wali',
        'pekerjaan_wali',
        'no_hp_wali',
        'penghasilan_ortu',
        'asal_sekolah',
        'npsn_sekolah',
        'alamat_sekolah',
        'tahun_lulus',
        'nilai_un',
        'jurusan_pilihan_1',
        'jurusan_pilihan_2',
        'status_pendaftaran',
        'status_verifikasi',
        'verified_by',
        'verified_at',
        'catatan_verifikasi',
        'nilai_akhir',
        'jurusan_diterima',
        'catatan_seleksi',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'penghasilan_ortu' => 'decimal:2',
        'nilai_un' => 'decimal:2',
        'nilai_akhir' => 'decimal:2',
        'verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pendaftaran) {
            if (!$pendaftaran->no_pendaftaran) {
                $pendaftaran->no_pendaftaran = self::generateNoPendaftaran();
            }
        });
    }

    public static function generateNoPendaftaran()
    {
        $year = date('Y');
        $month = date('m');
        $prefix = 'PPDB' . $year . $month;
        
        $lastNumber = self::where('no_pendaftaran', 'like', $prefix . '%')
            ->orderBy('no_pendaftaran', 'desc')
            ->first();

        if ($lastNumber) {
            $lastNum = intval(substr($lastNumber->no_pendaftaran, -4));
            $newNum = $lastNum + 1;
        } else {
            $newNum = 1;
        }

        return $prefix . str_pad($newNum, 4, '0', STR_PAD_LEFT);
    }

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function gelombang()
    {
        return $this->belongsTo(Gelombang::class);
    }

    public function jalurMasuk()
    {
        return $this->belongsTo(JalurMasuk::class);
    }

    public function jurusanPilihan1()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_pilihan_1');
    }

    public function jurusanPilihan2()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_pilihan_2');
    }

    public function jurusanDiterima()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_diterima');
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function dokumenSiswas()
    {
        return $this->hasMany(DokumenSiswa::class);
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }

    // Scopes
    public function scopeSubmitted($query)
    {
        return $query->where('status_pendaftaran', 'submitted');
    }

    public function scopePending($query)
    {
        return $query->where('status_verifikasi', 'pending');
    }

    public function scopeVerified($query)
    {
        return $query->where('status_verifikasi', 'approved');
    }

    public function scopeAccepted($query)
    {
        return $query->where('status_pendaftaran', 'accepted');
    }
}