@extends('admin.layout')
@section('content')

<div class="w-full p-6 bg-gray-100 min-h-screen">
    <div class="w-full  bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-blue-300 p-4">
            <h2 class="text-xl font-bold text-blue-800">Buat Akun Konsultan</h2>
        </div>

        <form method="POST" action="{{ route('konsultan.store') }}" class="p-6" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-2">Email Konsultan</label>
                <input type="email" name="email" placeholder="Masukkan email" id="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300" required>

                    @error('email')

                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

            </div>

            <div class="mb-4">
                <label for="nama" class="block text-gray-700 font-medium mb-2">Nama Konsultan</label>
                <input type="text" name="nama" placeholder="Masukkan nama" id="nama" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300" value="{{old('nama')}}" required>

                    @error('nama')

                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

            </div>

            <div class="mb-4">
                <label for="image" class="block text-gray-700 font-medium mb-2">Desain Name Desk</label>
                <input type="file" name="image" id="image" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300" required>

                @error('image')

                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

            </div>

            <div class="mb-4">
                <label for="gambar" class="block text-gray-700 font-medium mb-2">Foto Konsultan JPG|PNG|JPEG</label>
                <input type="file" name="gambar" id="gambar" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300" required>

                @error('gambar')

                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

            </div>

            <div class="mb-4">
                <label for="posisi" class="block text-gray-700 font-medium mb-2">
                    Posisi Di BPS
                </label>

                <select
                    name="posisi"
                    id="posisi"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300"
                    required
                >
                    <option value="">Pilih Posisi</option>

                    @foreach ($daftarPosisi as $kategori => $items)
                        <optgroup label="{{ $kategori }}">
                            @foreach ($items as $posisi)
                                <option value="{{ $posisi }}" {{ old('posisi') == $posisi ? 'selected' : '' }}>
                                    {{ $posisi }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>

                @error('posisi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">
                    Bidang Keahlian
                </label>

                <div class="grid grid-cols-2 gap-2">
                    @foreach ($bidangKeahlian as $bidang)
                        <label class="flex items-center gap-2 px-3 py-2 border rounded-lg cursor-pointer hover:bg-blue-50 hover:border-blue-300 transition">
                            <input
                                type="checkbox"
                                name="bidang_keahlian_id[]"
                                value="{{ $bidang->id }}"
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-300"
                                {{ in_array($bidang->id, old('bidang_keahlian_id', [])) ? 'checked' : '' }}
                            >

                            <span class="text-sm font-medium text-gray-700 truncate">
                                {{ $bidang->nama_bidang }}
                            </span>
                        </label>
                    @endforeach
                </div>

                @error('bidang_keahlian_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                @error('bidang_keahlian_id.*')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-medium mb-2">Password Konsultan</label>
                <input type="password" name="password" placeholder="Masukkan Password" id="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300" required>

                    @error('password')

                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="px-6 py-2 bg-blue-300 hover:bg-blue-400 text-blue-800 font-medium rounded-lg">Daftar</button>

            </div>
        </form>
    </div>
</div>
@endsection
