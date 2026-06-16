@extends('admin.layout')
@section('content')

<div class="w-full p-6 bg-gray-100">    
    <div class="w-full bg-white rounded-lg shadow-md overflow-hidden">

        <div class="bg-blue-500 p-4">
            <h2 class="text-xl font-bold text-white">Data Janji Temu</h2>
        </div>
        
        <div class="p-4 overflow-x-auto">
            <table class="min-w-[1200px] w-full border-collapse text-sm text-left">
                <thead>
                    <tr class="bg-blue-200 text-blue-800">
                        <th class="p-3 border border-blue-300 text-center w-[4%]">No</th>
                        <th class="p-3 border border-blue-300 text-left w-[18%]">Pengguna</th>
                        <th class="p-3 border border-blue-300 text-left w-[18%]">Instansi</th>
                        <th class="p-3 border border-blue-300 text-center w-[13%]">Jadwal</th>
                        <th class="p-3 border border-blue-300 text-center w-[8%]">Jenis</th>
                        <th class="p-3 border border-blue-300 text-center w-[9%]">Status</th>
                        <th class="p-3 border border-blue-300 text-center w-[8%]">Detail</th>
                        <th class="p-3 border border-blue-300 text-center w-[16%]">Penjadwalan</th>
                        <th class="p-3 border border-blue-300 text-center w-[10%]">Zoom</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($janjiTemu as $index => $item)
                        @php
                            $layananList = $item->layanan_dibutuhkan
                                ? explode(', ', $item->layanan_dibutuhkan)
                                : [];

                            $keperluanText = $item->keperluan_data ?? $item->keperluan ?? null;

                            $keperluanList = $keperluanText
                                ? explode(', ', $keperluanText)
                                : [];

                            $statusClass = $item->status == 'menunggu'
                                ? 'bg-yellow-100 text-yellow-700'
                                : ($item->status == 'diterima'
                                    ? 'bg-green-100 text-green-700'
                                    : 'bg-red-100 text-red-700');

                            $jenisClass = $item->jenis == 'online'
                                ? 'bg-green-100 text-green-700'
                                : 'bg-blue-100 text-blue-700';
                        @endphp

                        <tr class="bg-white hover:bg-blue-50/40 text-center layanan-item-row align-top">
                            <td class="p-3 border text-gray-500 font-semibold">
                                {{ $janjiTemu->firstItem() + $loop->index }}
                            </td>

                            {{-- Pengguna --}}
                            <td class="p-3 border text-left">
                                <div class="font-bold text-gray-800 leading-tight">
                                    {{ $item->user->nama ?? '-' }}
                                </div>

                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $item->user->no_hp ?? '-' }}
                                </div>
                            </td>

                            {{-- Instansi --}}
                            <td class="p-3 border text-left">
                                <div class="font-semibold text-gray-800 line-clamp-2">
                                    {{ $item->instansi_lembaga ?? '-' }}
                                </div>

                                <div class="text-xs text-gray-500 mt-1 truncate max-w-[220px]">
                                    {{ $item->user->email ?? '-' }}
                                </div>

                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $item->jumlah_orang ?? 1 }} orang
                                </div>
                            </td>

                            {{-- Jadwal --}}
                            <td class="p-3 border">
                                @if($item->tanggal && $item->jam)
                                    <div class="font-bold text-gray-800">
                                        {{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('D MMM Y') }}
                                    </div>

                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ \Carbon\Carbon::parse($item->jam)->format('H:i') }} WIB
                                    </div>
                                @else
                                    <span class="inline-flex px-2 py-1 bg-gray-100 text-gray-500 rounded-lg text-xs font-semibold italic">
                                        Belum diatur
                                    </span>
                                @endif
                            </td>

                            {{-- Jenis --}}
                            <td class="p-3 border">
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $jenisClass }}">
                                    {{ ucfirst($item->jenis ?? '-') }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td class="p-3 border">
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $statusClass }}">
                                    {{ ucfirst($item->status ?? '-') }}
                                </span>
                            </td>

                            {{-- Detail --}}
                            <td class="p-3 border">
                                <button type="button"
                                        onclick="document.getElementById('detail-janji-{{ $item->id }}').showModal()"
                                        class="px-3 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg text-xs font-bold transition">
                                    Detail
                                </button>

                                <dialog id="detail-janji-{{ $item->id }}" class="rounded-2xl w-full max-w-xl p-0 backdrop:bg-black/40">
                                    <div class="bg-white rounded-2xl overflow-hidden text-left">

                                        {{-- Header compact --}}
                                        <div class="bg-blue-600 px-4 py-3 text-white flex items-start justify-between gap-4">
                                            <div class="min-w-0">
                                                <p class="text-[10px] font-bold uppercase tracking-widest text-blue-100">
                                                    Detail Janji Temu
                                                </p>

                                                <h3 class="text-base font-black mt-1 truncate">
                                                    {{ $item->user->nama ?? '-' }}
                                                </h3>

                                                <p class="text-xs text-blue-100 mt-1 truncate">
                                                    {{ $item->instansi_lembaga ?? '-' }}
                                                </p>
                                            </div>

                                            <form method="dialog">
                                                <button class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 text-white font-bold">
                                                    ×
                                                </button>
                                            </form>
                                        </div>

                                        {{-- Body compact --}}
                                        <div class="p-4 space-y-3">

                                            {{-- Info utama --}}
                                            <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                <div class="bg-gray-50 px-3 py-2 rounded-xl">
                                                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-wider">
                                                        Jenis
                                                    </p>
                                                    <span class="inline-flex mt-1 px-2 py-0.5 rounded-full text-[10px] font-bold {{ $jenisClass }}">
                                                        {{ ucfirst($item->jenis ?? '-') }}
                                                    </span>
                                                </div>

                                                <div class="bg-gray-50 px-3 py-2 rounded-xl">
                                                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-wider">
                                                        Status
                                                    </p>
                                                    <span class="inline-flex mt-1 px-2 py-0.5 rounded-full text-[10px] font-bold {{ $statusClass }}">
                                                        {{ ucfirst($item->status ?? '-') }}
                                                    </span>
                                                </div>

                                                <div class="bg-gray-50 px-3 py-2 rounded-xl">
                                                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-wider">
                                                        Orang
                                                    </p>
                                                    <p class="text-xs font-black text-gray-800 mt-1">
                                                        {{ $item->jumlah_orang ?? 1 }} orang
                                                    </p>
                                                </div>

                                                <div class="bg-gray-50 px-3 py-2 rounded-xl">
                                                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-wider">
                                                        Jadwal
                                                    </p>

                                                    @if($item->tanggal && $item->jam)
                                                        <p class="text-xs font-black text-gray-800 mt-1">
                                                            {{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('D MMM Y') }}
                                                        </p>
                                                        <p class="text-[11px] text-gray-500">
                                                            {{ \Carbon\Carbon::parse($item->jam)->format('H:i') }} WIB
                                                        </p>
                                                    @else
                                                        <p class="text-xs text-gray-400 italic mt-1">
                                                            Belum diatur
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Layanan & Keperluan compact --}}
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                                <div class="bg-blue-50 px-3 py-2 rounded-xl">
                                                    <p class="text-[9px] font-black text-blue-700 uppercase tracking-wider mb-1">
                                                        Layanan Dibutuhkan
                                                    </p>

                                                    @if(count($layananList))
                                                        <div class="flex flex-wrap gap-1">
                                                            @foreach($layananList as $layanan)
                                                                <span class="px-2 py-0.5 bg-white text-blue-700 rounded-md text-[10px] font-semibold">
                                                                    {{ $layanan }}
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <span class="text-xs text-gray-400">-</span>
                                                    @endif
                                                </div>

                                                <div class="bg-green-50 px-3 py-2 rounded-xl">
                                                    <p class="text-[9px] font-black text-green-700 uppercase tracking-wider mb-1">
                                                        Keperluan Data
                                                    </p>

                                                    @if(count($keperluanList))
                                                        <div class="flex flex-wrap gap-1">
                                                            @foreach($keperluanList as $keperluan)
                                                                <span class="px-2 py-0.5 bg-white text-green-700 rounded-md text-[10px] font-semibold">
                                                                    {{ $keperluan }}
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <span class="text-xs text-gray-400">-</span>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Data yang diminta --}}
                                            <div class="bg-gray-50 px-3 py-2 rounded-xl">
                                                <p class="text-[9px] font-black text-gray-500 uppercase tracking-wider mb-1">
                                                    Data yang Diminta
                                                </p>

                                                <p class="text-xs text-gray-700 leading-relaxed max-h-20 overflow-y-auto">
                                                    {{ $item->data_diminta ?? '-' }}
                                                </p>
                                            </div>

                                            {{-- Alasan pembatalan --}}
                                            @if($item->alasan_batal)
                                                <div class="bg-red-50 border border-red-100 px-3 py-2 rounded-xl">
                                                    <p class="text-[9px] font-black text-red-700 uppercase tracking-wider mb-1">
                                                        Alasan Pembatalan
                                                    </p>

                                                    <p class="text-xs text-red-700 leading-relaxed max-h-20 overflow-y-auto">
                                                        {{ $item->alasan_batal }}
                                                    </p>
                                                </div>
                                            @elseif($item->status === 'batal')
                                                <div class="bg-red-50 border border-red-100 px-3 py-2 rounded-xl">
                                                    <p class="text-[9px] font-black text-red-700 uppercase tracking-wider mb-1">
                                                        Alasan Pembatalan
                                                    </p>

                                                    <p class="text-xs text-red-500 italic">
                                                        Janji temu dibatalkan, tetapi alasan tidak tersedia.
                                                    </p>
                                                </div>
                                            @endif

                                            {{-- Link Zoom --}}
                                            @if($item->zoom_link)
                                                <div class="bg-indigo-50 px-3 py-2 rounded-xl">
                                                    <p class="text-[9px] font-black text-indigo-700 uppercase tracking-wider mb-1">
                                                        Link Zoom
                                                    </p>

                                                    <a href="{{ $item->zoom_link }}"
                                                    target="_blank"
                                                    class="inline-flex items-center px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-bold">
                                                        Buka Link Zoom
                                                    </a>

                                                    <p class="text-[11px] text-indigo-700 mt-1 break-all">
                                                        {{ $item->zoom_link }}
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </dialog>
                            </td>

                            {{-- KOLOM AKSI & PENJADWALAN --}}
                            <td class="p-3 border align-top">
                                @if($item->status === 'menunggu')
                                    <form action="{{ route('jadwal.schedule', $item->id) }}" method="POST" class="mb-2">
                                        @csrf

                                        <div class="grid grid-cols-1 gap-2">
                                            <select name="konsultan_id" class="border border-gray-300 rounded-lg p-2 text-xs w-full" required>
                                                <option value="">Pilih Konsultan</option>
                                                @foreach ($konsultans as $konsultan)
                                                    <option value="{{ $konsultan->id }}">{{ $konsultan->nama }}</option>
                                                @endforeach
                                            </select>

                                            <div class="grid grid-cols-1">
                                                <input type="date"
                                                    name="tanggal"
                                                    class="border border-gray-300 rounded-lg p-2 text-xs w-full"
                                                    value="{{ now()->format('Y-m-d') }}"
                                                    required>

                                                <input type="time"
                                                    name="jam"
                                                    class="border border-gray-300 rounded-lg p-2 text-xs w-full"
                                                    value="{{ now()->format('H:i') }}"
                                                    required>
                                            </div>

                                            <button type="submit"
                                                    class="bg-blue-600 text-white px-3 py-2 rounded-lg text-xs font-bold w-full hover:bg-blue-700">
                                                Jadwalkan & Terima
                                            </button>
                                        </div>
                                    </form>

                                    <form action="{{ route('jadwal.tolak', $item->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Anda yakin ingin menolak janji temu ini?')">
                                        @csrf

                                        <button type="submit"
                                                class="w-full px-3 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg text-xs font-bold">
                                            Tolak
                                        </button>
                                    </form>
                                @else
                                    <div class="flex flex-col items-center gap-2 text-sm">
                                        <div class="text-xs text-gray-600">
                                            Konsultan:
                                            <br>
                                            <strong class="font-bold text-gray-800">
                                                {{ $item->jadwal->konsultan->nama ?? 'N/A' }}
                                            </strong>
                                        </div>

                                        @if($item->jadwal && $item->status == 'diterima')
                                            <form action="{{ route('jadwal.batal', $item->jadwal->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Anda yakin ingin membatalkan jadwal ini? Status akan kembali ke Menunggu.')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="w-full px-3 py-1.5 bg-yellow-400 hover:bg-yellow-500 text-yellow-900 rounded-lg text-xs font-bold">
                                                    Batalkan Jadwal
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('jadwal.destroy', $item->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('PERHATIAN: Anda akan MENGHAPUS janji temu ini selamanya. Lanjutkan?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="w-full px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-lg text-xs font-bold">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </td>

                            {{-- Zoom --}}
                            <td class="p-3 border align-middle">
                                @if($item->jenis === 'online' && $item->status === 'diterima')
                                    @if($item->zoom_link)
                                        <a href="{{ $item->zoom_link }}"
                                        target="_blank"
                                        class="block bg-green-600 text-white px-3 py-1.5 rounded text-xs hover:bg-green-700 font-semibold">
                                            Lihat Link
                                        </a>

                                        <a href="{{ route('jadwal.zoom', $item->id) }}"
                                        class="block mt-2 bg-indigo-600 text-white px-3 py-1.5 rounded text-xs hover:bg-indigo-700 font-semibold">
                                            Ubah / Kirim Ulang
                                        </a>
                                    @else
                                        <a href="{{ route('jadwal.zoom', $item->id) }}"
                                        class="bg-indigo-600 text-white px-3 py-1.5 rounded text-xs block hover:bg-indigo-700 font-semibold">
                                            Kirim Link
                                        </a>
                                    @endif
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="px-5 py-4 border-t border-slate-100">
                {{ $janjiTemu->links() }}
            </div>
        </div>

    </div>
</div>

@endsection
