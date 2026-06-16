@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-sm text-blue-900 mb-2']) }}>
    {{ $value ?? $slot }}
</label>
