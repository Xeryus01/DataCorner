@extends('jadwal.layout')
@section('content')

<div class="w-full p-6 bg-gray-100">
    <div class="w-full bg-white rounded-lg shadow-md overflow-hidden">

        <div class="bg-blue-400 p-4">
            <h2 class="text-xl font-bold text-blue-800">Data Janji Temu</h2>
        </div>

        <div class="mb-6 overflow-x-auto p-4">
            <table class="min-w-[1300px] w-full border-collapse text-sm text-left">
                <thead>
                    <tr class="bg-blue-300 text-blue-900">
                        <th class="p-3 border border-blue-400 text-center">Nama User</th>
                        <th class="p-3 border border-blue-400 text-center">No HP</th>
                        <th class="p-3 border border-blue-400 text-center">Instansi/Lembaga</th>
                        <th class="p-3 border border-blue-400 text-center">Layanan</th>
                        <th class="p-3 border border-blue-400 text-center">Keperluan Data</th>
                        <th class="p-3 border border-blue-400 text-center">Data Diminta</th>
                        <th class="p-3 border border-blue-400 text-center">Tanggal & Jam</th>
                        <th class="p-3 border border-blue-400 text-center">Jenis</th>
                        <th class="p-3 border border-blue-400 text-center">Jumlah Orang</th>
                        <th class="p-3 border border-blue-400 text-center">Status</th>
                        <th class="p-3 border border-blue-400 text-center">Alasan Pembatalan</th>
                        <th class="p-3 border border-blue-400 text-center">Zoom</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($jadwals as $item)
                        @php
                            $janji = $item->janjitemu;

                            $layananList = $janji && $janji->layanan_dibutuhkan
                                ? explode(', ', $janji->layanan_dibutuhkan)
                                : [];

                            $keperluanList = $janji && $janji->keperluan_data
                                ? explode(', ', $janji->keperluan_data)
                                : [];

                            $status = $janji->status ?? 'menunggu';
                        @endphp

                        <tr class="bg-white hover:bg-gray-50 text-center">

                            {{-- Nama User --}}
                            <td class="p-3 border text-left align-top">
                                <div class="font-semibold text-gray-800">
                                    {{ $janji->user->nama ?? '-' }}
                                </div>

                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $janji->user->email ?? '-' }}
                                </div>
                            </td>

                            {{-- No HP --}}
                            <td class="p-3 border align-top">
                                {{ $janji->user->no_hp ?? '-' }}
                            </td>

                            {{-- Instansi --}}
                            <td class="p-3 border text-left align-top">
                                <div class="font-semibold text-gray-800 line-clamp-2">
                                    {{ $janji->instansi_lembaga ?? '-' }}
                                </div>
                            </td>

                            {{-- Layanan --}}
                            <td class="p-3 border text-left align-top">
                                @if(count($layananList))
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($layananList as $layanan)
                                            <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-[10px] font-semibold">
                                                {{ $layanan }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                            {{-- Keperluan Data --}}
                            <td class="p-3 border text-left align-top">
                                @if(count($keperluanList))
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($keperluanList as $keperluan)
                                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-[10px] font-semibold">
                                                {{ $keperluan }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                            {{-- Data Diminta --}}
                            <td class="p-3 border text-left align-top">
                                <div class="w-56 line-clamp-3 text-gray-700">
                                    {{ $janji->data_diminta ?? '-' }}
                                </div>
                            </td>

                            {{-- Tanggal & Jam --}}
                            <td class="p-3 border align-top">
                                @if($janji && $janji->tanggal && $janji->jam)
                                    <div class="font-semibold text-gray-800">
                                        {{ \Carbon\Carbon::parse($janji->tanggal)->locale('id')->isoFormat('D MMMM Y') }}
                                    </div>

                                    <div class="text-xs text-gray-500 mt-1">
                                        Pukul {{ \Carbon\Carbon::parse($janji->jam)->format('H:i') }} WIB
                                    </div>
                                @else
                                    <span class="italic text-gray-500">Belum diatur</span>
                                @endif
                            </td>

                            {{-- Jenis --}}
                            <td class="p-3 border align-top">
                                <span class="px-2 py-1 rounded text-xs font-semibold
                                    {{ ($janji->jenis ?? '') === 'online' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ ucfirst($janji->jenis ?? '-') }}
                                </span>
                            </td>

                            {{-- Jumlah Orang --}}
                            <td class="p-3 border align-top">
                                {{ $janji->jumlah_orang ?? 1 }} orang
                            </td>

                            {{-- Status --}}
                            <td class="p-3 border align-top">
                                <span class="px-2 py-1 rounded text-xs font-semibold
                                    {{ $status === 'menunggu' ? 'bg-yellow-100 text-yellow-700' : 
                                       ($status === 'diterima' ? 'bg-green-100 text-green-700' : 
                                       ($status === 'batal' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700')) }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>

                            {{-- Alasan Pembatalan --}}
                            <td class="p-3 border text-left align-top">
                                @if($status === 'batal' && $janji->alasan_batal)
                                    <div class="bg-red-50 border border-red-100 text-red-700 rounded-lg p-2 text-xs leading-relaxed">
                                        {{ $janji->alasan_batal }}
                                    </div>
                                @elseif($status === 'batal')
                                    <span class="text-gray-400 italic text-xs">
                                        Tidak ada alasan.
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                            {{-- Zoom --}}
                            <td class="p-3 border align-top">
                                @if(($janji->jenis ?? '') === 'online' && $janji->zoom_link)
                                    <a href="{{ $janji->zoom_link }}"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       class="inline-block px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded text-xs font-semibold">
                                        Buka Zoom
                                    </a>
                                @elseif(($janji->jenis ?? '') === 'online')
                                    <span class="text-gray-400">Belum ada link</span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center p-4 text-xl text-gray-500">
                                Belum ada jadwal tersedia.
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