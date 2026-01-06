@extends('layouts.dashboard')

@section('title', 'Ubah Password')
@section('page-title', 'Ubah Password')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 rounded-xl p-4 animate-fade-in">
                <div class="flex">
                    <svg class="h-5 w-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="ml-3 text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 animate-fade-in">
                <div class="flex">
                    <svg class="h-5 w-5 text-red-600 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="ml-3 text-sm text-red-700">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Info Alert -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
            <div class="flex">
                <svg class="h-5 w-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        <strong>Tips Keamanan Password:</strong>
                    </p>
                    <ul class="mt-2 text-sm text-blue-600 list-disc list-inside space-y-1">
                        <li>Gunakan minimal 8 karakter</li>
                        <li>Kombinasikan huruf besar, huruf kecil, angka, dan simbol</li>
                        <li>Jangan gunakan password yang mudah ditebak</li>
                        <li>Jangan gunakan password yang sama dengan akun lain</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Change Password Form -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center mb-6">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">Ubah Password</h3>
                    <p class="text-sm text-gray-600">Pastikan password baru Anda kuat dan unik</p>
                </div>
            </div>

            <form action="{{ route('dashboard.profil.update-password') }}" method="POST" class="space-y-6"
                x-data="{
                    showCurrentPassword: false,
                    showNewPassword: false,
                    showConfirmPassword: false,
                    password: '',
                    passwordConfirmation: '',
                    strength: 0,
                    checkStrength() {
                        let str = 0;
                        if (this.password.length >= 8) str++;
                        if (this.password.match(/[a-z]/)) str++;
                        if (this.password.match(/[A-Z]/)) str++;
                        if (this.password.match(/[0-9]/)) str++;
                        if (this.password.match(/[^a-zA-Z0-9]/)) str++;
                        this.strength = str;
                    }
                }">
                @csrf
                @method('PUT')

                <!-- Current Password -->
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password Lama <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input :type="showCurrentPassword ? 'text' : 'password'" id="current_password"
                            name="current_password" required
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('current_password') border-red-500 @enderror pr-12">
                        <button type="button" @click="showCurrentPassword = !showCurrentPassword"
                            class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700">
                            <svg x-show="!showCurrentPassword" class="h-5 w-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                </path>
                            </svg>
                            <svg x-show="showCurrentPassword" class="h-5 w-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                                </path>
                            </svg>
                        </button>
                    </div>
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password Baru <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input :type="showNewPassword ? 'text' : 'password'" id="password" name="password"
                            x-model="password" @input="checkStrength()" required
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('password') border-red-500 @enderror pr-12">
                        <button type="button" @click="showNewPassword = !showNewPassword"
                            class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700">
                            <svg x-show="!showNewPassword" class="h-5 w-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                </path>
                            </svg>
                            <svg x-show="showNewPassword" class="h-5 w-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                                </path>
                            </svg>
                        </button>
                    </div>

                    <!-- Password Strength Indicator -->
                    <div x-show="password.length > 0" class="mt-2">
                        <div class="flex items-center space-x-2">
                            <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full transition-all duration-300"
                                    :class="{
                                        'w-1/5 bg-red-500': strength === 1,
                                        'w-2/5 bg-orange-500': strength === 2,
                                        'w-3/5 bg-yellow-500': strength === 3,
                                        'w-4/5 bg-blue-500': strength === 4,
                                        'w-full bg-green-500': strength === 5
                                    }">
                                </div>
                            </div>
                            <span class="text-xs font-medium"
                                :class="{
                                    'text-red-600': strength <= 2,
                                    'text-yellow-600': strength === 3,
                                    'text-blue-600': strength === 4,
                                    'text-green-600': strength === 5
                                }"
                                x-text="{
                                  1: 'Sangat Lemah',
                                  2: 'Lemah',
                                  3: 'Cukup',
                                  4: 'Kuat',
                                  5: 'Sangat Kuat'
                              }[strength] || ''">
                            </span>
                        </div>
                    </div>

                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Konfirmasi Password Baru <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input :type="showConfirmPassword ? 'text' : 'password'" id="password_confirmation"
                            name="password_confirmation" x-model="passwordConfirmation" required
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition pr-12">
                        <button type="button" @click="showConfirmPassword = !showConfirmPassword"
                            class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700">
                            <svg x-show="!showConfirmPassword" class="h-5 w-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                </path>
                            </svg>
                            <svg x-show="showConfirmPassword" class="h-5 w-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                                </path>
                            </svg>
                        </button>
                    </div>

                    <!-- Match Indicator -->
                    <div x-show="passwordConfirmation.length > 0" class="mt-2">
                        <p class="text-xs" :class="password === passwordConfirmation ? 'text-green-600' : 'text-red-600'">
                            <span x-show="password === passwordConfirmation">✓ Password cocok</span>
                            <span x-show="password !== passwordConfirmation">✗ Password tidak cocok</span>
                        </p>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-between pt-4 border-t">
                    <a href="{{ route('dashboard.profil.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>

                    <button type="submit"
                        class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-lg">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Ubah Password
                    </button>
                </div>
            </form>
        </div>

        <!-- Security Tips -->
        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
            <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                <svg class="h-5 w-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                    </path>
                </svg>
                Keamanan Akun
            </h4>
            <ul class="space-y-2 text-sm text-gray-600">
                <li class="flex items-start">
                    <svg class="h-4 w-4 mr-2 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Gunakan password yang unik dan tidak mudah ditebak
                </li>
                <li class="flex items-start">
                    <svg class="h-4 w-4 mr-2 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Jangan bagikan password Anda kepada siapapun
                </li>
                <li class="flex items-start">
                    <svg class="h-4 w-4 mr-2 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Ubah password secara berkala untuk keamanan akun
                </li>
                <li class="flex items-start">
                    <svg class="h-4 w-4 mr-2 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Logout dari akun jika menggunakan komputer umum
                </li>
            </ul>
        </div>
    </div>
@endsection
