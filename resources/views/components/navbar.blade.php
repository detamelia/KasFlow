@props([
    'role' => 'bendahara',
    'title' => 'Dashboard',
])

<header class="sticky top-0 z-30 h-16 glass-nav px-4 sm:px-6 flex items-center justify-between transition-all">
    <!-- Left Section: Sidebar Toggle & Page Title -->
    <div class="flex items-center gap-3 sm:gap-4">
        <button
            type="button"
            onclick="toggleSidebar()"
            class="lg:hidden p-2 rounded-xl text-slate-500 hover:text-slate-900 hover:bg-slate-100/80 transition-colors focus:outline-none cursor-pointer"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>

        <div>
            <h1 class="text-lg font-bold text-slate-900 tracking-tight flex items-center gap-2">
                {{ $title }}
            </h1>
        </div>
    </div>

    <!-- Right Section: Role Switcher, Notifications, Search, User Avatar -->
    <div class="flex items-center gap-2 sm:gap-4">
        <!-- Interactive Role Switcher Toggle (bendahara <-> anggota) -->
        <div class="relative group">
            <div class="flex items-center bg-slate-100 p-1 rounded-xl border border-slate-200/80">
                <a
                    href="{{ request()->fullUrlWithQuery(['role' => 'bendahara']) }}"
                    class="px-2.5 py-1 text-xs font-semibold rounded-lg transition-all {{ $role === 'bendahara' ? 'bg-white text-emerald-700 shadow-2xs' : 'text-slate-600 hover:text-slate-900' }}"
                    title="Beralih ke mode Bendahara"
                >
                    Bendahara
                </a>
                <a
                    href="{{ request()->fullUrlWithQuery(['role' => 'anggota']) }}"
                    class="px-2.5 py-1 text-xs font-semibold rounded-lg transition-all {{ $role === 'anggota' ? 'bg-white text-indigo-700 shadow-2xs' : 'text-slate-600 hover:text-slate-900' }}"
                    title="Beralih ke mode Ketua & Anggota"
                >
                    Ketua / Anggota
                </a>
            </div>
        </div>

        <!-- Global Search Input Mock -->
        <div class="hidden md:block relative w-48 lg:w-64">
            <input
                type="text"
                placeholder="Cari transaksi, laporan..."
                class="w-full bg-slate-100/80 border border-slate-200 rounded-xl pl-9 pr-3 py-1.5 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all"
            />
            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>

        <!-- Notification Bell Dropdown -->
        <div class="relative">
            <button
                type="button"
                onclick="toggleDropdown('notif-dropdown')"
                class="relative p-2 rounded-xl text-slate-500 hover:text-slate-900 hover:bg-slate-100/80 transition-colors cursor-pointer"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-rose-500 animate-ping"></span>
                <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-rose-500"></span>
            </button>

            <!-- Notifications Dropdown Menu -->
            <div
                id="notif-dropdown"
                class="hidden absolute right-0 mt-2 w-80 bg-white rounded-2xl border border-slate-200/80 card-shadow py-2 z-50 modal-animate"
            >
                <div class="px-4 py-2 border-b border-slate-100 flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-900 uppercase tracking-wider">Notifikasi KasFlow</span>
                    <span class="text-[10px] bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded-full font-semibold">2 Baru</span>
                </div>
                <div class="divide-y divide-slate-100 max-h-64 overflow-y-auto">
                    <a href="#" class="block px-4 py-3 hover:bg-slate-50 transition-colors">
                        <p class="text-xs font-semibold text-slate-800">Pemasukan Uang Kas Disetujui</p>
                        <p class="text-[11px] text-slate-500 mt-0.5">Rp 2.500.000 telah masuk ke saldo organisasi.</p>
                        <span class="text-[10px] text-slate-400 mt-1 block">10 menit yang lalu</span>
                    </a>
                    <a href="#" class="block px-4 py-3 hover:bg-slate-50 transition-colors">
                        <p class="text-xs font-semibold text-slate-800">Pengajuan Logistik Workshop</p>
                        <p class="text-[11px] text-slate-500 mt-0.5">Memerlukan verifikasi nota oleh Bendahara.</p>
                        <span class="text-[10px] text-slate-400 mt-1 block">1 jam yang lalu</span>
                    </a>
                </div>
                <div class="px-4 py-2 border-t border-slate-100 text-center">
                    <a href="#" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700">Lihat Semua Notifikasi &rarr;</a>
                </div>
            </div>
        </div>

        <!-- User Profile Pill -->
        <div class="flex items-center gap-2.5 pl-2 border-l border-slate-200/80">
            <div class="w-9 h-9 rounded-xl bg-slate-900 text-emerald-400 font-bold flex items-center justify-center text-xs shadow-2xs border border-slate-700">
                {{ $role === 'bendahara' ? 'SR' : 'MR' }}
            </div>
            <div class="hidden sm:block text-left">
                <span class="block text-xs font-semibold text-slate-900 leading-tight">
                    {{ $role === 'bendahara' ? 'Siti Rahma' : 'Muhammad Rizky' }}
                </span>
                <span class="block text-[11px] text-slate-500 leading-tight">
                    {{ $role === 'bendahara' ? 'Bendahara Utama' : 'Ketua Organisasi' }}
                </span>
            </div>
        </div>
    </div>
</header>
