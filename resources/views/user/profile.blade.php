@extends('layout.app')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BPS User | Profil</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 p-4">

  <nav class="w-full max-w-6xl mx-auto mb-8">
    <div class="glass-effect rounded-2xl p-4 flex items-center justify-between">
      <div class="flex items-center space-x-4">
        <div class="profile-avatar w-12 h-12 rounded-full flex items-center justify-center bg-primary">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
          </svg>
        </div>
        <div>
          <h1 class="text-xl font-bold text-gray-800">Profil Pengguna</h1>
          <p class="text-sm text-gray-600">Sistem BPS User</p>
        </div>
      </div>
      <img class=" sm:flex hidden" src="{{ asset('image/logo-bpsbiru.png') }}" width="400" height="400" alt="">
    </div>
  </nav>

  <main class="w-full max-w-6xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

      <!-- Kartu Profil -->
      <div class="lg:col-span-1">
        <div class="profile-card rounded-3xl p-8 card-shadow bg-white">
          <div class="text-center mb-8">
            <div class="profile-avatar w-32 h-32 rounded-full mx-auto flex items-center justify-center mb-4 bg-primary">
              <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
              </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $user->nama ?? 'Nama tidak tersedia' }}</h2>
            <div class="status-badge text-white px-4 py-2 rounded-full text-sm font-semibold inline-flex items-center bg-green-600">
              <div class="w-2 h-2 bg-black rounded-full mr-2"></div>
              Aktif
            </div>
            <div class="mt-6 grid grid-cols-1 gap-3">
              <button type="button"
                      id="btnInfoProfil"
                      onclick="showProfileTab('info')"
                      class="w-full bg-primary text-white py-3 px-4 rounded-xl flex items-center justify-center gap-2 text-sm font-bold transition">
                  Informasi Profil
              </button>

              <button type="button"
                      id="btnJadwalProfil"
                      onclick="showProfileTab('jadwal')"
                      class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 px-4 rounded-xl flex items-center justify-center gap-2 text-sm font-bold transition">
                  Jadwal Janji Temu
              </button>
          </div>
          </div>
        </div>
      </div>

      <!-- Informasi Profil -->
      <div class="lg:col-span-2">

          {{-- PANEL INFORMASI PROFIL --}}
          <div id="profileInfoPanel" class="profile-card rounded-3xl p-8 bg-white shadow">
              <h3 class="text-2xl font-bold text-gray-800 mb-6">
                  Informasi Profil
              </h3>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                  <div class="bg-gray-50 p-6 rounded-xl">
                      <p class="text-sm font-medium text-gray-600 mb-1">Username</p>
                      <p class="text-lg font-semibold text-gray-800">
                          {{ $user->nama ?? '-' }}
                      </p>
                  </div>

                  <div class="bg-gray-50 p-6 rounded-xl">
                      <p class="text-sm font-medium text-gray-600 mb-1">Nomor Handphone</p>
                      <p class="text-lg font-semibold text-gray-800">
                          +{{ $user->no_hp ?? '-' }}
                      </p>
                  </div>

              </div>

              <div class="mt-8 grid grid-cols-1 gap-4">
                  <a href="{{ route('profile.edit', $user->id) }}"
                    class="bg-primary hover:bg-blue-800 text-white py-3 px-6 rounded-xl flex items-center justify-center gap-2">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                      </svg>
                      <span>Edit Profil</span>
                  </a>

                  <a href="{{ route('home') }}"
                    class="bg-primary hover:bg-blue-800 text-white py-3 px-6 rounded-xl flex items-center justify-center gap-2">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                      </svg>
                      <span>Kembali Halaman Beranda</span>
                  </a>
              </div>
          </div>

          {{-- PANEL JADWAL JANJI TEMU --}}
          <div id="profileJadwalPanel" class="hidden profile-card rounded-3xl p-6 bg-white shadow">
              <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
                  <div>
                      <h3 class="text-xl font-black text-gray-800">
                          Jadwal Janji Temu
                      </h3>

                      <p class="text-sm text-gray-500 mt-1">
                          Ringkasan jadwal janji temu terbaru Anda.
                      </p>
                  </div>

                  <a href="{{ route('janjitemu.jadwal') }}"
                    class="inline-flex items-center justify-center px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-xl text-sm font-bold transition">
                      Lihat Semua
                  </a>
              </div>

              @if(isset($jadwalUser) && $jadwalUser->count())
                  <div class="rounded-2xl border border-gray-100 overflow-hidden max-h-[340px] overflow-y-auto">
                      <table class="w-full table-fixed text-xs sm:text-sm">
                          <thead class="sticky top-0 z-10">
                              <tr class="bg-blue-50 text-blue-900 border-b border-blue-100">
                                  <th class="w-[8%] px-3 py-3 text-left text-[10px] font-black uppercase tracking-widest">
                                      No
                                  </th>
                                  <th class="w-[28%] px-3 py-3 text-left text-[10px] font-black uppercase tracking-widest">
                                      Jadwal
                                  </th>
                                  <th class="w-[28%] px-3 py-3 text-left text-[10px] font-black uppercase tracking-widest">
                                      Instansi
                                  </th>
                                  <th class="w-[18%] px-3 py-3 text-left text-[10px] font-black uppercase tracking-widest">
                                      Status
                                  </th>
                                  <th class="w-[18%] px-3 py-3 text-center text-[10px] font-black uppercase tracking-widest">
                                      Detail
                                  </th>
                              </tr>
                          </thead>

                          <tbody class="divide-y divide-gray-100 bg-white">
                              @foreach($jadwalUser as $item)
                                  @php
                                      $status = strtolower($item->status ?? 'menunggu');

                                      $statusClass = [
                                          'menunggu' => 'bg-yellow-100 text-yellow-700',
                                          'diterima' => 'bg-green-100 text-green-700',
                                          'batal' => 'bg-red-100 text-red-700',
                                          'ditolak' => 'bg-gray-100 text-gray-700',
                                      ][$status] ?? 'bg-gray-100 text-gray-700';

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
                                      <td class="px-3 py-3 text-gray-400 font-bold">
                                          {{ $loop->iteration }}
                                      </td>

                                      <td class="px-3 py-3">
                                          <p class="font-black text-gray-800 truncate">
                                              {{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('D MMM Y') : 'Belum dijadwalkan' }}
                                          </p>

                                          <p class="text-[11px] text-gray-500 truncate mt-0.5">
                                              {{ $item->jam ? \Carbon\Carbon::parse($item->jam)->format('H:i') . ' WIB' : '-' }}
                                          </p>
                                      </td>

                                      <td class="px-3 py-3">
                                          <p class="font-black text-gray-800 truncate">
                                              {{ $item->instansi_lembaga ?? '-' }}
                                          </p>

                                          <p class="text-[11px] text-gray-400 truncate mt-0.5">
                                              {{ ucfirst($item->jenis ?? '-') }} • {{ $item->jumlah_orang ?? 1 }} orang
                                          </p>
                                      </td>

                                      <td class="px-3 py-3">
                                          <span class="inline-flex px-2 py-1 rounded-full text-[10px] font-black uppercase {{ $statusClass }}">
                                              {{ ucfirst($item->status ?? 'menunggu') }}
                                          </span>
                                      </td>

                                      <td class="px-3 py-3 text-center">
                                          <button type="button"
                                                  onclick="document.getElementById('detail-profile-jadwal-{{ $item->id }}').showModal()"
                                                  class="px-3 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-xl text-[11px] font-black transition">
                                              Detail
                                          </button>
                                      </td>
                                  </tr>

                                  {{-- MODAL DETAIL --}}
                                  <dialog id="detail-profile-jadwal-{{ $item->id }}"
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
                              @endforeach
                          </tbody>
                      </table>
                  </div>

                  <p class="text-xs text-gray-400 mt-3">
                      Tabel menampilkan jadwal terbaru. Klik "Lihat Semua" untuk melihat informasi lengkap.
                  </p>
              @else
                  <div class="bg-gray-50 border border-dashed border-gray-200 rounded-2xl p-6 text-center">
                      <h4 class="text-base font-black text-gray-800 mb-2">
                          Belum ada jadwal janji temu
                      </h4>

                      <p class="text-sm text-gray-500 mb-4">
                          Silakan buat janji temu terlebih dahulu.
                      </p>

                      <a href="{{ route('janjitemu.index') }}"
                        class="inline-flex bg-primary hover:bg-blue-800 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition">
                          Buat Janji Temu
                      </a>
                  </div>
              @endif
          </div>
      </div>
    </div>
  </main>
<script>
    function showProfileTab(tab) {
        const infoPanel = document.getElementById('profileInfoPanel');
        const jadwalPanel = document.getElementById('profileJadwalPanel');

        const btnInfo = document.getElementById('btnInfoProfil');
        const btnJadwal = document.getElementById('btnJadwalProfil');

        if (tab === 'jadwal') {
            infoPanel.classList.add('hidden');
            jadwalPanel.classList.remove('hidden');

            btnInfo.className = 'w-full bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 px-4 rounded-xl flex items-center justify-center gap-2 text-sm font-bold transition';
            btnJadwal.className = 'w-full bg-primary text-white py-3 px-4 rounded-xl flex items-center justify-center gap-2 text-sm font-bold transition';
        } else {
            jadwalPanel.classList.add('hidden');
            infoPanel.classList.remove('hidden');

            btnJadwal.className = 'w-full bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 px-4 rounded-xl flex items-center justify-center gap-2 text-sm font-bold transition';
            btnInfo.className = 'w-full bg-primary text-white py-3 px-4 rounded-xl flex items-center justify-center gap-2 text-sm font-bold transition';
        }
    }
</script>
</body>
</html>
@endsection