<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard - PPDB SMK')</title>


    <!-- ATAU gunakan logo sekolah sebagai favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <!-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@latest/dist/cdn.min.js"></script>-->




    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    @stack('styles')
</head>

<body class="font-sans antialiased bg-gray-50" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen">
        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out lg:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" @click.away="sidebarOpen = false">

            <!-- Logo -->
            <div class="flex items-center justify-between h-16 px-6 bg-gradient-to-r from-blue-600 to-blue-700">
                <div class="flex items-center">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l9-5-9-5-9 5 9 5z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z">
                        </path>
                    </svg>
                    <span class="ml-2 text-lg font-bold text-white">PPDB SMK</span>
                </div>
                <button @click="sidebarOpen = false" class="lg:hidden text-white">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- User Info -->
            <div class="px-6 py-4 border-b">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        @if (auth()->user()->foto)
                            <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="{{ auth()->user()->name }}"
                                class="h-10 w-10 rounded-full object-cover">
                        @else
                            <div
                                class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="px-4 py-4 space-y-1">
                <a href="{{ route('dashboard.index') }}"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition {{ request()->routeIs('dashboard.index') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('dashboard.pendaftaran.index') }}"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition {{ request()->routeIs('dashboard.pendaftaran.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Pendaftaran
                    @if ($pendaftaran = auth()->user()->pendaftaran)
                        @if ($pendaftaran->status_pendaftaran === 'draft')
                            <span
                                class="ml-auto inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Draft
                            </span>
                        @elseif($pendaftaran->status_verifikasi === 'pending')
                            <span
                                class="ml-auto inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                Pending
                            </span>
                        @endif
                    @endif
                </a>

                @if ($pendaftaran = auth()->user()->pendaftaran)
                    <a href="{{ route('dashboard.pembayaran.index') }}"
                        class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition {{ request()->routeIs('dashboard.pembayaran.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                        <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        Pembayaran
                        @if ($pembayaran = $pendaftaran->pembayaran)
                            @if ($pembayaran->status === 'pending')
                                <span
                                    class="ml-auto inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Pending
                                </span>
                            @elseif($pembayaran->status === 'verified')
                                <span
                                    class="ml-auto inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Lunas
                                </span>
                            @endif
                        @endif
                    </a>
                @endif

                <div class="pt-4 mt-4 border-t">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Pengaturan</p>
                </div>

                <a href="{{ route('dashboard.profil.index') }}"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition {{ request()->routeIs('dashboard.profil') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Profil Saya
                </a>

                <a href="{{ route('dashboard.profil.ubah-password') }}"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition {{ request()->routeIs('dashboard.ubah-password') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                        </path>
                    </svg>
                    Ubah Password
                </a>

                <a href="{{ route('home') }}"
                    class="flex items-center px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg transition">
                    <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    Kembali ke Beranda
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center px-4 py-3 text-sm font-medium text-red-700 hover:bg-red-50 rounded-lg transition">
                        <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        Logout
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="lg:pl-64">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm sticky top-0 z-40">
                <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                    <button @click="sidebarOpen = true" class="lg:hidden text-gray-500 hover:text-gray-700">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <div class="flex-1 lg:flex-none">
                        <h1 class="text-xl font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                    </div>

                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="relative p-2 text-gray-400 hover:text-gray-500">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                    </path>
                                </svg>
                                <span
                                    class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-400 ring-2 ring-white"></span>
                            </button>

                            <!-- Dropdown -->
                            <div x-show="open" x-cloak @click.away="open = false"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 transform scale-95"
                                x-transition:enter-end="opacity-100 transform scale-100"
                                class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5">
                                <div class="p-4">
                                    <h3 class="text-sm font-semibold text-gray-900 mb-3">Notifikasi</h3>
                                    <div class="space-y-3">
                                        <p class="text-sm text-gray-500 text-center py-4">Tidak ada notifikasi baru</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-4 sm:p-6 lg:p-8">
                @if (session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex">
                            <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="ml-3 text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex">
                            <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="ml-3 text-sm text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @livewireScripts
    @stack('scripts')
</body>

</html>
