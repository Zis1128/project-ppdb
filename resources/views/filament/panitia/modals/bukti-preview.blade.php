<div class="space-y-4">
    <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
        <dl class="grid grid-cols-2 gap-4">
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">No. Invoice</dt>
                <dd class="mt-1 text-sm font-bold text-gray-900 dark:text-gray-100">{{ $record->no_invoice }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Jumlah</dt>
                <dd class="mt-1 text-sm font-bold text-green-600 dark:text-green-400">Rp {{ number_format($record->jumlah, 0, ',', '.') }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Metode Pembayaran</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ str($record->metode_pembayaran)->replace('_', ' ')->title() }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Bayar</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                    {{ $record->tanggal_bayar ? $record->tanggal_bayar->format('d M Y H:i') : '-' }}
                </dd>
            </div>

            @if(in_array($record->metode_pembayaran, ['transfer_bank', 'virtual_account']))
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Bank Tujuan</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $record->bank_tujuan ?? '-' }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">No. Rekening</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $record->no_rekening ?? '-' }}</dd>
            </div>
            @endif
        </dl>

        @if($record->catatan)
        <div class="mt-4 p-3 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
            <dt class="text-sm font-medium text-red-800 dark:text-red-400 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                Catatan Verifikasi
            </dt>
            <dd class="mt-1 text-sm text-red-700 dark:text-red-300">{{ $record->catatan }}</dd>
        </div>
        @endif
    </div>

    <div class="border rounded-lg overflow-hidden bg-white dark:bg-gray-900">
        @if($record->bukti_pembayaran)
            <img src="{{ asset('storage/' . $record->bukti_pembayaran) }}" 
                 alt="Bukti Pembayaran" 
                 class="w-full h-auto max-h-[600px] object-contain">
        @else
            <div class="p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <p class="mt-2 text-sm text-gray-500">Bukti pembayaran belum diupload</p>
            </div>
        @endif
    </div>

    <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
        <div class="flex gap-3">
            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div class="text-sm text-blue-800 dark:text-blue-300">
                <p class="font-medium mb-1">Tips Verifikasi:</p>
                <ul class="list-disc list-inside space-y-1 text-xs">
                    <li>Pastikan jumlah transfer sesuai dengan yang tertera</li>
                    <li>Periksa tanggal dan waktu transfer</li>
                    <li>Verifikasi nama pengirim sesuai dengan data pendaftar</li>
                    <li>Cek kesesuaian bank tujuan</li>
                </ul>
            </div>
        </div>
    </div>
</div>