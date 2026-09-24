@props([
    'label' => null,
    'name' => null,
    'type' => 'text',
    'value' => null,
    'placeholder' => null,
    'icon' => null,
    'required' => false,
    'helper' => null,
    'error' => null,
    'disabled' => false,
])

<div class="w-full">
    @if ($label)
        <label for="{{ $name }}" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">
            {{ $label }}
            @if ($required)
                <span class="text-rose-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative rounded-xl shadow-2xs">
        @if ($icon)
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                {!! $icon !!}
            </div>
        @endif

        <input
            type="{{ $type }}"
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $attributes->merge([
                'class' => 'w-full rounded-xl border ' . ($error ? 'border-rose-300 focus:border-rose-500 focus:ring-rose-500' : 'border-slate-300 focus:border-emerald-500 focus:ring-emerald-500') . ' bg-white px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-offset-0 disabled:bg-slate-50 disabled:text-slate-500 transition-colors duration-150 ' . ($icon ? 'pl-10' : '')
            ]) }}
        />
    </div>

    @if ($error)
        <p class="mt-1 text-xs text-rose-600 font-medium">{{ $error }}</p>
    @elseif ($helper)
        <p class="mt-1 text-xs text-slate-500">{{ $helper }}</p>
    @endif
</div>
