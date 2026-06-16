@props(['name','label'=>'','options'=>[], 'selected'=>null,'required'=>false])

<div class="mb-4">
    <label for="{{ $name }}" class="block text-gray-700 font-medium mb-2">{{ $label }} @if($required)<span aria-hidden="true">*</span>@endif</label>
    <select id="{{ $name }}" name="{{ $name }}" class="form-control w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300" {{ $required ? 'required' : '' }}>
        <option value="" disabled {{ $selected ? '' : 'selected' }}>-- Pilih --</option>
        @foreach($options as $optVal => $optLabel)
            <option value="{{ $optVal }}" {{ (string)old($name, $selected) === (string)$optVal ? 'selected' : '' }}>{{ $optLabel }}</option>
        @endforeach
    </select>
    @error($name)
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @else
        <p class="text-red-500 text-sm mt-1 form-error" aria-live="polite"></p>
    @enderror
</div>
