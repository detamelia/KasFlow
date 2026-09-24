@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
    'icon' => null,
    'disabled' => false,
])

@php
$baseClasses = "inline-flex items-center justify-center font-medium rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed select-none cursor-pointer";

$sizeClasses = [
    'sm' => 'px-3 py-1.5 text-xs gap-1.5',
    'md' => 'px-4 py-2.5 text-sm gap-2',
    'lg' => 'px-6 py-3.5 text-base gap-2.5',
][$size] ?? 'px-4 py-2.5 text-sm gap-2';

$variantClasses = [
    'primary' => 'bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm hover:shadow focus:ring-emerald-500 active:bg-emerald-800',
    'secondary' => 'bg-slate-800 hover:bg-slate-900 text-white shadow-sm hover:shadow focus:ring-slate-700 active:bg-slate-950',
    'success' => 'bg-teal-600 hover:bg-teal-700 text-white shadow-sm hover:shadow focus:ring-teal-500',
    'danger' => 'bg-rose-600 hover:bg-rose-700 text-white shadow-sm hover:shadow focus:ring-rose-500 active:bg-rose-800',
    'warning' => 'bg-amber-500 hover:bg-amber-600 text-white shadow-sm hover:shadow focus:ring-amber-400',
    'outline' => 'border border-slate-300 bg-white text-slate-700 hover:bg-slate-50 hover:border-slate-400 shadow-2xs focus:ring-slate-400',
    'ghost' => 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 focus:ring-slate-300',
][$variant] ?? 'bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm focus:ring-emerald-500';

$classes = "{$baseClasses} {$sizeClasses} {$variantClasses}";
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)
            <span class="shrink-0">{!! $icon !!}</span>
        @endif
        <span>{{ $slot }}</span>
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }} {{ $disabled ? 'disabled' : '' }}>
        @if ($icon)
            <span class="shrink-0">{!! $icon !!}</span>
        @endif
        <span>{{ $slot }}</span>
    </button>
@endif
