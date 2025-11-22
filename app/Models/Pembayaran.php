<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembayaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'no_invoice',
        'pendaftaran_id',
        'jumlah',
        'metode_pembayaran',
        'bank_tujuan',
        'no_rekening',
        'atas_nama',
        'bukti_pembayaran',
        'status',
        'verified_by',
        'verified_at',
        'catatan',
        'tanggal_bayar',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
        'verified_at' => 'datetime',
        'tanggal_bayar' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pembayaran) {
            if (!$pembayaran->no_invoice) {
                $pembayaran->no_invoice = self::generateNoInvoice();
            }
        });
    }

    public static function generateNoInvoice()
    {
        $year = date('Y');
        $month = date('m');
        $prefix = 'INV' . $year . $month;
        
        $lastNumber = self::where('no_invoice', 'like', $prefix . '%')
            ->orderBy('no_invoice', 'desc')
            ->first();

        if ($lastNumber) {
            $lastNum = intval(substr($lastNumber->no_invoice, -4));
            $newNum = $lastNum + 1;
        } else {
            $newNum = 1;
        }

        return $prefix . str_pad($newNum, 4, '0', STR_PAD_LEFT);
    }

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}