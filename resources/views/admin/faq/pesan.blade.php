@extends('admin.layout')

@section('content')
<div class="w-full p-6 bg-gray-100">
    <div class="w-full bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-blue-400 p-4">
            <h2 class="text-xl font-bold text-blue-800">Pesan Masuk Dari WA</h2>
        </div>

        <div class="p-6 link-container overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-blue-300">
                        <th class="p-3 text-left text-blue-800 border border-blue-400">No</th>
                        <th class="p-3 text-left text-blue-800 border border-blue-400">Tanggal</th>
                        <th class="p-3 text-left text-blue-800 border border-blue-400">Nama</th>
                        <th class="p-3 text-left text-blue-800 border border-blue-400">Nomor WA</th>
                        <th class="p-3 text-left text-blue-800 border border-blue-400">Instansi</th>
                        <th class="p-3 text-left text-blue-800 border border-blue-400">Data Yang Diminta</th>
                        <th class="p-3 text-left text-blue-800 border border-blue-400">Keperluan Penggunaan Data</th>
                        <th class="p-3 text-left text-blue-800 border border-blue-400">Memiliki Akun PST</th>
                        <th class="p-3 text-left text-blue-800 border border-blue-400">Posisi Sebagai</th>
                        <th class="p-3 text-left text-blue-800 border border-blue-400">Aksi</th>
                    </tr>
                </thead>

                <tbody id="layanan-body">
                    @forelse ($faq as $index => $item)
                        <tr class="hover:bg-gray-50 layanan-item-row">
                            <td class="p-3 border border-gray-200 text-center">
                                {{ $index + 1 }}
                            </td>

                            <td class="p-3 border border-gray-200">
                                {{ \Carbon\Carbon::parse($item->clicked_at)->locale('id')->isoFormat('D MMMM Y, HH:mm') }}
                            </td>

                            <td class="p-3 border border-gray-200">
                                {{ $item->user->nama ?? '-' }}
                            </td>

                            <td class="p-3 border border-gray-200">
                                {{ $item->user->no_hp ?? '-' }}
                            </td>

                            <td class="p-3 border border-gray-200">
                                {{ $item->instansi }}
                            </td>

                            <td class="p-3 border border-gray-200">
                                <div class="w-64 line-clamp-2 overflow-hidden text-ellipsis">
                                    {{ $item->data_diminta }}
                                </div>
                            </td>

                            <td class="p-3 border border-gray-200">
                                <div class="w-64 line-clamp-2 overflow-hidden text-ellipsis">
                                    {{ $item->keperluan_data ?? '-' }}
                                </div>
                            </td>

                            <td class="p-3 border border-gray-200">
                                {{ ucfirst($item->memiliki_akun ?? '-') }}
                            </td>

                            <td class="p-3 border border-gray-200">
                                @php
                                    $labelPosisi = [
                                        'asn' => 'ASN',
                                        'karyawan_swasta' => 'Karyawan Swasta',
                                        'wiraswasta' => 'Wiraswasta',
                                        'peneliti' => 'Peneliti',
                                        'pelajar_mahasiswa' => 'Pelajar/Mahasiswa',
                                        'lainnya' => 'Lainnya',
                                    ];
                                @endphp

                                {{ $labelPosisi[$item->posisi] ?? $item->posisi }}
                            </td>

                            <td class="p-3 border border-gray-200">
                                <div class="flex space-x-2">
                                    <form action="{{ route('faq.hapusPesan', $item->id) }}" method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')">
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
                            <td colspan="10" class="p-6 text-center text-gray-500 border border-gray-200">
                                Belum ada pesan konsultasi masuk.
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