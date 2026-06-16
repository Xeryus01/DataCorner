@extends('admin.layout')

@section('content')
<div class="w-full p-6 bg-gray-100">
    <div class="w-full bg-white rounded-lg shadow-md overflow-hidden">

        <div class="bg-blue-400 p-4">
            <h2 class="text-xl font-bold text-blue-800">Data Survei Layanan</h2>
            <p class="text-sm text-blue-900 mt-1">
                Kelola link survei layanan berdasarkan tahun.
            </p>
        </div>

        @if(session('success'))
            <div class="mx-6 mt-6 p-3 bg-green-100 border border-green-300 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="p-6">
            <a href="{{ route('survei-layanan.create') }}"
               class="px-4 py-2 bg-blue-300 hover:bg-blue-400 text-blue-800 rounded font-semibold">
                Tambah Data
            </a>
        </div>

        <div class="p-6 pt-0">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-blue-300">
                        <th class="p-3 text-left text-blue-800 border border-blue-400">No</th>
                        <th class="p-3 text-left text-blue-800 border border-blue-400">Tahun</th>
                        <th class="p-3 text-left text-blue-800 border border-blue-400">Link Survei</th>
                        <th class="p-3 text-left text-blue-800 border border-blue-400">Status</th>
                        <th class="p-3 text-left text-blue-800 border border-blue-400">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($surveiLayanan as $index => $item)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 border border-gray-200 text-center">
                                {{ $index + 1 }}
                            </td>

                            <td class="p-3 border border-gray-200">
                                <span class="font-semibold text-gray-800">
                                    {{ $item->tahun }}
                                </span>
                            </td>

                            <td class="p-3 border border-gray-200">
                                <a href="{{ $item->link }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="text-blue-600 hover:underline text-sm">
                                    {{ $item->link }}
                                </a>
                            </td>

                            <td class="p-3 border border-gray-200">
                                @if($item->is_active)
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-semibold">
                                        Aktif
                                    </span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-semibold">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>

                            <td class="p-3 border border-gray-200">
                                <div class="flex space-x-2">
                                    <a href="{{ route('survei-layanan.edit', $item->id) }}"
                                       class="px-3 py-1 bg-blue-300 hover:bg-blue-400 text-blue-800 rounded">
                                        Edit
                                    </a>

                                    <form action="{{ route('survei-layanan.destroy', $item->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus data survei ini?')">
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
                            <td colspan="5" class="p-5 border border-gray-200 text-center text-gray-500">
                                Belum ada data survei layanan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection