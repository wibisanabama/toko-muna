@extends('layouts.app')
@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')
@section('content')
<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Daftar User</h3>
        <a href="{{ route('users.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">
            <svg class="fill-current" width="16" height="16" viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>Tambah User</a>
    </div>
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="w-full"><thead><tr class="border-b border-gray-100 dark:border-gray-800">
                <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Nama</th>
                <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Email</th>
                <th class="px-4 py-3 text-left text-theme-xs font-medium uppercase text-gray-500">Role</th>
                <th class="px-4 py-3 text-center text-theme-xs font-medium uppercase text-gray-500">Aksi</th>
            </tr></thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @foreach($users as $user)
                <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02]">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=465fff&color=fff&size=40" class="h-9 w-9 rounded-full">
                            <span class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-500">{{ $user->email }}</td>
                    <td class="px-4 py-3">
                        @if($user->role === 'admin')
                        <span class="rounded-full bg-brand-50 px-2.5 py-1 text-theme-xs font-medium text-brand-500 dark:bg-brand-500/10">Admin</span>
                        @else
                        <span class="rounded-full bg-success-50 px-2.5 py-1 text-theme-xs font-medium text-success-500 dark:bg-success-500/10">Kasir</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('users.edit', $user) }}" class="rounded-lg border border-gray-200 p-2 text-gray-500 hover:bg-gray-100 hover:text-brand-500 dark:border-gray-700 dark:hover:bg-white/5"><svg class="fill-current" width="16" height="16" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 000-1.41l-2.34-2.34a1 1 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg></a>
                            @if(auth()->id() !== $user->id)
                            <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Yakin hapus user ini?')">@csrf @method('DELETE')
                                <button type="submit" class="rounded-lg border border-gray-200 p-2 text-gray-500 hover:bg-error-50 hover:text-error-500 dark:border-gray-700 dark:hover:bg-error-500/10"><svg class="fill-current" width="16" height="16" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg></button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody></table>
        </div>
        <div class="mt-4">{{ $users->links() }}</div>
    </div>
</div>
@endsection
