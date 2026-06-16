@extends('layout.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 px-4 py-6">

    <main class="w-full max-w-7xl mx-auto">

        @php
            $totalJadwal = method_exists($janjitemu, 'total') ? $janjitemu->total() : $janjitemu->count();
        @endphp

        {{-- Header compact --}}
        <div class="bg-white/90 backdrop-blur-xl rounded-3xl shadow-sm border border-white/70 p-5 mb-5">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-blue-600 mb-1">
                        Riwayat Janji Temu
                    </p>

                    <h1 class="text-2xl font-black text-slate-800">
                        Jadwal Janji Temu
                    </h1>

                    <p class="text-sm text-slate-500 mt-1">
                        Total {{ $totalJadwal }} pengajuan janji temu.
                    </p>
                </div>

                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('janjitemu.index') }}"
                       class="inline-flex items-center justify-center px-4 py-2.5 bg-primary hover:bg-blue-800 text-white rounded-2xl text-sm font-black transition">
                        + Buat Jadwal
                    </a>

                    <a href="{{ route('home') }}"
                       class="inline-flex items-center justify-center px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-2xl text-sm font-black transition">
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-2xl text-sm font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white/95 rounded-3xl shadow-sm border border-white/70 overflow-hidden">

            @if($janjitemu->count())
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[980px] text-sm">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100">
                                <th class="px-4 py-3 text-left text-[10px] font-black uppercase tracking-widest text-slate-500">No</th>
                                <th class="px-4 py-3 text-left text-[10px] font-black uppercase tracking-widest text-slate-500">Jadwal</th>
                                <th class="px-4 py-3 text-left text-[10px] font-black uppercase tracking-widest text-slate-500">Instansi</th>
                                <th class="px-4 py-3 text-left text-[10px] font-black uppercase tracking-widest text-slate-500">Jenis</th>
                                <th class="px-4 py-3 text-left text-[10px] font-black uppercase tracking-widest text-slate-500">Orang</th>
                                <th class="px-4 py-3 text-left text-[10px] font-black uppercase tracking-widest text-slate-500">Status</th>
                                <th class="px-4 py-3 text-left text-[10px] font-black uppercase tracking-widest text-slate-500">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @foreach($janjitemu as $item)
                                @php
                                    $status = strtolower($item->status ?? 'menunggu');

                                    $statusClass = [
                                        'menunggu' => 'bg-yellow-100 text-yellow-700',
                                        'diterima' => 'bg-green-100 text-green-700',
                                        'batal' => 'bg-slate-100 text-slate-600',
                                        'ditolak' => 'bg-red-100 text-red-700',
                                    ][$status] ?? 'bg-slate-100 text-slate-600';

                                    $jenisClass = ($item->jenis ?? '') === 'online'
                                        ? 'bg-green-50 text-green-700'
                                        : 'bg-blue-50 text-blue-700';

                                    $layananList = $item->layanan_dibutuhkan
                                        ? explode(', ', $item->layanan_dibutuhkan)
                                        : [];

                                    $keperluanList = $item->keperluan_data
                                        ? explode(', ', $item->keperluan_data)
                                        : [];
                                @endphp

                                <tr class="hover:bg-blue-50/40 transition">
                                    <td class="px-4 py-3 text-slate-400 font-bold">
                                        {{ method_exists($janjitemu, 'firstItem') ? $janjitemu->firstItem() + $loop->index : $loop->iteration }}
                                    </td>

                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <p class="font-black text-slate-800 text-sm">
                                            {{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('D MMM Y') : '-' }}
                                        </p>
                                        <p class="text-xs text-slate-500">
                                            {{ $item->jam ? \Carbon\Carbon::parse($item->jam)->format('H:i') : '-' }} WIB
                                        </p>
                                    </td>

                                    <td class="px-4 py-3">
                                        <p class="font-black text-slate-800 max-w-[220px] truncate">
                                            {{ $item->instansi_lembaga ?? '-' }}
                                        </p>
                                        <p class="text-xs text-slate-400 max-w-[220px] truncate">
                                            {{ $item->user->email ?? '-' }}
                                        </p>
                                    </td>

                                    <td class="px-4 py-3">
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase {{ $jenisClass }}">
                                            {{ ucfirst($item->jenis ?? '-') }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3 text-slate-700 font-bold whitespace-nowrap">
                                        {{ $item->jumlah_orang ?? 1 }}
                                    </td>

                                    <td class="px-4 py-3">
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase {{ $statusClass }}">
                                            {{ ucfirst($item->status ?? 'menunggu') }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <button type="button"
                                                    onclick="document.getElementById('detail-jadwal-{{ $item->id }}').showModal()"
                                                    class="px-3 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-xl text-xs font-black transition">
                                                Detail
                                            </button>

                                            @if($item->status === 'menunggu')
                                                <a href="{{ route('janjitemu.edit', $item->id) }}"
                                                   class="px-3 py-1.5 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-xl text-xs font-black transition">
                                                    Edit
                                                </a>
                                            @else
                                                <span class="px-3 py-1.5 bg-slate-100 text-slate-400 rounded-xl text-xs font-black">
                                                    Terkunci
                                                </span>
                                            @endif

                                            @if($item->status === 'menunggu' || $item->status === 'diterima')
                                                <button type="button"
                                                        onclick="document.getElementById('batal-jadwal-{{ $item->id }}').showModal()"
                                                        class="px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 rounded-xl text-xs font-black transition">
                                                    Batal
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                <!-- {{-- Modal Detail --}}
                                <dialog id="detail-jadwal-{{ $item->id }}"
                                        class="rounded-3xl w-full max-w-2xl p-0 backdrop:bg-slate-900/50">
                                    <div class="bg-white rounded-3xl overflow-hidden">
                                        <div class="bg-gradient-to-r from-primary to-blue-700 p-5 text-white">
                                            <div class="flex items-start justify-between gap-4">
                                                <div>
                                                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-blue-100">
                                                        Detail Janji Temu
                                                    </p>

                                                    <h2 class="text-xl font-black mt-1">
                                                        {{ $item->instansi_lembaga ?? '-' }}
                                                    </h2>

                                                    <p class="text-sm text-blue-100 mt-1">
                                                        {{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('D MMMM Y') : '-' }}
                                                        •
                                                        {{ $item->jam ? \Carbon\Carbon::parse($item->jam)->format('H:i') : '-' }} WIB
                                                    </p>
                                                </div>

                                                <form method="dialog">
                                                    <button class="w-9 h-9 rounded-full bg-white/15 hover:bg-white/25 flex items-center justify-center">
                                                        ✕
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="p-5 space-y-4">
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                                <div class="bg-slate-50 rounded-2xl p-4">
                                                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">
                                                        Status
                                                    </p>
                                                    <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-black uppercase {{ $statusClass }}">
                                                        {{ ucfirst($item->status ?? 'menunggu') }}
                                                    </span>
                                                </div>

                                                <div class="bg-slate-50 rounded-2xl p-4">
                                                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">
                                                        Jenis
                                                    </p>
                                                    <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-black uppercase {{ $jenisClass }}">
                                                        {{ ucfirst($item->jenis ?? '-') }}
                                                    </span>
                                                </div>

                                                <div class="bg-slate-50 rounded-2xl p-4">
                                                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">
                                                        Jumlah Orang
                                                    </p>
                                                    <p class="text-sm font-black text-slate-800">
                                                        {{ $item->jumlah_orang ?? 1 }} orang
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                <div class="bg-blue-50 rounded-2xl p-4">
                                                    <p class="text-[10px] font-black uppercase tracking-widest text-blue-700 mb-2">
                                                        Layanan Dibutuhkan
                                                    </p>

                                                    @if(count($layananList))
                                                        <div class="flex flex-wrap gap-1.5">
                                                            @foreach($layananList as $layanan)
                                                                <span class="px-2 py-1 bg-white text-blue-700 rounded-lg text-xs font-bold">
                                                                    {{ $layanan }}
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <p class="text-sm text-slate-400">-</p>
                                                    @endif
                                                </div>

                                                <div class="bg-green-50 rounded-2xl p-4">
                                                    <p class="text-[10px] font-black uppercase tracking-widest text-green-700 mb-2">
                                                        Keperluan Data
                                                    </p>

                                                    @if(count($keperluanList))
                                                        <div class="flex flex-wrap gap-1.5">
                                                            @foreach($keperluanList as $keperluan)
                                                                <span class="px-2 py-1 bg-white text-green-700 rounded-lg text-xs font-bold">
                                                                    {{ $keperluan }}
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <p class="text-sm text-slate-400">-</p>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="bg-slate-50 rounded-2xl p-4">
                                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                                                    Data yang Diminta
                                                </p>
                                                <p class="text-sm text-slate-700 leading-relaxed">
                                                    {{ $item->data_diminta ?? '-' }}
                                                </p>
                                            </div>

                                            @if(($item->jenis ?? '') === 'online')
                                                <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-4">
                                                    <p class="text-[10px] font-black uppercase tracking-widest text-indigo-700 mb-2">
                                                        Link Zoom
                                                    </p>

                                                    @if($item->zoom_link)
                                                        <a href="{{ $item->zoom_link }}"
                                                        target="_blank"
                                                        rel="noopener noreferrer"
                                                        class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-black transition">
                                                            Buka Link Zoom
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    stroke-width="2.5"
                                                                    d="M14 3h7m0 0v7m0-7L10 14" />
                                                                <path stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    stroke-width="2.5"
                                                                    d="M5 10v11h11" />
                                                            </svg>
                                                        </a>

                                                        <p class="text-xs text-indigo-700 mt-2 break-all">
                                                            {{ $item->zoom_link }}
                                                        </p>
                                                    @else
                                                        <div class="flex items-center gap-2 text-sm text-indigo-700">
                                                            <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                                                            Link Zoom belum tersedia. Silakan tunggu admin mengirimkan link.
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif

                                            @if($item->alasan_batal)
                                                <div class="bg-red-50 border border-red-100 rounded-2xl p-4">
                                                    <p class="text-[10px] font-black uppercase tracking-widest text-red-600 mb-2">
                                                        Alasan Pembatalan
                                                    </p>
                                                    <p class="text-sm text-red-700">
                                                        {{ $item->alasan_batal }}
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </dialog> --> 

                                <dialog id="detail-jadwal-{{ $item->id }}"
                                          class="w-full max-w-lg p-0 rounded-2xl backdrop:bg-slate-900/50">
                                      <div class="bg-white rounded-2xl overflow-hidden shadow-xl">

                                          {{-- Header --}}
                                          <div class="bg-primary px-5 py-4 text-white flex items-start justify-between gap-4">
                                              <div class="min-w-0">
                                                  <p class="text-[10px] font-black uppercase tracking-[0.18em] text-blue-100">
                                                      Detail Janji Temu
                                                  </p>

                                                  <h2 class="text-lg font-black mt-1 truncate">
                                                      {{ $item->instansi_lembaga ?? '-' }}
                                                  </h2>

                                                  <p class="text-xs text-blue-100 mt-1">
                                                      {{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('D MMMM Y') : 'Belum dijadwalkan' }}
                                                      @if($item->jam)
                                                          • {{ \Carbon\Carbon::parse($item->jam)->format('H:i') }} WIB
                                                      @endif
                                                  </p>
                                              </div>

                                              <form method="dialog">
                                                  <button type="submit"
                                                          class="w-8 h-8 rounded-full bg-white/15 hover:bg-white/25 text-white font-black flex items-center justify-center">
                                                      ✕
                                                  </button>
                                              </form>
                                          </div>

                                          {{-- Body --}}
                                          <div class="p-5 space-y-3">

                                              <div class="grid grid-cols-3 gap-2">
                                                  <div class="bg-slate-50 rounded-xl px-3 py-2">
                                                      <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">
                                                          Jenis
                                                      </p>
                                                      <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-black uppercase {{ $jenisClass }}">
                                                          {{ ucfirst($item->jenis ?? '-') }}
                                                      </span>
                                                  </div>

                                                  <div class="bg-slate-50 rounded-xl px-3 py-2">
                                                      <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">
                                                          Status
                                                      </p>
                                                      <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-black uppercase {{ $statusClass }}">
                                                          {{ ucfirst($item->status ?? 'menunggu') }}
                                                      </span>
                                                  </div>

                                                  <div class="bg-slate-50 rounded-xl px-3 py-2">
                                                      <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">
                                                          Orang
                                                      </p>
                                                      <p class="text-xs font-black text-slate-800">
                                                          {{ $item->jumlah_orang ?? 1 }} orang
                                                      </p>
                                                  </div>
                                              </div>

                                              <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                                  <div class="bg-blue-50 rounded-xl px-3 py-2">
                                                      <p class="text-[9px] font-black text-blue-700 uppercase tracking-widest mb-1">
                                                          Layanan
                                                      </p>

                                                      @if(count($layananList))
                                                          <div class="flex flex-wrap gap-1">
                                                              @foreach($layananList as $layanan)
                                                                  <span class="px-2 py-0.5 bg-white text-blue-700 rounded-md text-[10px] font-bold">
                                                                      {{ $layanan }}
                                                                  </span>
                                                              @endforeach
                                                          </div>
                                                      @else
                                                          <span class="text-xs text-gray-400">-</span>
                                                      @endif
                                                  </div>

                                                  <div class="bg-green-50 rounded-xl px-3 py-2">
                                                      <p class="text-[9px] font-black text-green-700 uppercase tracking-widest mb-1">
                                                          Keperluan
                                                      </p>

                                                      @if(count($keperluanList))
                                                          <div class="flex flex-wrap gap-1">
                                                              @foreach($keperluanList as $keperluan)
                                                                  <span class="px-2 py-0.5 bg-white text-green-700 rounded-md text-[10px] font-bold">
                                                                      {{ $keperluan }}
                                                                  </span>
                                                              @endforeach
                                                          </div>
                                                      @else
                                                          <span class="text-xs text-gray-400">-</span>
                                                      @endif
                                                  </div>
                                              </div>

                                              <div class="bg-slate-50 rounded-xl px-3 py-2">
                                                  <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">
                                                      Data yang Diminta
                                                  </p>

                                                  <p class="text-xs text-slate-700 leading-relaxed max-h-20 overflow-y-auto">
                                                      {{ $item->data_diminta ?? '-' }}
                                                  </p>
                                              </div>

                                              @if(($item->jenis ?? '') === 'online')
                                                  <div class="bg-indigo-50 rounded-xl px-3 py-2">
                                                      <p class="text-[9px] font-black text-indigo-700 uppercase tracking-widest mb-1">
                                                          Link Zoom
                                                      </p>

                                                      @if($item->zoom_link)
                                                          <a href="{{ $item->zoom_link }}"
                                                            target="_blank"
                                                            rel="noopener noreferrer"
                                                            class="inline-flex px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-bold transition">
                                                              Buka Zoom
                                                          </a>

                                                          <p class="text-[11px] text-indigo-700 mt-1 break-all">
                                                              {{ $item->zoom_link }}
                                                          </p>
                                                      @else
                                                          <p class="text-xs text-indigo-700">
                                                              Link Zoom belum tersedia.
                                                          </p>
                                                      @endif
                                                  </div>
                                              @endif

                                              @if($item->status === 'batal' && $item->alasan_batal)
                                                  <div class="bg-red-50 border border-red-100 rounded-xl px-3 py-2">
                                                      <p class="text-[9px] font-black text-red-600 uppercase tracking-widest mb-1">
                                                          Alasan Pembatalan
                                                      </p>

                                                      <p class="text-xs text-red-700 leading-relaxed max-h-20 overflow-y-auto">
                                                          {{ $item->alasan_batal }}
                                                      </p>
                                                  </div>
                                              @endif
                                          </div>
                                      </div>
                                  </dialog>

                                {{-- Modal Batal --}}
                                @if($item->status === 'menunggu' || $item->status === 'diterima')
                                    <dialog id="batal-jadwal-{{ $item->id }}"
                                            class="w-full max-w-md p-0 rounded-2xl backdrop:bg-slate-900/40">

                                        <div class="bg-white rounded-2xl overflow-hidden shadow-xl">

                                            {{-- Header compact --}}
                                            <div class="bg-red-600 px-5 py-4 text-white flex items-start justify-between gap-4">
                                                <div>
                                                    <p class="text-[10px] font-black uppercase tracking-[0.18em] text-red-100">
                                                        Konfirmasi Pembatalan
                                                    </p>

                                                    <h2 class="text-lg font-black mt-1">
                                                        Batalkan Janji Temu
                                                    </h2>

                                                    <p class="text-xs text-red-100 mt-1 leading-relaxed">
                                                        Tuliskan alasan pembatalan jadwal.
                                                    </p>
                                                </div>

                                                <form method="dialog">
                                                    <button type="submit"
                                                            class="w-8 h-8 rounded-full bg-white/15 hover:bg-white/25 text-white font-black flex items-center justify-center">
                                                        ✕
                                                    </button>
                                                </form>
                                            </div>

                                            {{-- Body --}}
                                            <div class="p-5">

                                                {{-- Info Jadwal compact --}}
                                                <div class="grid grid-cols-2 gap-3 mb-5">
                                                    <div class="bg-slate-50 rounded-xl px-4 py-3">
                                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">
                                                            Tanggal
                                                        </p>

                                                        <p class="text-sm font-black text-slate-800">
                                                            {{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('D MMM Y') : '-' }}
                                                        </p>
                                                    </div>

                                                    <div class="bg-slate-50 rounded-xl px-4 py-3">
                                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">
                                                            Jam
                                                        </p>

                                                        <p class="text-sm font-black text-slate-800">
                                                            {{ $item->jam ? \Carbon\Carbon::parse($item->jam)->format('H:i') . ' WIB' : '-' }}
                                                        </p>
                                                    </div>
                                                </div>

                                                {{-- Form --}}
                                                <form action="{{ route('janjitemu.batal', $item->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin membatalkan janji temu ini?')">
                                                    @csrf
                                                    @method('PUT')

                                                    <label for="alasan_batal_{{ $item->id }}"
                                                        class="block text-sm font-black text-slate-700 mb-2">
                                                        Alasan Pembatalan <span class="text-red-500">*</span>
                                                    </label>

                                                    <textarea id="alasan_batal_{{ $item->id }}"
                                                            name="alasan_batal"
                                                            required
                                                            maxlength="255"
                                                            placeholder="Contoh: Ingin mengganti jadwal kunjungan..."
                                                            rows="3"
                                                            class="w-full text-sm px-4 py-3 border-2 border-slate-200 rounded-xl resize-none focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition placeholder:text-slate-400"></textarea>

                                                    <p class="text-[11px] text-slate-400 mt-2">
                                                        Maksimal 255 karakter.
                                                    </p>

                                                    <div class="flex justify-end gap-2 mt-5">
                                                        <button type="button"
                                                                onclick="document.getElementById('batal-jadwal-{{ $item->id }}').close()"
                                                                class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-black transition">
                                                            Tutup
                                                        </button>

                                                        <button type="submit"
                                                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm font-black transition">
                                                            Kirim
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </dialog>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-5 py-4 border-t border-slate-100">
                    {{ $janjitemu->links('vendor.pagination.custom') }}
                </div>
            @else
                <div class="p-10 text-center">
                    <h2 class="text-xl font-black text-slate-800 mb-2">
                        Belum ada jadwal janji temu
                    </h2>

                    <p class="text-slate-500 mb-6 text-sm">
                        Silakan buat janji temu terlebih dahulu.
                    </p>

                    <a href="{{ route('janjitemu.index') }}"
                       class="inline-flex bg-primary hover:bg-blue-800 text-white py-3 px-6 rounded-2xl items-center justify-center gap-2 font-black transition">
                        Buat Janji Temu
                    </a>
                </div>
            @endif

        </div>
    </main>
</div>
@endsection