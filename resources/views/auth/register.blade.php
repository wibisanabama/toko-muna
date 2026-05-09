@extends('layouts.auth')
@section('title', 'Daftar')
@section('content')
<div>
    <div class="mb-5 sm:mb-8">
        <h1 class="mb-2 font-semibold text-gray-800 text-title-sm dark:text-white/90 sm:text-title-md">Daftar Akun</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Buat akun baru untuk menggunakan sistem</p>
    </div>
    <form action="{{ route('register.post') }}" method="POST">
        @csrf
        <div class="space-y-5">
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nama Lengkap <span class="text-error-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required autofocus class="dark:bg-gray-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                @error('name')<p class="mt-1 text-sm text-error-500">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Email <span class="text-error-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required class="dark:bg-gray-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                @error('email')<p class="mt-1 text-sm text-error-500">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Password <span class="text-error-500">*</span></label>
                <input type="password" name="password" placeholder="Min. 8 karakter" required class="dark:bg-gray-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                @error('password')<p class="mt-1 text-sm text-error-500">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Konfirmasi Password <span class="text-error-500">*</span></label>
                <input type="password" name="password_confirmation" placeholder="Ulangi password" required class="dark:bg-gray-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
            </div>
            <button type="submit" class="flex w-full items-center justify-center rounded-lg bg-brand-500 px-4 py-3 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600 transition">Daftar</button>
        </div>
    </form>
    <p class="mt-5 text-sm text-center text-gray-700 dark:text-gray-400">Sudah punya akun? <a href="{{ route('login') }}" class="text-brand-500 hover:text-brand-600 dark:text-brand-400">Masuk</a></p>
</div>
@endsection
