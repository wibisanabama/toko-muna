@extends('layouts.app')
@section('title', 'Tambah Pengguna')
@section('page-title', 'Tambah Pengguna')
@section('content')
<div>
 <div class="rounded-2xl border border-gray-200 bg-white ">
 <div class="border-b border-gray-200 px-6 py-4 "><h3 class="text-lg font-semibold text-gray-800 ">Tambah Pengguna Baru</h3></div>
 <div class="p-6">
 <form action="{{ route('users.store') }}" method="POST">
 @csrf
 <div class="space-y-5">
 <div>
 <label class="mb-1.5 block text-sm font-medium text-gray-700 ">Nama Lengkap <span class="text-error-500">*</span></label>
 <input type="text" name="name" value="{{ old('name') }}" required class=" h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 ">
 @error('name')<p class="mt-1 text-sm text-error-500">{{ $message }}</p>@enderror
 </div>
 <div>
 <label class="mb-1.5 block text-sm font-medium text-gray-700 ">Email <span class="text-error-500">*</span></label>
 <input type="email" name="email" value="{{ old('email') }}" required class=" h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 ">
 @error('email')<p class="mt-1 text-sm text-error-500">{{ $message }}</p>@enderror
 </div>
 <div>
 <label class="mb-1.5 block text-sm font-medium text-gray-700 ">Password <span class="text-error-500">*</span></label>
 <input type="password" name="password" required class=" h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 ">
 @error('password')<p class="mt-1 text-sm text-error-500">{{ $message }}</p>@enderror
 </div>
 <div>
 <label class="mb-1.5 block text-sm font-medium text-gray-700 ">Role <span class="text-error-500">*</span></label>
                    <div class="relative" x-data="{ open: false, selected: '{{ old('role') === 'admin' ? 'Admin' : 'Kasir' }}' }">
                        <button type="button" @click="open = !open" class="custom-select-trigger">
                            <span x-text="selected"></span>
                            <svg class="fill-gray-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" width="18" height="18" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>
                        </button>
                        <div x-show="open" @click.outside="open = false" x-transition class="custom-select-dropdown">
                            <div @click="selected = 'Kasir'; open = false; $refs.roleInput.value = 'kasir';" class="custom-select-option" :class="$refs.roleInput.value === 'kasir' ? 'custom-select-option-active' : 'custom-select-option-inactive'">Kasir</div>
                            <div @click="selected = 'Admin'; open = false; $refs.roleInput.value = 'admin';" class="custom-select-option" :class="$refs.roleInput.value === 'admin' ? 'custom-select-option-active' : 'custom-select-option-inactive'">Admin</div>
                        </div>
                        <input type="hidden" name="role" x-ref="roleInput" value="{{ old('role', 'kasir') }}">
                    </div>
 </div>
 </div>
 <div class="mt-6 flex items-center gap-3">
 <button type="submit" class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">Simpan</button>
 <a href="{{ route('users.index') }}" class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 ">Batal</a>
 </div>
 </form>
 </div>
 </div>
</div>
@endsection
