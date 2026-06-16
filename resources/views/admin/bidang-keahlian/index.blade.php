@extends('admin.layout')

@section('content')

<div class="w-full p-6 bg-gray-100">
    <div class="w-full bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-blue-400 p-4">
            <h2 class="text-xl font-bold text-blue-800">Data Bidang Keahlian</h2>
        </div>

        <div class="p-6">
            <a href="{{ route('bidang-keahlian.create') }}"
               class="px-4 py-2 bg-blue-300 hover:bg-blue-400 text-blue-800 rounded">
                Tambah Data
            </a>
        </div>

        @if(session('success'))
            <div class="mx-6 mb-4 p-4 bg-green-100 text-green-700 rounded border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        <div class="p-6 link-container">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-blue-300">
                        <th class="p-3 text-center text-blue-800 border border-blue-400">No</th>
                        <th class="p-3 text-left text-blue-800 border border-blue-400">Nama Bidang</th>
                        <th class="p-3 text-center text-blue-800 border border-blue-400">Status</th>
                        <th class="p-3 text-center text-blue-800 border border-blue-400">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($bidangKeahlian as $index => $item)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 border border-gray-200 text-center">
                                {{ $index + 1 }}
                            </td>

                            <td class="p-3 border border-gray-200">
                                {{ $item->nama_bidang }}
                            </td>

                            <td class="p-3 border border-gray-200 text-center">
                                @if($item->status == 'aktif')
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded text-sm">
                                        Aktif
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded text-sm">
                                        Tidak Aktif
                                    </span>
                                @endif
                            </td>

                            <td class="p-3 border border-gray-200">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('bidang-keahlian.edit', $item->id) }}"
                                       class="px-3 py-1 bg-blue-300 hover:bg-blue-400 text-blue-800 rounded">
                                        Edit
                                    </a>

                                    <form action="{{ route('bidang-keahlian.destroy', $item->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus bidang keahlian ini?')">
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
                            <td colspan="4" class="p-6 text-center text-gray-500 border border-gray-200">
                                Belum ada data bidang keahlian.
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