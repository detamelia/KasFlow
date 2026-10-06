import React, { useState } from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function AppLayout({ children, title }) {
    const { auth, flash, url } = usePage().props;
    const userRole = auth?.user?.role || 'anggota';
    const userName = auth?.user?.name || 'Pengguna';
    const userEmail = auth?.user?.email || 'user@kasflow.id';

    const [isSidebarOpen, setIsSidebarOpen] = useState(false);
    const [isUserMenuOpen, setIsUserMenuOpen] = useState(false);

    const toggleSidebar = () => setIsSidebarOpen(!isSidebarOpen);

    const navItems = [
        {
            name: 'Dashboard',
            href: '/dashboard',
            icon: (
                <svg className="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
            ),
        },
        {
            name: 'Pemasukan Kas',
            href: '/pemasukan',
            badge: '+',
            badgeColor: 'bg-emerald-500/20 text-emerald-300',
            icon: (
                <svg className="w-5 h-5 shrink-0 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                </svg>
            ),
        },
        {
            name: 'Pengeluaran Kas',
            href: '/pengeluaran',
            badge: '-',
            badgeColor: 'bg-rose-500/20 text-rose-300',
            icon: (
                <svg className="w-5 h-5 shrink-0 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/>
                </svg>
            ),
        },
        {
            name: 'Riwayat Transaksi',
            href: '/transaksi',
            icon: (
                <svg className="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
            ),
        },
        {
            name: 'Kategori',
            href: '/kategori',
            icon: (
                <svg className="w-5 h-5 shrink-0 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            ),
            role: 'bendahara',
        },
        {
            name: 'Rincian & Laporan',
            href: '/laporan',
            icon: (
                <svg className="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            ),
        },
    ];

    const currentUrl = url || window.location.pathname;

    return (
        <div className="min-h-screen flex flex-col lg:flex-row bg-slate-50 font-sans text-slate-800 antialiased">
            {/* Sidebar Mobile Overlay */}
            {isSidebarOpen && (
                <div
                    onClick={toggleSidebar}
                    className="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-40 lg:hidden transition-opacity"
                />
            )}

            {/* Sidebar Navigation */}
            <aside
                className={`fixed top-0 bottom-0 left-0 z-50 w-64 bg-slate-900 text-slate-300 flex flex-col justify-between border-r border-slate-800 transition-transform duration-300 ${
                    isSidebarOpen ? 'translate-x-0' : '-translate-x-full'
                } lg:translate-x-0`}
            >
                <div>
                    {/* Brand Header */}
                    <div className="h-16 px-6 flex items-center justify-between border-b border-slate-800/80">
                        <a href="/dashboard" className="flex items-center gap-3 group">
                            <div className="w-10 h-10 rounded-xl gradient-emerald flex items-center justify-center text-white shadow-md shadow-emerald-500/20 group-hover:scale-105 transition-transform duration-200">
                                <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <span className="text-lg font-extrabold tracking-tight text-white flex items-center gap-1">
                                    Kas<span className="text-emerald-400">Flow</span>
                                </span>
                                <span className="text-[10px] block font-medium uppercase tracking-widest text-slate-400 -mt-1">Keuangan Organisasi</span>
                            </div>
                        </a>
                        <button
                            onClick={toggleSidebar}
                            className="lg:hidden text-slate-400 hover:text-white p-1"
                        >
                            <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    {/* Role Pill Indicator */}
                    <div className="px-4 py-3 bg-slate-900/80 border-b border-slate-800/60">
                        <div className="flex items-center justify-between bg-slate-800/90 px-3 py-2 rounded-xl border border-slate-700/60">
                            <div className="flex items-center gap-2">
                                <span className={`w-2 h-2 rounded-full ${userRole === 'bendahara' ? 'bg-emerald-400 animate-pulse' : 'bg-indigo-400'}`}></span>
                                <span className="text-xs font-semibold text-slate-200">
                                    Akses {userRole.charAt(0).toUpperCase() + userRole.slice(1)}
                                </span>
                            </div>
                            <span className="text-[10px] px-1.5 py-0.5 rounded font-mono uppercase bg-slate-700 text-slate-300">
                                {userRole === 'bendahara' ? 'Full' : 'Read-only'}
                            </span>
                        </div>
                    </div>

                    {/* Navigation Menu */}
                    <nav className="px-3 py-4 space-y-1.5 overflow-y-auto max-h-[calc(100vh-320px)]">
                        <div className="px-3 pb-1 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">
                            Menu Utama
                        </div>
                        {navItems.map((item) => {
                            if (item.role && item.role !== userRole) return null;
                            const isActive = currentUrl.startsWith(item.href);
                            const isBladePage = item.href === '/dashboard' || item.href === '/laporan';
                            const Component = isBladePage ? 'a' : Link;

                            return (
                                <Component
                                    key={item.name}
                                    href={item.href}
                                    className={`flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 ${
                                        isActive
                                            ? 'bg-emerald-600/90 text-white shadow-md shadow-emerald-900/30'
                                            : 'text-slate-300 hover:bg-slate-800/80 hover:text-white'
                                    }`}
                                >
                                    <div className="flex items-center gap-3">
                                        {item.icon}
                                        <span>{item.name}</span>
                                    </div>
                                    {item.badge && (
                                        <span className={`text-xs px-2 py-0.5 rounded-full font-semibold ${item.badgeColor}`}>
                                            {item.badge}
                                        </span>
                                    )}
                                </Component>
                            );
                        })}
                    </nav>
                </div>

                {/* Sidebar Bottom Widgets & Profile */}
                <div className="p-4 border-t border-slate-800/80 bg-slate-900/90 space-y-3">
                    <div className="rounded-xl bg-slate-800/70 p-3 border border-slate-700/50 text-xs">
                        <div className="text-slate-400 font-medium mb-1">Total Saldo Kas Organisasi</div>
                        <div className="text-lg font-bold text-emerald-400">Rp 18.450.000</div>
                        <div className="text-[10px] text-slate-400 mt-1 flex items-center justify-between">
                            <span>Update: Sep 2026</span>
                            <span className="text-emerald-400">● Realtime</span>
                        </div>
                    </div>

                    <div className="bg-slate-800/80 p-2.5 rounded-xl border border-slate-700/50 flex items-center justify-between">
                        <div className="flex items-center gap-2">
                            <span className="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span className="text-[11px] font-medium text-slate-300">Versi UI</span>
                        </div>
                        <a
                            href={`${currentUrl}?view=blade`}
                            className="text-[10px] bg-slate-700 hover:bg-slate-600 text-emerald-300 font-semibold px-2 py-1 rounded-md transition-colors"
                            title="Buka versi Blade untuk screenshot"
                        >
                            Ke Blade &rarr;
                        </a>
                    </div>

                    <div className="flex items-center justify-between pt-1">
                        <div className="flex items-center gap-2.5">
                            <div className="w-8 h-8 rounded-full bg-emerald-600 flex items-center justify-center text-white font-bold text-xs uppercase">
                                {userName.substring(0, 2)}
                            </div>
                            <div className="truncate max-w-[110px]">
                                <p className="text-xs font-semibold text-white truncate">{userName}</p>
                                <p className="text-[10px] text-slate-400 truncate capitalize">{userRole}</p>
                            </div>
                        </div>

                        <form method="POST" action="/logout">
                            <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''} />
                            <button
                                type="submit"
                                className="p-1.5 text-slate-400 hover:text-rose-400 hover:bg-slate-800 rounded-lg transition-colors cursor-pointer"
                                title="Logout"
                            >
                                <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            {/* Main workspace */}
            <div className="flex-1 lg:pl-64 flex flex-col min-h-screen transition-all duration-300">
                {/* Navbar Top */}
                <header className="sticky top-0 z-30 bg-white/90 backdrop-blur-md border-b border-slate-200/80 px-4 sm:px-6 py-3 flex items-center justify-between">
                    <div className="flex items-center gap-3">
                        <button
                            onClick={toggleSidebar}
                            className="lg:hidden p-2 text-slate-600 hover:text-slate-900 rounded-xl hover:bg-slate-100"
                        >
                            <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        <div>
                            <h1 className="text-sm font-bold text-slate-900">{title || 'KasFlow'}</h1>
                            <span className="text-[11px] text-slate-500 hidden sm:inline-block">Tugas Studio 3 (React + Inertia)</span>
                        </div>
                    </div>

                    <div className="flex items-center gap-3">
                        <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            <span className="w-2 h-2 rounded-full bg-emerald-500"></span>
                            React (Inertia.js)
                        </span>

                        <a
                            href={`${currentUrl}?view=blade`}
                            className="text-xs font-semibold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 px-3 py-1.5 rounded-lg transition-colors border border-slate-200"
                            title="Buka Tampilan Blade"
                        >
                            Lihat Versi Blade &rarr;
                        </a>
                    </div>
                </header>

                {/* Notifications / Flash */}
                <div className="px-4 sm:px-6 lg:px-8 pt-4">
                    {flash?.success && (
                        <div className="p-4 mb-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium flex items-center justify-between">
                            <div className="flex items-center gap-2">
                                <svg className="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>{flash.success}</span>
                            </div>
                        </div>
                    )}

                    {flash?.error && (
                        <div className="p-4 mb-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-medium flex items-center justify-between">
                            <div className="flex items-center gap-2">
                                <svg className="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{flash.error}</span>
                            </div>
                        </div>
                    )}
                </div>

                {/* Main Content Area */}
                <main className="flex-1 p-4 sm:p-6 lg:p-8">
                    {children}
                </main>

                {/* Footer */}
                <footer className="mt-auto py-6 px-6 border-t border-slate-200/80 bg-white text-center sm:text-left flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                    <div>
                        &copy; 2026 <span className="font-bold text-slate-800">KasFlow</span>. Sistem Manajemen Keuangan Organisasi.
                    </div>
                    <div className="flex items-center gap-4 text-slate-400">
                        <span className="text-emerald-600 font-semibold">React + Inertia UI (Tugas Studio 3)</span>
                    </div>
                </footer>
            </div>
        </div>
    );
}
