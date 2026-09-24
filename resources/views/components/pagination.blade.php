@props([
    'currentPage' => 1,
    'totalPages' => 5,
    'totalItems' => 42,
    'itemsPerPage' => 10,
])

@php
$startItem = ($currentPage - 1) * $itemsPerPage + 1;
$endItem = min($currentPage * $itemsPerPage, $totalItems);
@endphp

<div {{ $attributes->merge(['class' => 'px-6 py-4 bg-white border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500']) }}>
    <div>
        Menampilkan <span class="font-semibold text-slate-900">{{ $startItem }}</span> sampai <span class="font-semibold text-slate-900">{{ $endItem }}</span> dari <span class="font-semibold text-slate-900">{{ $totalItems }}</span> total data
    </div>

    <div class="inline-flex items-center gap-1">
        <button
            type="button"
            class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-slate-900 disabled:opacity-40 disabled:cursor-not-allowed transition-colors cursor-pointer"
            {{ $currentPage <= 1 ? 'disabled' : '' }}
        >
            Sebelumnya
        </button>

        @for ($i = 1; $i <= $totalPages; $i++)
            <button
                type="button"
                class="w-8 h-8 rounded-lg font-medium transition-colors cursor-pointer {{ $i == $currentPage ? 'bg-emerald-600 text-white shadow-2xs' : 'text-slate-600 hover:bg-slate-100' }}"
            >
                {{ $i }}
            </button>
        @endfor

        <button
            type="button"
            class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-slate-900 disabled:opacity-40 disabled:cursor-not-allowed transition-colors cursor-pointer"
            {{ $currentPage >= $totalPages ? 'disabled' : '' }}
        >
            Selanjutnya
        </button>
    </div>
</div>
