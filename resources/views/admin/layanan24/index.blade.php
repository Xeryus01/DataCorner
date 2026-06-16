@extends('admin.layout')
@section('content')

<div class="w-full p-6 bg-gray-100">
    <div class="w-full bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-blue-400 p-4">
            <h2 class="text-xl font-bold text-blue-800">Data Layanan 24 Jam</h2>
        </div>

        <div class="p-6">
                <a href="{{ route('layanan.create') }}" class="px-4 py-2 bg-blue-300 hover:bg-blue-400 text-blue-800 rounded">Tambah Data</a>
        </div>

            <div class="p-6 link-container">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-blue-300">
                            <th class="p-3 text-center text-blue-800 border border-blue-400">No</th>
                            <th class="p-3 text-center text-blue-800 border border-blue-400">Gambar</th>
                            <th class="p-3 text-center text-blue-800 border border-blue-400">Judul</th>
                            <th class="p-3 text-center text-blue-800 border border-blue-400">Deskripsi</th>
                            <th class="p-3 text-center text-blue-800 border border-blue-400">Link</th>
                            <th class="p-3 text-center text-blue-800 border border-blue-400">Aksi</th>
                        </tr>
                    </thead>

                    <tbody id="layanan-body">
                        @foreach ($layanan as $index => $item)
                        <tr class="layanan-item-row hover:bg-gray-50">
                            <td class="p-3 border border-gray-200 text-center">{{ $index + 1 }}</td>
                            <td class="p-3 border text-center align-middle border-gray-200">
                                <a href="{{ Storage::url($item->gambar) }}" target="_blank" class="px-4 py-2 inline-block bg-blue-300 hover:bg-blue-400 text-blue-800 font-medium rounded-lg">
                                    Lihat File
                                </a>
                            </td>
                            
                            <td class="p-3 border border-gray-200">
                                <div class="w-40 line-clamp-2">{{ $item->judul }}</div>
                            </td>
                            <td class="p-3 border border-gray-200">
                                <div class="w-64 line-clamp-2 overflow-hidden text-ellipsis">{{ $item->deskripsi }}</div>
                            </td>
                            <td class="p-3 border border-gray-200">
                                <div class="w-64 line-clamp-2 overflow-hidden text-ellipsis">{{ $item->link }}</div>
                            </td>
                            <td class="p-3 border border-gray-200">
                                <div class="flex space-x-2">
                                    <a href="{{ route('layanan.edit', $item->id) }}" class="px-3 py-1 bg-blue-300 hover:bg-blue-400 text-blue-800 rounded">Edit</a>

                                    <form action="{{ route('layanan.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-300 hover:bg-red-400 text-red-800 rounded">Hapus</button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination controls -->
                <div id="pagination-controls" class="flex justify-center mt-6 space-x-2"></div>
            </div>
    </div>
</div>
@endsection
