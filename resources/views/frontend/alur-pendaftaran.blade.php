@extends('layouts.frontend')

@section('title', 'Alur Pendaftaran - PPDB SMK YPI 2 Way Jepara')

@section('content')

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-900 text-white py-20 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div
                class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-blob">
            </div>
            <div
                class="absolute top-0 right-0 w-96 h-96 bg-purple-300 rounded-full mix-blend-overlay filter blur-3xl animate-blob animation-delay-2000">
            </div>
            <div
                class="absolute bottom-0 left-1/2 w-96 h-96 bg-pink-300 rounded-full mix-blend-overlay filter blur-3xl animate-blob animation-delay-4000">
            </div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <nav class="flex justify-center mb-6" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-2 text-sm">
                        <li class="inline-flex items-center">
                            <a href="{{ route('home') }}" class="text-blue-200 hover:text-white transition">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                    </path>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-2 text-white font-medium">Alur Pendaftaran</span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <div class="animate-fade-in-up">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                        Alur Pendaftaran
                        <span class="block text-blue-200 mt-2">PPDB 2025/2026</span>
                    </h1>
                    <p class="text-xl md:text-2xl text-blue-100 mb-8 max-w-3xl mx-auto leading-relaxed">
                        Ikuti langkah-langkah berikut untuk menyelesaikan proses pendaftaran dengan mudah dan cepat
                    </p>

                    <div class="grid grid-cols-3 gap-4 max-w-2xl mx-auto mt-12">
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                            <div class="text-3xl font-bold mb-1">7</div>
                            <div class="text-sm text-blue-200">Langkah Mudah</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                            <div class="text-3xl font-bold mb-1">24/7</div>
                            <div class="text-sm text-blue-200">Pendaftaran Online</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                            <div class="text-3xl font-bold mb-1">Fast</div>
                            <div class="text-sm text-blue-200">Proses Cepat</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z"
                    fill="#F9FAFB" />
            </svg>
        </div>
    </section>

    <!-- Timeline Section -->
    <section class="py-20 bg-gray-50" x-data="{ activeStep: null }">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">

                <div class="text-center mb-16">
                    <span class="inline-block bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                        LANGKAH DEMI LANGKAH
                    </span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Proses Pendaftaran yang Mudah
                    </h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Kami telah menyederhanakan proses pendaftaran menjadi 7 langkah mudah yang bisa diselesaikan dalam
                        hitungan menit
                    </p>
                </div>

                <div class="relative">
                    <div
                        class="hidden lg:block absolute left-1/2 top-0 bottom-0 w-1 bg-gradient-to-b from-blue-200 via-blue-400 to-blue-600 transform -translate-x-1/2">
                    </div>

                    <!-- Step 1 -->
                    <div class="relative mb-12" @mouseenter="activeStep = 0" @mouseleave="activeStep = null">
                        <div class="lg:grid lg:grid-cols-2 lg:gap-8 items-center">
                            <div class="lg:text-right lg:pr-8">
                                <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 md:p-8 transform hover:-translate-y-2"
                                    :class="{ 'ring-4 ring-blue-200': activeStep === 0 }">

                                    <div
                                        class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 text-white font-bold text-xl mb-4 shadow-lg">
                                        01
                                    </div>

                                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Buat Akun</h3>

                                    <span
                                        class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold mb-4">
                                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        ~2 menit
                                    </span>

                                    <p class="text-gray-600 leading-relaxed">
                                        Daftar menggunakan email aktif dan buat password yang aman. Anda akan menerima email
                                        verifikasi untuk mengaktifkan akun.
                                    </p>

                                    <div class="mt-4 pt-4 border-t border-gray-100">
                                        <div class="flex items-center text-sm text-gray-500">
                                            <div class="flex-1">
                                                <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                                    <div class="h-full bg-gradient-to-r from-blue-400 to-blue-600 rounded-full transition-all duration-500"
                                                        :style="{ width: activeStep === 0 ? '100%' : '0%' }"></div>
                                                </div>
                                            </div>
                                            <span class="ml-3 font-semibold text-blue-600">Step 1/7</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="hidden lg:flex absolute left-1/2 transform -translate-x-1/2 items-center justify-center">
                                <div class="w-20 h-20 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full shadow-2xl flex items-center justify-center border-4 border-white transition-all duration-300 hover:scale-110"
                                    :class="{ 'scale-125 ring-4 ring-blue-200': activeStep === 0 }">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                        </path>
                                    </svg>
                                </div>
                            </div>

                            <div class="hidden lg:block"></div>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative mb-12" @mouseenter="activeStep = 1" @mouseleave="activeStep = null">
                        <div class="lg:grid lg:grid-cols-2 lg:gap-8 items-center">
                            <div class="lg:order-2 lg:pl-8">
                                <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 md:p-8 transform hover:-translate-y-2"
                                    :class="{ 'ring-4 ring-indigo-200': activeStep === 1 }">

                                    <div
                                        class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-br from-indigo-400 to-indigo-600 text-white font-bold text-xl mb-4 shadow-lg">
                                        02
                                    </div>

                                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Login ke Dashboard</h3>

                                    <span
                                        class="inline-block bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-xs font-semibold mb-4">
                                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        ~1 menit
                                    </span>

                                    <p class="text-gray-600 leading-relaxed">
                                        Masuk menggunakan email dan password yang telah didaftarkan. Dashboard akan
                                        menampilkan progress pendaftaran Anda.
                                    </p>

                                    <div class="mt-4 pt-4 border-t border-gray-100">
                                        <div class="flex items-center text-sm text-gray-500">
                                            <div class="flex-1">
                                                <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                                    <div class="h-full bg-gradient-to-r from-indigo-400 to-indigo-600 rounded-full transition-all duration-500"
                                                        :style="{ width: activeStep === 1 ? '100%' : '0%' }"></div>
                                                </div>
                                            </div>
                                            <span class="ml-3 font-semibold text-indigo-600">Step 2/7</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="hidden lg:flex absolute left-1/2 transform -translate-x-1/2 items-center justify-center">
                                <div class="w-20 h-20 bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-full shadow-2xl flex items-center justify-center border-4 border-white transition-all duration-300 hover:scale-110"
                                    :class="{ 'scale-125 ring-4 ring-indigo-200': activeStep === 1 }">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                </div>
                            </div>

                            <div class="hidden lg:block lg:order-2"></div>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative mb-12" @mouseenter="activeStep = 2" @mouseleave="activeStep = null">
                        <div class="lg:grid lg:grid-cols-2 lg:gap-8 items-center">
                            <div class="lg:text-right lg:pr-8">
                                <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 md:p-8 transform hover:-translate-y-2"
                                    :class="{ 'ring-4 ring-purple-200': activeStep === 2 }">

                                    <div
                                        class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 text-white font-bold text-xl mb-4 shadow-lg">
                                        03
                                    </div>

                                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Isi Formulir Pendaftaran</h3>

                                    <span
                                        class="inline-block bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs font-semibold mb-4">
                                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        ~10 menit
                                    </span>

                                    <p class="text-gray-600 leading-relaxed">
                                        Lengkapi data diri, data orang tua, dan nilai rapor. Pilih maksimal 2 jurusan sesuai
                                        minat Anda. Data dapat disimpan dan dilanjutkan nanti.
                                    </p>

                                    <div class="mt-4 pt-4 border-t border-gray-100">
                                        <div class="flex items-center text-sm text-gray-500">
                                            <div class="flex-1">
                                                <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                                    <div class="h-full bg-gradient-to-r from-purple-400 to-purple-600 rounded-full transition-all duration-500"
                                                        :style="{ width: activeStep === 2 ? '100%' : '0%' }"></div>
                                                </div>
                                            </div>
                                            <span class="ml-3 font-semibold text-purple-600">Step 3/7</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="hidden lg:flex absolute left-1/2 transform -translate-x-1/2 items-center justify-center">
                                <div class="w-20 h-20 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full shadow-2xl flex items-center justify-center border-4 border-white transition-all duration-300 hover:scale-110"
                                    :class="{ 'scale-125 ring-4 ring-purple-200': activeStep === 2 }">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                            </div>

                            <div class="hidden lg:block"></div>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="relative mb-12" @mouseenter="activeStep = 3" @mouseleave="activeStep = null">
                        <div class="lg:grid lg:grid-cols-2 lg:gap-8 items-center">
                            <div class="lg:order-2 lg:pl-8">
                                <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 md:p-8 transform hover:-translate-y-2"
                                    :class="{ 'ring-4 ring-pink-200': activeStep === 3 }">

                                    <div
                                        class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-br from-pink-400 to-pink-600 text-white font-bold text-xl mb-4 shadow-lg">
                                        04
                                    </div>

                                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Upload Dokumen</h3>

                                    <span
                                        class="inline-block bg-pink-100 text-pink-800 px-3 py-1 rounded-full text-xs font-semibold mb-4">
                                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        ~5 menit
                                    </span>

                                    <p class="text-gray-600 leading-relaxed">
                                        Upload scan/foto dokumen persyaratan: Pas Foto 3×4, Ijazah/SKL, Kartu Keluarga, dan
                                        Akta Kelahiran. Format JPG/PNG/PDF, maksimal 2MB per file.
                                    </p>

                                    <div class="mt-4 pt-4 border-t border-gray-100">
                                        <div class="flex items-center text-sm text-gray-500">
                                            <div class="flex-1">
                                                <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                                    <div class="h-full bg-gradient-to-r from-pink-400 to-pink-600 rounded-full transition-all duration-500"
                                                        :style="{ width: activeStep === 3 ? '100%' : '0%' }"></div>
                                                </div>
                                            </div>
                                            <span class="ml-3 font-semibold text-pink-600">Step 4/7</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="hidden lg:flex absolute left-1/2 transform -translate-x-1/2 items-center justify-center">
                                <div class="w-20 h-20 bg-gradient-to-br from-pink-400 to-pink-600 rounded-full shadow-2xl flex items-center justify-center border-4 border-white transition-all duration-300 hover:scale-110"
                                    :class="{ 'scale-125 ring-4 ring-pink-200': activeStep === 3 }">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                        </path>
                                    </svg>
                                </div>
                            </div>

                            <div class="hidden lg:block lg:order-2"></div>
                        </div>
                    </div>

                    <!-- Step 5 -->
                    <div class="relative mb-12" @mouseenter="activeStep = 4" @mouseleave="activeStep = null">
                        <div class="lg:grid lg:grid-cols-2 lg:gap-8 items-center">
                            <div class="lg:text-right lg:pr-8">
                                <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 md:p-8 transform hover:-translate-y-2"
                                    :class="{ 'ring-4 ring-green-200': activeStep === 4 }">

                                    <div
                                        class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-br from-green-400 to-green-600 text-white font-bold text-xl mb-4 shadow-lg">
                                        05
                                    </div>

                                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Lakukan Pembayaran</h3>

                                    <span
                                        class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold mb-4">
                                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        ~3 menit
                                    </span>

                                    <p class="text-gray-600 leading-relaxed">
                                        Transfer biaya pendaftaran ke rekening sekolah. Simpan bukti pembayaran dan upload
                                        melalui sistem untuk proses verifikasi.
                                    </p>

                                    <div class="mt-4 pt-4 border-t border-gray-100">
                                        <div class="flex items-center text-sm text-gray-500">
                                            <div class="flex-1">
                                                <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                                    <div class="h-full bg-gradient-to-r from-green-400 to-green-600 rounded-full transition-all duration-500"
                                                        :style="{ width: activeStep === 4 ? '100%' : '0%' }"></div>
                                                </div>
                                            </div>
                                            <span class="ml-3 font-semibold text-green-600">Step 5/7</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="hidden lg:flex absolute left-1/2 transform -translate-x-1/2 items-center justify-center">
                                <div class="w-20 h-20 bg-gradient-to-br from-green-400 to-green-600 rounded-full shadow-2xl flex items-center justify-center border-4 border-white transition-all duration-300 hover:scale-110"
                                    :class="{ 'scale-125 ring-4 ring-green-200': activeStep === 4 }">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                        </path>
                                    </svg>
                                </div>
                            </div>

                            <div class="hidden lg:block"></div>
                        </div>
                    </div>

                    <!-- Step 6 -->
                    <div class="relative mb-12" @mouseenter="activeStep = 5" @mouseleave="activeStep = null">
                        <div class="lg:grid lg:grid-cols-2 lg:gap-8 items-center">
                            <div class="lg:order-2 lg:pl-8">
                                <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 md:p-8 transform hover:-translate-y-2"
                                    :class="{ 'ring-4 ring-yellow-200': activeStep === 5 }">

                                    <div
                                        class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-br from-yellow-400 to-yellow-600 text-white font-bold text-xl mb-4 shadow-lg">
                                        06
                                    </div>

                                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Verifikasi Panitia</h3>

                                    <span
                                        class="inline-block bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold mb-4">
                                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        1-2 hari kerja
                                    </span>

                                    <p class="text-gray-600 leading-relaxed">
                                        Tim panitia akan memverifikasi dokumen dan pembayaran Anda. Proses ini memakan waktu
                                        maksimal 2x24 jam. Anda akan mendapat notifikasi melalui dashboard dan email.
                                    </p>

                                    <div class="mt-4 pt-4 border-t border-gray-100">
                                        <div class="flex items-center text-sm text-gray-500">
                                            <div class="flex-1">
                                                <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                                    <div class="h-full bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-full transition-all duration-500"
                                                        :style="{ width: activeStep === 5 ? '100%' : '0%' }"></div>
                                                </div>
                                            </div>
                                            <span class="ml-3 font-semibold text-yellow-600">Step 6/7</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="hidden lg:flex absolute left-1/2 transform -translate-x-1/2 items-center justify-center">
                                <div class="w-20 h-20 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-full shadow-2xl flex items-center justify-center border-4 border-white transition-all duration-300 hover:scale-110"
                                    :class="{ 'scale-125 ring-4 ring-yellow-200': activeStep === 5 }">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>

                            <div class="hidden lg:block lg:order-2"></div>
                        </div>
                    </div>

                    <!-- Step 7 -->
                    <div class="relative mb-12" @mouseenter="activeStep = 6" @mouseleave="activeStep = null">
                        <div class="lg:grid lg:grid-cols-2 lg:gap-8 items-center">
                            <div class="lg:text-right lg:pr-8">
                                <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 md:p-8 transform hover:-translate-y-2"
                                    :class="{ 'ring-4 ring-red-200': activeStep === 6 }">

                                    <div
                                        class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-br from-red-400 to-red-600 text-white font-bold text-xl mb-4 shadow-lg">
                                        07
                                    </div>

                                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Pengumuman Hasil</h3>

                                    <span
                                        class="inline-block bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-semibold mb-4">
                                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Sesuai jadwal
                                    </span>

                                    <p class="text-gray-600 leading-relaxed">
                                        Cek pengumuman hasil seleksi di dashboard. Jika diterima, download dan cetak
                                        Formulir Pendaftaran dan Kartu Peserta untuk daftar ulang.
                                    </p>

                                    <div class="mt-4 pt-4 border-t border-gray-100">
                                        <div class="flex items-center text-sm text-gray-500">
                                            <div class="flex-1">
                                                <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                                    <div class="h-full bg-gradient-to-r from-red-400 to-red-600 rounded-full transition-all duration-500"
                                                        :style="{ width: activeStep === 6 ? '100%' : '0%' }"></div>
                                                </div>
                                            </div>
                                            <span class="ml-3 font-semibold text-red-600">Step 7/7</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="hidden lg:flex absolute left-1/2 transform -translate-x-1/2 items-center justify-center">
                                <div class="w-20 h-20 bg-gradient-to-br from-red-400 to-red-600 rounded-full shadow-2xl flex items-center justify-center border-4 border-white transition-all duration-300 hover:scale-110"
                                    :class="{ 'scale-125 ring-4 ring-red-200': activeStep === 6 }">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                                        </path>
                                    </svg>
                                </div>
                            </div>

                            <div class="hidden lg:block"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Important Notes Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-5xl mx-auto">

                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Hal Penting yang Perlu Diperhatikan
                    </h2>
                    <p class="text-lg text-gray-600">
                        Pastikan Anda membaca informasi berikut sebelum mendaftar
                    </p>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div
                        class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 border-2 border-blue-200 hover:border-blue-400 transition">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Dokumen Wajib</h3>
                                <ul class="text-sm text-gray-700 space-y-1">
                                    <li>• Pas Foto 3x4 (background merah)</li>
                                    <li>• Ijazah/SKL (scan asli)</li>
                                    <li>• Kartu Keluarga</li>
                                    <li>• Akta Kelahiran</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-6 border-2 border-green-200 hover:border-green-400 transition">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Biaya Pendaftaran</h3>
                                <p class="text-sm text-gray-700">
                                    Biaya pendaftaran <strong class="text-green-700">Rp 250.000</strong>
                                </p>
                                <p class="text-xs text-gray-600 mt-2">
                                    Transfer ke rekening BRI: 0123-4567-8901 a.n. SMK YPI 2 Way Jepara
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-2xl p-6 border-2 border-yellow-200 hover:border-yellow-400 transition">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-yellow-500 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Jadwal Pendaftaran</h3>
                                <p class="text-sm text-gray-700">
                                    Gelombang 1: <strong>4 Oktober - 15 Februari 2026</strong>
                                </p>
                                <p class="text-sm text-gray-700 mt-1">
                                    Gelombang 2: <strong>3 Maret - 11 Mei 2026</strong>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-gradient-to-br from-red-50 to-red-100 rounded-2xl p-6 border-2 border-red-200 hover:border-red-400 transition">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Perhatian!</h3>
                                <p class="text-sm text-gray-700">
                                    Pastikan data yang diinput <strong>benar dan valid</strong>.
                                    Data yang salah dapat menyebabkan pendaftaran ditolak.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">

                <div class="text-center mb-12">
                    <span class="inline-block bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                        FAQ
                    </span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Pertanyaan yang Sering Diajukan
                    </h2>
                    <p class="text-lg text-gray-600">
                        Temukan jawaban atas pertanyaan umum seputar pendaftaran
                    </p>
                </div>

                <div x-data="{ openFaq: null }" class="space-y-4">
                    @php
                        $faqs = [
                            [
                                'question' => 'Apakah bisa mendaftar tanpa Ijazah?',
                                'answer' =>
                                    'Untuk siswa yang belum lulus, dapat menggunakan Surat Keterangan Lulus (SKL) sementara dari sekolah asal. Ijazah asli harus diserahkan saat daftar ulang.',
                            ],
                            [
                                'question' => 'Berapa lama proses verifikasi dokumen?',
                                'answer' =>
                                    'Proses verifikasi dokumen dan pembayaran memakan waktu maksimal 2x24 jam kerja. Anda akan mendapat notifikasi melalui email dan dashboard setelah verifikasi selesai.',
                            ],
                            [
                                'question' => 'Apakah bisa mengubah pilihan jurusan setelah submit?',
                                'answer' =>
                                    'Pilihan jurusan tidak dapat diubah setelah pendaftaran di-submit. Pastikan Anda sudah yakin dengan pilihan jurusan sebelum menekan tombol submit.',
                            ],
                            [
                                'question' => 'Bagaimana cara mengetahui hasil seleksi?',
                                'answer' =>
                                    'Hasil seleksi akan diumumkan melalui dashboard akun Anda dan juga dikirim via email. Pastikan email yang didaftarkan aktif dan periksa folder spam.',
                            ],
                            [
                                'question' => 'Apakah bisa mendaftar ulang jika tidak diterima?',
                                'answer' =>
                                    'Ya, Anda dapat mendaftar ulang di gelombang berikutnya dengan membuat pendaftaran baru. Biaya pendaftaran tidak dapat dikembalikan atau dipindahkan ke gelombang lain.',
                            ],
                        ];
                    @endphp

                    @foreach ($faqs as $index => $faq)
                        <div
                            class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 hover:border-blue-300 transition">
                            <button @click="openFaq = openFaq === {{ $index }} ? null : {{ $index }}"
                                class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition">
                                <span class="font-semibold text-gray-900 pr-4">{{ $faq['question'] }}</span>
                                <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200"
                                    :class="{ 'rotate-180': openFaq === {{ $index }} }" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="openFaq === {{ $index }}"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 transform -translate-y-2"
                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 transform translate-y-0"
                                x-transition:leave-end="opacity-0 transform -translate-y-2" class="px-6 pb-4"
                                style="display: none;">
                                <p class="text-gray-600 leading-relaxed">{{ $faq['answer'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section
        class="relative py-20 bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 text-white overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <div
                class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-blob">
            </div>
            <div
                class="absolute bottom-0 right-0 w-96 h-96 bg-purple-300 rounded-full mix-blend-overlay filter blur-3xl animate-blob animation-delay-2000">
            </div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl md:text-5xl font-bold mb-6">
                    Siap Memulai Pendaftaran?
                </h2>
                <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                    Daftar sekarang dan raih kesempatan untuk menjadi bagian dari keluarga besar SMK YPI 2 Way Jepara
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center justify-center px-8 py-4 bg-white text-blue-600 font-bold rounded-xl hover:bg-blue-50 transition shadow-xl hover:shadow-2xl transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                            </path>
                        </svg>
                        Daftar Sekarang
                    </a>

                    <a href="{{ route('kontak') }}"
                        class="inline-flex items-center justify-center px-8 py-4 bg-transparent text-white font-bold rounded-xl border-2 border-white hover:bg-white hover:text-blue-600 transition shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </section>

    @push('styles')
        <style>
            @keyframes fade-in-up {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes blob {

                0%,
                100% {
                    transform: translate(0, 0) scale(1);
                }

                25% {
                    transform: translate(20px, -50px) scale(1.1);
                }

                50% {
                    transform: translate(-20px, 20px) scale(0.9);
                }

                75% {
                    transform: translate(50px, 50px) scale(1.05);
                }
            }

            .animate-fade-in-up {
                animation: fade-in-up 0.8s ease-out;
            }

            .animate-blob {
                animation: blob 7s infinite;
            }

            .animation-delay-2000 {
                animation-delay: 2s;
            }

            .animation-delay-4000 {
                animation-delay: 4s;
            }

            [x-cloak] {
                display: none !important;
            }
        </style>
    @endpush

@endsection
