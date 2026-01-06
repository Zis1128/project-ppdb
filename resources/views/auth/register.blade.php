<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - PPDB SMK</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <!-- Logo -->
            <div class="text-center mb-8">
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center">
                    <svg class="h-12 w-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l9-5-9-5-9 5 9 5z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z">
                        </path>
                    </svg>
                </a>
                <h2 class="mt-4 text-3xl font-bold text-gray-900">Buat Akun Baru</h2>
                <p class="mt-2 text-sm text-gray-600">PPDB SMK Negeri 1</p>
            </div>

            <!-- Register Form -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex">
                            <svg class="h-5 w-5 text-red-400 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="ml-3">
                                <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <!-- Nama Lengkap -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Lengkap
                        </label>
                        <input id="name" name="name" type="text" required autofocus
                            value="{{ old('name') }}"
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="Masukkan nama lengkap">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div> <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                            Email
                        </label>
                        <input id="email" name="email" type="email" required value="{{ old('email') }}"
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="nama@example.com">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div> <!-- Username -->
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-1">
                            Username
                        </label>
                        <input id="username" name="username" type="text" required value="{{ old('username') }}"
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="username">
                        <p class="mt-1 text-xs text-gray-500">Hanya huruf, angka, dash dan underscore</p>
                        @error('username')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div> <!-- No HP -->
                    <div>
                        <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-1">
                            No. HP/WhatsApp
                        </label>
                        <input id="no_hp" name="no_hp" type="tel" required value="{{ old('no_hp') }}"
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="08xxxxxxxxxx">
                        @error('no_hp')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div> <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                            Password
                        </label>
                        <input id="password" name="password" type="password" required
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="Minimal 8 karakter">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div> <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                            Konfirmasi Password
                        </label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="Ulangi password">
                    </div> <!-- Terms -->
                    <div class="flex items-start">
                        <input id="terms" name="terms" type="checkbox" required
                            class="h-4 w-4 mt-0.5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="terms" class="ml-2 block text-sm text-gray-700">
                            Saya menyetujui
                            <a href="#" class="text-blue-600 hover:text-blue-500">syarat dan ketentuan</a>
                            yang berlaku
                        </label>
                    </div> <!-- Submit Button -->
                    <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                        Daftar Sekarang
                    </button> <!-- Login Link -->
                    <div class="text-center pt-4">
                        <p class="text-sm text-gray-600">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                                Masuk di sini
                            </a>
                        </p>
                    </div>
                </form> <!-- Back to Home -->
                <div class="mt-6 text-center">
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
