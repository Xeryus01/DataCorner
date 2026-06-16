@extends('admin.layout')

@section('content')

<div class="w-full p-6 bg-gray-100 min-h-screen">

    <div class="w-full bg-white rounded-lg shadow-md overflow-hidden">

        {{-- Header --}}
        <div class="bg-blue-300 p-4 flex items-center justify-between">

            <h2 class="text-xl font-bold text-blue-800">
                Data Statistik Perpustakaan
            </h2>

            <a href="{{ route('statistik.perpustakaan.create') }}"
               class="px-4 py-2 bg-white hover:bg-gray-100 text-blue-800 font-medium rounded-lg shadow">

                + Tambah Data

            </a>

        </div>
        
        {{-- Table --}}
        <div class="p-6 overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-blue-200 text-xs uppercase tracking-wide">

                        <th class="p-2 border border-blue-300 text-blue-800 text-center">
                            No
                        </th>

                        <th class="p-2 border border-blue-300 text-blue-800 text-left">
                            Periode
                        </th>

                        <th class="p-2 border border-blue-300 text-blue-800 text-center">
                            Pengunjung Unik
                        </th>

                        <th class="p-2 border border-blue-300 text-blue-800 text-center">
                            Kunjungan
                        </th>

                        <th class="p-2 border border-blue-300 text-blue-800 text-center">
                            Rata-rata Harian
                        </th>

                        <th class="p-2 border border-blue-300 text-blue-800 text-center">
                            Layanan Tercetak
                        </th>

                        <th class="p-2 border border-blue-300 text-blue-800 text-center">
                            Digilib Online
                        </th>

                        <th class="p-2 border border-blue-300 text-blue-800 text-center">
                            Jumlah
                        </th>

                        <th class="p-2 border border-blue-300 text-blue-800 text-center">
                            Aksi
                        </th>

                    </tr>
                </thead>

                <tbody>
                    @forelse ($data as $index => $item)

                    @php
                        $periode = \Carbon\Carbon::createFromFormat('Y-m', $item->periode);
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="p-3 border border-gray-200 text-center">{{ $index + 1 }}</td>
                        <td class="p-3 border border-gray-200">{{ $periode->translatedFormat('F Y') }}</td>
                        <td class="p-3 border border-gray-200 text-center">{{ number_format($item->pengunjung_unik) }}</td>
                        <td class="p-3 border border-gray-200 text-center">{{ number_format($item->kunjungan) }}</td>
                        <td class="p-3 border border-gray-200 text-center">{{ number_format($item->rata_harian) }}</td>
                        <td class="p-3 border border-gray-200 text-center">{{ number_format($item->layanan_tercetak) }}</td>
                        <td class="p-3 border border-gray-200 text-center">{{ number_format($item->digilib_online) }}</td>
                        <td class="p-3 border border-gray-200 text-center font-bold text-blue-700">{{ number_format($item->jumlah) }}</td>

                        <td class="p-3 border border-gray-200">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('statistik.perpustakaan.edit', $item->id) }}"
                                    class="px-3 py-1 bg-yellow-300 hover:bg-yellow-400 text-yellow-800 rounded text-sm">
                                    Edit
                                </a>

                                <form action="{{ route('statistik.perpustakaan.destroy', $item->id) }}"
                                    method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-300 hover:bg-red-400 text-red-800 rounded text-sm">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty

                    <tr>
                        <td colspan="9"
                            class="p-6 border border-gray-200 text-center text-gray-500">
                            Belum ada data statistik perpustakaan.
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>
            <div class="mt-6 flex justify-center">
                {{ $data->links() }}
            </div>
        </div>

    </div>

</div>

@endsection