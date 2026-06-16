@if(session('mobile_app'))
  <x-user.webview>
    <div class="bg-white rounded-xl shadow-lg md:max-w-4xl my-10 py-8 mx-6 md:mx-auto px-6 lg:px-8">
      <!-- Header -->
      <div class="mb-8">
        <div class="flex flex-col justify-center items-center">
          <h1 class="text-xl md:text-3xl font-bold text-gray-900 mb-2">Edit Log Harian Magang</h1>
          <p class="text-sm md:text-base font-semibold text-gray-600">Edit aktivitas harian selama masa magang</p>
        </div>
      </div>
      <form action="{{ route('log-harian.update', ['id' => $log->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="id_pendaftaran_magang" value="{{ $log->id_pendaftaran_magang }}">
        <div class="grid md:grid-cols-2 gap-6 px-6 mb-6">
          <!-- Tanggal -->
          <div>
            <div class="flex items-center mb-2">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              <x-input-label for="tanggal" :value="__('Tanggal')" />
            </div>
            <x-text-input id="tanggal" class="w-full px-4 py-3 rounded-xl bg-white/80" type="date" name="tanggal"
              :value="$log->tanggal" readonly required/>
            <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
          </div>

          <!-- Status Kehadiran harus presensi masuk dan pulang = otomatis hadir -->
          <!-- <div>
            <div>
              <div class="flex items-center mb-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <x-input-label for="status_kehadiran" :value="__('Status Kehadiran')" />
              </div>

              @php
                $presensi = $log->presensi ?? null;
                $hadirLengkap = $presensi && $presensi->jam_masuk && $presensi->jam_pulang;
              @endphp

              @if($hadirLengkap)

                #HADIR (AUTO DARI PRESENSI) 
                <input type="text"
                  class="w-full px-4 py-3 rounded-xl bg-green-100 text-green-700 font-semibold"
                  value="Hadir"
                  readonly>

                <input type="hidden" name="status_kehadiran" value="hadir">

              @else

                #IZIN / SAKIT 
                <select name="status_kehadiran" id="status_kehadiran"
                  class="w-full px-4 py-3 border rounded-xl shadow-sm focus:border-primary focus:ring-primary bg-white"
                  required>

                  <option value="">-- Status Kehadiran --</option>
                  <option value="sakit" {{ $log->status_kehadiran == 'sakit' ? 'selected' : '' }}>Sakit</option>
                  <option value="izin" {{ $log->status_kehadiran == 'izin' ? 'selected' : '' }}>Izin</option>

                </select>

              @endif

              <x-input-error :messages="$errors->get('status_kehadiran')" class="mt-2" />
            </div>
          </div> -->

          <div>
            <div>
              <div class="flex items-center mb-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <x-input-label for="status_kehadiran" :value="__('Status Kehadiran')" />
              </div>

              @php
                $presensi = $log->presensi ?? null;
                $hadirLengkap = $presensi && $presensi->jam_masuk;
              @endphp

              @if($hadirLengkap)

                <!-- HADIR (AUTO DARI PRESENSI)  -->
                <input type="text"
                  class="w-full px-4 py-3 rounded-xl bg-green-100 text-green-700 font-semibold"
                  value="{{ $presensi->jam_pulang ? 'Hadir' : 'Hadir (Belum Presensi Pulang)' }}"
                  readonly>

                <input type="hidden" name="status_kehadiran" value="hadir">

              @else

                <!-- IZIN / TANPA KETERANGAN -->
                <select name="status_kehadiran" id="status_kehadiran"
                  class="w-full px-4 py-3 border rounded-xl shadow-sm focus:border-primary focus:ring-primary bg-white"
                  required>

                  <option value="">-- Status Kehadiran --</option>
                  <option value="izin" {{ $log->status_kehadiran == 'izin' ? 'selected' : '' }}>Izin</option>
                  <option value="tanpa_keterangan" {{ $log->status_kehadiran == 'tanpa keterangan' ? 'selected' : '' }}>Tanpa Keterangan</option>

                </select>

              @endif

              <x-input-error :messages="$errors->get('status_kehadiran')" class="mt-2" />
            </div>
          </div>
        </div>

        <div class="grid md:grid-cols-2 gap-6 px-6 mb-6">

          <div>
            <x-input-label value="Jam Masuk" />
            <input type="text" class="w-full px-4 py-3 rounded-xl bg-gray-100"
              value="{{ $log->presensi?->jam_masuk ? \Carbon\Carbon::parse($log->presensi->jam_masuk)->format('H:i') : '-' }}" readonly>
          </div>

          <div>
            <x-input-label value="Jam Pulang" />
            <input type="text" class="w-full px-4 py-3 rounded-xl bg-gray-100"
              value="{{ $log->presensi?->jam_pulang ? \Carbon\Carbon::parse($log->presensi->jam_pulang)->format('H:i') : '-' }}" readonly>
          </div>

        </div>

        {{-- Bukti Izin --}}
        <div id="form-bukti"
            class="px-6 mb-6 {{ $log->status_kehadiran === 'izin' ? '' : 'hidden' }}">

          <x-input-label value="Bukti Izin" />

          <div class="mt-2 p-4 rounded-xl bg-blue-50 border border-blue-200 space-y-3">

            {{-- Jika sudah ada bukti --}}
            @if($log->bukti_izin)
              <div class="flex items-center justify-between gap-4">
                <div class="text-sm text-gray-700">
                  <p class="font-semibold">Bukti izin saat ini</p>
                  <p class="text-xs text-gray-500">Klik untuk melihat atau unduh</p>
                </div>

                <div class="flex gap-2">
                  <a href="{{ asset('storage/'.$log->bukti_izin) }}"
                    target="_blank"
                    class="px-3 py-2 text-sm rounded-lg bg-white border text-blue-600 hover:bg-blue-100">
                    Lihat
                  </a>

                  <a href="{{ asset('storage/'.$log->bukti_izin) }}"
                    download
                    class="px-3 py-2 text-sm rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                    Download
                  </a>
                </div>
              </div>
            @endif

            {{-- Upload ulang --}}
            <div>
              <x-input-label value="Upload Bukti Izin (Opsional)" />
              <input type="file"
                    name="bukti_izin"
                    accept=".jpg,.jpeg,.png,.pdf"
                    class="w-full px-4 py-2 border rounded-lg bg-white">

              <p class="text-xs text-gray-500 mt-1">
                Format: JPG, PNG, PDF (Max 2MB)
              </p>

              <x-input-error :messages="$errors->get('bukti_izin')" class="mt-2" />
            </div>

          </div>
        </div>

        <div class="grid grid-cols-1 gap-6 px-6 mb-6">
          <div>
            <div class="flex items-center mb-2">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
              </svg>
              <x-input-label for="uraian kegiatan" :value="__('Uraian Kegiatan')" />
            </div>
            <textarea id="editor-uraian" name="uraian_kegiatan"
              class="w-full px-4 py-3 border rounded-xl shadow-sm focus:border-primary focus:ring-primary bg-white resize-none"
              placeholder="Jelaskan aktivitas magang hari ini">{{ $log->uraian_kegiatan }}</textarea>
            <x-input-error :messages="$errors->get('uraian_kegiatan')" class="mt-2" />
          </div>

          <div>
            <div class="flex items-center mb-2">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
              </svg>
              <x-input-label for="catatan" :value="__('Catatan (Opsional)')" />
            </div>
            <textarea id="editor-catatan" name="catatan"
              class="w-full px-4 py-3 border rounded-xl shadow-sm focus:border-primary focus:ring-primary bg-white resize-none"
              placeholder="Masukkan catatan (Jika Ada)">{{ $log->catatan }}</textarea>
            <x-input-error :messages="$errors->get('catatan')" class="mt-2" />
          </div>
        </div>
        <div class="flex justify-center items-center">
          <button type="submit" class="bg-primary hover:bg-[#00295A] text-white px-4 py-2 rounded-lg font-medium">
            Ubah Log
          </button>
        </div>
      </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@35.3.0/build/ckeditor.js"></script>
    <script>
      const editors = ['editor-uraian', 'editor-catatan'];
      editors.forEach(id => {
        ClassicEditor
          .create(document.querySelector(`#${id}`), {
            toolbar: [
              'heading', '|',
              'bold', 'italic', 'underline', 'strikethrough', '|',
              'fontColor', 'fontSize', '|',
              'link', 'bulletedList', 'numberedList', '|',
              'alignment',
              'insertTable', '|',
              'undo', 'redo'
            ],
            fontSize: {
              options: [9, 11, 13, 'default', 17, 19, 21],
              supportAllValues: false
            },
            fontColor: {
              columns: 5,
              documentColors: 5
            }
          })
          .catch(error => {
            console.error(`Editor ${id} error:`, error);
          });
      });
    </script>

    <script>
      const statusSelect = document.getElementById('status_kehadiran');
      const formBukti = document.getElementById('form-bukti');

      if (statusSelect && formBukti) {
        statusSelect.addEventListener('change', function () {
          if (this.value === 'izin') {
            formBukti.classList.remove('hidden');
          } else {
            formBukti.classList.add('hidden');
          }
        });
      }
    </script>
  </x-user.webview>
@else
  <x-layout-web>
    <div class="bg-white rounded-xl shadow-lg md:max-w-4xl my-10 py-8 mx-6 md:mx-auto px-6 lg:px-8">
      <!-- Header -->
      <div class="mb-8">
        <div class="flex flex-col justify-center items-center">
          <h1 class="text-xl md:text-3xl font-bold text-gray-900 mb-2">Edit Log Harian Magang</h1>
          <p class="text-sm md:text-base font-semibold text-gray-600">Edit aktivitas harian selama masa magang</p>
        </div>
      </div>
      <form action="{{ route('log-harian.update', ['id' => $log->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="id_pendaftaran_magang" value="{{ $log->id_pendaftaran_magang }}">
        <div class="grid md:grid-cols-2 gap-6 px-6 mb-6">
          <!-- Tanggal -->
          <div>
            <div class="flex items-center mb-2">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              <x-input-label for="tanggal" :value="__('Tanggal')" />
            </div>
            <x-text-input id="tanggal" class="w-full px-4 py-3 rounded-xl bg-white/80" type="date" name="tanggal"
              :value="$log->tanggal" readonly required/>
            <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
          </div>

          <!-- Status Kehadiran harus presensi masuk dan pulang = otomatis hadir -->
          <!-- <div>
            <div>
              <div class="flex items-center mb-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <x-input-label for="status_kehadiran" :value="__('Status Kehadiran')" />
              </div>

              @php
                $presensi = $log->presensi ?? null;
                $hadirLengkap = $presensi && $presensi->jam_masuk && $presensi->jam_pulang;
              @endphp

              @if($hadirLengkap)

                #HADIR (AUTO DARI PRESENSI) 
                <input type="text"
                  class="w-full px-4 py-3 rounded-xl bg-green-100 text-green-700 font-semibold"
                  value="Hadir"
                  readonly>

                <input type="hidden" name="status_kehadiran" value="hadir">

              @else

                #IZIN / SAKIT 
                <select name="status_kehadiran" id="status_kehadiran"
                  class="w-full px-4 py-3 border rounded-xl shadow-sm focus:border-primary focus:ring-primary bg-white"
                  required>

                  <option value="">-- Status Kehadiran --</option>
                  <option value="sakit" {{ $log->status_kehadiran == 'sakit' ? 'selected' : '' }}>Sakit</option>
                  <option value="izin" {{ $log->status_kehadiran == 'izin' ? 'selected' : '' }}>Izin</option>

                </select>

              @endif

              <x-input-error :messages="$errors->get('status_kehadiran')" class="mt-2" />
            </div>
          </div> -->

          <div>
            <div>
              <div class="flex items-center mb-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <x-input-label for="status_kehadiran" :value="__('Status Kehadiran')" />
              </div>

              @php
                $presensi = $log->presensi ?? null;
                $hadirLengkap = $presensi && $presensi->jam_masuk;
              @endphp

              @if($hadirLengkap)

                <!-- HADIR (AUTO DARI PRESENSI)  -->
                <input type="text"
                  class="w-full px-4 py-3 rounded-xl bg-green-100 text-green-700 font-semibold"
                  value="{{ $presensi->jam_pulang ? 'Hadir' : 'Hadir (Belum Presensi Pulang)' }}"
                  readonly>

                <input type="hidden" name="status_kehadiran" value="hadir">

              @else

                <!-- IZIN / TANPA KETERANGAN -->
                <select name="status_kehadiran" id="status_kehadiran"
                  class="w-full px-4 py-3 border rounded-xl shadow-sm focus:border-primary focus:ring-primary bg-white"
                  required>

                  <option value="">-- Status Kehadiran --</option>
                  <option value="izin" {{ $log->status_kehadiran == 'izin' ? 'selected' : '' }}>Izin</option>
                  <option value="tanpa_keterangan" {{ $log->status_kehadiran == 'tanpa keterangan' ? 'selected' : '' }}>Tanpa Keterangan</option>

                </select>

              @endif

              <x-input-error :messages="$errors->get('status_kehadiran')" class="mt-2" />
            </div>
          </div>
        </div>

        <div class="grid md:grid-cols-2 gap-6 px-6 mb-6">

          <div>
            <x-input-label value="Jam Masuk" />
            <input type="text" class="w-full px-4 py-3 rounded-xl bg-gray-100"
              value="{{ $log->presensi?->jam_masuk ? \Carbon\Carbon::parse($log->presensi->jam_masuk)->format('H:i') : '-' }}" readonly>
          </div>

          <div>
            <x-input-label value="Jam Pulang" />
            <input type="text" class="w-full px-4 py-3 rounded-xl bg-gray-100"
              value="{{ $log->presensi?->jam_pulang ? \Carbon\Carbon::parse($log->presensi->jam_pulang)->format('H:i') : '-' }}" readonly>
          </div>

        </div>

        {{-- Bukti Izin --}}
        <div id="form-bukti"
            class="px-6 mb-6 {{ $log->status_kehadiran === 'izin' ? '' : 'hidden' }}">

          <x-input-label value="Bukti Izin" />

          <div class="mt-2 p-4 rounded-xl bg-blue-50 border border-blue-200 space-y-3">

            {{-- Jika sudah ada bukti --}}
            @if($log->bukti_izin)
              <div class="flex items-center justify-between gap-4">
                <div class="text-sm text-gray-700">
                  <p class="font-semibold">Bukti izin saat ini</p>
                  <p class="text-xs text-gray-500">Klik untuk melihat atau unduh</p>
                </div>

                <div class="flex gap-2">
                  <a href="{{ asset('storage/'.$log->bukti_izin) }}"
                    target="_blank"
                    class="px-3 py-2 text-sm rounded-lg bg-white border text-blue-600 hover:bg-blue-100">
                    Lihat
                  </a>

                  <a href="{{ asset('storage/'.$log->bukti_izin) }}"
                    download
                    class="px-3 py-2 text-sm rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                    Download
                  </a>
                </div>
              </div>
            @endif

            {{-- Upload ulang --}}
            <div>
              <x-input-label value="Upload Bukti Izin (Opsional)" />
              <input type="file"
                    name="bukti_izin"
                    accept=".jpg,.jpeg,.png,.pdf"
                    class="w-full px-4 py-2 border rounded-lg bg-white">

              <p class="text-xs text-gray-500 mt-1">
                Format: JPG, PNG, PDF (Max 2MB)
              </p>

              <x-input-error :messages="$errors->get('bukti_izin')" class="mt-2" />
            </div>

          </div>
        </div>

        <div class="grid grid-cols-1 gap-6 px-6 mb-6">
          <div>
            <div class="flex items-center mb-2">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
              </svg>
              <x-input-label for="uraian kegiatan" :value="__('Uraian Kegiatan')" />
            </div>
            <textarea id="editor-uraian" name="uraian_kegiatan"
              class="w-full px-4 py-3 border rounded-xl shadow-sm focus:border-primary focus:ring-primary bg-white resize-none"
              placeholder="Jelaskan aktivitas magang hari ini">{{ $log->uraian_kegiatan }}</textarea>
            <x-input-error :messages="$errors->get('uraian_kegiatan')" class="mt-2" />
          </div>

          <div>
            <div class="flex items-center mb-2">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
              </svg>
              <x-input-label for="catatan" :value="__('Catatan (Opsional)')" />
            </div>
            <textarea id="editor-catatan" name="catatan"
              class="w-full px-4 py-3 border rounded-xl shadow-sm focus:border-primary focus:ring-primary bg-white resize-none"
              placeholder="Masukkan catatan (Jika Ada)">{{ $log->catatan }}</textarea>
            <x-input-error :messages="$errors->get('catatan')" class="mt-2" />
          </div>
        </div>
        <div class="flex justify-center items-center">
          <button type="submit" class="bg-primary hover:bg-[#00295A] text-white px-4 py-2 rounded-lg font-medium">
            Ubah Log
          </button>
        </div>
      </form>
    </div>

    <x-footer class="fill-[#EEF0F2]" />

    <script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@35.3.0/build/ckeditor.js"></script>
    <script>
      const editors = ['editor-uraian', 'editor-catatan'];
      editors.forEach(id => {
        ClassicEditor
          .create(document.querySelector(`#${id}`), {
            toolbar: [
              'heading', '|',
              'bold', 'italic', 'underline', 'strikethrough', '|',
              'fontColor', 'fontSize', '|',
              'link', 'bulletedList', 'numberedList', '|',
              'alignment',
              'insertTable', '|',
              'undo', 'redo'
            ],
            fontSize: {
              options: [9, 11, 13, 'default', 17, 19, 21],
              supportAllValues: false
            },
            fontColor: {
              columns: 5,
              documentColors: 5
            }
          })
          .catch(error => {
            console.error(`Editor ${id} error:`, error);
          });
      });
    </script>

    <script>
      const statusSelect = document.getElementById('status_kehadiran');
      const formBukti = document.getElementById('form-bukti');

      if (statusSelect && formBukti) {
        statusSelect.addEventListener('change', function () {
          if (this.value === 'izin') {
            formBukti.classList.remove('hidden');
          } else {
            formBukti.classList.add('hidden');
          }
        });
      }
    </script>
  </x-layout-web>
@endif
