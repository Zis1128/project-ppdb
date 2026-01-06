@extends('layouts.frontend')

@section('title', 'Beranda - PPDB SMK')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-blue-600 to-blue-800 text-white overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-black opacity-50"></div>

        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 animate-fade-in">
                    Selamat Datang di PPDB<br>
                    <span class="text-yellow-400">SMKS ISLAM YPI 2 WAY JEPARA</span>
                </h1>

                @if ($gelombangAktif)
                    <div class="inline-block bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg px-6 py-3 mb-6">
                        <p class="text-lg">
                            <span class="font-semibold">{{ $gelombangAktif->nama }}</span> -
                            Tahun Ajaran {{ $tahunAjaran->nama ?? '-' }}
                        </p>
                        <p class="text-sm mt-1">
                            Pendaftaran: {{ $gelombangAktif->tanggal_mulai->format('d M Y') }} -
                            {{ $gelombangAktif->tanggal_selesai->format('d M Y') }}
                        </p>
                    </div>
                @else
                    <div class="inline-block bg-yellow-500 text-gray-900 rounded-lg px-6 py-3 mb-6">
                        <p class="font-semibold">Pendaftaran Belum Dibuka</p>
                    </div>
                @endif

                <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">
                    Wujudkan masa depan gemilang bersama kami!<br>
                    Daftar sekarang dan raih kesempatan emas untuk pendidikan berkualitas.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @auth
                        <a href="{{ route('dashboard.index') }}"
                            class="inline-flex items-center justify-center px-8 py-4 text-lg font-medium rounded-lg text-white bg-yellow-500 hover:bg-yellow-600 transition shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Dashboard Saya
                        </a>
                    @else
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center justify-center px-8 py-4 text-lg font-medium rounded-lg text-white bg-yellow-500 hover:bg-yellow-600 transition shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                            Daftar Sekarang
                        </a>
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center justify-center px-8 py-4 text-lg font-medium rounded-lg text-white bg-white/10 backdrop-blur-sm hover:bg-white/20 border-2 border-white transition">
                            Sudah Punya Akun? Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Wave -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z"
                    fill="rgb(249 250 251)" />
            </svg>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                    <div class="text-4xl font-bold text-blue-600 mb-2">{{ $jurusans->count() }}</div>
                    <div class="text-gray-600">Program Keahlian</div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                    <div class="text-4xl font-bold text-green-600 mb-2">95%</div>
                    <div class="text-gray-600">Tingkat Kelulusan</div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                    <div class="text-4xl font-bold text-yellow-600 mb-2">50+</div>
                    <div class="text-gray-600">Guru Profesional</div>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                    <div class="text-4xl font-bold text-purple-600 mb-2">1000+</div>
                    <div class="text-gray-600">Alumni Sukses</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Jurusan Section -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Program Keahlian</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Pilih jurusan sesuai minat dan bakat Anda untuk masa depan yang cerah
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($jurusans as $jurusan)
                    <div
                        class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition transform hover:-translate-y-1">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-sm font-medium opacity-90">{{ $jurusan->kode }}</div>
                                    <h3 class="text-xl font-bold mt-1">{{ $jurusan->nama }}</h3>
                                </div>
                                @if ($jurusan->icon)
                                    <img src="{{ asset('storage/' . $jurusan->icon) }}" alt="{{ $jurusan->nama }}"
                                        class="h-12 w-12 rounded-lg bg-white/20 p-2">
                                @else
                                    <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                @endif
                            </div>
                        </div>
                        <div class="p-6">
                            <p class="text-gray-600 mb-4 line-clamp-3">{{ $jurusan->deskripsi }}</p>

                            <div class="flex items-center justify-between mb-4">
                                <div class="text-sm">
                                    <span class="text-gray-500">Kuota:</span>
                                    <span class="font-semibold text-gray-900 ml-1">{{ $jurusan->kuota }} siswa</span>
                                </div>
                                <div class="text-sm">
                                    <span class="text-gray-500">Passing Grade:</span>
                                    <span class="font-semibold text-gray-900 ml-1">{{ $jurusan->passing_grade }}</span>
                                </div>
                            </div>

                            <a href="{{ route('jurusan') }}"
                                class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('jurusan') }}"
                    class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
                    Lihat Semua Jurusan
                    <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3">
                        </path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Jalur Masuk Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Jalur Penerimaan</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Berbagai jalur penerimaan sesuai dengan prestasi dan kebutuhan Anda
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($jalurMasuks as $jalur)
                    <div
                        class="bg-white rounded-xl shadow-lg p-8 border-t-4 {{ $loop->first ? 'border-blue-600' : ($loop->iteration == 2 ? 'border-green-600' : 'border-yellow-600') }}">
                        <div
                            class="flex items-center justify-center h-16 w-16 rounded-full {{ $loop->first ? 'bg-blue-100 text-blue-600' : ($loop->iteration == 2 ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600') }} mb-6">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                                </path>
                            </svg>
                        </div>

                        <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $jalur->nama }}</h3>
                        <p class="text-gray-600 mb-4">{{ $jalur->deskripsi }}</p>

                        <div class="space-y-2">
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Kuota: {{ $jalur->kuota_persen }}%
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-blue-600 to-blue-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">
                Siap Bergabung dengan Kami?
            </h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">
                Jangan lewatkan kesempatan emas ini! Daftar sekarang dan raih masa depan cemerlang bersama SMK ISLAM YPI 2
                WAY JEPARA.
            </p>

            @auth
                <a href="{{ route('dashboard.index') }}"
                    class="inline-flex items-center px-8 py-4 text-lg font-medium rounded-lg text-blue-600 bg-white hover:bg-gray-100 transition shadow-lg">
                    Ke Dashboard
                    <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3">
                        </path>
                    </svg>
                </a>
            @else
                <a href="{{ route('register') }}"
                    class="inline-flex items-center px-8 py-4 text-lg font-medium rounded-lg text-blue-600 bg-white hover:bg-gray-100 transition shadow-lg">
                    Daftar Sekarang
                    <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3">
                        </path>
                    </svg>
                </a>
            @endauth
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Pertanyaan yang Sering Diajukan</h2>
                <p class="text-lg text-gray-600">Temukan jawaban untuk pertanyaan umum seputar PPDB</p>
            </div>

            <div class="space-y-4" x-data="{ selected: null }">
                <div class="bg-white rounded-lg shadow-sm">
                    <button @click="selected !== 1 ? selected = 1 : selected = null"
                        class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition">
                        <span class="font-medium text-gray-900">Kapan pendaftaran dibuka?</span>
                        <svg class="h-5 w-5 text-gray-500 transform transition-transform"
                            :class="{ 'rotate-180': selected === 1 }" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div x-show="selected === 1" x-collapse class="px-6 pb-4 text-gray-600">
                        Pendaftaran dibuka sesuai dengan jadwal yang telah ditentukan. Silakan cek informasi terbaru di
                        halaman beranda atau hubungi kami untuk informasi lebih lanjut.
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm">
                    <button @click="selected !== 2 ? selected = 2 : selected = null"
                        class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition">
                        <span class="font-medium text-gray-900">Apa saja persyaratan pendaftaran?</span>
                        <svg class="h-5 w-5 text-gray-500 transform transition-transform"
                            :class="{ 'rotate-180': selected === 2 }" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div x-show="selected === 2" x-collapse class="px-6 pb-4 text-gray-600">
                        Persyaratan meliputi: Ijazah/SKHUN, Kartu Keluarga, Akta Kelahiran, Rapor Semester 1-5, Pas Foto
                        3x4, dan dokumen pendukung lainnya. Dokumen lengkap dapat dilihat saat mendaftar.
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm">
                    <button @click="selected !== 3 ? selected = 3 : selected = null"
                        class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition">
                        <span class="font-medium text-gray-900">Berapa biaya pendaftaran?</span>
                        <svg class="h-5 w-5 text-gray-500 transform transition-transform"
                            :class="{ 'rotate-180': selected === 3 }" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div x-show="selected === 3" x-collapse class="px-6 pb-4 text-gray-600">
                        Biaya pendaftaran sebesar Rp 250.000,-. Pembayaran dapat dilakukan melalui transfer bank yang akan
                        diberikan setelah registrasi akun.
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm">
                    <button @click="selected !== 4 ? selected = 4 : selected = null"
                        class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition">
                        <span class="font-medium text-gray-900">Bagaimana cara melihat hasil seleksi?</span>
                        <svg class="h-5 w-5 text-gray-500 transform transition-transform"
                            :class="{ 'rotate-180': selected === 4 }" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div x-show="selected === 4" x-collapse class="px-6 pb-4 text-gray-600">
                        Hasil seleksi dapat dilihat melalui dashboard akun Anda sesuai dengan jadwal pengumuman yang telah
                        ditentukan. Anda juga akan mendapatkan notifikasi via email/WhatsApp.
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
