@extends('layouts.app')

@section('title', 'Dashboard - ' . config('app.name'))

@section('content')
<div class="min-h-full">
    <nav class="bg-white shadow-sm">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 justify-between">
                <div class="flex">
                    <div class="flex shrink-0 items-center">
                        <span class="text-xl font-bold text-blue-600">Toko Muna</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <span class="text-sm text-gray-700 mr-4">Halo, {{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="py-10">
        <header>
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Dashboard</h1>
            </div>
        </header>
        <main>
            <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        Selamat datang di Toko Muna POS System!
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
