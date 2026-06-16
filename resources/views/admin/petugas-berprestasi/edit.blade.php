@extends('admin.layout')

@section('content')

<div class="w-full p-6 bg-gray-100 min-h-screen">
    <div class="w-full bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-blue-300 p-4">
            <h2 class="text-xl font-bold text-blue-800">Edit Petugas Berprestasi</h2>
        </div>

        <form method="POST"
              action="{{ route('petugas-berprestasi.update', $prestasi->id) }}"
              class="p-6"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Petugas / Konsultan --}}
            <div class="mb-4">
                <label for="konsultan_id" class="block text-gray-700 font-medium mb-2">
                    Petugas / Konsultan
                </label>

                <select name="konsultan_id"
                        id="konsultan_id"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300"
                        required>
                    <option value="">Pilih Petugas / Konsultan</option>

                    @foreach($konsultan as $item)
                        <option value="{{ $item->id }}"
                            {{ old('konsultan_id', $prestasi->konsultan_id) == $item->id ? 'selected' : '' }}>
                            {{ $item->nama }}
                        </option>
                    @endforeach
                </select>

                @error('konsultan_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Triwulan --}}
            <div class="mb-4">
                <label for="triwulan" class="block text-gray-700 font-medium mb-2">
                    Triwulan
                </label>

                <select name="triwulan"
                        id="triwulan"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300"
                        required>
                    <option value="">Pilih Triwulan</option>

                    <option value="1" {{ old('triwulan', $prestasi->triwulan) == '1' ? 'selected' : '' }}>
                        Triwulan 1 - Januari s.d. Maret
                    </option>

                    <option value="2" {{ old('triwulan', $prestasi->triwulan) == '2' ? 'selected' : '' }}>
                        Triwulan 2 - April s.d. Juni
                    </option>

                    <option value="3" {{ old('triwulan', $prestasi->triwulan) == '3' ? 'selected' : '' }}>
                        Triwulan 3 - Juli s.d. September
                    </option>

                    <option value="4" {{ old('triwulan', $prestasi->triwulan) == '4' ? 'selected' : '' }}>
                        Triwulan 4 - Oktober s.d. Desember
                    </option>
                </select>

                @error('triwulan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tahun --}}
            <div class="mb-4">
                <label for="tahun" class="block text-gray-700 font-medium mb-2">
                    Tahun
                </label>

                <input type="number"
                       name="tahun"
                       id="tahun"
                       placeholder="Masukkan tahun"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300"
                       value="{{ old('tahun', $prestasi->tahun) }}"
                       required>

                @error('tahun')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nilai --}}
            <div class="mb-4">
                <label for="nilai" class="block text-gray-700 font-medium mb-2">
                    Nilai
                </label>

                <input type="number"
                       name="nilai"
                       id="nilai"
                       placeholder="Masukkan nilai"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300"
                       value="{{ old('nilai', $prestasi->nilai) }}">

                @error('nilai')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Sertifikat --}}
            <div class="mb-4">
                <label for="sertifikat" class="block text-gray-700 font-medium mb-2">
                    Sertifikat PDF | JPG | PNG | JPEG
                </label>

                <input type="file"
                       name="sertifikat"
                       id="sertifikat"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300"
                       accept=".pdf,.jpg,.jpeg,.png">

                @if($prestasi->sertifikat)
                    <div class="mt-2">
                        <a href="{{ asset('storage/' . $prestasi->sertifikat) }}"
                           target="_blank"
                           class="text-blue-600 hover:underline text-sm">
                            Lihat sertifikat saat ini
                        </a>
                    </div>
                @endif

                <p class="text-gray-500 text-sm mt-1">
                    Kosongkan jika tidak ingin mengganti sertifikat.
                </p>

                @error('sertifikat')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol --}}
            <div class="flex items-center justify-between">
                <button type="submit"
                        class="px-6 py-2 bg-blue-300 hover:bg-blue-400 text-blue-800 font-medium rounded-lg">
                    Simpan Perubahan
                </button>

                <a href="{{ route('petugas-berprestasi.index') }}"
                   class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded-lg">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>

@endsection