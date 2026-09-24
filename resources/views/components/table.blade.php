@props([
    'headers' => [],
    'emptyText' => 'Belum ada data transaksi yang tersedia.',
])

<div {{ $attributes->merge(['class' => 'w-full bg-white rounded-2xl border border-slate-200/80 card-shadow overflow-hidden']) }}>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600 border-collapse">
            @if (count($headers) > 0)
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200/70 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        @foreach ($headers as $header)
                            <th scope="col" class="px-6 py-4">
                                {{ $header }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
            @endif

            <tbody class="divide-y divide-slate-100 bg-white">
                {{ $slot }}
            </tbody>
        </table>
    </div>

    @if (trim($slot) === '')
        <div class="px-6 py-12 text-center">
            <div class="inline-flex p-3 rounded-full bg-slate-100 text-slate-400 mb-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
            </div>
            <p class="text-slate-500 font-medium text-sm">{{ $emptyText }}</p>
        </div>
    @endif
</div>
