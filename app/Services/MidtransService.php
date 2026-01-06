<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\Pembayaran;
use App\Models\Pendaftaran;

class MidtransService
{
    public function __construct()
    {
        $this->setConfig();
    }

    /**
     * Set Midtrans Configuration
     */
    private function setConfig()
    {
        \Midtrans\Config::$serverKey = Setting::get('midtrans_server_key');
        \Midtrans\Config::$isProduction = Setting::get('midtrans_environment') === 'production';
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    }

    /**
     * Create Snap Token for Payment
     */
    public function createTransaction(Pendaftaran $pendaftaran, Pembayaran $pembayaran)
{
    $biaya = (int) Setting::get('biaya_pendaftaran', 250000);
    $orderId = 'PPDB-' . $pendaftaran->no_pendaftaran . '-' . time();
    
    \Log::info('MidtransService: Creating transaction', [
        'order_id' => $orderId,
        'pembayaran_id' => $pembayaran->id,
        'amount' => $biaya,
    ]);

    $params = [
        'transaction_details' => [
            'order_id' => $orderId,
            'gross_amount' => $biaya,
        ],
        'customer_details' => [
            'first_name' => $pendaftaran->nama_lengkap,
            'email' => $pendaftaran->email_siswa ?? $pendaftaran->user->email,
            'phone' => $pendaftaran->no_hp_siswa,
        ],
        'item_details' => [
            [
                'id' => 'PPDB-FEE',
                'price' => $biaya,
                'quantity' => 1,
                'name' => 'Biaya Pendaftaran PPDB SMK ISLAM YPI 2',
            ],
        ],
        'callbacks' => [
            'finish' => route('dashboard.pembayaran.finish'),
        ],
    ];

    try {
        $snapToken = \Midtrans\Snap::getSnapToken($params);
        
        \Log::info('✅ Snap token generated:', ['snap_token' => substr($snapToken, 0, 20) . '...']);

        // ⚠️ FIX: Update langsung dengan property assignment + save()
        $pembayaran->midtrans_order_id = $orderId;
        $pembayaran->midtrans_transaction_status = 'pending';
        $saved = $pembayaran->save();
        
        \Log::info('Update pembayaran with order_id:', [
            'saved' => $saved,
            'pembayaran_id' => $pembayaran->id,
            'order_id' => $orderId,
        ]);
        
        // Verify with fresh query
        $check = Pembayaran::find($pembayaran->id);
        \Log::info('Verification from database:', [
            'id' => $check->id,
            'midtrans_order_id' => $check->midtrans_order_id,
        ]);

        return [
            'success' => true,
            'snap_token' => $snapToken,
            'order_id' => $orderId,
        ];

    } catch (\Exception $e) {
        \Log::error('❌ Midtrans create transaction failed:', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        
        return [
            'success' => false,
            'message' => $e->getMessage(),
        ];
    }
}

    /**
     * Get Transaction Status
     */
    public function getTransactionStatus($orderId)
    {
        try {
            $status = \Midtrans\Transaction::status($orderId);
            return [
                'success' => true,
                'data' => $status,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Handle Notification from Midtrans
     * UPDATE: Auto-verify payment when successful
     */
    public function handleNotification($notification)
    {
        try {
            $notif = new \Midtrans\Notification();

            $orderId = $notif->order_id;
            $transactionStatus = $notif->transaction_status;
            $fraudStatus = $notif->fraud_status;
            $transactionId = $notif->transaction_id;

            $pembayaran = Pembayaran::where('midtrans_order_id', $orderId)->first();

            if (!$pembayaran) {
                return [
                    'success' => false,
                    'message' => 'Pembayaran tidak ditemukan',
                ];
            }

            // Update transaction ID
            $pembayaran->midtrans_transaction_id = $transactionId;

            // Handle status - AUTO VERIFY FOR SUCCESSFUL PAYMENT
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    // ✅ AUTO VERIFIED - No manual verification needed
                    $pembayaran->status = 'verified';
                    $pembayaran->midtrans_transaction_status = 'success';
                    $pembayaran->paid_at = now();
                    $pembayaran->catatan = 'Pembayaran terverifikasi otomatis melalui Midtrans';
                }
            } else if ($transactionStatus == 'settlement') {
                // ✅ AUTO VERIFIED - No manual verification needed
                $pembayaran->status = 'verified';
                $pembayaran->midtrans_transaction_status = 'success';
                $pembayaran->paid_at = now();
                $pembayaran->catatan = 'Pembayaran terverifikasi otomatis melalui Midtrans';
            } else if ($transactionStatus == 'pending') {
                $pembayaran->status = 'pending';
                $pembayaran->midtrans_transaction_status = 'pending';
            } else if ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
                $pembayaran->status = 'rejected';
                $pembayaran->midtrans_transaction_status = 'failed';
                $pembayaran->catatan = 'Pembayaran dibatalkan atau gagal';
            }

            // Save response
            $pembayaran->midtrans_response = json_encode($notif);
            $pembayaran->save();

            // Log for debugging
            \Log::info('Midtrans Notification Handled:', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'payment_status' => $pembayaran->status,
            ]);

            return [
                'success' => true,
                'pembayaran' => $pembayaran,
            ];

        } catch (\Exception $e) {
            \Log::error('Midtrans Notification Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}