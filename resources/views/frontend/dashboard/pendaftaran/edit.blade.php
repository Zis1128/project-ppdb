@extends('layouts.dashboard')

@section('title', 'Edit Pendaftaran')
@section('page-title', 'Edit Data Pendaftaran')

@section('content')
    <div x-data="{
        currentStep: 1,
        totalSteps: 5,
        formData: {},
        nextStep() {
            if (this.currentStep < this.totalSteps) {
                this.currentStep++;
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        },
        prevStep() {
            if (this.currentStep > 1) {
                this.currentStep--;
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }
    }" class="max-w-4xl mx-auto">

        <!-- Alert Warning -->
        <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-xl p-4">
            <div class="flex">
                <svg class="h-5 w-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                    </path>
                </svg>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        <strong>Perhatian:</strong> Data yang sudah disubmit tidak dapat diedit lagi. Pastikan semua data
                        sudah benar sebelum menyimpan.
                    </p>
                </div>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="mb-8 bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900">Edit Data Pendaftaran</h3>
                    <p class="text-sm text-gray-600">No. Pendaftaran: <span
                            class="font-semibold">{{ $pendaftaran->no_pendaftaran }}</span></p>
                </div>
                <div class="text-sm text-gray-600">
                    Step <span x-text="currentStep"></span> dari <span x-text="totalSteps"></span>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="relative">
                <div class="overflow-hidden h-2 text-xs flex rounded-full bg-gray-200">
                    <div :style="`width: ${(currentStep / totalSteps) * 100}%`"
                        class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-600 transition-all duration-500">
                    </div>
                </div>
            </div>

            <!-- Step Indicators -->
            <div class="flex justify-between mt-6">
                <div class="flex flex-col items-center" :class="currentStep >= 1 ? 'text-blue-600' : 'text-gray-400'">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center border-2 transition-all"
                        :class="currentStep >= 1 ? 'border-blue-600 bg-blue-600 text-white' : 'border-gray-300'">
                        <span x-show="currentStep > 1">✓</span>
                        <span x-show="currentStep <= 1">1</span>
                    </div>
                    <span class="text-xs mt-2 hidden sm:block">Jalur Masuk</span>
                </div>
                <div class="flex flex-col items-center" :class="currentStep >= 2 ? 'text-blue-600' : 'text-gray-400'">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center border-2 transition-all"
                        :class="currentStep >= 2 ? 'border-blue-600 bg-blue-600 text-white' : 'border-gray-300'">
                        <span x-show="currentStep > 2">✓</span>
                        <span x-show="currentStep <= 2">2</span>
                    </div>
                    <span class="text-xs mt-2 hidden sm:block">Data Pribadi</span>
                </div>
                <div class="flex flex-col items-center" :class="currentStep >= 3 ? 'text-blue-600' : 'text-gray-400'">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center border-2 transition-all"
                        :class="currentStep >= 3 ? 'border-blue-600 bg-blue-600 text-white' : 'border-gray-300'">
                        <span x-show="currentStep > 3">✓</span>
                        <span x-show="currentStep <= 3">3</span>
                    </div>
                    <span class="text-xs mt-2 hidden sm:block">Orang Tua</span>
                </div>
                <div class="flex flex-col items-center" :class="currentStep >= 4 ? 'text-blue-600' : 'text-gray-400'">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center border-2 transition-all"
                        :class="currentStep >= 4 ? 'border-blue-600 bg-blue-600 text-white' : 'border-gray-300'">
                        <span x-show="currentStep > 4">✓</span>
                        <span x-show="currentStep <= 4">4</span>
                    </div>
                    <span class="text-xs mt-2 hidden sm:block">Sekolah</span>
                </div>
                <div class="flex flex-col items-center" :class="currentStep >= 5 ? 'text-blue-600' : 'text-gray-400'">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center border-2 transition-all"
                        :class="currentStep >= 5 ? 'border-blue-600 bg-blue-600 text-white' : 'border-gray-300'">
                        <span x-show="currentStep > 5">✓</span>
                        <span x-show="currentStep <= 5">5</span>
                    </div>
                    <span class="text-xs mt-2 hidden sm:block">Jurusan</span>
                </div>
            </div>
        </div>

        <!-- Info Box -->
        <div class="mb-6 bg-blue-50 border border-blue-200 rounded-xl p-4">
            <div class="flex">
                <svg class="h-5 w-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        <strong>Tahun Ajaran:</strong> {{ $tahunAjaran->nama }} |
                        <strong>{{ $gelombangAktif->nama }}</strong> ({{ $gelombangAktif->tanggal_mulai->format('d M Y') }}
                        - {{ $gelombangAktif->tanggal_selesai->format('d M Y') }})
                    </p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('dashboard.pendaftaran.update', $pendaftaran) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- STEP 1: Jalur Masuk -->
            <div x-show="currentStep === 1" x-transition class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-6">Step 1: Pilih Jalur Masuk</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach ($jalurMasuks as $jalur)
                        <label
                            class="relative flex cursor-pointer rounded-xl border-2 border-gray-200 p-6 hover:border-blue-500 transition group">
                            <input type="radio" name="jalur_masuk_id" value="{{ $jalur->id }}" class="sr-only peer"
                                required
                                {{ old('jalur_masuk_id', $pendaftaran->jalur_masuk_id) == $jalur->id ? 'checked' : '' }}>
                            <div class="flex flex-col flex-1">
                                <div class="flex items-center justify-between mb-3">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $jalur->kode }}
                                    </span>
                                    <svg class="h-6 w-6 text-blue-600 hidden peer-checked:block" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <span class="block text-lg font-semibold text-gray-900 mb-2">{{ $jalur->nama }}</span>
                                <span class="text-sm text-gray-600">{{ $jalur->deskripsi }}</span>
                                <div class="mt-3 text-xs text-gray-500">
                                    Kuota: {{ $jalur->kuota_persen }}%
                                </div>
                            </div>
                            <span
                                class="absolute -inset-px rounded-xl border-2 pointer-events-none hidden peer-checked:block border-blue-600"></span>
                        </label>
                    @endforeach
                </div>

                @error('jalur_masuk_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <div class="mt-6 flex justify-end">
                    <button type="button" @click="nextStep()"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Lanjut: Data Pribadi →
                    </button>
                </div>
            </div>

            <!-- STEP 2: Data Pribadi -->
            <div x-show="currentStep === 2" x-transition class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-6">Step 2: Data Pribadi</h3>

                <div class="space-y-6">
                    <!-- NISN & NIK -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nisn" class="block text-sm font-medium text-gray-700 mb-2">
                                NISN <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="nisn" name="nisn"
                                value="{{ old('nisn', $pendaftaran->nisn) }}" required maxlength="10"
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('nisn') border-red-500 @enderror"
                                placeholder="1234567890">
                            @error('nisn')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">
                                NIK (KTP) <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="nik" name="nik"
                                value="{{ old('nik', $pendaftaran->nik) }}" required maxlength="16"
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('nik') border-red-500 @enderror"
                                placeholder="1234567890123456">
                            @error('nik')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Nama Lengkap -->
                    <div>
                        <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap"
                            value="{{ old('nama_lengkap', $pendaftaran->nama_lengkap) }}" required
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('nama_lengkap') border-red-500 @enderror"
                            placeholder="Nama lengkap sesuai ijazah">
                        @error('nama_lengkap')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tempat, Tanggal Lahir -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 mb-2">
                                Tempat Lahir <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="tempat_lahir" name="tempat_lahir"
                                value="{{ old('tempat_lahir', $pendaftaran->tempat_lahir) }}" required
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('tempat_lahir') border-red-500 @enderror">
                            @error('tempat_lahir')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Lahir <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                                value="{{ old('tanggal_lahir', $pendaftaran->tanggal_lahir->format('Y-m-d')) }}" required
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('tanggal_lahir') border-red-500 @enderror">
                            @error('tanggal_lahir')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Kelamin <span class="text-red-500">*</span>
                            </label>
                            <select id="jenis_kelamin" name="jenis_kelamin" required
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('jenis_kelamin') border-red-500 @enderror">
                                <option value="">Pilih</option>
                                <option value="L"
                                    {{ old('jenis_kelamin', $pendaftaran->jenis_kelamin) == 'L' ? 'selected' : '' }}>
                                    Laki-laki</option>
                                <option value="P"
                                    {{ old('jenis_kelamin', $pendaftaran->jenis_kelamin) == 'P' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Agama -->
                    <div>
                        <label for="agama" class="block text-sm font-medium text-gray-700 mb-2">
                            Agama <span class="text-red-500">*</span>
                        </label>
                        <select id="agama" name="agama" required
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('agama') border-red-500 @enderror">
                            <option value="">Pilih Agama</option>
                            <option value="Islam" {{ old('agama', $pendaftaran->agama) == 'Islam' ? 'selected' : '' }}>
                                Islam</option>
                            <option value="Kristen"
                                {{ old('agama', $pendaftaran->agama) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="Katolik"
                                {{ old('agama', $pendaftaran->agama) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ old('agama', $pendaftaran->agama) == 'Hindu' ? 'selected' : '' }}>
                                Hindu</option>
                            <option value="Buddha" {{ old('agama', $pendaftaran->agama) == 'Buddha' ? 'selected' : '' }}>
                                Buddha</option>
                            <option value="Konghucu"
                                {{ old('agama', $pendaftaran->agama) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                        </select>
                        @error('agama')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                            Alamat Lengkap <span class="text-red-500">*</span>
                        </label>
                        <textarea id="alamat" name="alamat" rows="3" required
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('alamat') border-red-500 @enderror"
                            placeholder="Jalan, nomor rumah, RT/RW">{{ old('alamat', $pendaftaran->alamat) }}</textarea>
                        @error('alamat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kelurahan, Kecamatan, Kota, Provinsi -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="kelurahan" class="block text-sm font-medium text-gray-700 mb-2">
                                Kelurahan/Desa <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="kelurahan" name="kelurahan"
                                value="{{ old('kelurahan', $pendaftaran->kelurahan) }}" required
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>

                        <div>
                            <label for="kecamatan" class="block text-sm font-medium text-gray-700 mb-2">
                                Kecamatan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="kecamatan" name="kecamatan"
                                value="{{ old('kecamatan', $pendaftaran->kecamatan) }}" required
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>

                        <div>
                            <label for="kota" class="block text-sm font-medium text-gray-700 mb-2">
                                Kota/Kabupaten <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="kota" name="kota"
                                value="{{ old('kota', $pendaftaran->kota) }}" required
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>

                        <div>
                            <label for="provinsi" class="block text-sm font-medium text-gray-700 mb-2">
                                Provinsi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="provinsi" name="provinsi"
                                value="{{ old('provinsi', $pendaftaran->provinsi) }}" required
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                    </div>

                    <!-- Kontak -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="no_hp_siswa" class="block text-sm font-medium text-gray-700 mb-2">
                                No. HP Siswa <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" id="no_hp_siswa" name="no_hp_siswa"
                                value="{{ old('no_hp_siswa', $pendaftaran->no_hp_siswa) }}" required
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="08xxxxxxxxxx">
                        </div>

                        <div>
                            <label for="email_siswa" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Siswa <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="email_siswa" name="email_siswa"
                                value="{{ old('email_siswa', $pendaftaran->email_siswa) }}" required
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="email@example.com">
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-between">
                    <button type="button" @click="prevStep()"
                        class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        ← Kembali
                    </button>
                    <button type="button" @click="nextStep()"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Lanjut: Data Orang Tua →
                    </button>
                </div>
            </div>

            <!-- STEP 3: Data Orang Tua -->
            <div x-show="currentStep === 3" x-transition class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-6">Step 3: Data Orang Tua/Wali</h3>

                <div class="space-y-8">
                    <!-- Data Ayah -->
                    <div class="border-l-4 border-blue-500 pl-4">
                        <h4 class="font-semibold text-gray-900 mb-4">Data Ayah</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nama_ayah" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Ayah <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="nama_ayah" name="nama_ayah"
                                    value="{{ old('nama_ayah', $pendaftaran->nama_ayah) }}" required
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            </div>

                            <div>
                                <label for="pekerjaan_ayah" class="block text-sm font-medium text-gray-700 mb-2">
                                    Pekerjaan Ayah
                                </label>
                                <input type="text" id="pekerjaan_ayah" name="pekerjaan_ayah"
                                    value="{{ old('pekerjaan_ayah', $pendaftaran->pekerjaan_ayah) }}"
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            </div>

                            <div>
                                <label for="no_hp_ayah" class="block text-sm font-medium text-gray-700 mb-2">
                                    No. HP Ayah
                                </label>
                                <input type="tel" id="no_hp_ayah" name="no_hp_ayah"
                                    value="{{ old('no_hp_ayah', $pendaftaran->no_hp_ayah) }}"
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            </div>
                        </div>
                    </div>

                    <!-- Data Ibu -->
                    <div class="border-l-4 border-pink-500 pl-4">
                        <h4 class="font-semibold text-gray-900 mb-4">Data Ibu</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nama_ibu" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Ibu <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="nama_ibu" name="nama_ibu"
                                    value="{{ old('nama_ibu', $pendaftaran->nama_ibu) }}" required
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            </div>

                            <div>
                                <label for="pekerjaan_ibu" class="block text-sm font-medium text-gray-700 mb-2">
                                    Pekerjaan Ibu
                                </label>
                                <input type="text" id="pekerjaan_ibu" name="pekerjaan_ibu"
                                    value="{{ old('pekerjaan_ibu', $pendaftaran->pekerjaan_ibu) }}"
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            </div>

                            <div>
                                <label for="no_hp_ibu" class="block text-sm font-medium text-gray-700 mb-2">
                                    No. HP Ibu
                                </label>
                                <input type="tel" id="no_hp_ibu" name="no_hp_ibu"
                                    value="{{ old('no_hp_ibu', $pendaftaran->no_hp_ibu) }}"
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            </div>
                        </div>
                    </div>

                    <!-- Data Wali (Opsional) -->
                    <div class="border-l-4 border-gray-400 pl-4" x-data="{ showWali: {{ $pendaftaran->nama_wali ? 'true' : 'false' }} }">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="font-semibold text-gray-900">Data Wali (Opsional)</h4>
                            <button type="button" @click="showWali = !showWali"
                                class="text-sm text-blue-600 hover:text-blue-700">
                                <span x-show="!showWali">+ Tambah Data Wali</span>
                                <span x-show="showWali">- Sembunyikan</span>
                            </button>
                        </div>
                        <div x-show="showWali" x-transition class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nama_wali" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Wali
                                </label>
                                <input type="text" id="nama_wali" name="nama_wali"
                                    value="{{ old('nama_wali', $pendaftaran->nama_wali) }}"
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            </div>
                            <div>
                                <label for="pekerjaan_wali" class="block text-sm font-medium text-gray-700 mb-2">
                                    Pekerjaan Wali
                                </label>
                                <input type="text" id="pekerjaan_wali" name="pekerjaan_wali"
                                    value="{{ old('pekerjaan_wali', $pendaftaran->pekerjaan_wali) }}"
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            </div>

                            <div>
                                <label for="no_hp_wali" class="block text-sm font-medium text-gray-700 mb-2">
                                    No. HP Wali
                                </label>
                                <input type="tel" id="no_hp_wali" name="no_hp_wali"
                                    value="{{ old('no_hp_wali', $pendaftaran->no_hp_wali) }}"
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            </div>
                        </div>
                    </div>

                    <!-- Penghasilan -->
                    <div>
                        <label for="penghasilan_ortu" class="block text-sm font-medium text-gray-700 mb-2">
                            Penghasilan Orang Tua/Wali Per Bulan
                        </label>
                        <select id="penghasilan_ortu" name="penghasilan_ortu"
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option value="">Pilih Range Penghasilan</option>
                            <option value="1000000"
                                {{ old('penghasilan_ortu', $pendaftaran->penghasilan_ortu) == '1000000' ? 'selected' : '' }}>
                                < Rp 1.000.000</option>
                            <option value="2500000"
                                {{ old('penghasilan_ortu', $pendaftaran->penghasilan_ortu) == '2500000' ? 'selected' : '' }}>
                                Rp 1.000.000 - Rp 2.500.000</option>
                            <option value="5000000"
                                {{ old('penghasilan_ortu', $pendaftaran->penghasilan_ortu) == '5000000' ? 'selected' : '' }}>
                                Rp 2.500.000 - Rp 5.000.000</option>
                            <option value="10000000"
                                {{ old('penghasilan_ortu', $pendaftaran->penghasilan_ortu) == '10000000' ? 'selected' : '' }}>
                                Rp 5.000.000 - Rp 10.000.000</option>
                            <option value="15000000"
                                {{ old('penghasilan_ortu', $pendaftaran->penghasilan_ortu) == '15000000' ? 'selected' : '' }}>
                                > Rp 10.000.000</option>
                        </select>
                    </div>
                </div>

                <div class="mt-6 flex justify-between">
                    <button type="button" @click="prevStep()"
                        class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        ← Kembali
                    </button>
                    <button type="button" @click="nextStep()"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Lanjut: Data Sekolah →
                    </button>
                </div>
            </div>

            <!-- STEP 4: Sekolah Asal -->
            <div x-show="currentStep === 4" x-transition class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-6">Step 4: Data Sekolah Asal</h3>

                <div class="space-y-6">
                    <div>
                        <label for="asal_sekolah" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Sekolah <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="asal_sekolah" name="asal_sekolah"
                            value="{{ old('asal_sekolah', $pendaftaran->asal_sekolah) }}" required
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="Contoh: SMP Negeri 1 Jakarta">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="npsn_sekolah" class="block text-sm font-medium text-gray-700 mb-2">
                                NPSN Sekolah
                            </label>
                            <input type="text" id="npsn_sekolah" name="npsn_sekolah"
                                value="{{ old('npsn_sekolah', $pendaftaran->npsn_sekolah) }}"
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="8 digit angka">
                        </div>

                        <div>
                            <label for="tahun_lulus" class="block text-sm font-medium text-gray-700 mb-2">
                                Tahun Lulus <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="tahun_lulus" name="tahun_lulus"
                                value="{{ old('tahun_lulus', $pendaftaran->tahun_lulus) }}" required min="2010"
                                max="{{ date('Y') + 1 }}"
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                    </div>

                    <div>
                        <label for="nilai_un" class="block text-sm font-medium text-gray-700 mb-2">
                            Nilai UN/Rata-rata Ijazah
                        </label>
                        <input type="number" id="nilai_un" name="nilai_un"
                            value="{{ old('nilai_un', $pendaftaran->nilai_un) }}" step="0.01" min="0"
                            max="100"
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="Contoh: 85.50">
                        <p class="mt-1 text-sm text-gray-500">Isi jika sudah memiliki nilai UN atau nilai ijazah</p>
                    </div>
                </div>

                <div class="mt-6 flex justify-between">
                    <button type="button" @click="prevStep()"
                        class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        ← Kembali
                    </button>
                    <button type="button" @click="nextStep()"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Lanjut: Pilih Jurusan →
                    </button>
                </div>
            </div>

            <!-- STEP 5: Pilihan Jurusan -->
            <div x-show="currentStep === 5" x-transition class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-6">Step 5: Pilihan Jurusan</h3>

                <div class="space-y-6">
                    <div>
                        <label for="jurusan_pilihan_1" class="block text-sm font-medium text-gray-700 mb-2">
                            Jurusan Pilihan 1 <span class="text-red-500">*</span>
                        </label>
                        <select id="jurusan_pilihan_1" name="jurusan_pilihan_1" required
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option value="">Pilih Jurusan</option>
                            @foreach ($jurusans as $jurusan)
                                <option value="{{ $jurusan->id }}"
                                    {{ old('jurusan_pilihan_1', $pendaftaran->jurusan_pilihan_1) == $jurusan->id ? 'selected' : '' }}>
                                    {{ $jurusan->nama }} (Kuota: {{ $jurusan->kuota }} siswa)
                                </option>
                            @endforeach
                        </select>
                        @error('jurusan_pilihan_1')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jurusan_pilihan_2" class="block text-sm font-medium text-gray-700 mb-2">
                            Jurusan Pilihan 2 (Opsional)
                        </label>
                        <select id="jurusan_pilihan_2" name="jurusan_pilihan_2"
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option value="">Pilih Jurusan (Tidak Wajib)</option>
                            @foreach ($jurusans as $jurusan)
                                <option value="{{ $jurusan->id }}"
                                    {{ old('jurusan_pilihan_2', $pendaftaran->jurusan_pilihan_2) == $jurusan->id ? 'selected' : '' }}>
                                    {{ $jurusan->nama }} (Kuota: {{ $jurusan->kuota }} siswa)
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-2 text-sm text-gray-500">
                            <svg class="inline h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Pilih jurusan alternatif sebagai cadangan jika pilihan pertama penuh
                        </p>
                    </div>

                    <!-- Ringkasan -->
                    <div class="mt-8 p-6 bg-gray-50 rounded-lg border border-gray-200">
                        <h4 class="font-semibold text-gray-900 mb-4">📝 Ringkasan Pendaftaran</h4>
                        <div class="space-y-2 text-sm">
                            <p><span class="text-gray-600">No. Pendaftaran:</span> <span
                                    class="font-medium">{{ $pendaftaran->no_pendaftaran }}</span></p>
                            <p><span class="text-gray-600">Nama Lengkap:</span> <span
                                    class="font-medium">{{ $pendaftaran->nama_lengkap }}</span></p>
                            <p><span class="text-gray-600">NISN:</span> <span
                                    class="font-medium">{{ $pendaftaran->nisn }}</span></p>
                            <p><span class="text-gray-600">Asal Sekolah:</span> <span
                                    class="font-medium">{{ $pendaftaran->asal_sekolah }}</span></p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-between">
                    <button type="button" @click="prevStep()"
                        class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        ← Kembali
                    </button>
                    <button type="submit"
                        class="px-8 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition shadow-lg">
                        <svg class="inline h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Update Data Pendaftaran
                    </button>
                </div>
            </div>

        </form>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto format NISN dan NIK
            const nisnInput = document.getElementById('nisn');
            const nikInput = document.getElementById('nik');

            if (nisnInput) {
                nisnInput.addEventListener('input', function(e) {
                    this.value = this.value.replace(/\D/g, '').slice(0, 10);
                });
            }

            if (nikInput) {
                nikInput.addEventListener('input', function(e) {
                    this.value = this.value.replace(/\D/g, '').slice(0, 16);
                });
            }

            // Prevent selecting same jurusan
            const jurusan1 = document.getElementById('jurusan_pilihan_1');
            const jurusan2 = document.getElementById('jurusan_pilihan_2');

            if (jurusan1 && jurusan2) {
                jurusan1.addEventListener('change', function() {
                    const selectedValue = this.value;
                    Array.from(jurusan2.options).forEach(option => {
                        if (option.value === selectedValue && selectedValue !== '') {
                            option.disabled = true;
                        } else {
                            option.disabled = false;
                        }
                    });

                    // Reset jurusan 2 if same as jurusan 1
                    if (jurusan2.value === selectedValue) {
                        jurusan2.value = '';
                    }
                });

                // Trigger on load
                jurusan1.dispatchEvent(new Event('change'));
            }
        });
    </script>
@endpush
