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
        <x-sidebar :role="auth()->user()->role" />

        <!-- Main Workspace Area -->
        <div class="flex-1 lg:pl-64 flex flex-col min-h-screen transition-all duration-300">
            <!-- Navbar Component -->
            <x-navbar :role="auth()->user()->role" :title="$title ?? 'KasFlow'" />

            <!-- Toast Alert Container (Dynamic JavaScript Notifications) -->
            <div id="toast-container" class="fixed top-20 right-6 z-50 flex flex-col gap-2 max-w-sm"></div>

            <!-- Main Content Section -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
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
