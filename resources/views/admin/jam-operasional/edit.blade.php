@extends('admin.layout')
@section('content')

<div class="w-full p-6 bg-gray-100 min-h-screen">
    <div class="w-full  bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-blue-300 p-4">
            <h2 class="text-xl font-bold text-blue-800">Ubah Jam Operasional</h2>
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

        <form method="POST" action="{{ route('jam-operasional.update', $jamOperasional->id) }}" class="p-6">
            @method('PUT')
            @csrf

            <div class="mb-4">
                <label for="keterangan_hari" class="block text-gray-700 font-medium mb-2">Keterangan Hari</label>
                <input type="text" name="keterangan_hari" id="keterangan_hari" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300" value="{{ old('keterangan_hari', $jamOperasional->keterangan_hari) }}">

                    <p class="text-red-500 text-sm mt-1"></p>

            </div>

            <div class="mb-4">
                <label for="jam_mulai" class="block text-gray-700 font-medium mb-2">Jam Mulai</label>
                <input type="time" name="jam_mulai" id="jam_mulai" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300" value="{{ old('jam_mulai', \Carbon\Carbon::parse($jamOperasional->jam_mulai)->format('H:i')) }}">

                    <p class="text-red-500 text-sm mt-1"></p>

            </div>

            <div class="mb-4">
                <label for="jam_selesai" class="block text-gray-700 font-medium mb-2">Jam selesai</label>
                <input type="time" name="jam_selesai" id="jam_selesai" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300" value="{{ old('jam_selesai', \Carbon\Carbon::parse($jamOperasional->jam_selesai)->format('H:i')) }}">

                    <p class="text-red-500 text-sm mt-1"></p>

            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="px-6 py-2 bg-blue-300 hover:bg-blue-400 text-blue-800 font-medium rounded-lg">Ubah</button>

            </div>
        </form>
    </div>
</div>
@endsection
