<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Midtrans Settings
            [
                'key' => 'midtrans_enabled',
                'value' => 'false',
                'type' => 'boolean',
                'group' => 'payment',
                'label' => 'Aktifkan Midtrans',
                'description' => 'Aktifkan atau nonaktifkan pembayaran melalui Midtrans',
            ],
            [
                'key' => 'midtrans_environment',
                'value' => 'sandbox',
                'type' => 'select',
                'group' => 'payment',
                'label' => 'Environment Midtrans',
                'description' => 'Pilih Sandbox untuk testing atau Production untuk live',
            ],
            [
                'key' => 'midtrans_client_key',
                'value' => '',
                'type' => 'text',
                'group' => 'payment',
                'label' => 'Midtrans Client Key',
                'description' => 'Client Key dari dashboard Midtrans',
            ],
            [
                'key' => 'midtrans_server_key',
                'value' => '',
                'type' => 'password',
                'group' => 'payment',
                'label' => 'Midtrans Server Key',
                'description' => 'Server Key dari dashboard Midtrans (rahasia)',
            ],
            [
                'key' => 'midtrans_merchant_id',
                'value' => '',
                'type' => 'text',
                'group' => 'payment',
                'label' => 'Midtrans Merchant ID',
                'description' => 'Merchant ID dari dashboard Midtrans',
            ],
            
            // Transfer Bank Settings
            [
                'key' => 'transfer_bank_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'payment',
                'label' => 'Aktifkan Transfer Bank',
                'description' => 'Aktifkan atau nonaktifkan pembayaran via transfer bank manual',
            ],
            [
                'key' => 'bank_name',
                'value' => 'Bank BRI',
                'type' => 'text',
                'group' => 'payment',
                'label' => 'Nama Bank',
                'description' => 'Nama bank untuk transfer manual',
            ],
            [
                'key' => 'bank_account_number',
                'value' => '1234567890',
                'type' => 'text',
                'group' => 'payment',
                'label' => 'Nomor Rekening',
                'description' => 'Nomor rekening bank',
            ],
            [
                'key' => 'bank_account_name',
                'value' => 'SMK ISLAM YPI 2',
                'type' => 'text',
                'group' => 'payment',
                'label' => 'Nama Pemilik Rekening',
                'description' => 'Nama pemilik rekening bank',
            ],
            
            // Biaya Pendaftaran
            [
                'key' => 'biaya_pendaftaran',
                'value' => '250000',
                'type' => 'number',
                'group' => 'payment',
                'label' => 'Biaya Pendaftaran',
                'description' => 'Biaya pendaftaran dalam Rupiah',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}