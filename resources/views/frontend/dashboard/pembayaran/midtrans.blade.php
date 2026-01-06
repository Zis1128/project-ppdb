@extends('layouts.dashboard')

@section('title', 'Pembayaran - Midtrans')

@section('content')
    <div class="container mx-auto px-4 py-8">

        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-xl shadow-lg p-8 text-center">

                <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-blue-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                        </path>
                    </svg>
                </div>

                <h1 class="text-3xl font-bold text-gray-900 mb-3">Proses Pembayaran</h1>
                <p class="text-gray-600 mb-8">Klik tombol di bawah untuk melanjutkan ke halaman pembayaran Midtrans</p>

                <button id="pay-button"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-8 rounded-lg transition inline-flex items-center text-lg shadow-lg hover:shadow-xl transform hover:scale-105">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                        </path>
                    </svg>
                    Bayar Sekarang
                </button>

                <div class="mt-8 p-4 bg-blue-50 rounded-lg">
                    <p class="text-sm text-blue-800 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Halaman pembayaran akan terbuka secara otomatis
                    </p>
                </div>

                <!-- Loading Indicator -->
                <div id="loading" class="mt-6 hidden">
                    <div class="flex items-center justify-center space-x-2">
                        <div class="w-3 h-3 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                        <div class="w-3 h-3 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                        <div class="w-3 h-3 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
                    </div>
                    <p class="text-sm text-gray-600 mt-2">Memproses pembayaran...</p>
                </div>

                <div class="mt-6">
                    <p class="text-sm text-gray-500 mb-2">Powered by</p>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/9/9d/Midtrans_logo.png" alt="Midtrans"
                        class="h-8 mx-auto opacity-75">
                </div>
            </div>

            <div class="text-center mt-6">
                <a href="{{ route('dashboard.pembayaran.index') }}"
                    class="text-gray-600 hover:text-gray-900 text-sm inline-flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Batal dan Kembali
                </a>
            </div>
        </div>

    </div>

    <!-- Midtrans Snap JS -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>

    <script>
        const payButton = document.getElementById('pay-button');
        const loading = document.getElementById('loading');
        const snapToken = '{{ $snapToken }}';

        // Function untuk auto-verify via AJAX
        async function autoVerifyPayment(orderId) {
            console.log('Auto-verifying payment:', orderId);

            try {
                const response = await fetch('{{ route('dashboard.pembayaran.auto-verify') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        order_id: orderId
                    })
                });

                const result = await response.json();
                console.log('Auto-verify result:', result);

                return result.success;
            } catch (error) {
                console.error('Auto-verify error:', error);
                return false;
            }
        }

        payButton.addEventListener('click', function() {
            loading.classList.remove('hidden');
            payButton.disabled = true;
            payButton.classList.add('opacity-50', 'cursor-not-allowed');

            snap.pay(snapToken, {
                onSuccess: async function(result) {
                    console.log('✅ Payment success:', result);

                    // Show loading
                    loading.classList.remove('hidden');

                    // Auto-verify payment
                    const verified = await autoVerifyPayment(result.order_id);

                    if (verified) {
                        console.log('✅ Status berhasil diupdate ke verified');
                    } else {
                        console.log('⚠️ Auto-verify gagal, tapi payment sudah success');
                    }

                    // Redirect ke success page
                    window.location.href = '{{ route('dashboard.pembayaran.success') }}';
                },
                onPending: function(result) {
                    console.log('⏳ Payment pending:', result);
                    window.location.href = '{{ route('dashboard.pembayaran.pending') }}';
                },
                onError: function(result) {
                    console.log('❌ Payment error:', result);
                    window.location.href = '{{ route('dashboard.pembayaran.failed') }}';
                },
                onClose: function() {
                    console.log('❌ Payment popup closed');
                    loading.classList.add('hidden');
                    payButton.disabled = false;
                    payButton.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            });
        });

        // Auto open Snap after 1 second
        setTimeout(function() {
            payButton.click();
        }, 1000);
    </script>
@endsection
