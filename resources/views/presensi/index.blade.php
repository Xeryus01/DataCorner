@if(session('mobile_app'))
    <x-user.webview>
      <div class="py-8 mx-auto px-6 lg:px-8 max-w-4xl">

        <!-- Header -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
          <h1 class="text-3xl font-bold text-gray-900 mb-1">Presensi Magang</h1>
          <p class="text-gray-600">Pencatatan kehadiran harian peserta magang</p>
        </div>

        <!-- Alert -->
        @if(session('success'))
          <div class="mb-4 p-4 bg-green-100 border border-green-300 rounded-lg text-green-800 font-medium">
            {{ session('success') }}
          </div>
        @endif

        @if(session('error'))
          <div class="mb-4 p-4 bg-red-100 border border-red-300 rounded-lg text-red-800 font-medium">
            {{ session('error') }}
          </div>
        @endif

        @php
          $pendaftaran = \App\Models\PendaftaranMagang::where('user_id', auth()->id())
            ->where('status', 'diterima')
            ->first();
        @endphp

        <!-- Konten -->
        <div class="bg-white rounded-xl shadow-lg p-6">

          @if (! $pendaftaran)
            <div class="text-center py-10">
              <p class="text-gray-700 mb-4">
                Anda belum memiliki status <strong>diterima</strong> pada program magang.
              </p>
              <a href="{{ route('daftar-magang.index') }}"
                class="inline-flex items-center bg-primary text-white px-5 py-3 rounded-lg font-medium hover:bg-[#00295A] transition">
                Daftar Magang
              </a>
            </div>
          @else

            <!-- Tanggal -->
            <div class="flex items-center justify-between mb-6">
              <span class="text-sm text-gray-500">
                Tanggal: <strong>{{ now()->format('d M Y') }}</strong>
              </span>

              @if (! $presensiHariIni)
                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold">
                  Belum Presensi
                </span>
              @else
                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
                  Sudah Presensi
                </span>
              @endif
            </div>

            @if (! $presensiHariIni)

              <!-- Status -->
              <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg text-yellow-800">
                Anda belum melakukan presensi hari ini.
              </div>

              <!-- Tombol -->
              <div class="grid grid-cols-2 sm:grid-cols-2 gap-4">
                <a href="{{ route('presensi.form-masuk', $pendaftaran->id) }}">
                  <button
                    class="w-full flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-semibold transition">
                    Presensi Masuk
                  </button>
                </a>

                <a href="{{ route('presensi.form-pulang', $pendaftaran->id) }}">
                <button
                  class="w-full flex items-center justify-center gap-2 bg-gray-200 text-gray-400 py-3 rounded-lg font-semibold cursor-not-allowed"
                  disabled>
                  Presensi Pulang
                </button>
                </a>

                <a href="{{ route('daftar-magang.log-harian') }}">
                      <button type="button"
                          class="w-full py-3 rounded-xl font-semibold text-white bg-green-500 hover:bg-green-600 transition-shadow shadow-sm">
                          Isi Log Harian
                      </button>
                  </a>
              </div>

            @else

            <!-- INFO PRESENSI -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- JAM MASUK -->
                <div class="p-4 rounded-lg border min-h-[120px]
                    @if ($presensiHariIni && $presensiHariIni->jam_masuk)
                        bg-green-50 border-green-200
                    @else
                        bg-yellow-50 border-yellow-200
                    @endif
                ">
                    <p class="text-sm text-gray-600 mb-1">
                        Jam Masuk
                    </p>

                    <p class="text-2xl font-bold
                        @if ($presensiHariIni && $presensiHariIni->jam_masuk)
                            text-green-700
                        @else
                            text-yellow-700
                        @endif
                    ">
                        {{ $presensiHariIni->jam_masuk ? \Carbon\Carbon::parse($presensiHariIni->jam_masuk)->format('H.i') : '-' }}
                    </p>
                </div>


                <!-- JAM PULANG -->
                <div class="p-4 rounded-lg border min-h-[120px]
                    @if ($presensiHariIni && $presensiHariIni->jam_pulang)
                        bg-green-50 border-green-200
                    @else
                        bg-yellow-50 border-yellow-200
                    @endif
                ">
                    <p class="text-sm text-gray-600 mb-1">
                        Jam Pulang
                    </p>

                    <p class="text-2xl font-bold
                        @if ($presensiHariIni && $presensiHariIni->jam_pulang)
                            text-green-700
                        @else
                            text-yellow-700
                        @endif
                    ">
                        {{ $presensiHariIni->jam_pulang ? \Carbon\Carbon::parse($presensiHariIni->jam_pulang)->format('H.i') : '-' }}
                    </p>
                </div>

            </div>


            <!-- AKSI -->
            <div class="mt-6 flex flex-col space-y-3">

              <!-- Tombol Presensi Pulang -->
              @if ($presensiHariIni && $presensiHariIni->jam_masuk)
                  <button
                      onclick="window.location.href='{{ route('presensi.form-pulang', $pendaftaran->id) }}'"
                      class="w-full py-3 rounded-xl font-semibold text-white bg-blue-500 hover:bg-blue-600 transition-shadow shadow-sm">
                      {{ $presensiHariIni->jam_pulang ? 'Update Presensi Pulang' : 'Presensi Pulang' }}
                  </button>
              @endif

              <!-- Tombol Log Harian -->
              @if($presensiHariIni && $presensiHariIni->jam_masuk)
                  <a href="{{ route('daftar-magang.log-harian') }}">
                      <button type="button"
                          class="w-full py-3 rounded-xl font-semibold text-white bg-green-500 hover:bg-green-600 transition-shadow shadow-sm">
                          Isi Log Harian
                      </button>
                  </a>
              @endif      
            </div>

            @endif

            <div id="msg" class="mt-4 text-sm hidden"></div>

          @endif
        </div>
      </div>

      <!-- <script>
        function handlePresensiPulang(bolehPulang, jamPulang, jamSekarang) {
            if (!bolehPulang) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Presensi Pulang Belum Dibuka',
                    html: `
                        <div style="text-align:left">
                            <b>Waktu sekarang:</b> ${jamSekarang}<br>
                            <b>Presensi pulang dimulai:</b> ${jamPulang}<br><br>
                            Silakan melakukan presensi pulang setelah jam tersebut.
                        </div>
                    `,
                    confirmButtonText: 'Mengerti',
                    confirmButtonColor: '#64a5daff'
                });
                return false;
            }

            window.location.href = "{{ route('presensi.form-pulang', $pendaftaran->id) }}";
        }
      </script> -->
    </x-user.webview>
@else 
    <x-layout-web>
      <div class="py-8 mx-auto px-6 lg:px-8 max-w-4xl">

        <!-- Header -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
          <h1 class="text-3xl font-bold text-gray-900 mb-1">Presensi Magang</h1>
          <p class="text-gray-600">Pencatatan kehadiran harian peserta magang</p>
        </div>

        <!-- Alert -->
        @if(session('success'))
          <div class="mb-4 p-4 bg-green-100 border border-green-300 rounded-lg text-green-800 font-medium">
            {{ session('success') }}
          </div>
        @endif

        @if(session('error'))
          <div class="mb-4 p-4 bg-red-100 border border-red-300 rounded-lg text-red-800 font-medium">
            {{ session('error') }}
          </div>
        @endif

        @php
          $pendaftaran = \App\Models\PendaftaranMagang::where('user_id', auth()->id())
            ->where('status', 'diterima')
            ->first();
        @endphp

        <!-- Konten -->
        <div class="bg-white rounded-xl shadow-lg p-6">

          @if (! $pendaftaran)
            <div class="text-center py-10">
              <p class="text-gray-700 mb-4">
                Anda belum memiliki status <strong>diterima</strong> pada program magang.
              </p>
              <a href="{{ route('daftar-magang.index') }}"
                class="inline-flex items-center bg-primary text-white px-5 py-3 rounded-lg font-medium hover:bg-[#00295A] transition">
                Daftar Magang
              </a>
            </div>
          @else

            <!-- Tanggal -->
            <div class="flex items-center justify-between mb-6">
              <span class="text-sm text-gray-500">
                Tanggal: <strong>{{ now()->format('d M Y') }}</strong>
              </span>

              @if (! $presensiHariIni)
                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold">
                  Belum Presensi
                </span>
              @else
                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
                  Sudah Presensi
                </span>
              @endif
            </div>

            @if (! $presensiHariIni)

              <!-- Status -->
              <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg text-yellow-800">
                Anda belum melakukan presensi hari ini.
              </div>

              <!-- Tombol -->
              <div class="grid grid-cols-2 sm:grid-cols-2 gap-4">
                <a href="{{ route('presensi.form-masuk', $pendaftaran->id) }}">
                  <button
                    class="w-full flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-semibold transition">
                    Presensi Masuk
                  </button>
                </a>

                <a href="{{ route('presensi.form-pulang', $pendaftaran->id) }}">
                <button
                  class="w-full flex items-center justify-center gap-2 bg-gray-200 text-gray-400 py-3 rounded-lg font-semibold cursor-not-allowed"
                  disabled>
                  Presensi Pulang
                </button>
                </a>

                <a href="{{ route('daftar-magang.log-harian') }}">
                      <button type="button"
                          class="w-full py-3 rounded-xl font-semibold text-white bg-green-500 hover:bg-green-600 transition-shadow shadow-sm">
                          Isi Log Harian
                      </button>
                  </a>
              </div>

            @else

            <!-- INFO PRESENSI -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- JAM MASUK -->
                <div class="p-4 rounded-lg border min-h-[120px]
                    @if ($presensiHariIni && $presensiHariIni->jam_masuk)
                        bg-green-50 border-green-200
                    @else
                        bg-yellow-50 border-yellow-200
                    @endif
                ">
                    <p class="text-sm text-gray-600 mb-1">
                        Jam Masuk
                    </p>

                    <p class="text-2xl font-bold
                        @if ($presensiHariIni && $presensiHariIni->jam_masuk)
                            text-green-700
                        @else
                            text-yellow-700
                        @endif
                    ">
                        {{ $presensiHariIni->jam_masuk ? \Carbon\Carbon::parse($presensiHariIni->jam_masuk)->format('H.i') : '-' }}
                    </p>
                </div>


                <!-- JAM PULANG -->
                <div class="p-4 rounded-lg border min-h-[120px]
                    @if ($presensiHariIni && $presensiHariIni->jam_pulang)
                        bg-green-50 border-green-200
                    @else
                        bg-yellow-50 border-yellow-200
                    @endif
                ">
                    <p class="text-sm text-gray-600 mb-1">
                        Jam Pulang
                    </p>

                    <p class="text-2xl font-bold
                        @if ($presensiHariIni && $presensiHariIni->jam_pulang)
                            text-green-700
                        @else
                            text-yellow-700
                        @endif
                    ">
                        {{ $presensiHariIni->jam_pulang ? \Carbon\Carbon::parse($presensiHariIni->jam_pulang)->format('H.i') : '-' }}
                    </p>
                </div>

            </div>


            <!-- AKSI -->
            <div class="mt-6 flex flex-col space-y-3">

              <!-- Tombol Presensi Pulang -->
              @if ($presensiHariIni && $presensiHariIni->jam_masuk)
                  <button
                      onclick="window.location.href='{{ route('presensi.form-pulang', $pendaftaran->id) }}'"
                      class="w-full py-3 rounded-xl font-semibold text-white bg-blue-500 hover:bg-blue-600 transition-shadow shadow-sm">
                      {{ $presensiHariIni->jam_pulang ? 'Update Presensi Pulang' : 'Presensi Pulang' }}
                  </button>
              @endif

              <!-- Tombol Log Harian -->
              @if($presensiHariIni && $presensiHariIni->jam_masuk)
                  <a href="{{ route('daftar-magang.log-harian') }}">
                      <button type="button"
                          class="w-full py-3 rounded-xl font-semibold text-white bg-green-500 hover:bg-green-600 transition-shadow shadow-sm">
                          Isi Log Harian
                      </button>
                  </a>
              @endif      
            </div>

            @endif

            <div id="msg" class="mt-4 text-sm hidden"></div>

          @endif
        </div>
      </div>

      <!-- <script>
        function handlePresensiPulang(bolehPulang, jamPulang, jamSekarang) {
            if (!bolehPulang) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Presensi Pulang Belum Dibuka',
                    html: `
                        <div style="text-align:left">
                            <b>Waktu sekarang:</b> ${jamSekarang}<br>
                            <b>Presensi pulang dimulai:</b> ${jamPulang}<br><br>
                            Silakan melakukan presensi pulang setelah jam tersebut.
                        </div>
                    `,
                    confirmButtonText: 'Mengerti',
                    confirmButtonColor: '#64a5daff'
                });
                return false;
            }

            window.location.href = "{{ route('presensi.form-pulang', $pendaftaran->id) }}";
        }
      </script> -->
    </x-layout-web>
@endif

