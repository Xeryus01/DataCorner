@extends('admin.layout')
@section('content')

<div class="w-full p-6 bg-gray-100 min-h-screen">
    <div class="w-full  bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-blue-300 p-4">
            <h2 class="text-xl font-bold text-blue-800">Input Konsultasi</h2>
        </div>

        {{-- Tambahkan kode ini untuk debugging --}}
@if ($errors->any())
    <div style="background-color: #f8d7da; color: #721c24; padding: 1rem; border: 1px solid #f5c6cb; border-radius: .25rem; margin-bottom: 1rem;">
        <strong>Terjadi Kesalahan!</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <form method="POST" action="{{ route('adminKonsultasi.store') }}" class="p-6">
            @csrf
{{--
            <div class="mb-4">
                <label for="no_hp" class="block text-gray-700 font-medium mb-2">Nomor Handphone</label>
                <input type="text" name="no_hp" placeholder="Masukkan nomor handphone" id="no_hp" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300" value="{{ old('no_hp') }}" required>
                    @error('no_hp')

                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

            </div> --}}

            <div class="mb-4">
                <label for="posisi" class="block text-gray-700 font-medium mb-2">Posisi Sebagai</label>

                <select name="posisi" placeholder="Masukkan posisi" id="posisi" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300" required>
                    <option disabled selected value="">-- Pilih Posisi Sebagai --</option>
                    <option value="masyarakat">Masyarakat</option>
                    <option value="mahasiswa">Mahasiswa</option>
                    <option value="pegawai_pemerintah">Pegawai Pemerintah</option>

                </select>
                @error('posisi')
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
