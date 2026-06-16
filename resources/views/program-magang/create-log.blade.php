@if (session('mobile_app')) 
    <x-user.webview>
      <div class="bg-white rounded-xl shadow-lg md:max-w-4xl my-10 py-8 mx-6 md:mx-auto px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
          <div class="flex flex-col justify-center items-center">
            <h1 class="text-xl md:text-3xl font-bold text-gray-900 mb-2">Tambah Log Harian Magang</h1>
            <p class="text-sm md:text-base font-semibold text-gray-600">Tambah aktivitas harian selama masa magang</p>
          </div>
        </div>

        <div class="grid md:grid-cols-2 gap-6 px-6 mb-6">
          <!-- TANGGAL (FORM GET - TETAP SENDIRI) -->
          <form method="GET" action="{{ route('log-harian.create-log') }}">
            <div>
              <div class="flex items-center mb-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <x-input-label for="tanggal" value="Tanggal" />
              </div>

              <input
                type="date"
                name="tanggal"
                value="{{ request('tanggal', $tanggal) }}"
                min="{{ now()->startOfMonth()->format('Y-m-d') }}"
                max="{{ now()->endOfMonth()->format('Y-m-d') }}"
                onchange="this.form.submit()"
                class="w-full px-4 py-3 rounded-xl bg-white"
                required
              >
            </div>
          </form>

          <form  action="{{ $log ? route('log-harian.update', $log->id) : route('log-harian.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if($log)
              @method('PUT')
            @endif

            <input type="hidden" name="tanggal" value="{{ $tanggal }}">
            <input type="hidden" name="id_pendaftaran_magang" value="{{ $pendaftaran->id }}">
          <!-- STATUS KEHADIRAN (MASIH BAGIAN FORM POST) -->
            <div>
              <div class="flex items-center mb-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <x-input-label value="Status Kehadiran" />
              </div>
          
              @if($log && $log->status_kehadiran === 'hadir')
                <input type="text"
                  class="w-full px-4 py-3 rounded-xl bg-green-100 text-green-700 font-semibold"
                  value="Hadir"
                  readonly>
                <input type="hidden" name="status_kehadiran" value="hadir">

              @elseif($log && $log->status_kehadiran === 'izin')
                <input type="text"
                  class="w-full px-4 py-3 rounded-xl bg-yellow-100 text-yellow-700 font-semibold"
                  value="Izin"
                  readonly>
                <input type="hidden" name="status_kehadiran" value="izin">

              @elseif($log && $log->status_kehadiran === 'tanpa_keterangan')
                <input type="text"
                  class="w-full px-4 py-3 rounded-xl bg-red-100 text-red-700 font-semibold"
                  value="Tanpa Keterangan"
                  readonly>
                <input type="hidden" name="status_kehadiran" value="tanpa_keterangan">

              @elseif($presensi && $presensi->jam_masuk)
                <input type="text"
                  class="w-full px-4 py-3 rounded-xl bg-green-100 text-green-700 font-semibold"
                  value="Hadir (Otomatis)"
                  readonly>
                <input type="hidden" name="status_kehadiran" value="hadir">

              @else
                <select name="status_kehadiran" id="status_kehadiran"
                  class="w-full px-4 py-3 border rounded-xl bg-white"
                  required>
                  <option value="" disabled selected>-- Status Kehadiran --</option>
                  <option value="izin">Izin</option>
                  <option value="tanpa_keterangan">Tanpa Keterangan</option>
                </select>
              @endif

              <x-input-error :messages="$errors->get('status_kehadiran')" class="mt-2" />
            </div>

        </div>

          <div class="grid md:grid-cols-2 gap-6 px-6 mb-6">

            <div>
              <x-input-label value="Jam Masuk" />
              <input type="text" class="w-full px-4 py-3 rounded-xl bg-gray-100"
                value="{{ $presensi?->jam_masuk ? \Carbon\Carbon::parse($presensi->jam_masuk)->format('H:i') : '-' }}" readonly>
            </div>

            <div>
              <x-input-label value="Jam Pulang" />
              <input type="text" class="w-full px-4 py-3 rounded-xl bg-gray-100"
                value="{{ $presensi?->jam_pulang ? \Carbon\Carbon::parse($presensi->jam_pulang)->format('H:i') : '-' }}" readonly>
            </div>

          </div>

          <div class="grid grid-cols-1 gap-6 px-6 mb-6">        
            <div id="form-bukti" data-has-bukti="{{ !empty($log->bukti_izin) ? '1' : '0' }}" class="{{ old('status_kehadiran', $log->status_kehadiran ?? '') === 'izin' || !empty($log->bukti_izin) ? '' : 'hidden' }}">          
              <div class="flex items-center mb-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 11c0 1.657-1.343 3-3 3S6 12.657 6 11s1.343-3 3-3 3 1.343 3 3z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19.428 15.341A8 8 0 114.572 8.659" />
                </svg>
                <x-input-label value="Bukti Izin" />
              </div>
              
              <div class="p-4 border border-dashed rounded-xl bg-gray-50">

                <p class="text-sm text-gray-600 mb-3">
                  Upload surat izin atau bukti resmi jika memilih status <span class="font-medium">Izin</span>.
                </p>
                
                @if(!empty($log->bukti_izin))
                  <div class="mb-4 p-3 bg-white border rounded-lg">
                    <p class="text-sm font-medium text-gray-700 mb-2">
                      Bukti izin tersimpan:
                    </p>

                    @if(Str::endsWith($log->bukti_izin, ['.jpg', '.jpeg', '.png']))
                      <img
                        src="{{ asset('storage/' . $log->bukti_izin) }}"
                        alt="Bukti Izin"
                        class="w-56 rounded-lg border shadow-sm"
                      >
                    @else
                      <a
                        href="{{ asset('storage/' . $log->bukti_izin) }}"
                        target="_blank"
                        class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 text-sm underline"
                      >
                        📄 Lihat Bukti Izin (PDF)
                      </a>
                    @endif

                    <p class="text-xs text-gray-500 mt-2">
                      Anda dapat mengganti bukti izin dengan mengupload file baru.
                    </p>
                  </div>
                @endif
                
                <input
                  type="file"
                  name="bukti_izin"
                  id="bukti_izin"
                  accept=".jpg,.jpeg,.png,.pdf"
                  class="w-full px-4 py-3 border rounded-xl bg-white focus:border-primary focus:ring-primary"
                >

                <p class="text-sm text-gray-500 mt-2">
                  Format: JPG, PNG, atau PDF (maks. 2MB)
                </p>

                <x-input-error :messages="$errors->get('bukti_izin')" class="mt-2" />
              </div>
            </div>

            <div>
              <div class="flex items-center mb-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <x-input-label for="uraian kegiatan" value="Uraian Kegiatan" />
              </div>

              <textarea
                id="editor-uraian"
                name="uraian_kegiatan"
                class="w-full px-4 py-3 border rounded-xl shadow-sm focus:border-primary focus:ring-primary bg-white resize-none"
                placeholder="Jelaskan aktivitas magang hari ini"
              >{{ old('uraian_kegiatan', $log->uraian_kegiatan ?? '') }}</textarea>

              <x-input-error :messages="$errors->get('uraian_kegiatan')" class="mt-2" />
            </div>

            <div>
              <div class="flex items-center mb-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <x-input-label for="catatan" value="Catatan (Opsional)" />
              </div>

              <textarea
                id="editor-catatan"
                name="catatan"
                class="w-full px-4 py-3 border rounded-xl shadow-sm focus:border-primary focus:ring-primary bg-white resize-none"
                placeholder="Masukkan catatan (Jika ada)"
              >{{ old('catatan', $log->catatan ?? '') }}</textarea>

              <x-input-error :messages="$errors->get('catatan')" class="mt-2" />
            </div>

          </div>
          <div class="flex justify-center items-center">
            <button type="submit" class="bg-primary hover:bg-[#00295A] text-white px-4 py-2 rounded-lg font-medium">
              Tambah Log
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
        document.addEventListener('DOMContentLoaded', function () {
          const statusSelect = document.getElementById('status_kehadiran');
          const formBukti = document.getElementById('form-bukti');
          const buktiInput = document.getElementById('bukti_izin');

          if (!formBukti) return;

          // Cek apakah sudah ada bukti dari server (edit)
          const hasBukti = formBukti.dataset.hasBukti === '1';

          function toggleBukti() {        
            // JIKA SUDAH ADA BUKTI (EDIT)      
            if (hasBukti) {
              formBukti.classList.remove('hidden');
              buktiInput?.removeAttribute('required'); // tidak wajib upload ulang
              return;
            }
            
            // JIKA STATUS = IZIN        
            if (statusSelect && statusSelect.value === 'izin') {
              formBukti.classList.remove('hidden');
              buktiInput?.setAttribute('required', 'required'); // WAJIB
            } else {
              formBukti.classList.add('hidden');
              buktiInput?.removeAttribute('required');
            }
          }

          if (statusSelect) {
            statusSelect.addEventListener('change', toggleBukti);
          }

          toggleBukti(); // jalankan saat halaman pertama kali dibuka
        });
        </script>
    </x-user.webview>
@else
    <x-layout-web>
      <div class="bg-white rounded-xl shadow-lg md:max-w-4xl my-10 py-8 mx-6 md:mx-auto px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
          <div class="flex flex-col justify-center items-center">
            <h1 class="text-xl md:text-3xl font-bold text-gray-900 mb-2">Tambah Log Harian Magang</h1>
            <p class="text-sm md:text-base font-semibold text-gray-600">Tambah aktivitas harian selama masa magang</p>
          </div>
        </div>

        <div class="grid md:grid-cols-2 gap-6 px-6 mb-6">
          <!-- TANGGAL (FORM GET - TETAP SENDIRI) -->
          <form method="GET" action="{{ route('log-harian.create-log') }}">
            <div>
              <div class="flex items-center mb-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <x-input-label for="tanggal" value="Tanggal" />
              </div>

              <input
                type="date"
                name="tanggal"
                value="{{ request('tanggal', $tanggal) }}"
                min="{{ now()->startOfMonth()->format('Y-m-d') }}"
                max="{{ now()->endOfMonth()->format('Y-m-d') }}"
                onchange="this.form.submit()"
                class="w-full px-4 py-3 rounded-xl bg-white"
                required
              >
            </div>
          </form>

          <form  action="{{ $log ? route('log-harian.update', $log->id) : route('log-harian.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if($log)
              @method('PUT')
            @endif

            <input type="hidden" name="tanggal" value="{{ $tanggal }}">
            <input type="hidden" name="id_pendaftaran_magang" value="{{ $pendaftaran->id }}">
          <!-- STATUS KEHADIRAN (MASIH BAGIAN FORM POST) -->
            <div>
              <div class="flex items-center mb-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <x-input-label value="Status Kehadiran" />
              </div>
          
              @if($log && $log->status_kehadiran === 'hadir')
                <input type="text"
                  class="w-full px-4 py-3 rounded-xl bg-green-100 text-green-700 font-semibold"
                  value="Hadir"
                  readonly>
                <input type="hidden" name="status_kehadiran" value="hadir">

              @elseif($log && $log->status_kehadiran === 'izin')
                <input type="text"
                  class="w-full px-4 py-3 rounded-xl bg-yellow-100 text-yellow-700 font-semibold"
                  value="Izin"
                  readonly>
                <input type="hidden" name="status_kehadiran" value="izin">

              @elseif($log && $log->status_kehadiran === 'tanpa_keterangan')
                <input type="text"
                  class="w-full px-4 py-3 rounded-xl bg-red-100 text-red-700 font-semibold"
                  value="Tanpa Keterangan"
                  readonly>
                <input type="hidden" name="status_kehadiran" value="tanpa_keterangan">

              @elseif($presensi && $presensi->jam_masuk)
                <input type="text"
                  class="w-full px-4 py-3 rounded-xl bg-green-100 text-green-700 font-semibold"
                  value="Hadir (Otomatis)"
                  readonly>
                <input type="hidden" name="status_kehadiran" value="hadir">

              @else
                <select name="status_kehadiran" id="status_kehadiran"
                  class="w-full px-4 py-3 border rounded-xl bg-white"
                  required>
                  <option value="" disabled selected>-- Status Kehadiran --</option>
                  <option value="izin">Izin</option>
                  <option value="tanpa_keterangan">Tanpa Keterangan</option>
                </select>
              @endif

              <x-input-error :messages="$errors->get('status_kehadiran')" class="mt-2" />
            </div>

        </div>

          <div class="grid md:grid-cols-2 gap-6 px-6 mb-6">

            <div>
              <x-input-label value="Jam Masuk" />
              <input type="text" class="w-full px-4 py-3 rounded-xl bg-gray-100"
                value="{{ $presensi?->jam_masuk ? \Carbon\Carbon::parse($presensi->jam_masuk)->format('H:i') : '-' }}" readonly>
            </div>

            <div>
              <x-input-label value="Jam Pulang" />
              <input type="text" class="w-full px-4 py-3 rounded-xl bg-gray-100"
                value="{{ $presensi?->jam_pulang ? \Carbon\Carbon::parse($presensi->jam_pulang)->format('H:i') : '-' }}" readonly>
            </div>

          </div>

          <div class="grid grid-cols-1 gap-6 px-6 mb-6">        
            <div id="form-bukti" data-has-bukti="{{ !empty($log->bukti_izin) ? '1' : '0' }}" class="{{ old('status_kehadiran', $log->status_kehadiran ?? '') === 'izin' || !empty($log->bukti_izin) ? '' : 'hidden' }}">          
              <div class="flex items-center mb-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 11c0 1.657-1.343 3-3 3S6 12.657 6 11s1.343-3 3-3 3 1.343 3 3z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19.428 15.341A8 8 0 114.572 8.659" />
                </svg>
                <x-input-label value="Bukti Izin" />
              </div>
              
              <div class="p-4 border border-dashed rounded-xl bg-gray-50">

                <p class="text-sm text-gray-600 mb-3">
                  Upload surat izin atau bukti resmi jika memilih status <span class="font-medium">Izin</span>.
                </p>
                
                @if(!empty($log->bukti_izin))
                  <div class="mb-4 p-3 bg-white border rounded-lg">
                    <p class="text-sm font-medium text-gray-700 mb-2">
                      Bukti izin tersimpan:
                    </p>

                    @if(Str::endsWith($log->bukti_izin, ['.jpg', '.jpeg', '.png']))
                      <img
                        src="{{ asset('storage/' . $log->bukti_izin) }}"
                        alt="Bukti Izin"
                        class="w-56 rounded-lg border shadow-sm"
                      >
                    @else
                      <a
                        href="{{ asset('storage/' . $log->bukti_izin) }}"
                        target="_blank"
                        class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 text-sm underline"
                      >
                        📄 Lihat Bukti Izin (PDF)
                      </a>
                    @endif

                    <p class="text-xs text-gray-500 mt-2">
                      Anda dapat mengganti bukti izin dengan mengupload file baru.
                    </p>
                  </div>
                @endif
                
                <input
                  type="file"
                  name="bukti_izin"
                  id="bukti_izin"
                  accept=".jpg,.jpeg,.png,.pdf"
                  class="w-full px-4 py-3 border rounded-xl bg-white focus:border-primary focus:ring-primary"
                >

                <p class="text-sm text-gray-500 mt-2">
                  Format: JPG, PNG, atau PDF (maks. 2MB)
                </p>

                <x-input-error :messages="$errors->get('bukti_izin')" class="mt-2" />
              </div>
            </div>

            <div>
              <div class="flex items-center mb-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <x-input-label for="uraian kegiatan" value="Uraian Kegiatan" />
              </div>

              <textarea
                id="editor-uraian"
                name="uraian_kegiatan"
                class="w-full px-4 py-3 border rounded-xl shadow-sm focus:border-primary focus:ring-primary bg-white resize-none"
                placeholder="Jelaskan aktivitas magang hari ini"
              >{{ old('uraian_kegiatan', $log->uraian_kegiatan ?? '') }}</textarea>

              <x-input-error :messages="$errors->get('uraian_kegiatan')" class="mt-2" />
            </div>

            <div>
              <div class="flex items-center mb-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <x-input-label for="catatan" value="Catatan (Opsional)" />
              </div>

              <textarea
                id="editor-catatan"
                name="catatan"
                class="w-full px-4 py-3 border rounded-xl shadow-sm focus:border-primary focus:ring-primary bg-white resize-none"
                placeholder="Masukkan catatan (Jika ada)"
              >{{ old('catatan', $log->catatan ?? '') }}</textarea>

              <x-input-error :messages="$errors->get('catatan')" class="mt-2" />
            </div>

          </div>
          <div class="flex justify-center items-center">
            <button type="submit" class="bg-primary hover:bg-[#00295A] text-white px-4 py-2 rounded-lg font-medium">
              Tambah Log
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
        document.addEventListener('DOMContentLoaded', function () {
          const statusSelect = document.getElementById('status_kehadiran');
          const formBukti = document.getElementById('form-bukti');
          const buktiInput = document.getElementById('bukti_izin');

          if (!formBukti) return;

          // Cek apakah sudah ada bukti dari server (edit)
          const hasBukti = formBukti.dataset.hasBukti === '1';

          function toggleBukti() {        
            // JIKA SUDAH ADA BUKTI (EDIT)      
            if (hasBukti) {
              formBukti.classList.remove('hidden');
              buktiInput?.removeAttribute('required'); // tidak wajib upload ulang
              return;
            }
            
            // JIKA STATUS = IZIN        
            if (statusSelect && statusSelect.value === 'izin') {
              formBukti.classList.remove('hidden');
              buktiInput?.setAttribute('required', 'required'); // WAJIB
            } else {
              formBukti.classList.add('hidden');
              buktiInput?.removeAttribute('required');
            }
          }

          if (statusSelect) {
            statusSelect.addEventListener('change', toggleBukti);
          }

          toggleBukti(); // jalankan saat halaman pertama kali dibuka
        });
        </script>
    </x-layout-web>
@endif

