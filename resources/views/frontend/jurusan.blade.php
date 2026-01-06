@extends('layouts.frontend')

@section('title', 'Program Keahlian - PPDB SMK YPI 2 Way Jepara')

@section('content')
    <div x-data="jurusanPage()">
        <!-- Hero Section -->
        <section class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900 text-white py-20">
            <div class="absolute inset-0 bg-black opacity-20"></div>
            <div class="absolute inset-0 bg-pattern opacity-10"></div>

            <div class="container mx-auto px-4 relative z-10">
                <div class="max-w-3xl mx-auto text-center">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4 animate-fade-in-up">
                        Program Keahlian
                    </h1>
                    <p class="text-xl text-blue-100 animate-fade-in-up animation-delay-200">
                        Pilih jurusan yang sesuai dengan minat dan bakatmu untuk masa depan yang cerah
                    </p>
                </div>
            </div>
        </section>

        <!-- Jurusan Grid -->
        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">

                <!-- Filter & Info -->
                <div class="max-w-7xl mx-auto mb-8">
                    <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4">
                        <div class="flex items-start">
                            <svg class="h-6 w-6 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-blue-900">Informasi Kuota</p>
                                <p class="text-sm text-blue-700 mt-1">
                                    Kuota yang ditampilkan adalah sisa kuota yang tersedia. Segera daftar sebelum kuota
                                    penuh!
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grid Cards -->
                <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($jurusans as $jurusan)
                        <div
                            class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">

                            <!-- Header with Gradient & Logo -->
                            <div
                                class="relative h-48 bg-gradient-to-br {{ $loop->iteration % 5 === 1 ? 'from-blue-500 to-blue-700' : ($loop->iteration % 5 === 2 ? 'from-green-500 to-green-700' : ($loop->iteration % 5 === 3 ? 'from-purple-500 to-purple-700' : ($loop->iteration % 5 === 4 ? 'from-red-500 to-red-700' : 'from-yellow-500 to-yellow-700'))) }}">
                                <div class="absolute inset-0 bg-black opacity-10"></div>

                                <!-- Logo -->
                                <div class="absolute inset-0 flex items-center justify-center">
                                    @if ($jurusan->logo)
                                        <img src="{{ Storage::url($jurusan->logo) }}" alt="{{ $jurusan->nama }}"
                                            class="h-24 w-24 object-contain drop-shadow-lg">
                                    @else
                                        <svg class="h-24 w-24 text-white opacity-80" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                            </path>
                                        </svg>
                                    @endif
                                </div>

                                <!-- Kuota Ribbon -->
                                <div class="absolute top-4 right-4">
                                    <div
                                        class="bg-white px-4 py-2 rounded-full shadow-lg border-2 {{ $jurusan->kuota_tersisa <= 0 ? 'border-red-500' : ($jurusan->kuota_tersisa <= 10 ? 'border-yellow-500' : 'border-green-500') }}">
                                        <div class="flex items-center space-x-2">
                                            <div
                                                class="w-2 h-2 rounded-full {{ $jurusan->kuota_tersisa <= 0 ? 'bg-red-500' : ($jurusan->kuota_tersisa <= 10 ? 'bg-yellow-500 animate-pulse' : 'bg-green-500') }}">
                                            </div>
                                            <span
                                                class="text-xs font-bold {{ $jurusan->kuota_tersisa <= 0 ? 'text-red-600' : ($jurusan->kuota_tersisa <= 10 ? 'text-yellow-600' : 'text-green-600') }}">
                                                {{ $jurusan->kuota_tersisa }} / {{ $jurusan->kuota }}
                                            </span>
                                        </div>
                                    </div>

                                    @if ($jurusan->kuota_tersisa <= 0)
                                        <div
                                            class="mt-2 bg-red-600 text-white px-3 py-1 rounded-full text-xs font-bold text-center animate-pulse">
                                            ❌ PENUH
                                        </div>
                                    @elseif($jurusan->kuota_tersisa <= 10)
                                        <div
                                            class="mt-2 bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-bold text-center animate-pulse">
                                            ⚡ Segera!
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-6">
                                <!-- Badge Kode -->
                                <div class="mb-3">
                                    <span
                                        class="inline-block bg-gray-100 text-gray-700 text-xs font-semibold px-3 py-1 rounded-full">
                                        {{ $jurusan->kode }}
                                    </span>
                                </div>

                                <!-- Nama Jurusan -->
                                <h3 class="font-bold text-xl text-gray-900 mb-3 line-clamp-2 min-h-[3.5rem]">
                                    {{ $jurusan->nama }}
                                </h3>

                                <!-- Deskripsi Singkat -->
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3 min-h-[4rem]">
                                    {{ Str::limit($jurusan->deskripsi, 120) }}
                                </p>

                                <!-- Stats -->
                                <div class="grid grid-cols-2 gap-3 mb-4">
                                    <div class="bg-blue-50 rounded-lg p-3 text-center">
                                        <p class="text-xs text-gray-600 mb-1">Lama Studi</p>
                                        <p class="font-bold text-blue-600">3 Tahun</p>
                                    </div>
                                    <div
                                        class="{{ $jurusan->kuota_tersisa <= 0 ? 'bg-red-50' : ($jurusan->kuota_tersisa <= 10 ? 'bg-yellow-50' : 'bg-green-50') }} rounded-lg p-3 text-center">
                                        <p class="text-xs text-gray-600 mb-1">Sisa Kuota</p>
                                        <div class="flex items-center justify-center space-x-1">
                                            <p
                                                class="font-bold text-lg {{ $jurusan->kuota_tersisa <= 0 ? 'text-red-600' : ($jurusan->kuota_tersisa <= 10 ? 'text-yellow-600' : 'text-green-600') }}">
                                                {{ $jurusan->kuota_tersisa }}
                                            </p>
                                            <span class="text-xs text-gray-500">/</span>
                                            <p class="font-semibold text-sm text-gray-600">{{ $jurusan->kuota }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Button -->
                                <button @click="openModal({{ $jurusan->toJson() }})"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center group">
                                    Lihat Detail
                                    <svg class="ml-2 h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($jurusans->isEmpty())
                    <div class="max-w-7xl mx-auto text-center py-12">
                        <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Belum Ada Program Keahlian</h3>
                        <p class="mt-2 text-gray-500">Program keahlian akan segera ditambahkan.</p>
                    </div>
                @endif
            </div>
        </section>

        <!-- CTA Section -->
        <section class="bg-gradient-to-r from-blue-600 to-blue-800 py-16">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                    Siap Bergabung dengan Kami?
                </h2>
                <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                    Daftarkan dirimu sekarang dan raih masa depan cerah bersama SMK YPI 2 Way Jepara
                </p>
                <a href="{{ route('register') }}"
                    class="inline-flex items-center px-8 py-4 bg-white text-blue-600 font-bold rounded-full hover:bg-blue-50 transition shadow-lg hover:shadow-xl transform hover:scale-105">
                    Daftar Sekarang
                    <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6">
                        </path>
                    </svg>
                </a>
            </div>
        </section>

        <!-- Modal Detail Jurusan -->
        <div x-show="modalOpen" x-cloak @click.away="closeModal()" class="fixed inset-0 z-50 overflow-y-auto"
            style="display: none;">

            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" x-show="modalOpen"
                x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            </div>

            <!-- Modal Content -->
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto"
                    x-show="modalOpen" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-4" @click.stop>

                    <!-- Close Button -->
                    <button @click="closeModal()"
                        class="absolute top-4 right-4 z-10 bg-white rounded-full p-2 hover:bg-gray-100 transition shadow-lg">
                        <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>

                    <template x-if="selectedJurusan">
                        <div>
                            <!-- Header with Gradient -->
                            <div
                                class="relative h-48 bg-gradient-to-br from-blue-500 to-blue-700 rounded-t-2xl overflow-hidden">
                                <div class="absolute inset-0 bg-black opacity-20"></div>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <template x-if="selectedJurusan.logo">
                                        <img :src="`/storage/${selectedJurusan.logo}`" :alt="selectedJurusan.nama"
                                            class="h-32 w-32 object-contain drop-shadow-lg">
                                    </template>
                                    <template x-if="!selectedJurusan.logo">
                                        <svg class="h-32 w-32 text-white opacity-80" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                            </path>
                                        </svg>
                                    </template>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-8">
                                <!-- Judul & Kode -->
                                <div class="mb-6">
                                    <span
                                        class="inline-block bg-blue-100 text-blue-800 text-sm font-semibold px-3 py-1 rounded-full mb-3"
                                        x-text="selectedJurusan.kode"></span>
                                    <h2 class="text-3xl font-bold text-gray-900" x-text="selectedJurusan.nama"></h2>
                                </div>

                                <!-- Stats Grid -->
                                <div class="grid grid-cols-2 gap-4 mb-6">
                                    <div class="p-4 bg-blue-50 rounded-lg">
                                        <p class="text-sm text-gray-600 mb-1">Lama Studi</p>
                                        <p class="font-bold text-blue-600 text-xl">3 Tahun</p>
                                    </div>
                                    <div class="p-4 rounded-lg"
                                        :class="{
                                            'bg-red-50': selectedJurusan.kuota_tersisa <= 0,
                                            'bg-yellow-50': selectedJurusan.kuota_tersisa > 0 && selectedJurusan
                                                .kuota_tersisa <= 10,
                                            'bg-green-50': selectedJurusan.kuota_tersisa > 10
                                        }">
                                        <p class="text-sm text-gray-600 mb-1">Kuota Pendaftaran</p>
                                        <p class="font-bold text-xl"
                                            :class="{
                                                'text-red-600': selectedJurusan.kuota_tersisa <= 0,
                                                'text-yellow-600': selectedJurusan.kuota_tersisa > 0 && selectedJurusan
                                                    .kuota_tersisa <= 10,
                                                'text-green-600': selectedJurusan.kuota_tersisa > 10
                                            }">
                                            <span x-text="selectedJurusan.kuota_tersisa"></span> / <span
                                                x-text="selectedJurusan.kuota"></span>
                                        </p>
                                        <p class="text-xs font-semibold mt-1"
                                            :class="{
                                                'text-red-600': selectedJurusan.kuota_tersisa <= 0,
                                                'text-yellow-600': selectedJurusan.kuota_tersisa > 0 && selectedJurusan
                                                    .kuota_tersisa <= 10,
                                                'text-green-600': selectedJurusan.kuota_tersisa > 10
                                            }"
                                            x-text="selectedJurusan.kuota_tersisa <= 0 ? '⚠️ Kuota Penuh' : (selectedJurusan.kuota_tersisa <= 10 ? '⚠️ Segera Daftar!' : '✅ Kuota Tersedia')">
                                        </p>
                                    </div>
                                </div>

                                <!-- Deskripsi -->
                                <div class="mb-6">
                                    <h3 class="text-lg font-bold text-gray-900 mb-3 flex items-center">
                                        <svg class="h-5 w-5 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Tentang Program Keahlian
                                    </h3>
                                    <p class="text-gray-700 leading-relaxed" x-text="selectedJurusan.deskripsi"></p>
                                </div>

                                <!-- Kompetensi -->
                                <template x-if="selectedJurusan.kompetensi">
                                    <div class="mb-6">
                                        <h3 class="text-lg font-bold text-gray-900 mb-3 flex items-center">
                                            <svg class="h-5 w-5 mr-2 text-green-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Kompetensi yang Dipelajari
                                        </h3>
                                        <div class="bg-green-50 rounded-lg p-4">
                                            <p class="text-gray-700 whitespace-pre-line"
                                                x-text="selectedJurusan.kompetensi"></p>
                                        </div>
                                    </div>
                                </template>

                                <!-- Prospek Kerja -->
                                <template x-if="selectedJurusan.prospek_kerja">
                                    <div class="mb-6">
                                        <h3 class="text-lg font-bold text-gray-900 mb-3 flex items-center">
                                            <svg class="h-5 w-5 mr-2 text-purple-600" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            Prospek Kerja
                                        </h3>
                                        <div class="bg-purple-50 rounded-lg p-4">
                                            <p class="text-gray-700 whitespace-pre-line"
                                                x-text="selectedJurusan.prospek_kerja"></p>
                                        </div>
                                    </div>
                                </template>

                                <!-- CTA Buttons -->
                                <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t">
                                    <button @click="closeModal()"
                                        class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition">
                                        Tutup
                                    </button>
                                    <a href="{{ route('register') }}"
                                        class="flex-1 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition text-center">
                                        Daftar Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function jurusanPage() {
                return {
                    modalOpen: false,
                    selectedJurusan: null,

                    openModal(jurusan) {
                        this.selectedJurusan = jurusan;
                        this.modalOpen = true;
                        document.body.style.overflow = 'hidden';
                    },

                    closeModal() {
                        this.modalOpen = false;
                        document.body.style.overflow = 'auto';
                        setTimeout(() => {
                            this.selectedJurusan = null;
                        }, 300);
                    }
                }
            }
        </script>
    @endpush
@endsection
