@extends('layouts.dashboard')

@section('title', 'Pembayaran Berhasil')

@section('content')
    <div class="container mx-auto px-4 py-8">

        <div class="max-w-2xl mx-auto">

            <!-- Success Card -->
            <div class="bg-white rounded-xl shadow-lg p-8 text-center">

                <!-- Success Icon with Animation -->
                <div class="relative">
                    <div
                        class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 animate-bounce">
                        <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <!-- Confetti Effect -->
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-32 h-32 animate-ping opacity-75">
                            <svg class="w-full h-full text-green-300" fill="currentColor" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="10"></circle>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Title -->
                <h1 class="text-3xl font-bold text-gray-900 mb-3">Pembayaran Berhasil!</h1>
                <p class="text-lg text-gray-600 mb-8">Selamat! Pembayaran Anda telah berhasil diproses</p>

                <!-- Success Message -->
                <div class="bg-green-50 border-2 border-green-200 rounded-xl p-6 mb-8">
                    <div class="flex items-start space-x-3">
                        <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <div class="text-left">
                            <h3 class="font-semibold text-green-900 mb-2">✅ Pembayaran Berhasil & Terverifikasi Otomatis
                            </h3>
                            <p class="text-sm text-green-800">
                                Pembayaran Anda telah berhasil diproses dan <strong>otomatis terverifikasi</strong> oleh
                                sistem.
                                Tidak perlu menunggu verifikasi manual dari panitia. Data pendaftaran Anda sedang dalam
                                proses review.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Next Steps -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-8">
                    <h3 class="font-semibold text-blue-900 mb-4 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Langkah Selanjutnya
                    </h3>
                    <ol class="text-left text-sm text-blue-800 space-y-2">
                        <li class="flex items-start">
                            <span class="font-bold mr-2">1.</span>
                            <span>Tunggu konfirmasi email mengenai status pendaftaran Anda</span>
                        </li>
                        <li class="flex items-start">
                            <span class="font-bold mr-2">2.</span>
                            <span>Pantau status pendaftaran di dashboard Anda</span>
                        </li>
                        <li class="flex items-start">
                            <span class="font-bold mr-2">3.</span>
                            <span>Selesaikan upload dokumen persyaratan jika belum lengkap</span>
                        </li>
                        <li class="flex items-start">
                            <span class="font-bold mr-2">4.</span>
                            <span>Cetak kartu peserta setelah pendaftaran disetujui</span>
                        </li>
                    </ol>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-3">
                    <a href="{{ route('dashboard.pendaftaran.index') }}"
                        class="w-full inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        Kembali ke Dashboard
                    </a>

                    <a href="{{ route('dashboard.pembayaran.index') }}"
                        class="w-full inline-flex items-center justify-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                        Lihat Detail Pembayaran
                    </a>
                </div>

            </div>

            <!-- Help Card -->
            <div class="mt-6 bg-gray-50 rounded-xl p-6 text-center">
                <p class="text-sm text-gray-600">
                    Butuh bantuan?
                    <a href="{{ route('kontak') }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                        Hubungi Panitia
                    </a>
                </p>
            </div>

        </div>

    </div>

    <script>
        // Auto scroll to top
        window.scrollTo(0, 0);

        // Confetti animation (optional)
        setTimeout(function() {
            // You can add confetti library here if desired
        }, 100);
    </script>
@endsection
