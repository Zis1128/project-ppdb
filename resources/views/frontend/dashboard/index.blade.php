@extends('layouts.dashboard')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <div class="space-y-6">
        <!-- Welcome Card -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-lg p-6 text-white">
            <h2 class="text-2xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}! 👋</h2>
            <p class="text-blue-100">Semoga hari Anda menyenangkan</p>
        </div>

        @if ($pendaftaran)
            <!-- Status Pendaftaran -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Status Pendaftaran</h3>
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    {{ $pendaftaran->status_pendaftaran === 'draft'
                        ? 'bg-yellow-100 text-yellow-800'
                        : ($pendaftaran->status_pendaftaran === 'submitted'
                            ? 'bg-blue-100 text-blue-800'
                            : ($pendaftaran->status_pendaftaran === 'verified'
                                ? 'bg-purple-100 text-purple-800'
                                : ($pendaftaran->status_pendaftaran === 'accepted'
                                    ? 'bg-green-100 text-green-800'
                                    : 'bg-red-100 text-red-800'))) }}">
                        {{ ucfirst($pendaftaran->status_pendaftaran) }}
                    </span>
                </div>

                <!-- Pengumuman Hasil Seleksi -->
                @if ($pendaftaran->status_pendaftaran === 'accepted')
                    <!-- DITERIMA -->
                    <div class="bg-green-50 border-2 border-green-500 rounded-xl p-6 mb-6 animate-fade-in">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0">
                                <svg class="h-16 w-16 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-2xl font-bold text-green-800">🎉 SELAMAT! ANDA DITERIMA!</h4>
                                <p class="text-green-700 mt-1">Pendaftaran Anda telah disetujui</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg p-4 space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">No. Pendaftaran:</span>
                                <span class="font-bold text-gray-900">{{ $pendaftaran->no_pendaftaran }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nama:</span>
                                <span class="font-bold text-gray-900">{{ $pendaftaran->nama_lengkap }}</span>
                            </div>
                            @if ($pendaftaran->jurusanDiterima)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Diterima di:</span>
                                    <span class="font-bold text-green-600">{{ $pendaftaran->jurusanDiterima->nama }}</span>
                                </div>
                            @else
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Jurusan:</span>
                                    <span class="font-bold text-green-600">{{ $pendaftaran->jurusanPilihan1->nama }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="mt-4 flex gap-3">
                            <a href="{{ route('dashboard.cetak.kartu') }}" target="_blank"
                                class="flex-1 inline-flex items-center justify-center px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2">
                                    </path>
                                </svg>
                                Cetak Kartu Peserta
                            </a>
                            <a href="{{ route('dashboard.cetak.formulir') }}" target="_blank"
                                class="flex-1 inline-flex items-center justify-center px-4 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                                    </path>
                                </svg>
                                Cetak Formulir
                            </a>
                        </div>
                    </div>
                @elseif($pendaftaran->status_pendaftaran === 'rejected')
                    <!-- DITOLAK -->
                    <div class="bg-red-50 border-2 border-red-500 rounded-xl p-6 mb-6">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0">
                                <svg class="h-16 w-16 text-red-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-2xl font-bold text-red-800">Mohon Maaf</h4>
                                <p class="text-red-700 mt-1">Pendaftaran Anda belum dapat kami terima</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg p-4">
                            <p class="text-gray-700 mb-3">
                                Terima kasih telah mendaftar di SMK Nusantara. Sayangnya, untuk periode ini pendaftaran Anda
                                belum dapat kami terima.
                            </p>

                            @if ($pendaftaran->catatan_verifikasi)
                                <div class="mt-3 p-3 bg-red-50 rounded-lg">
                                    <p class="text-sm font-semibold text-red-800 mb-1">Alasan:</p>
                                    <p class="text-sm text-red-700">{{ $pendaftaran->catatan_verifikasi }}</p>
                                </div>
                            @endif

                            <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                                <p class="text-sm text-blue-800">
                                    💡 <strong>Info:</strong> Anda dapat mencoba mendaftar kembali pada gelombang berikutnya
                                    atau tahun ajaran mendatang.
                                </p>
                            </div>
                        </div>
                    </div>
                @elseif($pendaftaran->status_pendaftaran === 'verified')
                    <!-- SEDANG PROSES SELEKSI -->
                    <div class="bg-purple-50 border border-purple-200 rounded-xl p-6 mb-6">
                        <div class="flex items-center">
                            <svg class="h-12 w-12 text-purple-600 animate-spin" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                </path>
                            </svg>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-purple-800">Sedang Dalam Proses Seleksi</h4>
                                <p class="text-purple-700 text-sm mt-1">Data Anda sedang ditinjau oleh panitia. Harap
                                    bersabar.</p>
                            </div>
                        </div>
                    </div>
                @elseif($pendaftaran->status_pendaftaran === 'submitted')
                    <!-- MENUNGGU VERIFIKASI -->
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-6">
                        <div class="flex items-center">
                            <svg class="h-12 w-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-blue-800">Menunggu Verifikasi</h4>
                                <p class="text-blue-700 text-sm mt-1">Pendaftaran Anda telah disubmit dan menunggu
                                    verifikasi.</p>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- DRAFT -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 mb-6">
                        <div class="flex items-center">
                            <svg class="h-12 w-12 text-yellow-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-yellow-800">Pendaftaran Belum Lengkap</h4>
                                <p class="text-yellow-700 text-sm mt-1">Silakan lengkapi data pendaftaran Anda.</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Quick Info -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">No. Pendaftaran</p>
                        <p class="font-semibold text-gray-900">{{ $pendaftaran->no_pendaftaran }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Jalur Masuk</p>
                        <p class="font-semibold text-gray-900">{{ $pendaftaran->jalurMasuk->nama }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Jurusan Pilihan</p>
                        <p class="font-semibold text-gray-900">{{ $pendaftaran->jurusanPilihan1->nama }}</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-6 flex gap-3">
                    <a href="{{ route('dashboard.pendaftaran.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Lihat Detail Pendaftaran
                    </a>
                </div>
            </div>

            <!-- Payment Status -->
            @if ($pembayaran)
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Pembayaran</h3>

                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">No. Invoice</p>
                            <p class="font-semibold">{{ $pembayaran->no_invoice }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Jumlah</p>
                            <p class="text-lg font-bold text-green-600">Rp
                                {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        {{ $pembayaran->status === 'pending'
                            ? 'bg-yellow-100 text-yellow-800'
                            : ($pembayaran->status === 'verified'
                                ? 'bg-green-100 text-green-800'
                                : 'bg-red-100 text-red-800') }}">
                                {{ $pembayaran->status === 'pending' ? 'Pending' : ($pembayaran->status === 'verified' ? 'Terverifikasi' : 'Ditolak') }}
                            </span>
                        </div>
                    </div>

                    @if ($pembayaran->status === 'pending' && !$pembayaran->bukti_pembayaran)
                        <a href="{{ route('dashboard.pembayaran.index') }}"
                            class="mt-4 block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Upload Bukti Pembayaran
                        </a>
                    @endif
                </div>
            @endif
        @else
            <!-- Belum Ada Pendaftaran -->
            <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Pendaftaran</h3>
                <p class="text-gray-600 mb-6">Mulai proses pendaftaran Anda sekarang</p>
                <a href="{{ route('dashboard.pendaftaran.create') }}"
                    class="inline-flex items-center px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-lg">
                    Daftar Sekarang
                </a>
            </div>
        @endif
    </div>
@endsection
