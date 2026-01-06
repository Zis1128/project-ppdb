@extends('layouts.frontend')

@section('title', 'Tentang Kami')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-blue-600 to-blue-800 text-white py-20">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Tentang SMK Nusantara</h1>
            <p class="text-xl text-blue-100 max-w-3xl mx-auto">
                SMK unggulan dengan komitmen menghasilkan lulusan yang kompeten, berkarakter, dan siap kerja
            </p>
        </div>
    </section>

    <!-- Sambutan Kepala Sekolah -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <img src="https://via.placeholder.com/600x700/3B82F6/FFFFFF?text=Kepala+Sekolah" alt="Kepala Sekolah"
                        class="rounded-2xl shadow-2xl">
                </div>
                <div>
                    <span class="inline-block px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold mb-4">
                        Sambutan Kepala Sekolah
                    </span>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">
                        Drs. Ahmad Budiman, M.Pd
                    </h2>
                    <div class="prose prose-lg text-gray-600">
                        <p class="mb-4">
                            Assalamu'alaikum Warahmatullahi Wabarakatuh,
                        </p>
                        <p class="mb-4">
                            Puji syukur kita panjatkan kehadirat Allah SWT, Tuhan Yang Maha Esa, atas segala rahmat dan
                            karunia-Nya.
                            Selamat datang di website resmi SMK Nusantara.
                        </p>
                        <p class="mb-4">
                            SMK Nusantara adalah lembaga pendidikan kejuruan yang berkomitmen untuk mencetak generasi muda
                            yang tidak hanya
                            kompeten dalam bidang teknologi dan industri, tetapi juga memiliki karakter yang kuat dan
                            berakhlak mulia.
                        </p>
                        <p class="mb-4">
                            Dengan dukungan tenaga pendidik profesional, fasilitas modern, dan kerjasama dengan dunia
                            industri,
                            kami siap mewujudkan visi menjadi SMK unggulan yang menghasilkan lulusan siap kerja dan berdaya
                            saing global.
                        </p>
                        <p class="font-semibold text-gray-900">
                            Wassalamu'alaikum Warahmatullahi Wabarakatuh
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Visi Misi -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Visi & Misi</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Menjadi SMK unggulan yang menghasilkan lulusan berkualitas dan berakhlak mulia
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Visi -->
                <div class="bg-white rounded-2xl shadow-lg p-8 border-t-4 border-blue-600">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Visi</h3>
                    </div>
                    <p class="text-gray-600 leading-relaxed text-lg">
                        Menjadi SMK unggulan yang menghasilkan lulusan kompeten, berkarakter, berakhlak mulia,
                        dan mampu bersaing di tingkat nasional maupun global pada tahun 2030.
                    </p>
                </div>

                <!-- Misi -->
                <div class="bg-white rounded-2xl shadow-lg p-8 border-t-4 border-green-600">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Misi</h3>
                    </div>
                    <ul class="space-y-3 text-gray-600">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-600 mr-2 mt-1 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span>Menyelenggarakan pendidikan berkualitas berbasis kompetensi</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-600 mr-2 mt-1 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span>Membangun karakter siswa yang berakhlak mulia dan berwawasan global</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-600 mr-2 mt-1 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span>Mengembangkan kemitraan dengan dunia industri</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-600 mr-2 mt-1 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span>Meningkatkan profesionalisme tenaga pendidik dan kependidikan</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Fasilitas -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Fasilitas Sekolah</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Kami menyediakan fasilitas modern untuk mendukung proses pembelajaran yang optimal
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Fasilitas Item -->
                <div
                    class="bg-gradient-to-br from-blue-50 to-white rounded-xl shadow-lg p-6 hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mb-4 mx-auto">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 text-center mb-2">Lab Komputer</h3>
                    <p class="text-gray-600 text-sm text-center">50+ unit komputer dengan spesifikasi tinggi</p>
                </div>

                <div
                    class="bg-gradient-to-br from-green-50 to-white rounded-xl shadow-lg p-6 hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mb-4 mx-auto">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 text-center mb-2">Perpustakaan</h3>
                    <p class="text-gray-600 text-sm text-center">Koleksi 5000+ buku dan e-library</p>
                </div>

                <div
                    class="bg-gradient-to-br from-purple-50 to-white rounded-xl shadow-lg p-6 hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="w-16 h-16 bg-purple-600 rounded-full flex items-center justify-center mb-4 mx-auto">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 text-center mb-2">Lab Praktek</h3>
                    <p class="text-gray-600 text-sm text-center">Workshop lengkap untuk praktikum</p>
                </div>

                <div
                    class="bg-gradient-to-br from-yellow-50 to-white rounded-xl shadow-lg p-6 hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="w-16 h-16 bg-yellow-600 rounded-full flex items-center justify-center mb-4 mx-auto">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 text-center mb-2">Kantin</h3>
                    <p class="text-gray-600 text-sm text-center">Kantin bersih dengan menu sehat</p>
                </div>

                <div
                    class="bg-gradient-to-br from-red-50 to-white rounded-xl shadow-lg p-6 hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="w-16 h-16 bg-red-600 rounded-full flex items-center justify-center mb-4 mx-auto">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 text-center mb-2">Lapangan</h3>
                    <p class="text-gray-600 text-sm text-center">Lapangan olahraga multifungsi</p>
                </div>

                <div
                    class="bg-gradient-to-br from-indigo-50 to-white rounded-xl shadow-lg p-6 hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="w-16 h-16 bg-indigo-600 rounded-full flex items-center justify-center mb-4 mx-auto">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 text-center mb-2">Masjid</h3>
                    <p class="text-gray-600 text-sm text-center">Musholla untuk kegiatan ibadah</p>
                </div>

                <div
                    class="bg-gradient-to-br from-pink-50 to-white rounded-xl shadow-lg p-6 hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="w-16 h-16 bg-pink-600 rounded-full flex items-center justify-center mb-4 mx-auto">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 text-center mb-2">Ruang Kelas</h3>
                    <p class="text-gray-600 text-sm text-center">Kelas ber-AC dan proyektor</p>
                </div>

                <div
                    class="bg-gradient-to-br from-teal-50 to-white rounded-xl shadow-lg p-6 hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="w-16 h-16 bg-teal-600 rounded-full flex items-center justify-center mb-4 mx-auto">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 text-center mb-2">Security 24/7</h3>
                    <p class="text-gray-600 text-sm text-center">Keamanan terjamin 24 jam</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-blue-600 to-blue-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Siap Bergabung dengan Kami?</h2>
            <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                Daftarkan diri Anda sekarang dan raih masa depan cemerlang bersama SMK Nusantara
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <a href="{{ route('dashboard.index') }}"
                        class="inline-flex items-center justify-center px-8 py-4 bg-white text-blue-600 rounded-lg hover:bg-gray-100 transition shadow-lg font-semibold">
                        Dashboard Saya
                        <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                @else
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center justify-center px-8 py-4 bg-white text-blue-600 rounded-lg hover:bg-gray-100 transition shadow-lg font-semibold">
                        Daftar Sekarang
                        <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                @endauth
                <a href="{{ route('kontak') }}"
                    class="inline-flex items-center justify-center px-8 py-4 bg-transparent border-2 border-white text-white rounded-lg hover:bg-white hover:text-blue-600 transition font-semibold">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </section>
@endsection
