@extends('admin.layout')
@section('content')

<div class="w-full p-6 bg-gray-100 min-h-screen">
    <div class="w-full  bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-blue-300 p-4">
            <h2 class="text-xl font-bold text-blue-800">Buat Standar Layanan</h2>
        </div>

        <form method="POST" action="{{ route('standar.store') }}" class="p-6 needs-validation" enctype="multipart/form-data" novalidate>
            @csrf

            @include('components.form.input', ['name' => 'judul', 'label' => 'Judul Standar Layanan', 'type' => 'text', 'placeholder' => 'Masukkan judul', 'required' => true])

            <div class="mb-4">
                <label for="gambar" class="block text-gray-700 font-medium mb-2">gambar (Bentuk File) Jpg|Png</label>
                <input type="file" name="gambar" id="gambar" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300" value="{{ old('gambar') }}" required>
                @error('gambar')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @else
                <p class="text-red-500 text-sm mt-1 form-error" aria-live="polite"></p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="px-6 py-2 bg-blue-300 hover:bg-blue-400 text-blue-800 font-medium rounded-lg">Tambahkan</button>

            </div>
        </form>
    </div>
</div>
@endsection
