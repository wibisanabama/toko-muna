@extends('layouts.auth')
@section('title', 'Daftar')
@section('content')
<div>
 <div class="mb-5 sm:mb-8">
 <h1 class="mb-2 font-semibold text-gray-800 text-title-sm sm:text-title-md">Daftar Akun</h1>
 <p class="text-sm text-gray-500 ">Buat akun baru untuk menggunakan sistem</p>
 </div>
 <form action="{{ route('register.post') }}" method="POST">
 @csrf
 <div class="space-y-5">
 <div>
 <label class="mb-1.5 block text-sm font-medium text-gray-700 ">Nama Lengkap <span class="text-error-500">*</span></label>
 <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required autofocus class=" h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 ">
 @error('name')<p class="mt-1 text-sm text-error-500">{{ $message }}</p>@enderror
 </div>
 <div>
 <label class="mb-1.5 block text-sm font-medium text-gray-700 ">Email <span class="text-error-500">*</span></label>
 <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required class=" h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 ">
 @error('email')<p class="mt-1 text-sm text-error-500">{{ $message }}</p>@enderror
 <label class="mb-1.5 block text-sm font-medium text-gray-700 mt-5">Kata Sandi <span class="text-error-500">*</span></label>
 <input type="password" name="password" placeholder="Min. 8 karakter" required class=" h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 ">
 @error('password')<p class="mt-1 text-sm text-error-500">{{ $message }}</p>@enderror
 <label class="mb-1.5 block text-sm font-medium text-gray-700 mt-5">Konfirmasi Kata Sandi <span class="text-error-500">*</span></label>
 <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi" required class=" h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 ">
 </div>
 <button type="submit" class="flex w-full items-center justify-center rounded-lg bg-brand-500 px-4 py-3 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600 transition">Daftar</button>
 </div>
 </form>
 <p class="mt-5 text-sm text-center text-gray-700 ">Sudah punya akun? <a href="{{ route('login') }}" class="text-brand-500 hover:text-brand-600 ">Masuk</a></p>
</div>
@endsection
