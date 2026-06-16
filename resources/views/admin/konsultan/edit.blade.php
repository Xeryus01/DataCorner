@extends('admin.layout')
@section('content')

<div class="w-full p-6 bg-gray-100 min-h-screen">
    <div class="w-full  bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-blue-300 p-4">
            <h2 class="text-xl font-bold text-blue-800">Ubah Akun Konsultan</h2>
        </div>

        @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <strong>Terjadi kesalahan:</strong>
        <ul class="list-disc pl-5 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


        <form method="POST" action="{{ route('konsultan.update',$konsultan->id) }}" class="p-6" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-2">Email Konsultan</label>
                <input type="email" name="email" id="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300" value="{{ $konsultan->email }}">

                    <p class="text-red-500 text-sm mt-1"></p>

            </div>

            <div class="mb-4">
                <label for="nama" class="block text-gray-700 font-medium mb-2">Nama Konsultan</label>
                <input type="text" name="nama" id="nama" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300" value="{{ $konsultan->nama }}">

                    <p class="text-red-500 text-sm mt-1"></p>

            </div>

            <div class="mb-4">
                <label for="image" class="block text-gray-700 font-medium mb-2">Desain Name Desk</label>

                <div class="mb-4">
                    @if($konsultan->image)
                    <img id="previewImage" src="{{ asset('storage/'.$konsultan->image) }}"
                    class="w-32 h-32 object-contain bg-white border rounded mb-2"
                    alt="Foto Petugas">

                    @else
                    <img id="previewImage" class="w-32 h-32 object-cover mb-2 hidden" alt="previewImage">
                    @endif
            </div>
            <input type="file" name="image" id="image" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300" accept="image/*">

                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

            <div class="mb-4">
                <label for="gambar" class="block text-gray-700 font-medium mb-2">Foto Konsultan</label>

                <div class="mb-4">
                    @if($konsultan->gambar)
                    <img id="preview" src="{{ asset('storage/'.$konsultan->gambar) }}" class="w-32 h-32 object-cover mb-2" alt="file">
                    @else
                    <img id="preview" class="w-32 h-32 object-cover mb-2 hidden" alt="preview">
                    @endif
            </div>

                <input type="file" name="gambar" id="gambar" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300" accept="image/*">

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
                                <option value="{{ $posisi }}" {{ old('posisi', $konsultan->posisi) == $posisi ? 'selected' : '' }}>
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

            @php
                $keahlianTerpilih = old(
                    'bidang_keahlian_id',
                    $konsultan->bidangKeahlian->pluck('id')->toArray()
                );
            @endphp

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
                                {{ in_array($bidang->id, $keahlianTerpilih) ? 'checked' : '' }}
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
                <input type="password" name="password" id="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">

                    <p class="text-red-500 text-sm mt-1"></p>

            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="px-6 py-2 bg-blue-300 hover:bg-blue-400 text-blue-800 font-medium rounded-lg">Ubah</button>

            </div>
        </form>
    </div>
</div>
@endsection
