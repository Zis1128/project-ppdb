@extends('layouts.dashboard')

@section('title', 'Profil')
@section('page-title', 'Profil Saya')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 rounded-xl p-4">
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
            <div class="bg-red-50 border border-red-200 rounded-xl p-4">
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

        <!-- Profile Card -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-8">
                <div class="flex items-center space-x-6">
                    <!-- Avatar -->
                    <div class="flex-shrink-0">
                        @if ($user->foto)
                            <img src="{{ asset('storage/' . $user->foto) }}" alt="{{ $user->name }}"
                                class="w-24 h-24 rounded-full border-4 border-white object-cover">
                        @else
                            <div
                                class="w-24 h-24 rounded-full border-4 border-white bg-white flex items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Info -->
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-white">{{ $user->name }}</h2>
                        <p class="text-blue-100">{{ '@' . $user->username }}</p>
                        <p class="text-blue-100 text-sm mt-1">{{ $user->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form action="{{ route('dashboard.profil.update') }}" method="POST" enctype="multipart/form-data"
                class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Foto Profil -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Foto Profil
                    </label>

                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            @if ($user->foto)
                                <img id="preview" src="{{ asset('storage/' . $user->foto) }}" alt="Preview"
                                    class="w-20 h-20 rounded-full object-cover border-2 border-gray-300">
                            @else
                                <img id="preview"
                                    src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=80&background=3b82f6&color=fff"
                                    alt="Preview" class="w-20 h-20 rounded-full border-2 border-gray-300">
                            @endif
                        </div>

                        <div class="flex-1">
                            <input type="file" id="foto" name="foto" accept="image/*"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                onchange="previewImage(event)">
                            <p class="mt-1 text-xs text-gray-500">JPG, JPEG, PNG (Max: 2MB)</p>
                            @error('foto')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        @if ($user->foto)
                            <form action="{{ route('dashboard.profil.delete-foto') }}" method="POST"
                                onsubmit="return confirm('Hapus foto profil?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition text-sm">
                                    Hapus Foto
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Username -->
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                        Username <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}"
                        required
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('username') border-red-500 @enderror">
                    @error('username')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No. HP -->
                <div>
                    <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2">
                        No. HP/WhatsApp <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" id="no_hp" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" required
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('no_hp') border-red-500 @enderror">
                    @error('no_hp')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-between pt-4 border-t">
                    <a href="{{ route('dashboard.profil.ubah-password') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                        Ubah Password
                    </a>

                    <button type="submit"
                        class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-lg">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- Account Info -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Akun</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Terdaftar sejak:</span>
                    <span class="font-medium">{{ $user->created_at->format('d M Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Login terakhir:</span>
                    <span
                        class="font-medium">{{ $user->last_login ? $user->last_login->format('d M Y H:i') : 'Belum pernah login' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Status akun:</span>
                    <span
                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
@endpush
