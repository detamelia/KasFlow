<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - KasFlow</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-800 antialiased">
<div class="grid min-h-screen lg:grid-cols-2">

    {{-- Panel kiri --}}
    <aside class="hidden flex-col justify-between bg-slate-900 p-10 text-slate-200 lg:flex">
        <div class="flex items-center gap-3">
            <span class="grid h-10 w-10 place-items-center rounded-xl bg-green-600 font-bold text-white">K</span>
            <div>
                <p class="text-lg font-semibold leading-none text-white">Kas Flow</p>
                <p class="mt-1 text-xs text-slate-400">Keuangan Organisasi</p>
            </div>
        </div>

        <div>
            <h1 class="max-w-sm text-4xl font-semibold leading-tight text-white">Kas organisasi, tercatat dan terbuka.</h1>
            <p class="mt-4 max-w-sm text-slate-400">Bendahara mencatat setiap transaksi, ketua dan anggota memantau arus kas.</p>
        </div>

        <div class="max-w-sm rounded-2xl bg-green-600 p-6 text-white">
            <p class="font-semibold">Akses sesuai peran</p>
            <p class="mt-2 text-sm text-green-50"><b>Bendahara</b> mengelola pemasukan, pengeluaran, dan kategori.</p>
            <p class="mt-1 text-sm text-green-50"><b>Ketua dan anggota</b> melihat ringkasan dan laporan (hanya baca).</p>
        </div>
    </aside>

    {{-- Form --}}
    <main class="flex items-center justify-center p-6">
        <div class="w-full max-w-md rounded-2xl bg-white p-8 shadow-sm ring-1 ring-slate-200">
            <div class="mb-6 flex items-center gap-3 lg:hidden">
                <span class="grid h-9 w-9 place-items-center rounded-lg bg-green-600 font-bold text-white">K</span>
                <span class="text-lg font-semibold">Kas Flow</span>
            </div>

            <h2 class="text-2xl font-semibold">Masuk ke KasFlow</h2>
            <p class="mt-1 mb-6 text-sm text-slate-500">Gunakan akun yang diberikan untuk organisasi Anda.</p>

            @if ($errors->any())
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-3.5 py-2.5 text-sm text-red-700" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.process') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           autocomplete="username" placeholder="nama@email.com"
                           class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm focus:border-green-600 focus:outline-none focus:ring-2 focus:ring-green-600/20">
                </div>

                <div>
                    <label for="password" class="mb-1.5 block text-sm font-medium">Kata sandi</label>
                    <input id="password" type="password" name="password" required
                           autocomplete="current-password" placeholder="Masukkan kata sandi"
                           class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm focus:border-green-600 focus:outline-none focus:ring-2 focus:ring-green-600/20">
                </div>

                <button type="submit"
                        class="w-full rounded-lg bg-green-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2">
                    Masuk
                </button>
            </form>
        </div>
    </main>
</div>
</body>
</html>