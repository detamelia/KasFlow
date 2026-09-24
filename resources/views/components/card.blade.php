@props([
    'title' => null,
    'subtitle' => null,
    'icon' => null,
    'headerAction' => null,
    'footer' => null,
    'trend' => null,
    'trendType' => 'up', // 'up' or 'down'
    'variant' => 'default', // 'default', 'emerald', 'rose', 'indigo', 'glass'
])

@php
$variantClasses = [
    'default' => 'bg-white border border-slate-200/80 card-shadow text-slate-800',
    'emerald' => 'gradient-emerald text-white shadow-md shadow-emerald-500/10 border border-emerald-500/20',
    'rose' => 'gradient-rose text-white shadow-md shadow-rose-500/10 border border-rose-500/20',
    'indigo' => 'gradient-indigo text-white shadow-md shadow-indigo-500/10 border border-indigo-500/20',
    'glass' => 'glass-card card-shadow text-slate-800',
][$variant] ?? 'bg-white border border-slate-200/80 card-shadow text-slate-800';

$isColored = in_array($variant, ['emerald', 'rose', 'indigo']);
@endphp

<div {{ $attributes->merge(['class' => "rounded-2xl overflow-hidden card-shadow-hover transition-all duration-200 {$variantClasses}"]) }}>
    @if ($title || $icon || $headerAction)
        <div class="px-6 py-5 border-b {{ $isColored ? 'border-white/10' : 'border-slate-100' }} flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                @if ($icon)
                    <div class="p-2.5 rounded-xl {{ $isColored ? 'bg-white/15 text-white' : 'bg-emerald-50 text-emerald-600' }} shrink-0">
                        {!! $icon !!}
                    </div>
                @endif
                <div>
                    @if ($title)
                        <h3 class="text-base font-semibold {{ $isColored ? 'text-white' : 'text-slate-900' }} tracking-tight">
                            {{ $title }}
                        </h3>
                    @endif
                    @if ($subtitle)
                        <p class="text-xs {{ $isColored ? 'text-white/80' : 'text-slate-500' }} mt-0.5">
                            {{ $subtitle }}
                        </p>
                    @endif
                </div>
            </div>

            @if ($headerAction)
                <div>
                    {{ $headerAction }}
                </div>
            @endif
        </div>
    @endif

    <div class="px-6 py-5">
        {{ $slot }}

        @if ($trend)
            <div class="mt-3 flex items-center gap-1.5 text-xs font-medium">
                @if ($trendType === 'up')
                    <span class="inline-flex items-center text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-100">
                        <svg class="w-3.5 h-3.5 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        {{ $trend }}
                    </span>
                @else
                    <span class="inline-flex items-center text-rose-600 bg-rose-50 px-2 py-0.5 rounded-full border border-rose-100">
                        <svg class="w-3.5 h-3.5 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"/></svg>
                        {{ $trend }}
                    </span>
                @endif
                <span class="{{ $isColored ? 'text-white/70' : 'text-slate-400' }}">vs bulan sebelumnya</span>
            </div>
        @endif
    </div>

    @if ($footer)
        <div class="px-6 py-3.5 bg-slate-50/50 border-t border-slate-100 text-xs text-slate-500">
            {{ $footer }}
        </div>
    @endif
</div>
