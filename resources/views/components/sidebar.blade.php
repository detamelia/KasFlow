@props([
    'role' => 'anggota',
])

@php
$currentRoute = request()->route() ? request()->route()->getName() : '';
@endphp

<!-- Mobile Backdrop -->
<div
    id="sidebar-backdrop"
    class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-xs hidden lg:hidden transition-opacity duration-300"
    onclick="toggleSidebar()"
></div>

<!-- Sidebar Container -->
<aside
    id="main-sidebar"
    class="fixed top-0 left-0 z-40 h-screen w-64 -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out glass-sidebar text-slate-300 flex flex-col justify-between border-r border-slate-800"
>
    <div>
        <!-- Brand Header -->
        <div class="h-16 px-6 flex items-center justify-between border-b border-slate-800/80">
            <a href="{{ route('dashboard.index') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl gradient-emerald flex items-center justify-center text-white shadow-md shadow-emerald-500/20 group-hover:scale-105 transition-transform duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <span class="text-lg font-extrabold tracking-tight text-white flex items-center gap-1">
                        Kas<span class="text-emerald-400">Flow</span>
                    </span>
                    <span class="text-[10px] block font-medium uppercase tracking-widest text-slate-400 -mt-1">Keuangan Organisasi</span>
                </div>
            </a>

            <button
                type="button"
                onclick="toggleSidebar()"
                class="lg:hidden text-slate-400 hover:text-white p-1 rounded-lg focus:outline-none cursor-pointer"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Role Pill Indicator -->
<div class="px-4 py-3 bg-slate-900/80 border-b border-slate-800/60">
    <div class="flex items-center justify-between bg-slate-800/90 px-3 py-2 rounded-xl border border-slate-700/60">
        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full {{ $role === 'bendahara' ? 'bg-emerald-400 animate-pulse' : 'bg-indigo-400' }}"></span>
            <span class="text-xs font-semibold text-slate-200">
                Akses {{ ucfirst($role) }}
            </span>
        </div>
        <span class="text-[10px] px-1.5 py-0.5 rounded font-mono uppercase bg-slate-700 text-slate-300">
            {{ $role === 'bendahara' ? 'Full' : 'Read-only' }}
        </span>
    </div>
</div>

        <!-- Navigation Menu -->
        <nav class="px-3 py-4 space-y-1.5 overflow-y-auto max-h-[calc(100vh-210px)]">
            <div class="px-3 pb-1 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">
                Menu Utama
            </div>

            <!-- Dashboard -->
            <a
                href="{{ route('dashboard.index') }}"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ in_array($currentRoute, ['dashboard', 'dashboard.index']) ? 'bg-emerald-600/90 text-white shadow-md shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}"
            >
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                <span>Dashboard</span>
            </a>

            <!-- Pemasukan -->
            <a
                href="{{ route('pemasukan.index') }}"
                class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ str_contains($currentRoute, 'pemasukan') ? 'bg-emerald-600/90 text-white shadow-md shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}"
            >
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                    <span>Pemasukan Kas</span>
                </div>
                <span class="text-xs px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 font-semibold">+</span>
            </a>

            <!-- Pengeluaran -->
            <a
                href="{{ route('pengeluaran.index') }}"
                class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ str_contains($currentRoute, 'pengeluaran') ? 'bg-emerald-600/90 text-white shadow-md shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}"
            >
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                    <span>Pengeluaran Kas</span>
                </div>
                <span class="text-xs px-2 py-0.5 rounded-full bg-rose-500/20 text-rose-300 font-semibold">-</span>
            </a>

            <!-- Transaksi -->
            <a
                href="{{ route('transaksi.index') }}"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ str_contains($currentRoute, 'transaksi') ? 'bg-emerald-600/90 text-white shadow-md shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}"
            >
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                <span>Riwayat Transaksi</span>
            </a>
@if ($role === 'bendahara')
            <!-- Kategori -->
            <a
                href="{{ route('kategori.index') }}"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ str_contains($currentRoute, 'kategori') ? 'bg-emerald-600/90 text-white shadow-md shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}"
            >
                <svg class="w-5 h-5 shrink-0 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                <span>Kategori</span>
            </a>
@endif
            <!-- Laporan Keuangan -->
            <a
                href="{{ route('laporan.index') }}"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ str_contains($currentRoute, 'laporan') ? 'bg-emerald-600/90 text-white shadow-md shadow-emerald-900/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}"
            >
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                <span>Rincian & Laporan</span>
            </a>
        </nav>
    </div>

        <!-- Sidebar Bottom Summary Widget -->
    <div class="p-4 border-t border-slate-800/80 bg-slate-900/90">
        <div class="rounded-xl bg-slate-800/70 p-3 border border-slate-700/50 text-xs">
            <div class="text-slate-400 font-medium mb-1">Total Saldo Kas Organisasi</div>
            <div class="text-lg font-bold text-emerald-400">Rp 18.450.000</div>
            <div class="text-[10px] text-slate-400 mt-1 flex items-center justify-between">
                <span>Update: Sep 2026</span>
                <span class="text-emerald-400">● Realtime</span>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-xl text-sm font-medium text-rose-300 bg-rose-500/10 hover:bg-rose-500/20 transition-colors cursor-pointer">
                Keluar
            </button>
        </form>
    </div>
</aside>
