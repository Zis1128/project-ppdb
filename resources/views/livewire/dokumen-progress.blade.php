<div>
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
</div>
