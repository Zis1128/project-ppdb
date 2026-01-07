@extends('layouts.dashboard')

@section('title', 'Pembayaran')

@section('content')
    <div class="container mx-auto px-4 py-8">

        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Pembayaran</h1>
            <p class="text-gray-600 mt-1">Lakukan pembayaran biaya pendaftaran PPDB</p>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd"></path>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        @if (session('info'))
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd"></path>
                </svg>
                {{ session('info') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Left: Payment Content -->
            <div class="lg:col-span-2 space-y-6">

                @if ($pembayaran && $pembayaran->status === 'verified')
                    <!-- ✅ Payment Success -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="text-center">
                            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Pembayaran Terverifikasi!</h3>
                            <p class="text-gray-600 mb-6">Pembayaran Anda telah berhasil diverifikasi oleh panitia</p>

                            <div class="bg-green-50 rounded-lg p-4 mb-6">
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div class="text-left">
                                        <p class="text-gray-600">No. Invoice</p>
                                        <p class="font-bold text-gray-900">{{ $pembayaran->no_invoice }}</p>
                                    </div>
                                    <div class="text-left">
                                        <p class="text-gray-600">Tanggal Bayar</p>
                                        <p class="font-bold text-gray-900">
                                            {{ $pembayaran->tanggal_bayar ? $pembayaran->tanggal_bayar->format('d M Y') : '-' }}
                                        </p>
                                    </div>
                                    <div class="text-left">
                                        <p class="text-gray-600">Metode</p>
                                        <p class="font-bold text-gray-900">{{ $pembayaran->metode_pembayaran }}</p>
                                    </div>
                                    <div class="text-left">
                                        <p class="text-gray-600">Jumlah</p>
                                        <p class="font-bold text-gray-900">Rp
                                            {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('dashboard.pendaftaran.index') }}"
                                class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Kembali ke Dashboard
                            </a>
                        </div>
                    </div>
                @elseif($pembayaran && $pembayaran->status === 'rejected')
                    <!-- ❌ Payment Rejected -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <!-- ... existing rejected content ... -->
                    </div>
                @elseif(
                    $pembayaran &&
                        $pembayaran->status === 'pending' &&
                        ($pembayaran->bukti_pembayaran ||
                            $pembayaran->midtrans_order_id ||
                            ($pembayaran->tanggal_bayar && $pembayaran->metode_pembayaran)))
                    <!-- ⏳ Payment Pending - SUDAH UPLOAD/BAYAR -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-start space-x-4 mb-6">
                            <div
                                class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Menunggu Verifikasi</h3>
                                <p class="text-gray-600">Pembayaran Anda sedang dalam proses verifikasi oleh panitia. Mohon
                                    tunggu 1-2 hari kerja.</p>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">No. Invoice:</span>
                                    <span class="font-semibold">{{ $pembayaran->no_invoice }}</span>
                                </div>
                                @if ($pembayaran->metode_pembayaran)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Metode Pembayaran:</span>
                                        <span class="font-semibold">{{ $pembayaran->metode_pembayaran }}</span>
                                    </div>
                                @endif
                                @if ($pembayaran->payment_type)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Tipe Pembayaran:</span>
                                        <span class="font-semibold">
                                            @if ($pembayaran->payment_type === 'midtrans')
                                                Online (Midtrans)
                                            @elseif($pembayaran->payment_type === 'manual')
                                                Manual Transfer
                                            @else
                                                {{ $pembayaran->payment_type }}
                                            @endif
                                        </span>
                                    </div>
                                @endif
                                @if ($pembayaran->tanggal_bayar)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Tanggal Bayar:</span>
                                        <span
                                            class="font-semibold">{{ $pembayaran->tanggal_bayar->format('d M Y') }}</span>
                                    </div>
                                @endif
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Jumlah:</span>
                                    <span class="font-semibold">Rp
                                        {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</span>
                                </div>

                                @if ($pembayaran->midtrans_order_id)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Order ID:</span>
                                        <span class="font-semibold">{{ $pembayaran->midtrans_order_id }}</span>
                                    </div>
                                @endif
                            </div>

                            @if ($pembayaran->bukti_pembayaran)
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <p class="text-sm text-gray-600 mb-2">Bukti Pembayaran:</p>
                                    <img src="{{ asset('storage/' . $pembayaran->bukti_pembayaran) }}"
                                        alt="Bukti Pembayaran" class="w-full max-w-md rounded-lg border border-gray-300">
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <!-- 💳 Payment Options - BELUM BAYAR -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-6">Pilih Metode Pembayaran</h3>

                        <div class="space-y-4">

                            <!-- Midtrans Option -->
                            @if ($midtransEnabled)
                                <div
                                    class="border-2 border-blue-200 rounded-xl p-6 hover:border-blue-500 hover:shadow-md transition">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center">
                                            <div
                                                class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                                                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-gray-900 text-lg">Pembayaran Online</h4>
                                                <p class="text-sm text-gray-600">Via Midtrans (Instant Verification)</p>
                                            </div>
                                        </div>
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Recommended
                                        </span>
                                    </div>

                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600 mb-3">
                                            💳 Bayar dengan Credit Card, Debit Card, Virtual Account, E-Wallet, dan lainnya
                                        </p>

                                        <div class="flex flex-wrap gap-2">
                                            <span class="px-2 py-1 bg-gray-100 text-xs font-medium rounded">GoPay</span>
                                            <span class="px-2 py-1 bg-gray-100 text-xs font-medium rounded">OVO</span>
                                            <span class="px-2 py-1 bg-gray-100 text-xs font-medium rounded">DANA</span>
                                            <span
                                                class="px-2 py-1 bg-gray-100 text-xs font-medium rounded">ShopeePay</span>
                                            <span class="px-2 py-1 bg-gray-100 text-xs font-medium rounded">BCA VA</span>
                                            <span class="px-2 py-1 bg-gray-100 text-xs font-medium rounded">Mandiri
                                                VA</span>
                                            <span class="px-2 py-1 bg-gray-100 text-xs font-medium rounded">BRI VA</span>
                                            <span
                                                class="px-2 py-1 bg-gray-100 text-xs font-medium rounded">Indomaret</span>
                                            <span class="px-2 py-1 bg-gray-100 text-xs font-medium rounded">Alfamart</span>
                                        </div>
                                    </div>

                                    <form action="{{ route('dashboard.pembayaran.midtrans') }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition flex items-center justify-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                            Bayar Sekarang dengan Midtrans
                                        </button>
                                    </form>
                                </div>
                            @endif

                            <!-- Transfer Bank Option -->
                            @if ($transferBankEnabled)
                                <div
                                    class="border-2 border-gray-200 rounded-xl p-6 hover:border-gray-400 hover:shadow-md transition">
                                    <div class="flex items-center mb-4">
                                        <div
                                            class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                                            <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-900 text-lg">Transfer Bank Manual</h4>
                                            <p class="text-sm text-gray-600">Verifikasi 1-2 hari kerja</p>
                                        </div>
                                    </div>

                                    <div class="bg-green-50 rounded-lg p-4 mb-4">
                                        <p class="text-sm font-semibold text-gray-700 mb-3">📋 Informasi Rekening:</p>
                                        <div class="space-y-2">
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-600">Bank:</span>
                                                <span class="font-bold text-gray-900">{{ $bankName }}</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-600">No. Rekening:</span>
                                                <span class="font-bold text-gray-900">{{ $bankAccountNumber }}</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-600">Atas Nama:</span>
                                                <span class="font-bold text-gray-900">{{ $bankAccountName }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Upload Form -->
                                    <form action="{{ route('dashboard.pembayaran.upload') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                    Metode Transfer <span class="text-red-500">*</span>
                                                </label>
                                                <select name="metode_pembayaran" required
                                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                                    <option value="">Pilih Metode</option>
                                                    <option value="Transfer Bank">Transfer Bank</option>
                                                    <option value="Setor Tunai">Setor Tunai</option>
                                                    <option value="Mobile Banking">Mobile Banking</option>
                                                    <option value="ATM">ATM</option>
                                                </select>
                                                @error('metode_pembayaran')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                    Tanggal Transfer <span class="text-red-500">*</span>
                                                </label>
                                                <input type="date" name="tanggal_bayar" required
                                                    max="{{ date('Y-m-d') }}"
                                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                                @error('tanggal_bayar')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                    Bukti Transfer <span class="text-red-500">*</span>
                                                </label>
                                                <input type="file" name="bukti_pembayaran"
                                                    accept="image/jpeg,image/png,image/jpg" required
                                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                                                <p class="text-xs text-gray-500 mt-1">Format: JPG, JPEG, PNG - Max 2MB</p>
                                                @error('bukti_pembayaran')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <button type="submit"
                                                class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition flex items-center justify-center">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 1 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                                    </path>
                                                </svg>
                                                Upload Bukti Pembayaran
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @endif

                            @if (!$midtransEnabled && !$transferBankEnabled)
                                <div class="p-6 bg-yellow-50 border border-yellow-200 rounded-lg text-center">
                                    <svg class="w-12 h-12 text-yellow-600 mx-auto mb-3" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                        </path>
                                    </svg>
                                    <p class="text-gray-700 font-semibold">Metode pembayaran sedang tidak tersedia</p>
                                    <p class="text-sm text-gray-600 mt-1">Silakan hubungi panitia untuk informasi lebih
                                        lanjut</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right: Summary -->
            <div class="lg:col-span-1">
                <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl shadow-lg p-6 text-white sticky top-6">
                    <h3 class="text-lg font-bold mb-4">Ringkasan Pembayaran</h3>

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between">
                            <span class="text-blue-100">Biaya Pendaftaran</span>
                            <span class="font-bold">Rp {{ number_format($biayaPendaftaran, 0, ',', '.') }}</span>
                        </div>
                        <div class="border-t border-blue-400 pt-3">
                            <div class="flex justify-between text-lg">
                                <span class="font-semibold">Total Pembayaran</span>
                                <span class="font-bold">Rp {{ number_format($biayaPendaftaran, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    @if ($pembayaran)
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 mb-4">
                            <p class="text-sm text-blue-100 mb-2">Status Pembayaran:</p>
                            @if ($pembayaran->status === 'verified')
                                <span
                                    class="inline-block px-3 py-1 text-sm font-semibold rounded-full bg-green-500 text-white">
                                    ✓ Terverifikasi
                                </span>
                            @elseif($pembayaran->status === 'pending')
                                <span
                                    class="inline-block px-3 py-1 text-sm font-semibold rounded-full bg-yellow-500 text-white">
                                    ⏳ Menunggu Verifikasi
                                </span>
                            @else
                                <span
                                    class="inline-block px-3 py-1 text-sm font-semibold rounded-full bg-red-500 text-white">
                                    ✗ Ditolak
                                </span>
                            @endif
                        </div>
                    @endif

                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4">
                        <p class="text-sm text-blue-100 flex items-start">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span>Pastikan nominal yang ditransfer sesuai dengan total pembayaran untuk mempercepat proses
                                verifikasi</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
