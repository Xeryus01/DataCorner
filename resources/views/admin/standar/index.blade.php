@extends('admin.layout')
@section('content')
<div class="w-full p-6 bg-gray-100 ">
    <div class="w-full bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-blue-400 p-4">
            <h2 class="text-xl font-bold text-blue-800">Data Standar Layanan</h2>
        </div>

         <div class="p-6">
                <a href="{{ route('standar.create') }}" class="px-4 py-2 bg-blue-300 hover:bg-blue-400 text-blue-800 rounded">Tambah Data</a>
            </div>

            <div class="p-6 link-container">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-blue-300">
                            <th class="p-3 text-left text-blue-800 border border-blue-400">No</th>
                            <th class="p-3 text-left text-blue-800 border border-blue-400">Judul</th>
                            <th class="p-3 text-left text-blue-800 border border-blue-400">Gambar</th>
                            <th class="p-3 text-left text-blue-800 border border-blue-400">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($standar as  $index => $item)

                        <tr class="hover:bg-gray-50 layanan-item-row">
                            <td class="p-3 border border-gray-200 text-center">
                            {{ $index + 1 }}
                        </td>

                            <td class="p-3 border border-gray-200">
                                {{ $item->judul }}
                            </td>

                            <td class="p-3 border border-gray-200">
                                <a href="{{ Storage::url($item->gambar) }}" target="_blank" class="px-6 py-2 bg-blue-300 hover:bg-blue-400 text-blue-800 font-medium rounded-lg">
                                    Lihat File
                                </a>
                            </td>

                                <td class="p-3 border border-gray-200">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('standar.edit', $item->id) }}" class="px-3 py-1 bg-blue-300 hover:bg-blue-400 text-blue-800 rounded">Edit</a>

                           <form action="{{ route('standar.destroy', $item->id) }}" method="POST">
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
                <div id="pagination-controls" class="flex justify-center mt-6 space-x-2"></div>
            </div>

        </form>
    </div>
</div>

<!-- Script untuk konfirmasi delete -->

@endsection
