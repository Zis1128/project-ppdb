@extends('layouts.dashboard')

@section('title', 'Pendaftaran')
@section('page-title', 'Data Pendaftaran')

@section('content')
    <div class="space-y-6">
        @if ($pendaftaran)
            <!-- Card Info Pendaftaran -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900">Informasi Pendaftaran</h3>
                        <p class="text-sm text-gray-600 mt-1">No. Pendaftaran: <span
                                class="font-semibold">{{ $pendaftaran->no_pendaftaran }}</span></p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        {{ $pendaftaran->status_pendaftaran === 'draft'
                            ? 'bg-yellow-100 text-yellow-800'
                            : ($pendaftaran->status_pendaftaran === 'submitted'
                                ? 'bg-blue-100 text-blue-800'
                                : ($pendaftaran->status_pendaftaran === 'verified'
                                    ? 'bg-green-100 text-green-800'
                                    : ($pendaftaran->status_pendaftaran === 'accepted'
                                        ? 'bg-green-100 text-green-800'
                                        : 'bg-red-100 text-red-800'))) }}">
                            {{ ucfirst($pendaftaran->status_pendaftaran) }}
                        </span>
                    </div>
                </div>

                <!-- Data Ringkas -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Nama Lengkap</p>
                        <p class="font-semibold text-gray-900">{{ $pendaftaran->nama_lengkap }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">NISN</p>
                        <p class="font-semibold text-gray-900">{{ $pendaftaran->nisn }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Asal Sekolah</p>
                        <p class="font-semibold text-gray-900">{{ $pendaftaran->asal_sekolah }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Jurusan Pilihan 1</p>
                        <p class="font-semibold text-gray-900">{{ $pendaftaran->jurusanPilihan1->nama }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Jurusan Pilihan 2</p>
                        <p class="font-semibold text-gray-900">{{ $pendaftaran->jurusanPilihan2->nama ?? '-' }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Jalur Masuk</p>
                        <p class="font-semibold text-gray-900">{{ $pendaftaran->jalurMasuk->nama }}</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 flex flex-wrap gap-3">
                    @if ($pendaftaran->status_pendaftaran === 'draft')
                        <a href="{{ route('dashboard.pendaftaran.edit', $pendaftaran) }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                            Edit Pendaftaran
                        </a>
                    @endif

                    <a href="{{ route('dashboard.pendaftaran.dokumen', $pendaftaran) }}"
                        class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                            </path>
                        </svg>
                        Kelola Dokumen
                    </a>

                    @if ($pendaftaran->status_pendaftaran !== 'draft')
                        <a href="{{ route('dashboard.cetak.formulir') }}" target="_blank"
                            class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                                </path>
                            </svg>
                            Cetak Formulir
                        </a>
                    @endif
                </div>
            </div>

            <!-- Detail Data -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px" x-data="{ tab: 'pribadi' }">
                        <button @click="tab = 'pribadi'"
                            :class="tab === 'pribadi' ? 'border-blue-500 text-blue-600' :
                                'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="px-6 py-4 border-b-2 font-medium text-sm transition">
                            Data Pribadi
                        </button>
                        <button @click="tab = 'ortu'"
                            :class="tab === 'ortu' ? 'border-blue-500 text-blue-600' :
                                'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="px-6 py-4 border-b-2 font-medium text-sm transition">
                            Data Orang Tua
                        </button>
                        <button @click="tab = 'sekolah'"
                            :class="tab === 'sekolah' ? 'border-blue-500 text-blue-600' :
                                'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                            class="px-6 py-4 border-b-2 font-medium text-sm transition">
                            Sekolah Asal
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div x-data="{ tab: 'pribadi' }" class="p-6">
                    <!-- Data Pribadi -->
                    <div x-show="tab === 'pribadi'" x-transition class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">NIK</label>
                                <p class="text-gray-900">{{ $pendaftaran->nik }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Tempat, Tanggal Lahir</label>
                                <p class="text-gray-900">{{ $pendaftaran->tempat_lahir }},
                                    {{ $pendaftaran->tanggal_lahir->format('d M Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Jenis Kelamin</label>
                                <p class="text-gray-900">
                                    {{ $pendaftaran->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Agama</label>
                                <p class="text-gray-900">{{ $pendaftaran->agama }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-500 mb-1">Alamat Lengkap</label>
                                <p class="text-gray-900">{{ $pendaftaran->alamat }}</p>
                                <p class="text-gray-600 text-sm mt-1">
                                    {{ $pendaftaran->kelurahan }}, {{ $pendaftaran->kecamatan }},
                                    {{ $pendaftaran->kota }}, {{ $pendaftaran->provinsi }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">No. HP</label>
                                <p class="text-gray-900">{{ $pendaftaran->no_hp_siswa }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                                <p class="text-gray-900">{{ $pendaftaran->email_siswa }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Data Orang Tua -->
                    <div x-show="tab === 'ortu'" x-transition class="space-y-6">
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-3">Data Ayah</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Nama Ayah</label>
                                    <p class="text-gray-900">{{ $pendaftaran->nama_ayah }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Pekerjaan</label>
                                    <p class="text-gray-900">{{ $pendaftaran->pekerjaan_ayah ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">No. HP</label>
                                    <p class="text-gray-900">{{ $pendaftaran->no_hp_ayah ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900 mb-3">Data Ibu</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Nama Ibu</label>
                                    <p class="text-gray-900">{{ $pendaftaran->nama_ibu }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Pekerjaan</label>
                                    <p class="text-gray-900">{{ $pendaftaran->pekerjaan_ibu ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">No. HP</label>
                                    <p class="text-gray-900">{{ $pendaftaran->no_hp_ibu ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        @if ($pendaftaran->nama_wali)
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-3">Data Wali</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Nama Wali</label>
                                        <p class="text-gray-900">{{ $pendaftaran->nama_wali }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Pekerjaan</label>
                                        <p class="text-gray-900">{{ $pendaftaran->pekerjaan_wali ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Penghasilan Orang Tua/Bulan</label>
                            <p class="text-gray-900">
                                {{ $pendaftaran->penghasilan_ortu ? 'Rp ' . number_format($pendaftaran->penghasilan_ortu, 0, ',', '.') : '-' }}
                            </p>
                        </div>
                    </div>

                    <!-- Sekolah Asal -->
                    <div x-show="tab === 'sekolah'" x-transition class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-500 mb-1">Nama Sekolah</label>
                                <p class="text-gray-900">{{ $pendaftaran->asal_sekolah }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">NPSN</label>
                                <p class="text-gray-900">{{ $pendaftaran->npsn_sekolah ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Tahun Lulus</label>
                                <p class="text-gray-900">{{ $pendaftaran->tahun_lulus }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Nilai UN/Rata-rata
                                    Ijazah</label>
                                <p class="text-gray-900">{{ $pendaftaran->nilai_un ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Belum Ada Pendaftaran -->
            <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Data Pendaftaran</h3>
                <p class="text-gray-600 mb-6 max-w-md mx-auto">
                    Anda belum memiliki data pendaftaran. Silakan mulai proses pendaftaran dengan mengklik tombol di bawah
                    ini.
                </p>
                <a href="{{ route('dashboard.pendaftaran.create') }}"
                    class="inline-flex items-center px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-lg">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Mulai Pendaftaran
                </a>
            </div>
        @endif
    </div>
@endsection
