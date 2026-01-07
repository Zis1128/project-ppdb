<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $apiUrl;
    protected $apiToken;
    protected $client;
    protected $enabled;

    public function __construct()
    {
        $this->apiUrl = config('services.whatsapp.api_url');
        $this->apiToken = config('services.whatsapp.api_token');
        $this->enabled = config('services.whatsapp.enabled', false);
        
        $this->client = new Client([
            'timeout' => 30,
            'verify' => false, // Disable SSL verification for local testing
        ]);
    }

    /**
     * Send WhatsApp message
     */
    public function sendMessage($phone, $message)
    {
        if (!$this->enabled) {
            Log::info('WhatsApp disabled, message not sent', [
                'phone' => $phone,
                'message' => substr($message, 0, 100),
            ]);
            return ['success' => false, 'message' => 'WhatsApp notification disabled'];
        }

        if (!$this->apiToken) {
            Log::error('WhatsApp API token not configured');
            return ['success' => false, 'message' => 'API token not configured'];
        }

        // Format phone number (remove +, spaces, dashes)
        $phone = $this->formatPhone($phone);

        Log::info('Sending WhatsApp message', [
            'phone' => $phone,
            'message_preview' => substr($message, 0, 100),
        ]);

        try {
            $response = $this->client->post($this->apiUrl, [
                'headers' => [
                    'Authorization' => $this->apiToken,
                ],
                'form_params' => [
                    'target' => $phone,
                    'message' => $message,
                    'countryCode' => '62', // Indonesia
                ],
            ]);

            $result = json_decode($response->getBody()->getContents(), true);

            Log::info('WhatsApp sent successfully', [
                'phone' => $phone,
                'response' => $result,
            ]);

            return [
                'success' => true,
                'message' => 'Message sent',
                'data' => $result,
            ];

        } catch (\Exception $e) {
            Log::error('WhatsApp send failed', [
                'phone' => $phone,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Format phone number to Indonesian format
     */
    protected function formatPhone($phone)
    {
        // Remove all non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Remove leading 0
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }

        // Add 62 if not exists
        if (substr($phone, 0, 2) !== '62') {
            $phone = '62' . $phone;
        }

        return $phone;
    }

    /**
     * Send welcome message after registration
     */
    public function sendWelcomeMessage($user)
    {
        $message = "🎓 *Selamat Datang di PPDB SMK Islam YPI 2!*\n\n";
        $message .= "Halo *{$user->name}*,\n\n";
        $message .= "Terima kasih telah mendaftar di sistem PPDB kami.\n\n";
        $message .= "*Langkah Selanjutnya:*\n";
        $message .= "1. Login ke dashboard\n";
        $message .= "2. Lengkapi data pendaftaran\n";
        $message .= "3. Upload dokumen yang diperlukan\n";
        $message .= "4. Lakukan pembayaran\n\n";
        $message .= "🔗 Login: " . route('login') . "\n\n";
        $message .= "Jika ada pertanyaan, hubungi panitia.\n\n";
        $message .= "_Pesan otomatis dari Sistem PPDB_";

        return $this->sendMessage($user->email, $message); // Ganti dengan phone jika ada
    }

    /**
     * Send notification after pendaftaran submitted
     */
    public function sendPendaftaranSubmitted($pendaftaran)
    {
        $message = "✅ *Pendaftaran Berhasil Disubmit!*\n\n";
        $message .= "Halo *{$pendaftaran->nama_lengkap}*,\n\n";
        $message .= "Data pendaftaran Anda telah berhasil disubmit.\n\n";
        $message .= "*Detail:*\n";
        $message .= "📋 No. Pendaftaran: *{$pendaftaran->no_pendaftaran}*\n";
        $message .= "👤 Nama: {$pendaftaran->nama_lengkap}\n";
        $message .= "📚 Jurusan: {$pendaftaran->jurusan->nama_jurusan}\n\n";
        $message .= "*Langkah Selanjutnya:*\n";
        $message .= "Silakan lakukan pembayaran biaya pendaftaran untuk melanjutkan proses.\n\n";
        $message .= "💰 Biaya: Rp " . number_format(setting('biaya_pendaftaran', 500000), 0, ',', '.') . "\n\n";
        $message .= "_Pesan otomatis dari Sistem PPDB_";

        return $this->sendMessage($pendaftaran->no_hp_siswa, $message);
    }

    /**
     * Send notification after bukti pembayaran uploaded
     */
    public function sendBuktiUploaded($pembayaran)
    {
        $pendaftaran = $pembayaran->pendaftaran;
        
        $message = "📄 *Bukti Pembayaran Diterima!*\n\n";
        $message .= "Halo *{$pendaftaran->nama_lengkap}*,\n\n";
        $message .= "Bukti pembayaran Anda telah berhasil diupload.\n\n";
        $message .= "*Detail Pembayaran:*\n";
        $message .= "🧾 No. Invoice: *{$pembayaran->no_invoice}*\n";
        $message .= "💰 Jumlah: Rp " . number_format($pembayaran->jumlah, 0, ',', '.') . "\n";
        $message .= "📅 Tanggal: " . $pembayaran->tanggal_bayar->format('d/m/Y') . "\n";
        $message .= "💳 Metode: {$pembayaran->metode_pembayaran}\n\n";
        $message .= "⏳ Status: *Menunggu Verifikasi*\n\n";
        $message .= "Bukti pembayaran Anda sedang dalam proses verifikasi oleh panitia.\n";
        $message .= "Mohon tunggu 1-2 hari kerja.\n\n";
        $message .= "_Pesan otomatis dari Sistem PPDB_";

        return $this->sendMessage($pendaftaran->no_hp_siswa, $message);
    }

    /**
     * Send notification after payment verified
     */
    public function sendPaymentVerified($pembayaran)
    {
        $pendaftaran = $pembayaran->pendaftaran;
        
        $message = "🎉 *Pembayaran Terverifikasi!*\n\n";
        $message .= "Halo *{$pendaftaran->nama_lengkap}*,\n\n";
        $message .= "Selamat! Pembayaran Anda telah diverifikasi.\n\n";
        $message .= "*Detail Pembayaran:*\n";
        $message .= "🧾 No. Invoice: *{$pembayaran->no_invoice}*\n";
        $message .= "💰 Jumlah: Rp " . number_format($pembayaran->jumlah, 0, ',', '.') . "\n";
        $message .= "✅ Status: *LUNAS*\n\n";
        $message .= "*Langkah Selanjutnya:*\n";
        $message .= "1. Download kartu peserta ujian\n";
        $message .= "2. Pantau jadwal ujian\n";
        $message .= "3. Pantau pengumuman hasil seleksi\n\n";
        $message .= "Terima kasih telah melakukan pembayaran. 🙏\n\n";
        $message .= "_Pesan otomatis dari Sistem PPDB_";

        return $this->sendMessage($pendaftaran->no_hp_siswa, $message);
    }

    /**
     * Send notification when pendaftaran accepted
     */
    public function sendPendaftaranAccepted($pendaftaran)
    {
        $message = "🎊 *SELAMAT! Anda DITERIMA!* 🎊\n\n";
        $message .= "Halo *{$pendaftaran->nama_lengkap}*,\n\n";
        $message .= "Selamat! Anda telah *DITERIMA* di:\n\n";
        $message .= "🏫 *SMK Islam YPI 2 Way Jepara*\n";
        $message .= "📚 Jurusan: *{$pendaftaran->jurusan->nama_jurusan}*\n";
        $message .= "📋 No. Pendaftaran: {$pendaftaran->no_pendaftaran}\n\n";
        $message .= "*Langkah Selanjutnya:*\n";
        $message .= "1. Download surat penerimaan\n";
        $message .= "2. Daftar ulang sesuai jadwal\n";
        $message .= "3. Lengkapi berkas administrasi\n\n";
        $message .= "Informasi lebih lanjut akan dikirimkan via email.\n\n";
        $message .= "Sampai jumpa di sekolah! 🎓\n\n";
        $message .= "_Pesan otomatis dari Sistem PPDB_";

        return $this->sendMessage($pendaftaran->no_hp_siswa, $message);
    }

    /**
     * Send notification when pendaftaran rejected
     */
    public function sendPendaftaranRejected($pendaftaran)
    {
        $message = "📢 *Pengumuman Hasil Seleksi*\n\n";
        $message .= "Halo *{$pendaftaran->nama_lengkap}*,\n\n";
        $message .= "Terima kasih telah mengikuti seleksi PPDB SMK Islam YPI 2.\n\n";
        $message .= "Setelah melalui proses seleksi, dengan berat hati kami informasikan bahwa Anda belum dapat kami terima pada tahun ajaran ini.\n\n";
        $message .= "📋 No. Pendaftaran: {$pendaftaran->no_pendaftaran}\n";
        $message .= "📚 Jurusan: {$pendaftaran->jurusan->nama_jurusan}\n\n";
        $message .= "*Catatan:*\n";
        $message .= $pendaftaran->catatan ?? "Kuota jurusan telah penuh.\n\n";
        $message .= "Jangan menyerah! Anda dapat mencoba di tahun berikutnya atau di sekolah lain.\n\n";
        $message .= "Semangat dan sukses selalu! 💪\n\n";
        $message .= "_Pesan otomatis dari Sistem PPDB_";

        return $this->sendMessage($pendaftaran->no_hp_siswa, $message);
    }

    /**
     * Send notification to admin
     */
    public function sendToAdmin($message)
    {
        $adminNumber = config('services.whatsapp.admin_number');
        
        if (!$adminNumber) {
            Log::warning('Admin WhatsApp number not configured');
            return ['success' => false, 'message' => 'Admin number not configured'];
        }

        return $this->sendMessage($adminNumber, $message);
    }
}