<x-layout-web>
  <div class="py-8 mx-auto px-6 lg:px-8">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
      <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
        <div class="mb-4 md:mb-0">
          <h1 class="text-3xl font-bold text-gray-900 mb-2">Log Harian Magang</h1>
          <p class="text-gray-600">Pencatatan aktivitas selama masa magang</p>
        </div>
        <a href="{{ route('log-harian.create-log') }}">
          <button
            class="bg-primary hover:bg-[#00295A] text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Tambah Log
          </button>
        </a>
      </div>
    </div>

    <!-- Filter dan Search -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
      <form method="GET" action="{{ route('daftar-magang.log-harian') }}">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}"
              class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}"
              class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status Kehadiran</label>
            <select name="status_kehadiran" class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
              <option value="">Semua Status</option>
              <option value="hadir" {{ request('status_kehadiran') == 'hadir' ? 'selected' : '' }}>Hadir</option>
              <option value="sakit" {{ request('status_kehadiran') == 'sakit' ? 'selected' : '' }}>Sakit</option>
              <option value="izin" {{ request('status_kehadiran') == 'izin' ? 'selected' : '' }}>Izin</option>
              <option value="alpha" {{ request('status_kehadiran') == 'alpha' ? 'selected' : '' }}>Alpha</option>

            </select>
          </div>
          <div class="flex items-end">
            <button type="submit"
              class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
              Filter
            </button>
          </div>
        </div>
      </form>

    </div>

    <!-- Tabel Log Harian -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
      <div class="overflow-x-auto pb-10">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                No
              </th>
              <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                Tanggal
              </th>
              <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                Jam Masuk
              </th>
              <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                Status Masuk
              </th>
              <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                Jam Pulang
              </th>
              <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                Status Pulang
              </th>
              <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                Uraian Kegiatan
              </th>
              <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                Status Kehadiran
              </th>
              <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                Status Verifikasi
              </th>
              <th class="py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                Aksi
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @php
              $no = $logs->firstItem();
            @endphp
            @forelse($logs as $log)
              <tr class="hover:bg-gray-50 transition-colors duration-150">
                <td class="text-sm text-gray-900 text-center font-semibold">
                  {{ $no++ }}
                </td>
                <td class="text-sm text-center text-gray-900 font-semibold">
                  {{ \Carbon\Carbon::parse($log->tanggal)->format('d/m/Y') }}
                </td>
                <td class="text-sm text-center text-gray-900 font-semibold">
                  {{ $log->jam_masuk ? \Carbon\Carbon::parse($log->jam_masuk)->format('H:i') : '-' }}
                </td>
                <td class="px-6 py-4 text-gray-900">
                  <div class="text-sm text-center font-semibold">
                    <div>{{ $log->presensi?->status_masuk_label ?? '-' }}</div>
                  </div>
                </td>
                <td class="text-sm text-center text-gray-900 font-semibold">
                  {{ $log->jam_pulang ? \Carbon\Carbon::parse($log->jam_pulang)->format('H:i') : '-' }}
                </td>
                <!-- <td class="px-6 py-4 text-gray-900">
                  <div class="prose max-w-none text-sm text-justify font-semibold">
                    {!! $log->catatan !!}
                  </div>
                </td> -->
                <td class="px-6 py-4 text-gray-900">
                  <div class="text-sm text-center font-semibold">
                    <div>{{ $log->presensi?->status_pulang_label ?? '-' }}</div>
                  </div>
                </td>
                <!-- <td class="px-6 py-4 text-gray-900">
                  <div class="prose max-w-none text-sm text-justify font-semibold">
                    {!! $log->uraian_kegiatan !!}
                  </div>
                </td> -->
                <td class="px-6 py-4 text-gray-900 max-w-xs">
                  <div 
                    title="{{ strip_tags($log->uraian_kegiatan) }}"
                    class="text-sm font-semibold text-left"
                    style="display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; text-overflow:ellipsis;">
                    {{ strip_tags($log->uraian_kegiatan) }}
                  </div>
                </td>
                <td class="text-sm text-center">
                  @if ($log->status_kehadiran == 'hadir')
                    <span class="bg-green-500 text-white px-2 py-1 font-semibold rounded">Hadir</span>
                  @elseif($log->status_kehadiran == 'sakit')
                    <span class="bg-red-500 text-white px-2 py-1 font-semibold rounded">Sakit</span>
                  @elseif($log->status_kehadiran == 'izin')
                    <span class="bg-yellow-500 text-white px-2 py-1 font-semibold rounded">Izin</span>
                  @endif
                </td>
                <td class="text-sm text-center">
                  @if ($log->status_verifikasi == 'disetujui')
                    <span class="bg-green-500 text-white px-2 py-1 font-semibold rounded">Disetujui</span>
                  @elseif($log->status_verifikasi == 'ditolak')
                    <span class="bg-red-500 text-white px-2 py-1 font-semibold rounded">Ditolak</span>
                  @elseif($log->status_verifikasi == 'pending')
                    <span class="bg-yellow-500 text-white px-2 py-1 font-semibold rounded">Menungggu</span>
                  @endif
                </td>
                <td class="text-sm px-6 font-medium">
                  <div class="flex justify-center items-center space-x-2">
                    <a href="{{ route('log-harian.show', ['id' => $log->id]) }}">
                      <button
                        class="text-blue-600 hover:text-blue-900 transition-colors duration-150 flex justify-center items-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5 c4.478 0 8.268 2.943 9.542 7 -1.274 4.057-5.064 7-9.542 7 -4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                      </button>
                    </a>
                    <a href="{{ route('log-harian.edit', ['id' => $log->id]) }}">
                      <button
                        class="text-green-600 hover:text-green-900 transition-colors duration-150 flex justify-center items-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                      </button>
                    </a>
                    <button type="button" data-url="{{ route('log-harian.destroy', ['id' => $log->id]) }}"
                      onclick="openDeleteModal(this)"
                      class="text-red-600 hover:text-red-900 transition-colors duration-150">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                      </svg>
                    </button>
                  </div>
                </td>
              </tr>



              <!-- Modal Konfirmasi Hapus Akun -->
              <div id="deleteConfirmationModal"
                class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-75">
                <div class="bg-white rounded-xl p-6 shadow-2xl w-full max-w-md mx-4 transform transition-all">
                  <!-- Header Modal -->
                  <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                      <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z">
                        </path>
                      </svg>
                    </div>
                    <div>
                      <h2 class="text-xl font-bold text-gray-900">Konfirmasi Hapus Log Harian</h2>
                    </div>
                  </div>

                  <!-- Konten Modal -->
                  <div class="mb-6">
                    <p class="text-gray-700 leading-relaxed">
                      Apakah Anda yakin ingin menghapus log harian ini?
                    </p>
                    <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                      <p class="text-sm text-red-800 font-medium">
                        ⚠️ Peringatan: Tindakan ini tidak dapat dibatalkan!
                      </p>
                    </div>
                  </div>

                  <!-- Tombol Aksi -->
                  <div class="flex flex-col sm:flex-row gap-3">
                    <button id="cancelButton" type="button"
                      class="flex-1 px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium rounded-lg transition-colors duration-200">
                      Batal
                    </button>
                    <form id="deleteForm" method="POST"
                      action="{{ route('log-harian.destroy', ['id' => $log->id]) }}" class="flex-1">
                      @csrf
                      @method('DELETE')
                      <button type="submit"
                        class="w-full px-4 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                          </path>
                        </svg>
                        Ya, Hapus Log
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            @empty
              <tr>
                <td colspan="10" class="px-6 py-12 text-center text-gray-500">
                  <div class="flex flex-col items-center">
                    <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor"
                      viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-lg font-medium">Belum ada log harian</p>
                    <p class="text-sm text-gray-400">Mulai tambahkan log harian aktivitas magang Anda</p>
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
        {{ $logs->links('vendor.pagination.custom') }}
      </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
      <div class="overflow-x-auto pb-10">

        <table class="min-w-full divide-y divide-gray-200">

          <!-- HEADER -->
          <thead class="bg-gray-100 border-b">
            <tr>
              @foreach ([
                'No','Tanggal','Jam Masuk','Status Masuk',
                'Jam Pulang','Status Pulang','Uraian Kegiatan',
                'Status Kehadiran','Status Verifikasi','Aksi'
              ] as $head)
              <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                {{ $head }}
              </th>
              @endforeach
            </tr>
          </thead>

          <!-- BODY -->
          <tbody class="bg-white divide-y divide-gray-100">

            @php $no = $logs->firstItem(); @endphp

            @forelse($logs as $log)
            <tr class="hover:bg-blue-50/40 transition">

              <td class="px-6 py-4 text-sm text-center text-gray-700">
                {{ $no++ }}
              </td>

              <td class="px-6 py-4 text-sm text-center text-gray-700">
                {{ \Carbon\Carbon::parse($log->tanggal)->format('d/m/Y') }}
              </td>

              <td class="px-6 py-4 text-sm text-center text-gray-700">
                {{ $log->jam_masuk ? \Carbon\Carbon::parse($log->jam_masuk)->format('H:i') : '-' }}
              </td>

              <td class="px-6 py-4 text-sm text-center text-gray-700">
                {{ $log->presensi?->status_masuk_label ?? '-' }}
              </td>

              <td class="px-6 py-4 text-sm text-center text-gray-700">
                {{ $log->jam_pulang ? \Carbon\Carbon::parse($log->jam_pulang)->format('H:i') : '-' }}
              </td>

              <td class="px-6 py-4 text-sm text-center text-gray-700">
                {{ $log->presensi?->status_pulang_label ?? '-' }}
              </td>

              <td class="px-6 py-4 text-sm text-left text-gray-600 max-w-xs">
                <div 
                  title="{{ strip_tags($log->uraian_kegiatan) }}"
                  class="leading-relaxed"
                  style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                  {{ strip_tags($log->uraian_kegiatan) }}
                </div>
              </td>

              <td class="px-6 py-4 text-center text-sm">
                @if ($log->status_kehadiran == 'hadir')
                  <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Hadir</span>
                @elseif($log->status_kehadiran == 'sakit')
                  <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">Sakit</span>
                @elseif($log->status_kehadiran == 'izin')
                  <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">Izin</span>
                @endif
              </td>

              <td class="px-6 py-4 text-center text-sm">
                @if ($log->status_verifikasi == 'disetujui')
                  <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Disetujui</span>
                @elseif($log->status_verifikasi == 'ditolak')
                  <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">Ditolak</span>
                @elseif($log->status_verifikasi == 'pending')
                  <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">Menunggu</span>
                @endif
              </td>

              <td class="text-sm px-6 font-medium">
                <div class="flex justify-center items-center space-x-2">
                  <a href="{{ route('log-harian.show', ['id' => $log->id]) }}">
                    <button
                      class="text-blue-600 hover:text-blue-900 transition-colors duration-150 flex justify-center items-center">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M2.458 12C3.732 7.943 7.523 5 12 5 c4.478 0 8.268 2.943 9.542 7 -1.274 4.057-5.064 7-9.542 7 -4.477 0-8.268-2.943-9.542-7z"/>
                      </svg>
                    </button>
                  </a>
                  <a href="{{ route('log-harian.edit', ['id' => $log->id]) }}">
                    <button
                      class="text-green-600 hover:text-green-900 transition-colors duration-150 flex justify-center items-center">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                      </svg>
                    </button>
                  </a>
                  <button type="button" data-url="{{ route('log-harian.destroy', ['id' => $log->id]) }}"
                    onclick="openDeleteModal(this)"
                    class="text-red-600 hover:text-red-900 transition-colors duration-150">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                  </button>
                </div>
              </td>

            </tr>

            @empty
            <tr>
              <td colspan="10" class="px-6 py-16 text-center">
                <div class="flex flex-col items-center text-gray-500">
                  <svg class="w-14 h-14 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                  </svg>
                  <p class="text-lg font-semibold">Belum ada log harian</p>
                  <p class="text-sm text-gray-400">Silakan tambahkan log aktivitas magang terlebih dahulu</p>
                </div>
              </td>
            </tr>
            @endforelse

          </tbody>
        </table>

        {{ $logs->links('vendor.pagination.custom') }}

      </div>
    </div>


    <!-- Summary Cards -->
    {{-- <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">
      <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
              <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Total Hadir</p>
            <p class="text-2xl font-bold text-gray-900"></p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
              <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Total Sakit</p>
            <p class="text-2xl font-bold text-gray-900"></p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
              <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Total Izin</p>
            <p class="text-2xl font-bold text-gray-900"></p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
              <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Total Hari</p>
            <p class="text-2xl font-bold text-gray-900"></p>
          </div>
        </div>
      </div>
    </div> --}}
  </div>
  <x-footer class="fill-[#EEF0F2]"></x-footer>


  <script>
    function openDeleteModal(button) {
      const modal = document.getElementById('deleteConfirmationModal');
      const deleteForm = document.getElementById('deleteForm');

      // Ambil URL dari data-url tombol
      const deleteUrl = button.getAttribute('data-url');
      deleteForm.setAttribute('action', deleteUrl);

      // Tampilkan modal dengan animasi
      modal.classList.remove('hidden');

      // Tambahkan event listener untuk menutup modal dengan ESC
      document.addEventListener('keydown', handleEscapeKey);
    }

    function closeDeleteModal() {
      const modal = document.getElementById('deleteConfirmationModal');
      modal.classList.add('hidden');

      // Hapus event listener ESC
      document.removeEventListener('keydown', handleEscapeKey);
    }

    function handleEscapeKey(event) {
      if (event.key === 'Escape') {
        closeDeleteModal();
      }
    }

    // Event listener untuk tombol batal
    document.getElementById('cancelButton').addEventListener('click', closeDeleteModal);

    // Event listener untuk menutup modal ketika klik di luar modal
    document.getElementById('deleteConfirmationModal').addEventListener('click', function(event) {
      if (event.target === this) {
        closeDeleteModal();
      }
    });

    // Mencegah modal tertutup ketika klik di dalam konten modal
    document.querySelector('#deleteConfirmationModal > div').addEventListener('click', function(event) {
      event.stopPropagation();
    });
  </script>
</x-layout-web>
