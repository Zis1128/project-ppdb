<?php

namespace Database\Seeders;

use App\Models\Pengaturan;
use Illuminate\Database\Seeder;

class PengaturanSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            [
                'key' => 'app_name',
                'value' => 'PPDB SMK Negeri 1',
                'label' => 'Nama Aplikasi',
                'type' => 'text',
                'description' => 'Nama sekolah atau institusi',
                'group' => 'general',
            ],
            [
                'key' => 'app_logo',
                'value' => null,
                'label' => 'Logo Aplikasi',
                'type' => 'text',
                'description' => 'Path logo sekolah',
                'group' => 'general',
            ],
            [
                'key' => 'contact_email',
                'value' => 'info@smk.sch.id',
                'label' => 'Email Kontak',
                'type' => 'text',
                'description' => 'Email untuk kontak',
                'group' => 'general',
            ],
            [
                'key' => 'contact_phone',
                'value' => '0271-123456',
                'label' => 'Telepon Kontak',
                'type' => 'text',
                'description' => 'Nomor telepon sekolah',
                'group' => 'general',
            ],
            [
                'key' => 'address',
                'value' => 'Jl. Pendidikan No. 123, Kota',
                'label' => 'Alamat Sekolah',
                'type' => 'text',
                'description' => 'Alamat lengkap sekolah',
                'group' => 'general',
            ],
            
            // Payment
            [
                'key' => 'biaya_pendaftaran',
                'value' => '250000',
                'label' => 'Biaya Pendaftaran',
                'type' => 'number',
                'description' => 'Biaya pendaftaran dalam Rupiah',
                'group' => 'payment',
            ],
            [
                'key' => 'bank_name',
                'value' => 'Bank BNI',
                'label' => 'Nama Bank',
                'type' => 'text',
                'description' => 'Nama bank untuk transfer',
                'group' => 'payment',
            ],
            [
                'key' => 'bank_account_number',
                'value' => '1234567890',
                'label' => 'Nomor Rekening',
                'type' => 'text',
                'description' => 'Nomor rekening sekolah',
                'group' => 'payment',
            ],
            [
                'key' => 'bank_account_name',
                'value' => 'SMK Negeri 1',
                'label' => 'Atas Nama Rekening',
                'type' => 'text',
                'description' => 'Nama pemilik rekening',
                'group' => 'payment',
            ],
            
            // Notification
            [
                'key' => 'email_notification',
                'value' => 'true',
                'label' => 'Notifikasi Email',
                'type' => 'boolean',
                'description' => 'Aktifkan notifikasi via email',
                'group' => 'notification',
            ],
            [
                'key' => 'whatsapp_notification',
                'value' => 'false',
                'label' => 'Notifikasi WhatsApp',
                'type' => 'boolean',
                'description' => 'Aktifkan notifikasi via WhatsApp',
                'group' => 'notification',
            ],
            
            // System
            [
                'key' => 'max_file_size',
                'value' => '2048',
                'label' => 'Maksimal Ukuran File (KB)',
                'type' => 'number',
                'description' => 'Maksimal ukuran file upload',
                'group' => 'system',
            ],
            [
                'key' => 'allowed_file_types',
                'value' => json_encode(['jpg', 'jpeg', 'png', 'pdf']),
                'label' => 'Tipe File Diizinkan',
                'type' => 'json',
                'description' => 'Tipe file yang boleh diupload',
                'group' => 'system',
            ],
        ];

        foreach ($settings as $setting) {
            Pengaturan::create($setting);
        }
    }
}