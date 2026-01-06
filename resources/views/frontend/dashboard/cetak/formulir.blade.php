<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran - {{ $pendaftaran->no_pendaftaran }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #000;
            padding-bottom: 15px;
        }

        .header h1 {
            font-size: 18px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .header h2 {
            font-size: 16px;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 11px;
            color: #666;
        }

        .info-box {
            background: #f5f5f5;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
        }

        .info-box table {
            width: 100%;
        }

        .info-box td {
            padding: 5px;
        }

        .section-title {
            background: #333;
            color: white;
            padding: 8px 10px;
            margin-top: 20px;
            margin-bottom: 10px;
            font-weight: bold;
            font-size: 13px;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        table.data-table td {
            padding: 6px;
            border: 1px solid #ddd;
        }

        table.data-table td:first-child {
            width: 35%;
            font-weight: bold;
            background: #f9f9f9;
        }

        .foto-box {
            float: right;
            width: 4cm;
            height: 6cm;
            border: 2px solid #333;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 15px;
            margin-bottom: 15px;
        }

        .signature-box {
            margin-top: 40px;
            overflow: hidden;
        }

        .signature-item {
            float: left;
            width: 45%;
            text-align: center;
            margin: 0 2.5%;
        }

        .signature-line {
            margin-top: 60px;
            border-top: 1px solid #000;
            padding-top: 5px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        @media print {
            body {
                padding: 0;
            }

            .no-print {
                display: none;
            }
        }

        .foto-box {
            width: 113px;
            /* 3 cm */
            height: 151px;
            /* 4 cm */
            border: 2px solid #cbd5e1;
            float: right;
            margin: 0 0 15px 15px;
            background-color: #f9fafb;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .foto-box img {
            width: 113px;
            height: 151px;
            object-fit: cover;
            object-position: center;
            display: block;
        }

        .foto-box p {
            color: #999;
            text-align: center;
            margin: 0;
            font-size: 11px;
            line-height: 1.4;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>Formulir Pendaftaran Peserta Didik Baru</h1>
        <h2>SMK ISLAM YPI 2 WAY JEPARA</h2>
        <p>Tahun Ajaran {{ $pendaftaran->tahunAjaran->nama }}</p>
        <p>Jl. Pendidikan No. 123, Jakarta | Telp: 021-12345678 | Email: info@smknusantara.sch.id</p>
    </div>

    <!-- Info Pendaftaran -->
    <div class="info-box">
        <table>
            <tr>
                <td style="width: 25%;"><strong>No. Pendaftaran</strong></td>
                <td style="width: 25%;">: {{ $pendaftaran->no_pendaftaran }}</td>
                <td style="width: 25%;"><strong>Tanggal Daftar</strong></td>
                <td style="width: 25%;">:
                    {{ $pendaftaran->tanggal_daftar ? $pendaftaran->tanggal_daftar->format('d M Y') : '-' }}</td>
            </tr>
            <tr>
                <td><strong>Jalur Masuk</strong></td>
                <td>: {{ $pendaftaran->jalurMasuk->nama }}</td>
                <td><strong>Gelombang</strong></td>
                <td>: {{ $pendaftaran->gelombang->nama }}</td>
            </tr>
        </table>
    </div>

    <!-- Foto -->
    <div class="foto-box">
        @php
            // Prioritas: ambil foto dari user dulu, kalau tidak ada ambil dari pendaftaran
            $fotoPath = null;

            // Cek foto di tabel users
            if (
                $pendaftaran->user &&
                $pendaftaran->user->foto &&
                file_exists(storage_path('app/public/' . $pendaftaran->user->foto))
            ) {
                $fotoPath = storage_path('app/public/' . $pendaftaran->user->foto);
            }
            // Kalau tidak ada, cek foto di tabel pendaftaran
            elseif ($pendaftaran->foto && file_exists(storage_path('app/public/' . $pendaftaran->foto))) {
                $fotoPath = storage_path('app/public/' . $pendaftaran->foto);
            }
        @endphp

        @if ($fotoPath)
            {{-- Convert foto ke base64 untuk PDF --}}
            @php
                $fotoType = pathinfo($fotoPath, PATHINFO_EXTENSION);
                $fotoData = base64_encode(file_get_contents($fotoPath));
                $fotoBase64 = 'data:image/' . $fotoType . ';base64,' . $fotoData;
            @endphp

            <img src="{{ $fotoBase64 }}" alt="Foto Siswa">
        @else
            {{-- Placeholder jika foto belum ada --}}
            <p>FOTO<br>3x4</p>
        @endif
    </div>

    <!-- Data Pribadi -->
    <div class="section-title">A. DATA PRIBADI</div>
    <table class="data-table">
        <tr>
            <td>NISN</td>
            <td>{{ $pendaftaran->nisn }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>{{ $pendaftaran->nik }}</td>
        </tr>
        <tr>
            <td>Nama Lengkap</td>
            <td>{{ strtoupper($pendaftaran->nama_lengkap) }}</td>
        </tr>
        <tr>
            <td>Tempat, Tanggal Lahir</td>
            <td>{{ $pendaftaran->tempat_lahir }}, {{ $pendaftaran->tanggal_lahir->format('d M Y') }}</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>{{ $pendaftaran->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>{{ $pendaftaran->agama }}</td>
        </tr>
        <tr>
            <td>Alamat Lengkap</td>
            <td>{{ $pendaftaran->alamat }}</td>
        </tr>
        <tr>
            <td>Kelurahan/Desa</td>
            <td>{{ $pendaftaran->kelurahan }}</td>
        </tr>
        <tr>
            <td>Kecamatan</td>
            <td>{{ $pendaftaran->kecamatan }}</td>
        </tr>
        <tr>
            <td>Kota/Kabupaten</td>
            <td>{{ $pendaftaran->kota }}</td>
        </tr>
        <tr>
            <td>Provinsi</td>
            <td>{{ $pendaftaran->provinsi }}</td>
        </tr>
        <tr>
            <td>No. HP</td>
            <td>{{ $pendaftaran->no_hp_siswa }}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>{{ $pendaftaran->email_siswa }}</td>
        </tr>
    </table>

    <!-- Data Orang Tua -->
    <div class="section-title">B. DATA ORANG TUA / WALI</div>
    <table class="data-table">
        <tr>
            <td colspan="2" style="background: #e9e9e9; font-weight: bold;">Data Ayah</td>
        </tr>
        <tr>
            <td>Nama Ayah</td>
            <td>{{ $pendaftaran->nama_ayah }}</td>
        </tr>
        <tr>
            <td>Pekerjaan Ayah</td>
            <td>{{ $pendaftaran->pekerjaan_ayah ?? '-' }}</td>
        </tr>
        <tr>
            <td>No. HP Ayah</td>
            <td>{{ $pendaftaran->no_hp_ayah ?? '-' }}</td>
        </tr>
        <tr>
            <td colspan="2" style="background: #e9e9e9; font-weight: bold;">Data Ibu</td>
        </tr>
        <tr>
            <td>Nama Ibu</td>
            <td>{{ $pendaftaran->nama_ibu }}</td>
        </tr>
        <tr>
            <td>Pekerjaan Ibu</td>
            <td>{{ $pendaftaran->pekerjaan_ibu ?? '-' }}</td>
        </tr>
        <tr>
            <td>No. HP Ibu</td>
            <td>{{ $pendaftaran->no_hp_ibu ?? '-' }}</td>
        </tr>
        @if ($pendaftaran->nama_wali)
            <tr>
                <td colspan="2" style="background: #e9e9e9; font-weight: bold;">Data Wali</td>
            </tr>
            <tr>
                <td>Nama Wali</td>
                <td>{{ $pendaftaran->nama_wali }}</td>
            </tr>
            <tr>
                <td>Pekerjaan Wali</td>
                <td>{{ $pendaftaran->pekerjaan_wali ?? '-' }}</td>
            </tr>
            <tr>
                <td>No. HP Wali</td>
                <td>{{ $pendaftaran->no_hp_wali ?? '-' }}</td>
            </tr>
        @endif
        <tr>
            <td>Penghasilan Orang Tua/Bulan</td>
            <td>{{ $pendaftaran->penghasilan_ortu ? 'Rp ' . number_format($pendaftaran->penghasilan_ortu, 0, ',', '.') : '-' }}
            </td>
        </tr>
    </table>

    <!-- Data Sekolah Asal -->
    <div class="section-title">C. DATA SEKOLAH ASAL</div>
    <table class="data-table">
        <tr>
            <td>Nama Sekolah</td>
            <td>{{ $pendaftaran->asal_sekolah }}</td>
        </tr>
        <tr>
            <td>NPSN</td>
            <td>{{ $pendaftaran->npsn_sekolah ?? '-' }}</td>
        </tr>
        <tr>
            <td>Tahun Lulus</td>
            <td>{{ $pendaftaran->tahun_lulus }}</td>
        </tr>
        <tr>
            <td>Nilai UN / Rata-rata Ijazah</td>
            <td>{{ $pendaftaran->nilai_un ?? '-' }}</td>
        </tr>
    </table>

    <!-- Pilihan Jurusan -->
    <div class="section-title">D. PILIHAN PROGRAM KEAHLIAN</div>
    <table class="data-table">
        <tr>
            <td>Pilihan 1</td>
            <td>{{ $pendaftaran->jurusanPilihan1->nama }}</td>
        </tr>
        <tr>
            <td>Pilihan 2</td>
            <td>{{ $pendaftaran->jurusanPilihan2->nama ?? '-' }}</td>
        </tr>
    </table>

    <!-- Pernyataan -->
    <div style="margin-top: 20px; padding: 10px; border: 1px solid #333;">
        <p style="text-align: justify; font-size: 11px;">
            <strong>PERNYATAAN:</strong><br>
            Saya menyatakan bahwa data yang saya isi dalam formulir ini adalah benar dan dapat dipertanggungjawabkan.
            Apabila dikemudian hari terbukti data yang saya berikan tidak benar, maka saya bersedia menerima sanksi
            sesuai ketentuan yang berlaku.
        </p>
    </div>

    <!-- Tanda Tangan -->
    <div class="signature-box">
        <div class="signature-item">
            <p>Orang Tua/Wali</p>
            <div class="signature-line">
                <p>(............................)</p>
            </div>
        </div>
        <div class="signature-item">
            <p>{{ date('d M Y') }}</p>
            <p>Calon Peserta Didik</p>
            <div class="signature-line">
                <p><strong>{{ $pendaftaran->nama_lengkap }}</strong></p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini dicetak otomatis dari Sistem PPDB Online SMK ISLAM YPI 2 WAY JEPARA</p>
        <p>Dicetak pada: {{ now()->format('d M Y H:i:s') }}</p>
    </div>

    <!-- Print Button (hidden saat print) -->
    <div class="no-print" style="position: fixed; bottom: 20px; right: 20px;">
        <button onclick="window.print()"
            style="padding: 10px 20px; background: #2563eb; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px;">
            🖨️ Cetak
        </button>
    </div>
</body>

</html>
