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
                <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            ),
        },
        {
            name: 'Pemasukan',
            href: '/pemasukan',
            icon: (
                <svg className="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 4v16m8-8H4"/>
                </svg>
            ),
        },
        {
            name: 'Pengeluaran',
            href: '/pengeluaran',
            icon: (
                <svg className="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M20 12H4"/>
                </svg>
            ),
        },
        {
            name: 'Semua Transaksi',
            href: '/transaksi',
            icon: (
                <svg className="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            ),
        },
        {
            name: 'Kategori',
            href: '/kategori',
            icon: (
                <svg className="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M7 7h.01M7 11h.01M7 15h.01M13 7h.01M13 11h.01M13 15h.01M19 7h.01M19 11h.01M19 15h.01"/>
                </svg>
            ),
            role: 'bendahara',
        },
        {
            name: 'Laporan',
            href: '/laporan',
            icon: (
                <svg className="w-5 h-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
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
                className={`fixed top-0 bottom-0 left-0 z-50 w-64 bg-slate-900 text-slate-300 flex flex-col transition-transform duration-300 ${
                    isSidebarOpen ? 'translate-x-0' : '-translate-x-full'
                } lg:translate-x-0`}
            >
                {/* Brand Header */}
                <div className="h-16 px-6 flex items-center justify-between border-b border-slate-800">
                    <Link href="/dashboard" className="flex items-center gap-3">
                        <div className="w-9 h-9 rounded-xl bg-emerald-500 flex items-center justify-center text-white font-black text-lg shadow-lg shadow-emerald-500/20">
                            K
                        </div>
                        <div>
                            <span className="font-black text-lg text-white tracking-tight">KasFlow</span>
                            <span className="text-[10px] text-emerald-400 block font-semibold -mt-1">Studio 3 (React)</span>
                        </div>
                    </Link>
                    <button
                        onClick={toggleSidebar}
                        className="lg:hidden text-slate-400 hover:text-white p-1"
                    >
                        <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {/* Role Badge */}
                <div className="px-6 py-3 bg-slate-950/40 border-b border-slate-800/60 flex items-center justify-between text-xs">
                    <span className="text-slate-400 font-medium">Akses Peran:</span>
                    <span className={`px-2 py-0.5 rounded-full font-bold uppercase text-[10px] ${
                        userRole === 'bendahara'
                            ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30'
                            : userRole === 'ketua'
                            ? 'bg-indigo-500/20 text-indigo-400 border border-indigo-500/30'
                            : 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30'
                    }`}>
                        {userRole}
                    </span>
                </div>

                {/* Navigation Links */}
                <nav className="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
                    {navItems.map((item) => {
                        if (item.role && item.role !== userRole) return null;
                        const isActive = currentUrl.startsWith(item.href);

                        return (
                            <Link
                                key={item.name}
                                href={item.href}
                                className={`flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium text-xs transition-all ${
                                    isActive
                                        ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20 font-semibold'
                                        : 'text-slate-400 hover:text-white hover:bg-slate-800/60'
                                }`}
                            >
                                {item.icon}
                                <span>{item.name}</span>
                            </Link>
                        );
                    })}
                </nav>

                {/* Quick Switcher & User Profile */}
                <div className="p-4 border-t border-slate-800 space-y-3">
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

                    <div className="flex items-center justify-between">
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
                                className="p-1.5 text-slate-400 hover:text-rose-400 hover:bg-slate-800 rounded-lg transition-colors"
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
