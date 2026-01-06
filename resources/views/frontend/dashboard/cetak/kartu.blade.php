<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Peserta - {{ $pendaftaran->no_pendaftaran }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .card-container {
            width: 85mm;
            height: 54mm;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 8px;
            padding: 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
        }

        .card-header {
            background: rgba(255, 255, 255, 0.95);
            padding: 8px 12px;
            text-align: center;
        }

        .card-header h1 {
            font-size: 14px;
            color: #333;
            margin-bottom: 2px;
        }

        .card-header h2 {
            font-size: 11px;
            color: #666;
            font-weight: normal;
        }

        .card-body {
            padding: 12px;
            color: white;
        }

        .card-row {
            display: flex;
            margin-bottom: 10px;
        }

        .photo-box {
            width: 3cm;
            height: 4cm;
            background: white;
            border: 2px solid white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            flex-shrink: 0;
            font-size: 10px;
            color: #999;
        }

        .info-section {
            flex: 1;
            font-size: 10px;
        }

        .info-row {
            margin-bottom: 6px;
            display: flex;
        }

        .info-label {
            width: 70px;
            font-weight: bold;
        }

        .info-value {
            flex: 1;
            font-weight: bold;
        }

        .barcode-section {
            text-align: center;
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px dashed rgba(255, 255, 255, 0.3);
        }

        .barcode-box {
            background: white;
            padding: 5px;
            display: inline-block;
            margin-bottom: 5px;
        }

        .barcode {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            font-weight: bold;
            color: #333;
            letter-spacing: 2px;
        }

        .card-footer {
            font-size: 8px;
            text-align: center;
            color: rgba(255, 255, 255, 0.8);
        }

        .decoration {
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }

        .decoration-1 {
            top: -100px;
            right: -100px;
        }

        .decoration-2 {
            bottom: -100px;
            left: -100px;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .card-container {
                box-shadow: none;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="card-container">
        <!-- Decorations -->
        <div class="decoration decoration-1"></div>
        <div class="decoration decoration-2"></div>

        <!-- Header -->
        <div class="card-header">
            <h1>KARTU PESERTA PPDB</h1>
            <h2>SMK ISLAM YPI 2 WAY JEPARA - T.A {{ $pendaftaran->tahunAjaran->nama }}</h2>
        </div>

        <!-- Body -->
        <div class="card-body">
            <div class="card-row">
                <!-- Photo -->
                <div class="photo-box">
                    <p>FOTO<br>3x4</p>
                </div>

                <!-- Info -->
                <div class="info-section">
                    <div class="info-row">
                        <div class="info-label">No. Daftar</div>
                        <div class="info-value">: {{ $pendaftaran->no_pendaftaran }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Nama</div>
                        <div class="info-value">: {{ strtoupper($pendaftaran->nama_lengkap) }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">NISN</div>
                        <div class="info-value">: {{ $pendaftaran->nisn }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Asal Sekolah</div>
                        <div class="info-value">: {{ $pendaftaran->asal_sekolah }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Jurusan</div>
                        <div class="info-value">: {{ $pendaftaran->jurusanPilihan1->nama }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Jalur</div>
                        <div class="info-value">: {{ $pendaftaran->jalurMasuk->nama }}</div>
                    </div>
                </div>
            </div>

            <!-- Barcode -->
            <div class="barcode-section">
                <div class="barcode-box">
                    <div class="barcode">{{ $pendaftaran->no_pendaftaran }}</div>
                </div>
                <div class="card-footer">
                    Tunjukkan kartu ini saat pelaksanaan tes/wawancara
                </div>
            </div>
        </div>
    </div>

    <!-- Print Button -->
    <div class="no-print" style="position: fixed; bottom: 20px; right: 20px;">
        <button onclick="window.print()"
            style="padding: 10px 20px; background: #2563eb; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px;">
            🖨️ Cetak Kartu
        </button>
    </div>
</body>

</html>
