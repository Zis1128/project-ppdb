<div class="space-y-4">
    <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
        <dl class="grid grid-cols-2 gap-4">
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Jenis Dokumen</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $record->persyaratan->nama }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                <dd class="mt-1">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        @if($record->status_verifikasi === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($record->status_verifikasi === 'approved') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst($record->status_verifikasi) }}
                    </span>
                </dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama File</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $record->file_name }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Ukuran</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ number_format($record->file_size / 1024, 2) }} MB</dd>
            </div>
        </dl>

        @if($record->catatan)
        <div class="mt-4">
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Catatan Verifikasi</dt>
            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $record->catatan }}</dd>
        </div>
        @endif
    </div>

    <div class="border rounded-lg overflow-hidden bg-white dark:bg-gray-900">
        @if(in_array($record->file_type, ['image/jpeg', 'image/png', 'image/jpg']))
            <img src="{{ asset('storage/' . $record->file_path) }}" 
                 alt="{{ $record->file_name }}" 
                 class="w-full h-auto max-h-[600px] object-contain">
        @elseif($record->file_type === 'application/pdf')
            <iframe src="{{ asset('storage/' . $record->file_path) }}" 
                    class="w-full h-[600px]"
                    frameborder="0">
            </iframe>
        @else
            <div class="p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="mt-2 text-sm text-gray-500">Preview tidak tersedia untuk tipe file ini</p>
                <a href="{{ asset('storage/' . $record->file_path) }}" 
                   target="_blank"
                   class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700">
                    Download File
                </a>
            </div>
        @endif
    </div>
</div>