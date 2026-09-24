<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'KasFlow' }} - Sistem Manajemen Keuangan Organisasi</title>

    <!-- Meta Description for SEO -->
    <meta name="description" content="KasFlow adalah sistem manajemen keuangan organisasi berbasis web untuk mencatat pemasukan, pengeluaran, mengelola saldo, dan menampilkan laporan keuangan.">

    <!-- Google Fonts: Instrument Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans text-slate-800 bg-slate-50 antialiased selection:bg-emerald-500 selection:text-white">

    <div class="min-h-screen flex flex-col lg:flex-row">
        <!-- Sidebar Component -->
        <x-sidebar :role="$role ?? 'bendahara'" />

        <!-- Main Workspace Area -->
        <div class="flex-1 lg:pl-64 flex flex-col min-h-screen transition-all duration-300">
            <!-- Navbar Component -->
            <x-navbar :role="$role ?? 'bendahara'" :title="$title ?? 'KasFlow'" />

            <!-- Toast Alert Container (Dynamic JavaScript Notifications) -->
            <div id="toast-container" class="fixed top-20 right-6 z-50 flex flex-col gap-2 max-w-sm"></div>

            <!-- Main Content Section -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                <!-- Role Banner Notification for UI testing preview -->
                <div class="mb-6 p-4 rounded-2xl bg-gradient-to-r {{ ($role ?? 'bendahara') === 'bendahara' ? 'from-emerald-900 to-slate-900' : 'from-indigo-900 to-slate-900' }} text-white shadow-md flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 rounded-xl bg-white/10 shrink-0">
                            @if (($role ?? 'bendahara') === 'bendahara')
                                <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                            @else
                                <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            @endif
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-emerald-300 uppercase tracking-widest block">
                                {{ ($role ?? 'bendahara') === 'bendahara' ? 'Peran Terpilih: Bendahara' : 'Peran Terpilih: Ketua / Anggota' }}
                            </span>
                            <h2 class="text-sm font-medium text-slate-200">
                                {{ ($role ?? 'bendahara') === 'bendahara' 
                                    ? 'Anda memiliki hak akses penuh untuk menambah, mengedit, dan mengelola transaksi kas.' 
                                    : 'Mode pemantauan terbuka untuk melihat kondisi saldo, transaksi, dan rincian keuangan organisasi.' }}
                            </h2>
                        </div>
                    </div>

                    <div class="shrink-0 flex items-center gap-2">
                        <span class="text-xs text-slate-300 hidden md:inline">Ubah Peran Demo:</span>
                        <a
                            href="{{ request()->fullUrlWithQuery(['role' => ($role ?? 'bendahara') === 'bendahara' ? 'anggota' : 'bendahara']) }}"
                            class="px-3 py-1.5 rounded-xl bg-white/15 hover:bg-white/25 text-xs font-semibold text-white transition-colors border border-white/20"
                        >
                            {{ ($role ?? 'bendahara') === 'bendahara' ? 'Beralih ke Mode Anggota' : 'Beralih ke Mode Bendahara' }}
                        </a>
                    </div>
                </div>

                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="mt-auto py-6 px-6 border-t border-slate-200/80 bg-white text-center sm:text-left flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <div>
                    &copy; 2026 <span class="font-bold text-slate-800">KasFlow</span>. Sistem Manajemen Keuangan Organisasi.
                </div>
                <div class="flex items-center gap-4 text-slate-400">
                    <span class="hover:text-slate-600 transition-colors cursor-pointer">Panduan Penggunaan</span>
                    <span>&bull;</span>
                    <span class="hover:text-slate-600 transition-colors cursor-pointer">Bantuan Bendahara</span>
                    <span>&bull;</span>
                    <span class="text-emerald-600 font-semibold">v1.0 (Blade UI)</span>
                </div>
            </footer>
        </div>
    </div>

    <!-- UI Component JavaScript Handlers -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('main-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }

        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }

        function toggleDropdown(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            if (dropdown) {
                dropdown.classList.toggle('hidden');
            }
        }

        // Global click listener to close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            const notifDropdown = document.getElementById('notif-dropdown');
            if (notifDropdown && !notifDropdown.contains(e.target) && !e.target.closest('button[onclick*="notif-dropdown"]')) {
                notifDropdown.classList.add('hidden');
            }
        });

        // Toast notification helper for UI demo simulation
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            
            const bgClass = type === 'success' ? 'bg-emerald-600 text-white' : 'bg-slate-800 text-white';
            
            toast.className = `p-4 rounded-xl shadow-xl ${bgClass} text-xs font-medium flex items-center justify-between gap-3 modal-animate border border-white/10`;
            toast.innerHTML = `
                <span>${message}</span>
                <button onclick="this.parentElement.remove()" class="text-white/80 hover:text-white font-bold">&times;</button>
            `;
            
            container.appendChild(toast);
            
            setTimeout(() => {
                toast.remove();
            }, 4000);
        }
    </script>
    @stack('scripts')
</body>
</html>
