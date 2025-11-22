<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Filter Form --}}
        <x-filament::card><form wire:submit="$refresh" class="space-y-6">
                {{ $this->form }}            <div class="flex gap-3">
                <x-filament::button type="submit" icon="heroicon-m-funnel">
                    Terapkan Filter
                </x-filament::button>                <x-filament::button 
                    type="button" 
                    color="gray"
                    wire:click="$set('data', [])"
                    icon="heroicon-m-x-mark">
                    Reset Filter
                </x-filament::button>
            </div>
        </form>
    </x-filament::card>    {{-- Statistik Umum --}}
    @php
        $stats = $this->getStats();
    @endphp    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <x-filament::card>
            <div class="text-center">
                <div class="text-3xl font-bold text-primary-600">{{ number_format($stats['total']) }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Total Pendaftar</div>
            </div>
        </x-filament::card>        <x-filament::card>
            <div class="text-center">
                <div class="text-3xl font-bold text-yellow-600">{{ number_format($stats['pending']) }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Pending</div>
            </div>
        </x-filament::card>        <x-filament::card>
            <div class="text-center">
                <div class="text-3xl font-bold text-green-600">{{ number_format($stats['approved']) }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Disetujui</div>
            </div>
        </x-filament::card>        <x-filament::card>
            <div class="text-center">
                <div class="text-3xl font-bold text-red-600">{{ number_format($stats['rejected']) }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Ditolak</div>
            </div>
        </x-filament::card>        <x-filament::card>
            <div class="text-center">
                <div class="text-3xl font-bold text-blue-600">{{ number_format($stats['accepted']) }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Diterima</div>
            </div>
        </x-filament::card>
    </div>    {{-- Rekap Per Jurusan --}}
    <x-filament::card>
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold">Rekap Per Jurusan</h3>
                <x-filament::badge color="primary">
                    {{ count($this->getRekapPerJurusan()) }} Jurusan
                </x-filament::badge>
            </div>            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="text-left py-3 px-4 font-semibold">Jurusan</th>
                            <th class="text-center py-3 px-4 font-semibold">Kuota</th>
                            <th class="text-center py-3 px-4 font-semibold">Peminat</th>
                            <th class="text-center py-3 px-4 font-semibold">Diterima</th>
                            <th class="text-center py-3 px-4 font-semibold">Sisa</th>
                            <th class="text-right py-3 px-4 font-semibold">Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($this->getRekapPerJurusan() as $jurusan)
                        <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800/50">
                            <td class="py-3 px-4 font-medium">{{ $jurusan['nama'] }}</td>
                            <td class="py-3 px-4 text-center">{{ number_format($jurusan['kuota']) }}</td>
                            <td class="py-3 px-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ number_format($jurusan['peminat']) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ number_format($jurusan['diterima']) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $jurusan['sisa'] > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800' }}">
                                    {{ number_format($jurusan['sisa']) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <div class="w-24 h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                        <div class="h-full bg-green-500 rounded-full" 
                                             style="width: {{ min($jurusan['persentase'], 100) }}%"></div>
                                    </div>
                                    <span class="font-semibold text-gray-700 dark:text-gray-300 w-12 text-right">
                                        {{ $jurusan['persentase'] }}%
                                    </span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </x-filament::card>    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Rekap Per Jalur Masuk --}}
        <x-filament::card>
            <div class="space-y-4">
                <h3 class="text-lg font-semibold">Rekap Per Jalur Masuk</h3>                <div class="space-y-3">
                    @foreach($this->getRekapPerJalur() as $jalur)
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="font-semibold text-gray-900 dark:text-white">{{ $jalur['nama'] }}</h4>
                            <span class="text-2xl font-bold text-primary-600">{{ number_format($jalur['total']) }}</span>
                        </div>                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Disetujui:</span>
                                <span class="font-semibold text-green-600 ml-2">{{ number_format($jalur['approved']) }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Ditolak:</span>
                                <span class="font-semibold text-red-600 ml-2">{{ number_format($jalur['rejected']) }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </x-filament::card>        {{-- Rekap Pembayaran --}}
        <x-filament::card>
            <div class="space-y-4">
                <h3 class="text-lg font-semibold">Rekap Pembayaran</h3>                @php
                    $pembayaran = $this->getRekapPembayaran();
                @endphp                <div class="space-y-3">
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-green-50 dark:bg-green-900/20">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Total Terverifikasi</div>
                                <div class="text-2xl font-bold text-green-600">
                                    Rp {{ number_format($pembayaran['verified'], 0, ',', '.') }}
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ number_format($pembayaran['count_verified']) }} pembayaran
                                </div>
                            </div>
                            <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-yellow-50 dark:bg-yellow-900/20">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Pending Verifikasi</div>
                                <div class="text-2xl font-bold text-yellow-600">
                                    Rp {{ number_format($pembayaran['pending'], 0, ',', '.') }}
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ number_format($pembayaran['count_pending']) }} pembayaran
                                </div>
                            </div>
                            <svg class="w-12 h-12 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Total Keseluruhan</div>
                                <div class="text-2xl font-bold text-primary-600">
                                    Rp {{ number_format($pembayaran['total'], 0, ',', '.') }}
                                </div>
                            </div>
                            <svg class="w-12 h-12 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </x-filament::card>
    </div>    {{-- Tombol Export --}}
    <div class="flex gap-3 justify-end">
        <x-filament::button 
            color="success"
            icon="heroicon-o-arrow-down-tray"
            wire:click="$dispatch('export-excel')">
            Export Excel
        </x-filament::button>        <x-filament::button 
            color="danger"
            icon="heroicon-o-document-arrow-down"
            wire:click="$dispatch('export-pdf')">
            Export PDF
        </x-filament::button>        <x-filament::button 
            color="gray"
            icon="heroicon-o-printer"
            wire:click="window.print()">
            Print
        </x-filament::button>
    </div>
</div>
</x-filament-panels::page>