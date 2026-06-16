@extends('admin.layout')
@section('content')

<div class="w-full p-6 bg-gray-100">
    <div class="w-full bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-blue-400 p-4">
            <h2 class="text-xl font-bold text-blue-800">Edit Data Petugas</h2>
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

        <div class="p-6">
            <form action="{{ route('petugas.update', $petugas->id) }}" method="POST">
                @csrf
                @method('PUT')

                @if($konsultan->isEmpty())
                <div class="text-red-600 font-medium mb-4">
                    Tidak ada konsultan yang tersedia saat ini.
                </div>
                @else

                <div class="mb-4">
                    <label for="konsultan_id" class="block text-sm font-medium text-gray-700">Nama Petugas</label>
                    <select name="konsultan_id" id="konsultan_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-400 focus:border-blue-400 sm:text-sm" required>
                        @foreach ($konsultan as $konsul)
                            <option value="{{ $konsul->id }}" {{ $petugas->konsultan_id == $konsul->id ? 'selected' : '' }}>{{ $konsul->nama }}</option>
                        @endforeach
                    </select>
                    @error('konsultan_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ $petugas->tanggal }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-400 focus:border-blue-400 sm:text-sm" required>
                    @error('tanggal')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('petugas.index') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded">Kembali</a>
                    <button type="submit" class="px-4 py-2 bg-blue-300 hover:bg-blue-400 text-blue-800 rounded">Simpan</button>
                </div>
                @endif
            </form>
        </div>
    </div>
</div>

@endsection
