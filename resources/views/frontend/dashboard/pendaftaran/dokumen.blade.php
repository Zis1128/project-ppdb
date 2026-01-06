@extends('layouts.dashboard')

@section('title', 'Upload Dokumen')
@section('page-title', 'Upload Dokumen Persyaratan')

@section('content')
    <div class="space-y-6">
        <!-- TEST LIVEWIRE - HAPUS SETELAH BERHASIL -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <h3 class="font-bold mb-2">🧪 Test Livewire (Debug Mode)</h3>
            @livewire('test-button')
        </div>
        <!-- Info Pendaftaran -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $pendaftaran->nama_lengkap }}</h3>
                    <p class="text-sm text-gray-600">No. Pendaftaran: {{ $pendaftaran->no_pendaftaran }}</p>
                </div>
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                {{ $pendaftaran->status_pendaftaran === 'draft' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                    {{ ucfirst($pendaftaran->status_pendaftaran) }}
                </span>
            </div>
        </div>

        <!-- Progress -->
        @php
            $totalWajib = $persyaratans->where('is_wajib', true)->count();
            $uploadedWajib = $dokumens
                ->whereIn('persyaratan_id', $persyaratans->where('is_wajib', true)->pluck('id'))
                ->count();
            $progress = $totalWajib > 0 ? ($uploadedWajib / $totalWajib) * 100 : 0;
        @endphp

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-700">Progress Upload Dokumen Wajib</span>
                <span class="text-sm font-medium text-gray-700">{{ $uploadedWajib }}/{{ $totalWajib }}</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3">
                <div class="bg-blue-600 h-3 rounded-full transition-all duration-500" style="width: {{ $progress }}%">
                </div>
            </div>
            <p class="mt-2 text-sm text-gray-600">
                @if ($progress >= 100)
                    <span class="text-green-600 font-medium">✓ Semua dokumen wajib sudah diupload!</span>
                @else
                    Lengkapi dokumen wajib untuk melanjutkan pendaftaran
                @endif
            </p>
        </div>

        <!-- Alert Info -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
            <div class="flex">
                <svg class="h-6 w-6 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Panduan Upload Dokumen</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <ul class="list-disc list-inside space-y-1">
                            <li>Pastikan dokumen dalam kondisi jelas dan terbaca</li>
                            <li>Format file yang diterima: JPG, PNG, PDF</li>
                            <li>Ukuran maksimal file: 2 MB per dokumen</li>
                            <li>Dokumen bertanda <span class="text-red-600 font-semibold">Wajib</span> harus diupload</li>
                            <li>Dokumen dapat diubah sebelum melakukan submit pendaftaran</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upload Dokumen -->
        <div class="space-y-4">
            @foreach ($persyaratans as $persyaratan)
                @livewire('dokumen-upload', ['pendaftaran' => $pendaftaran, 'persyaratan' => $persyaratan], key($persyaratan->id))
            @endforeach
        </div>

        <!-- Action Buttons -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <a href="{{ route('dashboard.pendaftaran.index') }}"
                    class="inline-flex items-center px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition w-full sm:w-auto justify-center">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Dashboard
                </a>

                @if ($pendaftaran->status_pendaftaran === 'draft' && $progress >= 100)
                    <form action="{{ route('dashboard.pendaftaran.submit', $pendaftaran) }}" method="POST"
                        onsubmit="return confirm('Apakah Anda yakin ingin submit pendaftaran? Data tidak dapat diubah setelah disubmit.')">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition shadow-lg w-full sm:w-auto justify-center">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Submit Pendaftaran
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('dokumenUploaded', () => {
                // reload halaman atau section progress
                location.reload();
            });
        });
    </script>

@endsection
