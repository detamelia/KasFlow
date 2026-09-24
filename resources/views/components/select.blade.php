@props([
    'label' => null,
    'name' => null,
    'options' => [],
    'selected' => null,
    'required' => false,
    'helper' => null,
    'error' => null,
    'disabled' => false,
    'placeholder' => 'Pilih Opsi...',
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
        <select
            id="{{ $name }}"
            name="{{ $name }}"
            {{ $required ? 'required' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $attributes->merge([
                'class' => 'w-full rounded-xl border ' . ($error ? 'border-rose-300 focus:border-rose-500 focus:ring-rose-500' : 'border-slate-300 focus:border-emerald-500 focus:ring-emerald-500') . ' bg-white px-3.5 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-offset-0 disabled:bg-slate-50 disabled:text-slate-500 transition-colors duration-150 appearance-none pr-10'
            ]) }}
        >
            @if ($placeholder)
                <option value="" {{ is_null($selected) ? 'selected' : '' }}>{{ $placeholder }}</option>
            @endif

            @foreach ($options as $key => $val)
                @php
                    $optionValue = is_numeric($key) ? $val : $key;
                    $optionLabel = $val;
                    $isSelected = ($selected == $optionValue);
                @endphp
                <option value="{{ $optionValue }}" {{ $isSelected ? 'selected' : '' }}>
                    {{ $optionLabel }}
                </option>
            @endforeach

            {{ $slot }}
        </select>

        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-400">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </div>
    </div>

    @if ($error)
        <p class="mt-1 text-xs text-rose-600 font-medium">{{ $error }}</p>
    @elseif ($helper)
        <p class="mt-1 text-xs text-slate-500">{{ $helper }}</p>
    @endif
</div>
