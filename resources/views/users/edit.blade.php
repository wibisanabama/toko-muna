@extends('layouts.app')

@section('title', 'Edit User - ' . config('app.name'))

@section('content')
<div class="min-h-full">
    <!-- Navbar (Same as index, consider extracting to a component later) -->
    <nav class="bg-white shadow-sm">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 justify-between">
                <div class="flex">
                    <div class="flex shrink-0 items-center">
                        <span class="text-xl font-bold text-blue-600">Toko Muna</span>
                    </div>
                    <div class="hidden sm:-my-px sm:ml-6 sm:flex sm:space-x-8">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">Dashboard</a>
                        <a href="{{ route('users.index') }}" class="inline-flex items-center border-b-2 border-blue-500 px-1 pt-1 text-sm font-medium text-gray-900">Users</a>
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
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Edit User: {{ $user->name }}</h1>
            </div>
        </header>
        <main>
            <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-6 max-w-2xl">
                            @csrf
                            @method('PUT')
                            
                            <div>
                                <label for="name" class="block text-sm/6 font-medium text-gray-900">Nama Lengkap</label>
                                <div class="mt-2">
                                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-blue-600 sm:text-sm/6">
                                </div>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm/6 font-medium text-gray-900">Email</label>
                                <div class="mt-2">
                                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-blue-600 sm:text-sm/6">
                                </div>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="block text-sm/6 font-medium text-gray-900">Password <span class="text-gray-400 font-normal">(Kosongkan jika tidak ingin mengubah)</span></label>
                                <div class="mt-2">
                                    <input type="password" name="password" id="password" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-blue-600 sm:text-sm/6">
                                </div>
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="role" class="block text-sm/6 font-medium text-gray-900">Role</label>
                                <div class="mt-2">
                                    <select id="role" name="role" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-blue-600 sm:text-sm/6">
                                        <option value="kasir" {{ old('role', $user->role) === 'kasir' ? 'selected' : '' }}>Kasir</option>
                                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </div>
                                @error('role')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex justify-end gap-3">
                                <a href="{{ route('users.index') }}" class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Batal</a>
                                <button type="submit" class="rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
