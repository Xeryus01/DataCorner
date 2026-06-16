@extends('admin.layout')

@section('content')

<div class="w-full p-6 bg-gray-100">
    <div class="w-full bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-blue-400 p-4">
            <h2 class="text-xl font-bold text-blue-800">Data Petugas Berprestasi</h2>
        </div>

        <div class="p-6">
            <a href="{{ route('petugas-berprestasi.create') }}"
               class="px-4 py-2 bg-blue-300 hover:bg-blue-400 text-blue-800 rounded">
                Tambah Data
            </a>
        </div>

        @if(session('success'))
            <div class="mx-6 mb-4 p-4 bg-green-100 text-green-700 rounded border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mx-6 mb-4 p-4 bg-red-100 text-red-700 rounded border border-red-200">
                {{ session('error') }}
            </div>
        @endif

        <div class="p-6 link-container">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-blue-300">
                        <th class="p-3 text-center text-blue-800 border border-blue-400">No</th>
                        <th class="p-3 text-center text-blue-800 border border-blue-400">Nama Petugas</th>
                        <th class="p-3 text-center text-blue-800 border border-blue-400">Triwulan</th>
                        <th class="p-3 text-center text-blue-800 border border-blue-400">Tahun</th>
                        <th class="p-3 text-center text-blue-800 border border-blue-400">Nilai</th>
                        <th class="p-3 text-center text-blue-800 border border-blue-400">Sertifikat</th>
                        <th class="p-3 text-center text-blue-800 border border-blue-400">Aksi</th>
                    </tr>
                </thead>

                <tbody id="petugas-berprestasi-body">
                    @forelse ($data as $index => $item)
                        <tr class="petugas-berprestasi-item-row hover:bg-gray-50">
                            <td class="p-3 border border-gray-200 text-center">
                                {{ $index + 1 }}
                            </td>

                            <td class="p-3 border border-gray-200">
                                <div class="w-48 line-clamp-2">
                                    {{ $item->konsultan->nama ?? 'Konsultan tidak ditemukan' }}
                                </div>
                            </td>

                            <td class="p-3 border border-gray-200 text-center">
                                Triwulan {{ $item->triwulan }}
                            </td>

                            <td class="p-3 border border-gray-200 text-center">
                                {{ $item->tahun }}
                            </td>

                            <td class="p-3 border border-gray-200 text-center">
                                {{ $item->nilai ?? '-' }}
                            </td>

                            <td class="p-3 border text-center align-middle border-gray-200">
                                @if($item->sertifikat)
                                    <a href="{{ asset('storage/' . $item->sertifikat) }}"
                                       target="_blank"
                                       class="px-4 py-2 inline-block bg-blue-300 hover:bg-blue-400 text-blue-800 font-medium rounded-lg">
                                        Lihat File
                                    </a>
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </td>

                            <td class="p-3 border border-gray-200">
                                <div class="flex space-x-2">
                                    <a href="{{ route('petugas-berprestasi.edit', $item->id) }}"
                                       class="px-3 py-1 bg-blue-300 hover:bg-blue-400 text-blue-800 rounded">
                                        Edit
                                    </a>

                                    <form action="{{ route('petugas-berprestasi.destroy', $item->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="px-3 py-1 bg-red-300 hover:bg-red-400 text-red-800 rounded">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-6 text-center text-gray-500 border border-gray-200">
                                Belum ada data petugas berprestasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div id="pagination-controls" class="flex justify-center mt-6 space-x-2"></div>
        </div>
    </div>
</div>

@endsection