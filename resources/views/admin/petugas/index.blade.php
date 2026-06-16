@extends('admin.layout')
@section('content')

<div class="w-full p-6 bg-gray-100 min-h-screen">
    <div class="w-full mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-blue-400 p-4">
            <h2 class="text-xl font-bold text-blue-800">Data Petugas Hari Ini</h2>
        </div>

        <div class="p-6 flex justify-between items-center mb-4">
            <a href="{{ route('petugas.create') }}" class="px-4 py-2 bg-blue-300 hover:bg-blue-400 text-blue-800 rounded">Tambah Data</a>

            {{-- <form action="{{ route('petugas.destroy.all') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus SEMUA data petugas? Tindakan ini tidak dapat dibatalkan.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded">Hapus Semua Data</button>
            </form> --}}
        </div>

        {{-- Form Filter --}}
        <div class="p-6 border-b border-gray-200">
            <form action="{{ route('petugas.index') }}" method="GET" class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4">
                <div class="w-full md:w-auto">
                    <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal:</label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ request('tanggal') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </div>
                <div class="w-full md:w-auto">
                    <label for="bulan" class="block text-sm font-medium text-gray-700">Bulan:</label>
                    <select name="bulan" id="bulan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="">Pilih Bulan</option>
                        @foreach(range(1, 12) as $bulan)
                            <option value="{{ $bulan }}" {{ request('bulan') == $bulan ? 'selected' : '' }}>{{ \Carbon\Carbon::create(null, $bulan)->locale('id')->isoFormat('MMMM') }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full md:w-auto">
                    <label for="tahun" class="block text-sm font-medium text-gray-700">Tahun:</label>
                    <select name="tahun" id="tahun" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="">Pilih Tahun</option>
                        {{-- Logika untuk tahun otomatis --}}
                        @php
                            $currentYear = date('Y');
                            $startYear = 2024;
                        @endphp
                        @for ($i = $currentYear; $i >= $startYear; $i--)
                            <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="w-full md:w-auto mt-6 md:mt-0 flex space-x-2">
                    <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md">Filter</button>
                    <a href="{{ route('petugas.index') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md">Reset</a>
                </div>
            </form>
        </div>

        <div class="p-6 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-700">Hasil Filter</h3>

            {{-- Tombol Download PDF --}}
            <a href="{{ route('petugas.export-pdf', ['tanggal' => request('tanggal'), 'bulan' => request('bulan'), 'tahun' => request('tahun')]) }}" class="px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white rounded-md">
                Download PDF
            </a>
        </div>

        <div class="p-6 link-container">
            {{-- Bagian tabel Anda --}}
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-blue-300">
                        <th class="p-3 text-center text-blue-800 border border-blue-400">No</th>
                        <th class="p-3 text-center text-blue-800 border border-blue-400">Petugas Hari Ini</th>
                        <th class="p-3 text-center text-blue-800 border border-blue-400">Tanggal</th>
                        <th class="p-3 text-center text-blue-800 border border-blue-400">Aksi</th>
                    </tr>
                </thead>
                <tbody id="layanan-body">
                    @foreach ($petugas as $index => $item)
                    <tr class="layanan-item-row hover:bg-gray-50">
                        <td class="p-3 border border-gray-200 text-center">{{ $index + 1 }}</td>
                        <td class="p-3 border border-gray-200 ">
                            <div class=" line-clamp-2 text-center">{{ $item->konsultan->nama }}</div>
                        </td>
                        <td class="p-3 border border-gray-200 text-center">
                            <div class="line-clamp-2 overflow text-ellipsis">
                                {{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('D MMMM Y') }}
                            </div>
                        </td>
                        <td class="p-3 border border-gray-200">
                            <div class="flex space-x-2 justify-center">
                                <a href="{{ route('petugas.edit', $item->id) }}" class="px-3 py-1 bg-blue-300 hover:bg-blue-400 text-blue-800 rounded">Edit</a>
                                <form action="{{ route('petugas.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-300 hover:bg-red-400 text-red-800 rounded" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div id="pagination-controls" class="flex justify-center mt-6 space-x-2"></div>
        </div>
    </div>
</div>
@endsection
