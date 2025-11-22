<?php

namespace Database\Seeders;

use App\Models\TahunAjaran;
use App\Models\Gelombang;
use App\Models\Jurusan;
use App\Models\JalurMasuk;
use App\Models\Persyaratan;
use Illuminate\Database\Seeder;

class DataDummySeeder extends Seeder
{
    public function run(): void
    {
        // Tahun Ajaran
        $tahunAjaran = TahunAjaran::create([
            'nama' => '2024/2025',
            'tahun_mulai' => 2024,
            'tahun_selesai' => 2025,
            'tanggal_mulai' => '2024-07-01',
            'tanggal_selesai' => '2025-06-30',
            'is_active' => true,
            'keterangan' => 'Tahun ajaran 2024/2025',
        ]);

        // Gelombang
        $gelombang = Gelombang::create([
            'tahun_ajaran_id' => $tahunAjaran->id,
            'nama' => 'Gelombang 1',
            'tanggal_mulai' => '2024-01-01',
            'tanggal_selesai' => '2024-03-31',
            'tanggal_pengumuman' => '2024-04-15',
            'kuota_total' => 500,
            'is_active' => true,
            'keterangan' => 'Gelombang pendaftaran pertama',
        ]);

        // Jurusan
        $jurusans = [
            [
                'kode' => 'TKJ',
                'nama' => 'Teknik Komputer dan Jaringan',
                'deskripsi' => 'Program keahlian yang mempelajari tentang instalasi, konfigurasi, dan pemeliharaan jaringan komputer',
                'kuota' => 108,
                'passing_grade' => 75.00,
                'is_active' => true,
                'urutan' => 1,
            ],
            [
                'kode' => 'RPL',
                'nama' => 'Rekayasa Perangkat Lunak',
                'deskripsi' => 'Program keahlian yang mempelajari tentang pembuatan dan pengembangan software/aplikasi',
                'kuota' => 108,
                'passing_grade' => 75.00,
                'is_active' => true,
                'urutan' => 2,
            ],
            [
                'kode' => 'MM',
                'nama' => 'Multimedia',
                'deskripsi' => 'Program keahlian yang mempelajari tentang desain grafis, video editing, dan animasi',
                'kuota' => 72,
                'passing_grade' => 70.00,
                'is_active' => true,
                'urutan' => 3,
            ],
            [
                'kode' => 'TBSM',
                'nama' => 'Teknik & Bisnis Sepeda Motor',
                'deskripsi' => 'Program keahlian yang mempelajari tentang perawatan dan perbaikan sepeda motor',
                'kuota' => 72,
                'passing_grade' => 70.00,
                'is_active' => true,
'urutan' => 4,
],
[
'kode' => 'TKRO',
'nama' => 'Teknik Kendaraan Ringan Otomotif',
'deskripsi' => 'Program keahlian yang mempelajari tentang perawatan dan perbaikan mobil',
'kuota' => 72,
'passing_grade' => 70.00,
'is_active' => true,
'urutan' => 5,
],
[
'kode' => 'AKL',
'nama' => 'Akuntansi dan Keuangan Lembaga',
'deskripsi' => 'Program keahlian yang mempelajari tentang pembukuan, perpajakan, dan keuangan',
'kuota' => 72,
'passing_grade' => 75.00,
'is_active' => true,
'urutan' => 6,
],
];
    foreach ($jurusans as $jurusan) {
        Jurusan::create($jurusan);
    }

    // Jalur Masuk
    $jalurMasuks = [
        [
            'nama' => 'Reguler',
            'kode' => 'REG',
            'deskripsi' => 'Jalur pendaftaran reguler tanpa persyaratan khusus',
            'persyaratan' => null,
            'kuota_persen' => 70,
            'is_active' => true,
        ],
        [
            'nama' => 'Prestasi',
            'kode' => 'PRES',
            'deskripsi' => 'Jalur pendaftaran untuk siswa berprestasi',
            'persyaratan' => [
                'item' => 'Sertifikat Juara 1-3 tingkat minimal Kabupaten/Kota',
            ],
            'kuota_persen' => 20,
            'is_active' => true,
        ],
        [
            'nama' => 'Afirmasi',
            'kode' => 'AFI',
            'deskripsi' => 'Jalur pendaftaran untuk siswa kurang mampu',
            'persyaratan' => [
                'item' => 'Surat Keterangan Tidak Mampu (SKTM) dari Kelurahan/Desa',
            ],
            'kuota_persen' => 10,
            'is_active' => true,
        ],
    ];

    foreach ($jalurMasuks as $jalur) {
        JalurMasuk::create($jalur);
    }

    // Persyaratan Dokumen
    $persyaratans = [
        [
            'nama' => 'Pas Foto 3x4',
            'deskripsi' => 'Foto ukuran 3x4 dengan background merah, format JPG/PNG',
            'jenis_file' => 'image',
            'max_size' => 1024,
            'is_wajib' => true,
            'is_active' => true,
            'urutan' => 1,
        ],
        [
            'nama' => 'Ijazah/SKHUN',
            'deskripsi' => 'Scan Ijazah atau Surat Keterangan Hasil Ujian Nasional',
            'jenis_file' => 'pdf',
            'max_size' => 2048,
            'is_wajib' => true,
            'is_active' => true,
            'urutan' => 2,
        ],
        [
            'nama' => 'Kartu Keluarga',
            'deskripsi' => 'Scan Kartu Keluarga (KK)',
            'jenis_file' => 'pdf',
            'max_size' => 2048,
            'is_wajib' => true,
            'is_active' => true,
            'urutan' => 3,
        ],
        [
            'nama' => 'Akta Kelahiran',
            'deskripsi' => 'Scan Akta Kelahiran',
            'jenis_file' => 'pdf',
            'max_size' => 2048,
            'is_wajib' => true,
            'is_active' => true,
            'urutan' => 4,
        ],
        [
            'nama' => 'Rapor Semester 1-5',
            'deskripsi' => 'Scan Rapor semester 1 sampai 5 (SMP/MTs)',
            'jenis_file' => 'pdf',
            'max_size' => 5120,
            'is_wajib' => true,
            'is_active' => true,
            'urutan' => 5,
        ],
        [
            'nama' => 'Sertifikat Prestasi',
            'deskripsi' => 'Sertifikat prestasi akademik/non-akademik (jika ada)',
            'jenis_file' => 'pdf',
            'max_size' => 2048,
            'is_wajib' => false,
            'is_active' => true,
            'urutan' => 6,
        ],
        [
            'nama' => 'SKTM',
            'deskripsi' => 'Surat Keterangan Tidak Mampu dari Kelurahan/Desa (untuk jalur afirmasi)',
            'jenis_file' => 'pdf',
            'max_size' => 2048,
            'is_wajib' => false,
            'is_active' => true,
            'urutan' => 7,
        ],
    ];

    foreach ($persyaratans as $persyaratan) {
        Persyaratan::create($persyaratan);
    }
}
}