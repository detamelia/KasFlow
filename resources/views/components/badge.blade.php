@props([
    'variant' => 'neutral', // success, danger, warning, info, primary, neutral
    'size' => 'md', // sm, md
    'dot' => false,
])

@php
$variantClasses = [
    'success' => 'bg-emerald-50 text-emerald-700 border-emerald-200/80',
    'danger' => 'bg-rose-50 text-rose-700 border-rose-200/80',
    'warning' => 'bg-amber-50 text-amber-700 border-amber-200/80',
    'info' => 'bg-sky-50 text-sky-700 border-sky-200/80',
    'primary' => 'bg-indigo-50 text-indigo-700 border-indigo-200/80',
    'neutral' => 'bg-slate-100 text-slate-700 border-slate-200',
][$variant] ?? 'bg-slate-100 text-slate-700 border-slate-200';

$dotColor = [
    'success' => 'bg-emerald-500',
    'danger' => 'bg-rose-500',
    'warning' => 'bg-amber-500',
    'info' => 'bg-sky-500',
    'primary' => 'bg-indigo-500',
    'neutral' => 'bg-slate-400',
][$variant] ?? 'bg-slate-400';

$sizeClasses = [
    'sm' => 'px-2 py-0.5 text-xs',
    'md' => 'px-2.5 py-1 text-xs font-semibold',
][$size] ?? 'px-2.5 py-1 text-xs font-semibold';
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 rounded-full border {$variantClasses} {$sizeClasses}"]) }}>
    @if ($dot)
        <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
    @endif
    <span>{{ $slot }}</span>
</span>
