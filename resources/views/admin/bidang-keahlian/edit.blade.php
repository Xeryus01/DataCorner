@extends('admin.layout')

@section('content')

<div class="w-full p-6 bg-gray-100 min-h-screen">
    <div class="w-full bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-blue-300 p-4">
            <h2 class="text-xl font-bold text-blue-800">Edit Bidang Keahlian</h2>
        </div>

        <form method="POST" action="{{ route('bidang-keahlian.update', $bidang->id) }}" class="p-6">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nama_bidang" class="block text-gray-700 font-medium mb-2">
                    Nama Bidang Keahlian
                </label>

                <input type="text"
                       name="nama_bidang"
                       id="nama_bidang"
                       placeholder="Masukkan nama bidang keahlian"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300"
                       value="{{ old('nama_bidang', $bidang->nama_bidang) }}"
                       required>

                @error('nama_bidang')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="status" class="block text-gray-700 font-medium mb-2">
                    Status
                </label>

                <select name="status"
                        id="status"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300"
                        required>
                    <option value="">Pilih Status</option>
                    <option value="aktif" {{ old('status', $bidang->status) == 'aktif' ? 'selected' : '' }}>
                        Aktif
                    </option>
                    <option value="tidak aktif" {{ old('status', $bidang->status) == 'tidak aktif' ? 'selected' : '' }}>
                        Tidak Aktif
                    </option>
                </select>

                @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <button type="submit"
                        class="px-6 py-2 bg-blue-300 hover:bg-blue-400 text-blue-800 font-medium rounded-lg">
                    Simpan Perubahan
                </button>

                <a href="{{ route('bidang-keahlian.index') }}"
                   class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded-lg">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>

@endsection