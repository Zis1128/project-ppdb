@extends('layouts.dashboard')

@section('title', 'Pembayaran Pending')

@section('content')
    <div class="container mx-auto px-4 py-8">

        <div class="max-w-2xl mx-auto">

            <!-- Pending Card -->
            <div class="bg-white rounded-xl shadow-lg p-8 text-center">

                <!-- Pending Icon -->
                <div class="w-24 h-24 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-yellow-600 animate-spin" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>

                <!-- Title -->
                <h1 class="text-3xl font-bold text-gray-900 mb-3">Pembayaran Sedang Diproses</h1>
                <p class="text-lg text-gray-600 mb-8">Transaksi Anda sedang dalam proses verifikasi</p>

                <!-- Pending Message -->
                <div class="bg-yellow-50 border-2 border-yellow-200 rounded-xl p-6 mb-8">
                    <div class="flex items-start space-x-3">
                        <svg class="w-6 h-6 text-yellow-600 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <div class="text-left">
                            <h3 class="font-semibold text-yellow-900 mb-2">Status: Menunggu Pembayaran</h3>
                            <p class="text-sm text-yellow-800 mb-3">
                                Pembayaran Anda sedang dalam proses. Silakan selesaikan pembayaran melalui metode yang Anda
                                pilih.
                            </p>
                            <ul class="text-sm text-yellow-800 space-y-1 list-disc list-inside">
                                <li>Untuk Virtual Account: Transfer sesuai nominal ke nomor VA yang diberikan</li>
                                <li>Untuk E-Wallet: Selesaikan pembayaran di aplikasi masing-masing</li>
                                <li>Untuk COD (Indomaret/Alfamart): Lakukan pembayaran di kasir</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Timer Info (optional) -->
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-8">
                    <p class="text-sm text-red-800">
                        <svg class="w-5 h-5 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <strong>Perhatian:</strong> Selesaikan pembayaran dalam waktu 24 jam untuk menghindari pembatalan
                        otomatis
                    </p>
                </div>

                <!-- Payment Instructions -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-8">
                    <h3 class="font-semibold text-blue-900 mb-4 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        Cara Menyelesaikan Pembayaran
                    </h3>
                    <ol class="text-left text-sm text-blue-800 space-y-2">
                        <li class="flex items-start">
                            <span class="font-bold mr-2">1.</span>
                            <span>Cek email Anda untuk instruksi pembayaran lengkap</span>
                        </li>
                        <li class="flex items-start">
                            <span class="font-bold mr-2">2.</span>
                            <span>Selesaikan pembayaran sesuai metode yang Anda pilih</span>
                        </li>
                        <li class="flex items-start">
                            <span class="font-bold mr-2">3.</span>
                            <span>Status akan otomatis berubah setelah pembayaran berhasil</span>
                        </li>
                        <li class="flex items-start">
                            <span class="font-bold mr-2">4.</span>
                            <span>Cek kembali halaman pembayaran untuk melihat status terkini</span>
                        </li>
                    </ol>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-3">
                    <a href="{{ route('dashboard.pembayaran.index') }}"
                        class="w-full inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                            </path>
                        </svg>
                        Cek Status Pembayaran
                    </a>

                    <a href="{{ route('dashboard.pendaftaran.index') }}"
                        class="w-full inline-flex items-center justify-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Dashboard
                    </a>
                </div>

            </div>

            <!-- Help Card -->
            <div class="mt-6 bg-gray-50 rounded-xl p-6 text-center">
                <p class="text-sm text-gray-600">
                    Mengalami kendala?
                    <a href="{{ route('kontak') }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                        Hubungi Customer Service
                    </a>
                </p>
            </div>

        </div>

    </div>

    <script>
        // Auto refresh after 30 seconds to check payment status
        setTimeout(function() {
            location.reload();
        }, 30000);
    </script>
@endsection
