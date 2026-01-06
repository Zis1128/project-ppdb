@extends('layouts.admin')

@section('title', 'Pengaturan Pembayaran')

@section('content')
    <div class="container-fluid px-4 py-6">

        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Pengaturan Pembayaran</h1>
            <p class="text-gray-600 mt-1">Kelola metode pembayaran dan konfigurasi payment gateway</p>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6" role="alert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Left Sidebar - Quick Actions -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm p-6 sticky top-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h3>

                        <div class="space-y-3">
                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Simpan Pengaturan
                            </button>

                            <button type="button" onclick="testMidtrans()"
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-lg transition flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Test Koneksi Midtrans
                            </button>

                            <a href="https://dashboard.midtrans.com/" target="_blank"
                                class="w-full bg-gray-600 hover:bg-gray-700 text-white font-medium py-3 px-4 rounded-lg transition flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                    </path>
                                </svg>
                                Midtrans Dashboard
                            </a>
                        </div>

                        <!-- Info -->
                        <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                            <div class="flex">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-800 font-medium">Info</p>
                                    <p class="text-xs text-blue-600 mt-1">Gunakan Sandbox untuk testing. Pindah ke
                                        Production saat sudah siap live.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Content - Settings Forms -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Midtrans Settings -->
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-bold text-white">Midtrans Payment Gateway</h3>
                                    <p class="text-blue-100 text-sm mt-1">Integrasi pembayaran online via Midtrans</p>
                                </div>
                                <img src="https://upload.wikimedia.org/wikipedia/commons/9/9d/Midtrans_logo.png"
                                    alt="Midtrans" class="h-8 bg-white px-3 py-1 rounded">
                            </div>
                        </div>

                        <div class="p-6 space-y-6">

                            <!-- Enable Midtrans -->
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <label class="font-semibold text-gray-900">Status Midtrans</label>
                                    <p class="text-sm text-gray-600 mt-1">Aktifkan atau nonaktifkan pembayaran via Midtrans
                                    </p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="settings[midtrans_enabled]" value="true"
                                        {{ Setting::get('midtrans_enabled') ? 'checked' : '' }} class="sr-only peer">
                                    <div
                                        class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-600">
                                    </div>
                                </label>
                            </div>

                            <!-- Environment -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Environment
                                    <span class="text-red-500">*</span>
                                </label>
                                <select name="settings[midtrans_environment]"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="sandbox"
                                        {{ Setting::get('midtrans_environment') === 'sandbox' ? 'selected' : '' }}>
                                        Sandbox (Testing)
                                    </option>
                                    <option value="production"
                                        {{ Setting::get('midtrans_environment') === 'production' ? 'selected' : '' }}>
                                        Production (Live)
                                    </option>
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Pilih Sandbox untuk testing, Production untuk live</p>
                            </div>

                            <!-- Client Key -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Client Key
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="settings[midtrans_client_key]"
                                    value="{{ Setting::get('midtrans_client_key') }}"
                                    placeholder="SB-Mid-client-xxxxxxxxxxxxxxxx"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <p class="text-xs text-gray-500 mt-1">Client Key dari Midtrans Dashboard</p>
                            </div>

                            <!-- Server Key -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Server Key
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="password" id="serverKey" name="settings[midtrans_server_key]"
                                        value="{{ Setting::get('midtrans_server_key') }}"
                                        placeholder="SB-Mid-server-xxxxxxxxxxxxxxxx"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent pr-10">
                                    <button type="button" onclick="togglePassword('serverKey')"
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Server Key dari Midtrans Dashboard (rahasia)</p>
                            </div>

                            <!-- Merchant ID -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Merchant ID
                                </label>
                                <input type="text" name="settings[midtrans_merchant_id]"
                                    value="{{ Setting::get('midtrans_merchant_id') }}" placeholder="G123456789"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <p class="text-xs text-gray-500 mt-1">Merchant ID dari Midtrans Dashboard</p>
                            </div>

                            <!-- How to Get Keys -->
                            <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <p class="text-sm font-semibold text-yellow-800 mb-2">📝 Cara Mendapatkan API Keys:</p>
                                <ol class="text-sm text-yellow-700 space-y-1 list-decimal list-inside">
                                    <li>Login ke <a href="https://dashboard.midtrans.com/" target="_blank"
                                            class="underline">Midtrans Dashboard</a></li>
                                    <li>Pilih Environment (Sandbox/Production)</li>
                                    <li>Menu Settings → Access Keys</li>
                                    <li>Copy Client Key dan Server Key</li>
                                    <li>Paste di form ini</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <!-- Transfer Bank Settings -->
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                            <h3 class="text-lg font-bold text-white">Transfer Bank Manual</h3>
                            <p class="text-green-100 text-sm mt-1">Pembayaran via transfer bank manual</p>
                        </div>

                        <div class="p-6 space-y-6">

                            <!-- Enable Transfer Bank -->
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <label class="font-semibold text-gray-900">Status Transfer Bank</label>
                                    <p class="text-sm text-gray-600 mt-1">Aktifkan atau nonaktifkan transfer bank manual
                                    </p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="settings[transfer_bank_enabled]" value="true"
                                        {{ Setting::get('transfer_bank_enabled') ? 'checked' : '' }} class="sr-only peer">
                                    <div
                                        class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-green-600">
                                    </div>
                                </label>
                            </div>

                            <!-- Bank Name -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Bank</label>
                                <input type="text" name="settings[bank_name]" value="{{ Setting::get('bank_name') }}"
                                    placeholder="Bank BRI"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>

                            <!-- Account Number -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Rekening</label>
                                <input type="text" name="settings[bank_account_number]"
                                    value="{{ Setting::get('bank_account_number') }}" placeholder="1234567890"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>

                            <!-- Account Name -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Pemilik Rekening</label>
                                <input type="text" name="settings[bank_account_name]"
                                    value="{{ Setting::get('bank_account_name') }}" placeholder="SMK ISLAM YPI 2"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>
                        </div>
                    </div>

                    <!-- Biaya Pendaftaran -->
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
                            <h3 class="text-lg font-bold text-white">Biaya Pendaftaran</h3>
                            <p class="text-purple-100 text-sm mt-1">Atur biaya pendaftaran PPDB</p>
                        </div>

                        <div class="p-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Biaya Pendaftaran
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span
                                        class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                                    <input type="number" name="settings[biaya_pendaftaran]"
                                        value="{{ Setting::get('biaya_pendaftaran') }}" placeholder="250000"
                                        class="w-full pl-12 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Format: 250000 (tanpa titik atau koma)</p>

                                <div class="mt-3 p-3 bg-purple-50 rounded-lg">
                                    <p class="text-sm text-purple-800">
                                        <span class="font-semibold">Preview:</span>
                                        Rp <span
                                            id="biayaPreview">{{ number_format(Setting::get('biaya_pendaftaran', 0), 0, ',', '.') }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>

    </div>

    <script>
        // Toggle Password Visibility
        function togglePassword(id) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        // Preview Biaya
        document.querySelector('input[name="settings[biaya_pendaftaran]"]').addEventListener('input', function(e) {
            const value = parseInt(e.target.value) || 0;
            document.getElementById('biayaPreview').textContent = value.toLocaleString('id-ID');
        });

        // Test Midtrans Connection
        async function testMidtrans() {
            try {
                const response = await fetch('{{ route('admin.settings.test-midtrans') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    alert('✅ ' + data.message);
                } else {
                    alert('❌ ' + data.message);
                }
            } catch (error) {
                alert('❌ Error: ' + error.message);
            }
        }
    </script>
@endsection
