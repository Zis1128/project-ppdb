@extends('layouts.dashboard')

@section('title', 'Pembayaran Gagal')

@section('content')
    <div class="container mx-auto px-4 py-8">

        <div class="max-w-2xl mx-auto">

            <!-- Failed Card -->
            <div class="bg-white rounded-xl shadow-lg p-8 text-center">

                <!-- Failed Icon -->
                <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>

                <!-- Title -->
                <h1 class="text-3xl font-bold text-gray-900 mb-3">Pembayaran Gagal</h1>
                <p class="text-lg text-gray-600 mb-8">Transaksi pembayaran Anda tidak dapat diproses</p>

                <!-- Error Message -->
                <div class="bg-red-50 border-2 border-red-200 rounded-xl p-6 mb-8">
                    <div class="flex items-start space-x-3">
                        <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <div class="text-left">
                            <h3 class="font-semibold text-red-900 mb-2">Transaksi Dibatalkan atau Gagal</h3>
                            <p class="text-sm text-red-800">
                                Pembayaran Anda tidak dapat diselesaikan. Hal ini bisa disebabkan karena:
                            </p>
                            <ul class="text-sm text-red-800 mt-2 space-y-1 list-disc list-inside">
                                <li>Pembayaran dibatalkan oleh Anda</li>
                                <li>Saldo tidak mencukupi</li>
                                <li>Batas waktu pembayaran habis</li>
                                <li>Terjadi kesalahan teknis</li>
                                <li>Transaksi ditolak oleh bank/payment gateway</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- What to Do Next -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-8">
                    <h3 class="font-semibold text-blue-900 mb-4 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Apa yang Harus Dilakukan?
                    </h3>
                    <ol class="text-left text-sm text-blue-800 space-y-2">
                        <li class="flex items-start">
                            <span class="font-bold mr-2">1.</span>
                            <span>Pastikan saldo atau limit kartu Anda mencukupi</span>
                        </li>
                        <li class="flex items-start">
                            <span class="font-bold mr-2">2.</span>
                            <span>Periksa koneksi internet Anda</span>
                        </li>
                        <li class="flex items-start">
                            <span class="font-bold mr-2">3.</span>
                            <span>Coba lagi dengan metode pembayaran yang berbeda</span>
                        </li>
                        <li class="flex items-start">
                            <span class="font-bold mr-2">4.</span>
                            <span>Hubungi customer service jika masalah terus berlanjut</span>
                        </li>
                    </ol>
                </div>

                <!-- Alternative Payment Methods -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-8">
                    <p class="text-sm text-yellow-800">
                        <svg class="w-5 h-5 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <strong>Tips:</strong> Jika pembayaran online gagal, Anda bisa mencoba metode transfer bank manual
                    </p>
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
                        Coba Lagi Pembayaran
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
                <p class="text-sm text-gray-600 mb-3">
                    <strong>Butuh bantuan?</strong>
                </p>
                <div class="flex items-center justify-center space-x-4 text-sm">
                    <a href="tel:+6272112345678"
                        class="text-blue-600 hover:text-blue-700 font-semibold inline-flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                            </path>
                        </svg>
                        Telepon
                    </a>
                    <span class="text-gray-400">|</span>
                    <a href="https://wa.me/6272112345678" target="_blank"
                        class="text-green-600 hover:text-green-700 font-semibold inline-flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z">
                            </path>
                        </svg>
                        WhatsApp
                    </a>
                    <span class="text-gray-400">|</span>
                    <a href="{{ route('kontak') }}"
                        class="text-blue-600 hover:text-blue-700 font-semibold inline-flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        Email
                    </a>
                </div>
            </div>

        </div>

    </div>
@endsection
