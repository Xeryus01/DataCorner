@if(session('mobile_app'))
  <x-user.webview>
    <div class="bg-white rounded-xl shadow-lg md:max-w-4xl my-10 py-8 mx-6 md:mx-auto px-6 lg:px-8">

      <!-- Header -->
      <div class="mb-8">
        <div class="flex flex-col justify-center items-center">
          <h1 class="text-xl md:text-3xl font-bold text-gray-900 mb-2">
            Detail Log Harian Magang
          </h1>
          <p class="text-sm md:text-base font-semibold text-gray-600">
            Informasi aktivitas harian selama masa magang
          </p>
        </div>
      </div>

      <!-- Grid Tanggal & Status -->
      <div class="grid md:grid-cols-2 gap-6 px-6 mb-6">

        <!-- Tanggal -->
        <div>
          <x-input-label value="Tanggal" />
          <div class="w-full px-4 py-3 rounded-xl bg-gray-100">
            {{ \Carbon\Carbon::parse($log->tanggal)->translatedFormat('d F Y') }}
          </div>
        </div>

        <!-- Status Kehadiran -->
        <div>
          <x-input-label value="Status Kehadiran" />

          <div class="w-full px-4 py-3 rounded-xl bg-gray-100">
            @if($log->jam_masuk && $log->jam_pulang)
              <span class="text-green-700 font-semibold">Hadir</span>
            @else
              <span class="text-yellow-700 font-semibold capitalize">
                {{ $log->status_kehadiran }}
              </span>
            @endif
          </div>
        </div>      
      </div>

      

      <!-- Jam -->
      <div class="grid md:grid-cols-2 gap-6 px-6 mb-6">
        {{-- Jam Masuk --}}
        <div>
          <x-input-label value="Jam Masuk" />
          <div class="w-full px-4 py-3 rounded-xl bg-gray-100 flex justify-between items-center">
            
            <span class="font-semibold text-gray-800">
              {{ $log->presensi?->jam_masuk ? \Carbon\Carbon::parse($log->presensi->jam_masuk)->format('H:i') : '-' }}
            </span>

            <span class="text-xs px-3 py-1 rounded-full bg-blue-100 text-blue-700">
              {{ $log->presensi?->status_masuk_label ?? '-' }}
            </span>

          </div>
        </div>

        {{-- Jam Pulang --}}
        <div>
          <x-input-label value="Jam Pulang" />
          <div class="w-full px-4 py-3 rounded-xl bg-gray-100 flex justify-between items-center">
            
            <span class="font-semibold text-gray-800">
              {{ $log->presensi?->jam_pulang ? \Carbon\Carbon::parse($log->presensi->jam_pulang)->format('H:i') : '-' }}
            </span>

            <span class="text-xs px-3 py-1 rounded-full bg-blue-100 text-blue-700">
              {{ $log->presensi?->status_pulang_label ?? '-' }}
            </span>

          </div>
        </div>

      </div>

    
      <!-- Uraian & Catatan -->
      <div class="grid grid-cols-1 gap-6 px-6 mb-6">
        
        @if($log->bukti_izin)
        <div>
          <x-input-label value="Bukti Izin" />
          <div class="w-full px-5 py-4 rounded-xl bg-blue-50 border border-blue-200">
            
            <div class="flex items-center justify-between mt-2 gap-4">

              <!-- Info File -->
              <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5l5 5v11a2 2 0 01-2 2z" />
                </svg>

                <div>
                  <p class="text-sm font-semibold text-gray-800">
                    Bukti Izin Terlampir
                  </p>
                  <p class="text-xs text-gray-500">
                    Klik untuk melihat atau mengunduh
                  </p>
                </div>
              </div>

              <!-- Aksi -->
              <div class="flex gap-2">

                <!-- Lihat -->
                <a href="{{ asset('storage/' . $log->bukti_izin) }}"
                  target="_blank"
                  class="px-3 py-2 text-sm rounded-lg bg-white border text-blue-600 hover:bg-blue-100 font-medium">
                  Lihat
                </a>

                <!-- Download -->
                <a href="{{ asset('storage/' . $log->bukti_izin) }}"
                  download
                  class="px-3 py-2 text-sm rounded-lg bg-blue-600 text-white hover:bg-blue-700 font-medium">
                  Download
                </a>

              </div>

            </div>
          </div>
        </div>
        @endif

        <div>
          <x-input-label value="Keterangan Masuk & Pulang" />

          <div class="w-full px-4 py-3 rounded-xl bg-gray-100 space-y-2">

            <div class="flex items-center gap-2">
              <span class="text-xs font-semibold text-blue-600">Masuk :</span>
              <span>{{ $log->presensi?->keterangan_masuk ?? '-' }}</span>
            </div>

            <div class="flex items-center gap-2">
              <span class="text-xs font-semibold text-green-600">Pulang :</span>
              <span>{{ $log->presensi?->keterangan_pulang ?? '-' }}</span>
            </div>

          </div>
        </div>

        <div>
          <x-input-label value="Uraian Kegiatan" />
          <div class="w-full px-4 py-3 rounded-xl bg-gray-100 prose max-w-none">
            {!! $log->uraian_kegiatan !!}
          </div>
        </div>

        <div>
          <x-input-label value="Catatan" />
          <div class="w-full px-4 py-3 rounded-xl bg-gray-100 prose max-w-none">
            {!! $log->catatan ?? '-' !!}
          </div>
        </div>

      </div>

      <!-- Tombol -->
      <div class="flex justify-center gap-3">

        <a href="{{ route('daftar-magang.log-harian') }}"
          class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium">
          Kembali
        </a>

      </div>

    </div>
  </x-user.webview>
@else
  <x-layout-web>
    <div class="bg-white rounded-xl shadow-lg md:max-w-4xl my-10 py-8 mx-6 md:mx-auto px-6 lg:px-8">

      <!-- Header -->
      <div class="mb-8">
        <div class="flex flex-col justify-center items-center">
          <h1 class="text-xl md:text-3xl font-bold text-gray-900 mb-2">
            Detail Log Harian Magang
          </h1>
          <p class="text-sm md:text-base font-semibold text-gray-600">
            Informasi aktivitas harian selama masa magang
          </p>
        </div>
      </div>

      <!-- Grid Tanggal & Status -->
      <div class="grid md:grid-cols-2 gap-6 px-6 mb-6">

        <!-- Tanggal -->
        <div>
          <x-input-label value="Tanggal" />
          <div class="w-full px-4 py-3 rounded-xl bg-gray-100">
            {{ \Carbon\Carbon::parse($log->tanggal)->translatedFormat('d F Y') }}
          </div>
        </div>

        <!-- Status Kehadiran -->
        <div>
          <x-input-label value="Status Kehadiran" />

          <div class="w-full px-4 py-3 rounded-xl bg-gray-100">
            @if($log->jam_masuk && $log->jam_pulang)
              <span class="text-green-700 font-semibold">Hadir</span>
            @else
              <span class="text-yellow-700 font-semibold capitalize">
                {{ $log->status_kehadiran }}
              </span>
            @endif
          </div>
        </div>      
      </div>

      

      <!-- Jam -->
      <div class="grid md:grid-cols-2 gap-6 px-6 mb-6">
        {{-- Jam Masuk --}}
        <div>
          <x-input-label value="Jam Masuk" />
          <div class="w-full px-4 py-3 rounded-xl bg-gray-100 flex justify-between items-center">
            
            <span class="font-semibold text-gray-800">
              {{ $log->presensi?->jam_masuk ? \Carbon\Carbon::parse($log->presensi->jam_masuk)->format('H:i') : '-' }}
            </span>

            <span class="text-xs px-3 py-1 rounded-full bg-blue-100 text-blue-700">
              {{ $log->presensi?->status_masuk_label ?? '-' }}
            </span>

          </div>
        </div>

        {{-- Jam Pulang --}}
        <div>
          <x-input-label value="Jam Pulang" />
          <div class="w-full px-4 py-3 rounded-xl bg-gray-100 flex justify-between items-center">
            
            <span class="font-semibold text-gray-800">
              {{ $log->presensi?->jam_pulang ? \Carbon\Carbon::parse($log->presensi->jam_pulang)->format('H:i') : '-' }}
            </span>

            <span class="text-xs px-3 py-1 rounded-full bg-blue-100 text-blue-700">
              {{ $log->presensi?->status_pulang_label ?? '-' }}
            </span>

          </div>
        </div>

      </div>

    
      <!-- Uraian & Catatan -->
      <div class="grid grid-cols-1 gap-6 px-6 mb-6">
        
        @if($log->bukti_izin)
        <div>
          <x-input-label value="Bukti Izin" />
          <div class="w-full px-5 py-4 rounded-xl bg-blue-50 border border-blue-200">
            
            <div class="flex items-center justify-between mt-2 gap-4">

              <!-- Info File -->
              <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5l5 5v11a2 2 0 01-2 2z" />
                </svg>

                <div>
                  <p class="text-sm font-semibold text-gray-800">
                    Bukti Izin Terlampir
                  </p>
                  <p class="text-xs text-gray-500">
                    Klik untuk melihat atau mengunduh
                  </p>
                </div>
              </div>

              <!-- Aksi -->
              <div class="flex gap-2">

                <!-- Lihat -->
                <a href="{{ asset('storage/' . $log->bukti_izin) }}"
                  target="_blank"
                  class="px-3 py-2 text-sm rounded-lg bg-white border text-blue-600 hover:bg-blue-100 font-medium">
                  Lihat
                </a>

                <!-- Download -->
                <a href="{{ asset('storage/' . $log->bukti_izin) }}"
                  download
                  class="px-3 py-2 text-sm rounded-lg bg-blue-600 text-white hover:bg-blue-700 font-medium">
                  Download
                </a>

              </div>

            </div>
          </div>
        </div>
        @endif

        <div>
          <x-input-label value="Keterangan Masuk & Pulang" />

          <div class="w-full px-4 py-3 rounded-xl bg-gray-100 space-y-2">

            <div class="flex items-center gap-2">
              <span class="text-xs font-semibold text-blue-600">Masuk :</span>
              <span>{{ $log->presensi?->keterangan_masuk ?? '-' }}</span>
            </div>

            <div class="flex items-center gap-2">
              <span class="text-xs font-semibold text-green-600">Pulang :</span>
              <span>{{ $log->presensi?->keterangan_pulang ?? '-' }}</span>
            </div>

          </div>
        </div>

        <div>
          <x-input-label value="Uraian Kegiatan" />
          <div class="w-full px-4 py-3 rounded-xl bg-gray-100 prose max-w-none">
            {!! $log->uraian_kegiatan !!}
          </div>
        </div>

        <div>
          <x-input-label value="Catatan" />
          <div class="w-full px-4 py-3 rounded-xl bg-gray-100 prose max-w-none">
            {!! $log->catatan ?? '-' !!}
          </div>
        </div>

      </div>

      <!-- Tombol -->
      <div class="flex justify-center gap-3">

        <a href="{{ route('daftar-magang.log-harian') }}"
          class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium">
          Kembali
        </a>

      </div>

    </div>

    <x-footer class="fill-[#EEF0F2]" />
  </x-layout-web>
@endif

