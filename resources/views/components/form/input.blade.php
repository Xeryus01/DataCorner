@props(['name','label'=>'','type'=>'text','value'=>null,'placeholder'=>'','required'=>false])

<div class="mb-4">
    <label for="{{ $name }}" class="block text-gray-700 font-medium mb-2">{{ $label }} @if($required)<span aria-hidden="true">*</span>@endif</label>
    <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ old($name, $value) }}" placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }} class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 form-control" />
    @error($name)
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @else
        <p class="text-red-500 text-sm mt-1 form-error" aria-live="polite"></p>
    @enderror
</div>
