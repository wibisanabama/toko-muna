<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <meta name="csrf-token" content="{{ csrf_token() }}">
 <title>@yield('title', 'Masuk') - Toko Muna</title>
 @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
 <div class="relative p-6 bg-white z-1 sm:p-0">
 <div class="relative flex flex-col justify-center w-full min-h-screen sm:p-0 lg:flex-row">
 <!-- Form Side -->
 <div class="flex flex-col flex-1 w-full lg:w-1/2">
 <div class="flex flex-col justify-center flex-1 w-full max-w-md mx-auto px-6">
 @yield('content')
 </div>
 </div>

 <!-- Branding Side -->
 <div class="relative hidden w-full bg-brand-950 lg:flex lg:w-1/2 items-center justify-center overflow-hidden">
 <!-- Background Decorative Elements -->
 <div class="absolute -top-24 -right-24 h-96 w-96 rounded-full bg-brand-500/10 blur-3xl"></div>
 <div class="absolute -bottom-24 -left-24 h-96 w-96 rounded-full bg-brand-500/10 blur-3xl"></div>

 <div class="relative flex flex-col items-center max-w-sm px-12 text-center z-1">
 <div class="mb-8 flex flex-col items-center">
 <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-brand-500 shadow-theme-xl mb-6">
 <svg class="fill-white" width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
 <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z" />
 </svg>
 </div>
 <h1 class="text-4xl font-bold text-white mb-6">Toko Muna</h1>
 </div>

 <p class="text-lg text-gray-300 leading-relaxed">
 Sistem Point of Sale modern untuk manajemen toko yang efisien, cepat, dan terintegrasi dalam satu platform.
 </p>

 <div class="mt-12 grid grid-cols-2 gap-4 w-full">
 <div class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur-sm">
 <p class="text-2xl font-bold text-white">Cepat</p>
 <p class="text-xs text-gray-500 uppercase tracking-wider">Performa</p>
 </div>
 <div class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur-sm">
 <p class="text-2xl font-bold text-white">Aman</p>
 <p class="text-xs text-gray-500 uppercase tracking-wider">Transaksi</p>
 </div>
 </div>
 </div>
 </div>
 </div>
 </div>
</body>
</html>
