<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title', 'PPDB') - SMK ISLAM YPI 2 WAY JEPARA</title>


    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@latest/dist/cdn.min.js"></script>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])


    @stack('styles')
</head>

<body class="bg-gray-50" x-data="{ mobileMenuOpen: false }">

    <!-- Header/Navbar with Scroll Effect -->
    <header x-data="{ scrolled: false }" x-init="window.addEventListener('scroll', () => { scrolled = window.pageYOffset > 50 })"
        :class="scrolled ? 'bg-blue-600 shadow-lg' : 'bg-white shadow-sm'"
        class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">

                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/favicon.png') }}" alt="Logo" class="h-10 w-10">
                    <div class="hidden sm:block">
                        <h1 :class="scrolled ? 'text-white' : 'text-gray-900'"
                            class="font-bold text-lg transition-colors duration-300">
                            PPDB SMK ISLAM YPI 2
                        </h1>
                        <p :class="scrolled ? 'text-blue-100' : 'text-gray-600'"
                            class="text-xs transition-colors duration-300">
                            Way Jepara
                        </p>
                    </div>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex md:items-center md:space-x-8">
                    <a href="{{ route('home') }}"
                        :class="scrolled ? 'text-white hover:text-blue-100' : 'text-gray-700 hover:text-blue-600'"
                        class="px-3 py-2 text-sm font-medium transition-colors duration-300 {{ request()->routeIs('home') ? (request()->routeIs('home') ? 'border-b-2' : '') : '' }}"
                        :style="scrolled && {{ request()->routeIs('home') ? 'true' : 'false' }} ? 'border-color: white' : ''">
                        Beranda
                    </a>
                    <a href="{{ route('tentang') }}"
                        :class="scrolled ? 'text-white hover:text-blue-100' : 'text-gray-700 hover:text-blue-600'"
                        class="px-3 py-2 text-sm font-medium transition-colors duration-300 {{ request()->routeIs('tentang') ? 'border-b-2' : '' }}"
                        :style="scrolled && {{ request()->routeIs('tentang') ? 'true' : 'false' }} ? 'border-color: white' : ''">
                        Tentang
                    </a>
                    <a href="{{ route('jurusan') }}"
                        :class="scrolled ? 'text-white hover:text-blue-100' : 'text-gray-700 hover:text-blue-600'"
                        class="px-3 py-2 text-sm font-medium transition-colors duration-300 {{ request()->routeIs('jurusan') ? 'border-b-2' : '' }}"
                        :style="scrolled && {{ request()->routeIs('jurusan') ? 'true' : 'false' }} ? 'border-color: white' : ''">
                        Jurusan
                    </a>
                    <a href="{{ route('alur-pendaftaran') }}"
                        :class="scrolled ? 'text-white hover:text-blue-100' : 'text-gray-700 hover:text-blue-600'"
                        class="px-3 py-2 text-sm font-medium transition-colors duration-300 {{ request()->routeIs('alur-pendaftaran') ? 'border-b-2' : '' }}"
                        :style="scrolled && {{ request()->routeIs('alur-pendaftaran') ? 'true' : 'false' }} ?
                            'border-color: white' : ''">
                        Alur Pendaftaran
                    </a>
                    <a href="{{ route('kontak') }}"
                        :class="scrolled ? 'text-white hover:text-blue-100' : 'text-gray-700 hover:text-blue-600'"
                        class="px-3 py-2 text-sm font-medium transition-colors duration-300 {{ request()->routeIs('kontak') ? 'border-b-2' : '' }}"
                        :style="scrolled && {{ request()->routeIs('kontak') ? 'true' : 'false' }} ? 'border-color: white' : ''">
                        Kontak
                    </a>

                    @auth
                        <a href="{{ route('dashboard.index') }}"
                            :class="scrolled ? 'bg-white text-blue-600 hover:bg-blue-50' :
                                'bg-blue-600 text-white hover:bg-blue-700'"
                            class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 transform hover:scale-105">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            :class="scrolled ? 'text-white hover:text-blue-100' : 'text-gray-700 hover:text-blue-600'"
                            class="px-3 py-2 text-sm font-medium transition-colors duration-300">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                            :class="scrolled ? 'bg-white text-blue-600 hover:bg-blue-50' :
                                'bg-blue-600 text-white hover:bg-blue-700'"
                            class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 transform hover:scale-105">
                            Daftar
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        :class="scrolled ? 'text-white' : 'text-gray-700'"
                        class="p-2 rounded-lg hover:bg-blue-50 transition-colors duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95" @click.away="mobileMenuOpen = false"
                class="md:hidden">
                <div :class="scrolled ? 'bg-blue-700' : 'bg-white'"
                    class="px-2 pt-2 pb-3 space-y-1 rounded-b-lg shadow-lg transition-colors duration-300">
                    <a href="{{ route('home') }}"
                        :class="scrolled ? 'text-white hover:bg-blue-600' : 'text-gray-700 hover:bg-gray-100'"
                        class="block px-3 py-2 rounded-lg text-base font-medium transition-colors duration-200 {{ request()->routeIs('home') ? (request()->routeIs('home') ? 'bg-blue-50' : '') : '' }}">
                        Beranda
                    </a>
                    <a href="{{ route('tentang') }}"
                        :class="scrolled ? 'text-white hover:bg-blue-600' : 'text-gray-700 hover:bg-gray-100'"
                        class="block px-3 py-2 rounded-lg text-base font-medium transition-colors duration-200 {{ request()->routeIs('tentang') ? 'bg-blue-50' : '' }}">
                        Tentang
                    </a>
                    <a href="{{ route('jurusan') }}"
                        :class="scrolled ? 'text-white hover:bg-blue-600' : 'text-gray-700 hover:bg-gray-100'"
                        class="block px-3 py-2 rounded-lg text-base font-medium transition-colors duration-200 {{ request()->routeIs('jurusan') ? 'bg-blue-50' : '' }}">
                        Jurusan
                    </a>
                    <a href="{{ route('alur-pendaftaran') }}"
                        :class="scrolled ? 'text-white hover:bg-blue-600' : 'text-gray-700 hover:bg-gray-100'"
                        class="block px-3 py-2 rounded-lg text-base font-medium transition-colors duration-200 {{ request()->routeIs('alur-pendaftaran') ? 'bg-blue-50' : '' }}">
                        Alur Pendaftaran
                    </a>
                    <a href="{{ route('kontak') }}"
                        :class="scrolled ? 'text-white hover:bg-blue-600' : 'text-gray-700 hover:bg-gray-100'"
                        class="block px-3 py-2 rounded-lg text-base font-medium transition-colors duration-200 {{ request()->routeIs('kontak') ? 'bg-blue-50' : '' }}">
                        Kontak
                    </a>

                    <div class="border-t border-gray-200 pt-3 mt-3">
                        @auth
                            <a href="{{ route('dashboard.index') }}"
                                class="block px-3 py-2 rounded-lg text-base font-medium bg-blue-600 text-white hover:bg-blue-700 transition-colors duration-200">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                :class="scrolled ? 'text-white hover:bg-blue-600' : 'text-gray-700 hover:bg-gray-100'"
                                class="block px-3 py-2 rounded-lg text-base font-medium transition-colors duration-200">
                                Login
                            </a>
                            <a href="{{ route('register') }}"
                                class="block px-3 py-2 rounded-lg text-base font-medium bg-blue-600 text-white hover:bg-blue-700 transition-colors duration-200 mt-2">
                                Daftar
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content (with padding to account for fixed header) -->
    <main class="pt-16">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <!-- About -->
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <img src="{{ asset('images/favicon.png') }}" alt="Logo" class="h-10 w-10">
                        <div>
                            <h3 class="font-bold text-lg">PPDB SMK ISLAM YPI 2</h3>
                            <p class="text-sm text-gray-400">Way Jepara</p>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm">
                        Sekolah Menengah Kejuruan yang menghasilkan lulusan berkualitas dan siap kerja.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="font-bold text-lg mb-4">Menu Cepat</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition">Beranda</a>
                        </li>
                        <li><a href="{{ route('tentang') }}"
                                class="text-gray-400 hover:text-white transition">Tentang</a></li>
                        <li><a href="{{ route('jurusan') }}"
                                class="text-gray-400 hover:text-white transition">Jurusan</a></li>
                        <li><a href="{{ route('alur-pendaftaran') }}"
                                class="text-gray-400 hover:text-white transition">Alur Pendaftaran</a></li>
                        <li><a href="{{ route('kontak') }}"
                                class="text-gray-400 hover:text-white transition">Kontak</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="font-bold text-lg mb-4">Kontak</h4>
                    <ul class="space-y-3 text-gray-400 text-sm">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>Jl. Raya Way Jepara, Lampung</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span>info@smkypi2.sch.id</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                            <span>(0721) 123-4567</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400 text-sm">
                <p>&copy; {{ date('Y') }} SMK ISLAM YPI 2 Way Jepara. All rights reserved.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>
