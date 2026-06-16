@extends('admin.layout')
@section('content')

<div class="w-full p-6 bg-gray-100 min-h-screen">
    <div class="w-full  bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-blue-300 p-4">
            <h2 class="text-xl font-bold text-blue-800">Buat Layanan 24 Jam</h2>
        </div>

        <form method="POST" action="{{ route('layanan.store') }}" class="p-6" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="gambar" class="block text-gray-700 font-medium mb-2">file (Bentuk Gambar) JPG|PNG|JPEG</label>
                <input type="file" name="gambar" id="gambar" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300" value="{{ old('gambar') }}" required>

                @error('gambar')

                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

            </div>

            <div class="mb-4">
                <label for="judul" class="block text-gray-700 font-medium mb-2">Judul Layanan</label>
                <input type="text" name="judul" placeholder="Masukkan judul" id="judul" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300" value="{{ old('judul') }}" required>
                    @error('judul')

                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

            </div>

            <div class="mb-4">
                <label for="deskripsi" class="block text-gray-700 font-medium mb-2">Deskripsi Layanan</label>
                <input type="text" name="deskripsi" placeholder="Masukkan Deskripsi" id="deskripsi" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300" value="{{ old('deskripsi') }}" required>
                    @error('deskripsi')

                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

            </div>

            <div class="mb-4">
                <label for="link" class="block text-gray-700 font-medium mb-2">link Layanan</label>
                <input type="text" name="link" placeholder="Masukkan Link Layanan" id="link" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300" value="{{ old('link') }}" required>
                    @error('link')

                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="px-6 py-2 bg-blue-300 hover:bg-blue-400 text-blue-800 font-medium rounded-lg">Buat</button>

            </div>
        </form>
    </div>
</div>
@endsection
