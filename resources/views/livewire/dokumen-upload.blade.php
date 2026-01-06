<div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 hover:border-blue-300 transition">
    <!-- Header -->
    <div class="flex items-start justify-between mb-4">
        <div class="flex-1">
            <div class="flex items-center space-x-2">
                <h4 class="font-semibold text-gray-900">{{ $persyaratan->nama }}</h4>
                @if ($persyaratan->is_wajib)
                    <span
                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        Wajib
                    </span>
                @else
                    <span
                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        Opsional
                    </span>
                @endif
            </div>
            @if ($persyaratan->keterangan)
                <p class="text-sm text-gray-600 mt-1">{{ $persyaratan->keterangan }}</p>
            @endif
        </div>

        @if ($existingDokumen)
            <div>
                @if ($existingDokumen->status_verifikasi === 'pending')
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        Pending
                    </span>
                @elseif($existingDokumen->status_verifikasi === 'verified')
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Terverifikasi
                    </span>
                @elseif($existingDokumen->status_verifikasi === 'rejected')
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        Ditolak
                    </span>
                @endif
            </div>
        @endif
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg">
            <p class="text-sm text-green-700">{{ session('message') }}</p>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
            <p class="text-sm text-red-700">{{ session('error') }}</p>
        </div>
    @endif

    @if ($existingDokumen)
        <!-- Existing Document -->
        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3 flex-1">
                    <div class="flex-shrink-0">
                        @php
                            $isPdf = str_ends_with(strtolower($existingDokumen->file_path), '.pdf');
                        @endphp

                        @if ($isPdf)
                            <svg class="h-10 w-10 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        @else
                            <img src="{{ asset('storage/' . $existingDokumen->file_path) }}"
                                alt="{{ $existingDokumen->file_name }}"
                                class="h-16 w-16 rounded object-cover cursor-pointer hover:opacity-75"
                                onclick="window.open('{{ asset('storage/' . $existingDokumen->file_path) }}', '_blank')">
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $existingDokumen->file_name }}</p>
                        <p class="text-xs text-gray-500">
                            {{ number_format($existingDokumen->file_size / 1024, 2) }} KB
                        </p>
                        @if ($existingDokumen->status_verifikasi === 'rejected' && $existingDokumen->catatan)
                            <p class="text-xs text-red-600 mt-1">
                                <strong>Alasan Ditolak:</strong> {{ $existingDokumen->catatan }}
                            </p>
                        @endif
                    </div>
                </div>

                <div class="flex items-center space-x-2 ml-4">
                    <a href="{{ asset('storage/' . $existingDokumen->file_path) }}" target="_blank"
                        class="inline-flex items-center px-3 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition text-sm">
                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                        Lihat
                    </a>

                    @if ($pendaftaran->status_pendaftaran === 'draft' || $existingDokumen->status_verifikasi === 'rejected')
                        <button type="button" wire:click="deleteDokumen"
                            wire:confirm="Apakah Anda yakin ingin menghapus dokumen ini?"
                            class="inline-flex items-center px-3 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition text-sm">
                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                            Hapus
                        </button>
                    @endif
                </div>
            </div>
        </div>

        @if ($pendaftaran->status_pendaftaran === 'draft' || $existingDokumen->status_verifikasi === 'rejected')
            <!-- Option to replace -->
            <div class="mt-4" x-data="{ showReplace: false }">
                <button @click="showReplace = !showReplace" type="button"
                    class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                    <span x-show="!showReplace">+ Ganti Dokumen</span>
                    <span x-show="showReplace">- Batal Ganti</span>
                </button>

                <div x-show="showReplace" x-transition x-cloak class="mt-3">
                    <div class="space-y-3">
                        <input type="file" wire:model="file" accept=".jpg,.jpeg,.png,.pdf"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">

                        @error('file')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        <div wire:loading wire:target="file" class="text-sm text-gray-600">
                            <svg class="inline animate-spin h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Memproses file...
                        </div>

                        @if ($file)
                            <button type="button" wire:click="uploadFile"
                                class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                <span wire:loading.remove wire:target="uploadFile">Upload Dokumen Baru</span>
                                <span wire:loading wire:target="uploadFile">Mengupload...</span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    @else
        <!-- Upload Form -->
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Pilih File {{ $persyaratan->is_wajib ? '*' : '' }}
                </label>
                <input type="file" wire:model="file" accept=".jpg,.jpeg,.png,.pdf"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">

                @error('file')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <p class="mt-2 text-xs text-gray-500">Format: JPG, JPEG, PNG, PDF (Max: 2MB)</p>
            </div>

            <!-- Loading indicator -->
            <div wire:loading wire:target="file" class="text-sm text-gray-600">
                <svg class="inline animate-spin h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                Memproses file...
            </div>

            @if ($file)
                <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">File siap diupload</p>
                            <p class="text-xs text-gray-600 mt-1">
                                @if (is_object($file))
                                    {{ $file->getClientOriginalName() }}
                                @endif
                            </p>
                        </div>
                        <button type="button" wire:click="uploadFile"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            <span wire:loading.remove wire:target="uploadFile">Upload</span>
                            <span wire:loading wire:target="uploadFile">Mengupload...</span>
                        </button>
                    </div>
                </div>
            @endif
        </div>
    @endif
</div>
