@extends('admin.layout')

@section('content')
<div class="w-full p-6 bg-gray-100">
    <div class="w-full bg-white rounded-lg shadow-md overflow-hidden">

        <div class="bg-blue-400 p-4">
            <h2 class="text-xl font-bold text-blue-800">Data Footer Website</h2>
            <p class="text-sm text-blue-900 mt-1">
                Kelola link, PDF, dan gambar yang tampil pada bagian footer website.
            </p>
        </div>

        @if(session('success'))
            <div class="mx-6 mt-6 p-3 bg-green-100 border border-green-300 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="p-6">
            <a href="{{ route('footer-item.create') }}"
               class="px-4 py-2 bg-blue-300 hover:bg-blue-400 text-blue-800 rounded font-semibold">
                Tambah Data
            </a>
        </div>

        <div class="p-6 pt-0 link-container">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-blue-300">
                        <th class="p-3 text-left text-blue-800 border border-blue-400">No</th>
                        <th class="p-3 text-left text-blue-800 border border-blue-400">Section</th>
                        <th class="p-3 text-left text-blue-800 border border-blue-400">Judul</th>
                        <th class="p-3 text-left text-blue-800 border border-blue-400">Tipe</th>
                        <th class="p-3 text-left text-blue-800 border border-blue-400">URL / File</th>
                        <th class="p-3 text-left text-blue-800 border border-blue-400">Urutan</th>
                        <th class="p-3 text-left text-blue-800 border border-blue-400">Status</th>
                        <th class="p-3 text-left text-blue-800 border border-blue-400">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($footerItems as $index => $item)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 border border-gray-200 text-center">
                                {{ $index + 1 }}
                            </td>

                            <td class="p-3 border border-gray-200">
                                @if($item->section == 'tentang_kami')
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-semibold">
                                        Tentang Kami
                                    </span>
                                @elseif($item->section == 'magang')
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-semibold">
                                        Magang
                                    </span>
                                @elseif($item->section == 'akademi_statistik')
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-semibold">
                                        Akademi Statistik
                                    </span>
                                @elseif($item->section == 'kontak_kami')
                                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-semibold">
                                        Kontak Kami 
                                    </span>
                                @else
                                    <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs font-semibold">
                                        {{ $item->section }}
                                    </span>
                                @endif
                            </td>

                            <td class="p-3 border border-gray-200">
                                <span class="font-semibold text-gray-800">
                                    {{ $item->title }}
                                </span>
                            </td>

                            <td class="p-3 border border-gray-200">
                                @if($item->type == 'link')
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-semibold">
                                        Link
                                    </span>
                                @elseif($item->type == 'pdf')
                                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-semibold">
                                        PDF
                                    </span>
                                @elseif($item->type == 'image')
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-semibold">
                                        Gambar
                                    </span>
                                @endif
                            </td>

                            <td class="p-3 border border-gray-200">
                                @if($item->type == 'link' && $item->url)
                                    <a href="{{ $item->url }}"
                                       target="_blank"
                                       class="text-blue-600 hover:underline text-sm">
                                        Lihat Link
                                    </a>
                                @elseif($item->file_path)
                                    <a href="{{ \Illuminate\Support\Facades\Storage::url($item->file_path) }}"
                                       target="_blank"
                                       class="text-blue-600 hover:underline text-sm">
                                        Lihat File
                                    </a>
                                @else
                                    <span class="text-gray-400 text-sm">Belum ada</span>
                                @endif
                            </td>

                            <td class="p-3 border border-gray-200 text-center">
                                {{ $item->sort_order }}
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
                                    <a href="{{ route('footer-item.edit', $item->id) }}"
                                       class="px-3 py-1 bg-blue-300 hover:bg-blue-400 text-blue-800 rounded">
                                        Edit
                                    </a>

                                    <form action="{{ route('footer-item.destroy', $item->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus data footer ini?')">
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
                            <td colspan="8" class="p-5 border border-gray-200 text-center text-gray-500">
                                Belum ada data footer.
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