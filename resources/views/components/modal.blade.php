@props([
    'id' => 'modal',
    'title' => null,
    'subtitle' => null,
    'size' => 'md', // sm, md, lg, xl
    'actions' => null,
])

@php
$maxWidthClass = [
    'sm' => 'max-w-sm',
    'md' => 'max-w-lg',
    'lg' => 'max-w-2xl',
    'xl' => 'max-w-4xl',
][$size] ?? 'max-w-lg';
@endphp

<div
    id="{{ $id }}"
    class="fixed inset-0 z-50 hidden overflow-y-auto"
    aria-labelledby="{{ $id }}-title"
    role="dialog"
    aria-modal="true"
>
    <!-- Backdrop -->
    <div
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity duration-300"
        onclick="closeModal('{{ $id }}')"
    ></div>

    <!-- Modal Content Center Wrapper -->
    <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-6">
        <div
            class="relative w-full {{ $maxWidthClass }} transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all modal-animate border border-slate-200/80"
        >
            <!-- Header -->
            @if ($title)
                <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4 bg-slate-50/50">
                    <div>
                        <h3 class="text-base font-semibold text-slate-900" id="{{ $id }}-title">
                            {{ $title }}
                        </h3>
                        @if ($subtitle)
                            <p class="text-xs text-slate-500 mt-0.5">{{ $subtitle }}</p>
                        @endif
                    </div>
                    <button
                        type="button"
                        onclick="closeModal('{{ $id }}')"
                        class="rounded-xl p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-colors focus:outline-none cursor-pointer"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif

            <!-- Body -->
            <div class="px-6 py-5 max-h-[75vh] overflow-y-auto">
                {{ $slot }}
            </div>

            <!-- Footer / Actions -->
            @if ($actions)
                <div class="flex items-center justify-end gap-3 border-t border-slate-100 bg-slate-50/80 px-6 py-4">
                    {{ $actions }}
                </div>
            @endif
        </div>
    </div>
</div>
