@extends('admin.layout')
@section('content')

<div class="w-full p-6 bg-gray-100">
    <div class="w-full bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-blue-400 p-4">
            <h2 class="text-xl font-bold text-blue-800">Data Jam Operasional</h2>
        </div>

        <div class="p-6">
                <a href="{{ route('jam-operasional.create') }}" class="px-4 py-2 bg-blue-300 hover:bg-blue-400 text-blue-800 rounded">Tambah Data</a>
        </div>

            <div class="p-6 link-container">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-blue-300">
                            <th class="p-3 text-center text-blue-800 border border-blue-400">No</th>
                            <th class="p-3 text-center text-blue-800 border border-blue-400">Keterangan Hari</th>
                            <th class="p-3 text-center text-blue-800 border border-blue-400">Jam Mulai</th>
                            <th class="p-3 text-center text-blue-800 border border-blue-400">Jam Selesai</th>
                            <th class="p-3 text-center text-blue-800 border border-blue-400">Aksi</th>
                        </tr>
                    </thead>

                    <tbody id="layanan-body">
                        @forelse ($jamOperasionals as $jam)
                        <tr class="layanan-item-row hover:bg-gray-50">
                            <td class="p-3 border border-gray-200 text-center">{{ $loop->iteration }}</td>

                            <td class="p-3 border border-gray-200">
                                <div class="w-40 line-clamp-2">{{ $jam->keterangan_hari }}</div>
                            </td>
                            <td class="p-3 border border-gray-200">
                                <div class="w-64 line-clamp-2 overflow-hidden text-ellipsis">{{ \Carbon\Carbon::parse($jam->jam_mulai)->format('H:i') }} WIB</div>
                            </td>
                            <td class="p-3 border border-gray-200">
                                <div class="w-64 line-clamp-2 overflow-hidden text-ellipsis">{{ \Carbon\Carbon::parse($jam->jam_selesai)->format('H:i') }} WIB</div>
                            </td>
                            <td class="p-3 border border-gray-200">
                                <div class="flex space-x-2">
                                    <a href="{{ route('jam-operasional.edit', $jam->id) }}" class="px-3 py-1 bg-blue-300 hover:bg-blue-400 text-blue-800 rounded">Edit</a>

                                    <form action="{{ route('jam-operasional.destroy', $jam->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-300 hover:bg-red-400 text-red-800 rounded">Hapus</button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        @empty
                    <tr>
                        <td colspan="5" class="text-center py-10 text-slate-500">
                            Belum ada data jam operasional.
                        </td>
                    </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination controls -->
                <div id="pagination-controls" class="flex justify-center mt-6 space-x-2"></div>
            </div>
    </div>
</div>
@endsection
