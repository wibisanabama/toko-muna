<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dasbor') - Toko Muna</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body x-data="{ sidebarToggle: false }" class="bg-gray-50">
    @auth
    <div class="flex h-screen overflow-hidden">

        <aside :class="sidebarToggle ? 'translate-x-0' : '-translate-x-full'" class="sidebar fixed left-0 top-0 z-9999 flex h-screen w-[290px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 duration-300 ease-linear lg:static lg:translate-x-0" @click.outside="sidebarToggle = false">
            <div class="flex items-center justify-between gap-2 pb-7 pt-8">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-brand-500">
                        <svg class="fill-white" width="20" height="20" viewBox="0 0 24 24"><path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    </div>
                    <span class="text-xl font-bold text-gray-800">Toko Muna</span>
                </a>
            </div>
            <div class="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear">
                <nav>
                    <div>
                        <h3 class="mb-4 text-xs uppercase leading-5 text-gray-400">Menu</h3>
                        <ul class="mb-6 flex flex-col gap-2">
                            <li><a href="{{ route('dashboard') }}" class="menu-item group {{ request()->routeIs('dashboard') ? 'menu-item-active' : 'menu-item-inactive' }}">
                                <svg class="{{ request()->routeIs('dashboard') ? 'fill-brand-500' : 'fill-gray-500' }}" width="20" height="20" viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                                <span>Dasbor</span></a></li>
                            <li><a href="{{ route('pos.index') }}" class="menu-item group {{ request()->routeIs('pos.*') ? 'menu-item-active' : 'menu-item-inactive' }}">
                                <svg class="{{ request()->routeIs('pos.*') ? 'fill-brand-500' : 'fill-gray-500' }}" width="20" height="20" viewBox="0 0 24 24"><path d="M17 2H7a2 2 0 00-2 2v16a2 2 0 002 2h10a2 2 0 002-2V4a2 2 0 00-2-2zm-3 18h-4v-1h4v1zm3-3H7V5h10v12z"/></svg>
                                <span>Kasir</span></a></li>
                        </ul>
                        <h3 class="mb-4 text-xs uppercase leading-5 text-gray-400">Manajemen</h3>
                        <ul class="mb-6 flex flex-col gap-2">
                            <li><a href="{{ route('categories.index') }}" class="menu-item group {{ request()->routeIs('categories.*') ? 'menu-item-active' : 'menu-item-inactive' }}">
                                <svg class="{{ request()->routeIs('categories.*') ? 'fill-brand-500' : 'fill-gray-500' }}" width="20" height="20" viewBox="0 0 24 24"><path d="M10 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2h-8l-2-2z"/></svg>
                                <span>Kategori</span></a></li>
                            <li><a href="{{ route('products.index') }}" class="menu-item group {{ request()->routeIs('products.*') ? 'menu-item-active' : 'menu-item-inactive' }}">
                                <svg class="{{ request()->routeIs('products.*') ? 'fill-brand-500' : 'fill-gray-500' }}" width="20" height="20" viewBox="0 0 24 24"><path d="M20 2H4c-1 0-2 1-2 2v3.01c0 .72.43 1.34 1 1.69V20c0 1.1 1.1 2 2 2h14c.9 0 2-.9 2-2V8.7c.57-.35 1-.97 1-1.69V4c0-1-1-2-2-2zm-5 12H9v-2h6v2zm5-7H4V4h16v3z"/></svg>
                                <span>Produk</span></a></li>
                            <li><a href="{{ route('stock-movements.index') }}" class="menu-item group {{ request()->routeIs('stock-movements.*') ? 'menu-item-active' : 'menu-item-inactive' }}">
                                <svg class="{{ request()->routeIs('stock-movements.*') ? 'fill-brand-500' : 'fill-gray-500' }}" width="20" height="20" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                <span>Stok</span></a></li>
                            <li><a href="{{ route('transactions.index') }}" class="menu-item group {{ request()->routeIs('transactions.*') ? 'menu-item-active' : 'menu-item-inactive' }}">
                                <svg class="{{ request()->routeIs('transactions.*') ? 'fill-brand-500' : 'fill-gray-500' }}" width="20" height="20" viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg>
                                <span>Transaksi</span></a></li>
                        </ul>
                        <h3 class="mb-4 text-xs uppercase leading-5 text-gray-400">Laporan</h3>
                        <ul class="mb-6 flex flex-col gap-2">
                            <li><a href="{{ route('reports.daily') }}" class="menu-item group {{ request()->routeIs('reports.daily') ? 'menu-item-active' : 'menu-item-inactive' }}">
                                <svg class="{{ request()->routeIs('reports.daily') ? 'fill-brand-500' : 'fill-gray-500' }}" width="20" height="20" viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/></svg>
                                <span>Laporan Harian</span></a></li>
                            <li><a href="{{ route('reports.monthly') }}" class="menu-item group {{ request()->routeIs('reports.monthly') ? 'menu-item-active' : 'menu-item-inactive' }}">
                                <svg class="{{ request()->routeIs('reports.monthly') ? 'fill-brand-500' : 'fill-gray-500' }}" width="20" height="20" viewBox="0 0 24 24"><path d="M5 9.2h3V19H5V9.2zM10.6 5h2.8v14h-2.8V5zm5.6 8H19v6h-2.8v-6z"/></svg>
                                <span>Laporan Bulanan</span></a></li>
                        </ul>
                        @if(auth()->user()->isAdmin())
                        <h3 class="mb-4 text-xs uppercase leading-5 text-gray-400">Admin</h3>
                        <ul class="mb-6 flex flex-col gap-2">
                            <li><a href="{{ route('users.index') }}" class="menu-item group {{ request()->routeIs('users.*') ? 'menu-item-active' : 'menu-item-inactive' }}">
                                <svg class="{{ request()->routeIs('users.*') ? 'fill-brand-500' : 'fill-gray-500' }}" width="20" height="20" viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                                <span>Manajemen Pengguna</span></a></li>
                        </ul>
                        @endif
                    </div>
                </nav>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0 overflow-hidden relative">

            <header class="flex-none border-b border-gray-200 bg-white relative">
                <div class="flex grow items-center justify-between px-4 py-2 lg:px-6">
                    <div class="flex items-center gap-4">
                        <button class="flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 text-gray-500 lg:hidden" @click.stop="sidebarToggle = !sidebarToggle">
                            <svg class="fill-current" width="20" height="20" viewBox="0 0 24 24"><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/></svg>
                        </button>
                        <h1 class="text-lg font-semibold text-gray-800">@yield('page-title', 'Dasbor')</h1>
                    </div>

                    <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 pointer-events-none flex justify-center z-50">
                        @if(session('success'))
                            <div x-data="{ show: true }"
                                 x-show="show"
                                 x-init="setTimeout(() => show = false, 3000)"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="pointer-events-auto rounded-lg border border-success-200 bg-success-50 px-4 py-2 shadow-sm backdrop-blur-xs w-fit whitespace-nowrap">
                                <span class="text-sm font-medium text-success-800">{{ session('success') }}</span>
                            </div>
                        @endif

                        @if(session('error'))
                            <div x-data="{ show: true }"
                                 x-show="show"
                                 x-init="setTimeout(() => show = false, 5000)"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="pointer-events-auto rounded-lg border border-error-200 bg-error-50 px-4 py-2 shadow-sm backdrop-blur-xs w-fit whitespace-nowrap">
                                <span class="text-sm font-medium text-error-800">{{ session('error') }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center gap-3">

                        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                            <button @click="open = !open" class="flex items-center gap-2 text-gray-700">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=465fff&color=fff&size=40" alt="User" class="h-10 w-10 rounded-full">
                                <span class="hidden text-theme-sm font-medium lg:block">{{ auth()->user()->name }}</span>
                                <svg :class="open && 'rotate-180'" class="h-4 w-4 transition-transform" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/></svg>
                            </button>
                            <div x-show="open" x-transition class="shadow-theme-lg absolute right-0 mt-3 w-56 rounded-xl border border-gray-200 bg-white p-2">
                                <div class="px-3 py-2 border-b border-gray-100 mb-1">
                                    <p class="text-sm font-medium text-gray-800">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ strtoupper(auth()->user()->role) }}</p>
                                </div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-sm text-error-500 hover:bg-error-50">
                                        <svg class="fill-current" width="18" height="18" viewBox="0 0 24 24"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto bg-gray-50">
                <div class="p-3 w-full">
                    @yield('content')
                </div>
            </main>

            <footer class="flex-none border-t border-gray-200 bg-white px-4 py-2 lg:px-6">
                <div class="flex flex-col items-center justify-between gap-4 md:flex-row">
                    <p class="text-sm text-gray-500">
                        {{ now()->translatedFormat('l, d F Y') }}
                    </p>
                    <p class="text-sm text-gray-500">
                        &copy; {{ date('Y') }} Toko Muna. Seluruh hak cipta dilindungi.
                    </p>
                </div>
            </footer>
        </div>
    </div>
    @else
        @yield('content')
    @endauth
    @stack('scripts')
</body>
</html>
