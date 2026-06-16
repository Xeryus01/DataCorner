@if(session('mobile_app'))
    <x-user.webview>
        <div class="container mx-auto px-4 py-8">
          <div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-6 text-center">
            <h1 class="text-2xl font-bold mb-3">PRESENSI MASUK</h1>
            <form method="POST" action="{{ route('presensi.masuk') }}" id="formPresensi">
              @csrf
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="bg-gray-50 border rounded-lg p-4 text-center">
                  <p class="text-sm text-gray-500">Tanggal</p>
                  <p class="mt-1 text-lg font-semibold text-gray-800">{{ $serverDate }}</p>
                </div>
                <div class="bg-gray-50 border rounded-lg p-4 text-center">
                  <p class="text-sm text-gray-500">Waktu (Server)</p>
                  <p class="mt-1 text-lg font-semibold text-gray-800">{{ $serverTime }}</p>
                </div>
                <div class="bg-gray-50 border rounded-lg p-4 text-center">
                  <p class="text-sm text-gray-500">Wilayah</p>
                  <p class="mt-1 text-lg font-semibold text-gray-800"> {{ $setting->wilayahBps->nama_wilayah }}</p>
                </div>
              </div>

              <input type="hidden" name="lat_masuk" id="lat_masuk">
              <input type="hidden" name="long_masuk" id="long_masuk">
              <input type="hidden" name="accuracy" id="accuracy">
              <input type="hidden" name="pengaturan_presensi_id" id="pengaturan_presensi_id" value="{{ $setting->id ?? '' }}">
              
              <div class="relative overflow-hidden rounded border mb-3 z-0">
                <div id="map" class="w-full h-[320px]"></div>
              </div>

              <!-- Status geotag visual -->
              <div id="mapStatus" class="relative bg-gradient-to-r from-blue-500 to-indigo-600
                          text-white px-5 py-3 rounded-2xl shadow-lg
                          inline-flex flex-col items-center justify-center
                          mb-4 transition-all duration-500">

                <span id="btn-geotag-line1" class="flex items-center gap-2 font-semibold text-sm md:text-base">
                  <span>Mencari akurasi</span>
                  <!-- Spinner animasi -->
                  <span id="geo-spinner" class="inline-block w-4 h-4 rounded-full border-2 border-white border-t-transparent animate-spin"></span>
                </span>

                <span id="btn-geotag-line2" class="text-xs md:text-sm mt-1 opacity-90">
                  Menunggu koordinat...
                </span>
              </div>  

              @if(session('alert'))
              <div class="bg-red-100 text-red-700 p-2 rounded mb-3">
                {{ session('alert') }}
              </div>
              @endif

              <div class="mb-4">
                  <label class="block text-sm font-medium text-gray-700 mb-1">
                    Keterangan (jika diperlukan)
                  </label>
                  <textarea name="keterangan_masuk" id="keterangan_masuk" rows="3" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200"
                    placeholder="Isi alasan jika terlambat atau di luar area..."></textarea>
                </div>

              <button type="submit" id="btnSubmit" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-semibold transition">
                Simpan Presensi
              </button>

              <a href="{{ route('daftar-magang.presensi') }}" class="mt-6 inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-gray-800 bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Daftar Presensi
              </a>
            </form>
          </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @push('scripts')
        <script>
          document.addEventListener('DOMContentLoaded', () => {

          /* =========================
            DATA KANTOR DARI LARAVEL
          ========================= */
          const selectPengaturan = document.getElementById('selectPengaturan');
          let kantorLat = parseFloat(selectPengaturan?.selectedOptions[0]?.dataset.lat) || {{ $setting->lat_kantor ?? 0 }};
          let kantorLon = parseFloat(selectPengaturan?.selectedOptions[0]?.dataset.lon) || {{ $setting->long_kantor ?? 0 }};
          let radiusKantor = parseFloat(selectPengaturan?.selectedOptions[0]?.dataset.radius) || {{ $setting->radius_kantor ?? 0 }}; // meter

          let diLuarRadiusJS = false; // status radius (GLOBAL)

            /* =========================
              ELEMENT
            ========================= */
            const line1 = document.getElementById('btn-geotag-line1');
            const line2 = document.getElementById('btn-geotag-line2');
            const spinner = document.getElementById('geo-spinner');

            const latInput = document.getElementById('lat_masuk');
            const lonInput = document.getElementById('long_masuk');
            const accInput = document.getElementById('accuracy');

            if (selectPengaturan) {
              selectPengaturan.addEventListener('change', function(){
                const opt = this.selectedOptions[0];
                kantorLat = parseFloat(opt.dataset.lat) || 0;
                kantorLon = parseFloat(opt.dataset.lon) || 0;
                radiusKantor = parseFloat(opt.dataset.radius) || 0;
                document.getElementById('pengaturan_presensi_id').value = this.value || '';
                if (latInput.value && lonInput.value) {
                  updateLocation(parseFloat(latInput.value), parseFloat(lonInput.value), parseFloat(accInput.value || 0));
                }
              });
            }

            /* =========================
              MAP INIT
            ========================= */
            const defaultLat = 	-2.15724761;
            const defaultLon = 106.16523656;
            const zoom = 17;

            const map = L.map('map', {
              zoomControl: true,
              attributionControl: true
            }).setView([defaultLat, defaultLon], zoom);

            const marker = L.marker([defaultLat, defaultLon]).addTo(map);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
              maxZoom: 19,
              attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            /* =========================
              FUNGSI HITUNG JARAK (HAVERSINE)
            ========================= */
            function hitungJarak(lat1, lon1, lat2, lon2) {
              const R = 6371000; // meter
              const dLat = (lat2 - lat1) * Math.PI / 180;
              const dLon = (lon2 - lon1) * Math.PI / 180;

              const a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(lat1 * Math.PI / 180) *
                Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);

              const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

              return R * c;
            }

            /*FIX MAP SAAT SCROLL */
            const refreshMap = () => map.invalidateSize();

            setTimeout(refreshMap, 300);
            window.addEventListener('resize', () => setTimeout(refreshMap, 200));
            window.addEventListener('scroll', refreshMap);

            /* UPDATE LOCATION */
            function updateLocation(lat, lon, accuracy) {
              map.setView([lat, lon], zoom, { animate: true });
              marker.setLatLng([lat, lon]);

              latInput.value = lat;
              lonInput.value = lon;
              accInput.value = accuracy.toFixed(2);

              // =========================
              // HITUNG JARAK KE KANTOR
              // =========================
              let jarak = 0;

              if (kantorLat && kantorLon) {
                jarak = hitungJarak(lat, lon, kantorLat, kantorLon);
              }

              if (radiusKantor > 0 && jarak > radiusKantor) {
                diLuarRadiusJS = true;
              } else {
                diLuarRadiusJS = false;
              }

              console.log("Jarak ke kantor:", jarak.toFixed(2), "meter");
              console.log("Di luar radius:", diLuarRadiusJS);

              // =========================
              // STATUS UI
              // =========================
              let statusRadius = diLuarRadiusJS ? "DI LUAR AREA" : "DALAM AREA";

              line1.innerHTML = "Lokasi terekam";
              line2.textContent = `Akurasi ± ${accuracy.toFixed(1)} m | Jarak ${jarak.toFixed(1)} m | ${statusRadius}`;
              spinner.classList.add('hidden');

              setTimeout(refreshMap, 200);
            }


            /* GEOLOCATION CHECK */
            if (!navigator.geolocation) {
              line1.textContent = "Geolocation tidak didukung";
              line2.textContent = "Browser Anda tidak kompatibel";
              spinner.classList.add('hidden');
              return;
            }

            /* AKURASI BERTINGKAT */
            const stages = [
              { duration: 15000, threshold: 5 },
              { duration: 15000, threshold: 10 },
              { duration: 15000, threshold: 15 },
              { duration: 30000, threshold: 20 },
              { duration: 0, threshold: Infinity }
            ];

            let stageIndex = 0;
            let stageStart = Date.now();
            let bestPos = null;

            // Fake GPS detection
            let initialAccuracy = null;
            let accuracyChanged = false;
            let fakeValidated = false;
            let fakeStart = Date.now();

            const watchId = navigator.geolocation.watchPosition(
              pos => {
                const lat = pos.coords.latitude;
                const lon = pos.coords.longitude;
                const acc = pos.coords.accuracy;

                const stage = stages[stageIndex];

                line1.innerHTML = `
                  <span>Mencari akurasi</span>
                  <span class="inline-block w-3 h-3 ml-2 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                `;

                line2.textContent = `Target ${stage.threshold} m • Jarak ${acc.toFixed(1)} m`;

                // Fake GPS check
                if (initialAccuracy === null) {
                  initialAccuracy = acc;
                  fakeStart = Date.now();
                } else {
                  if (acc !== initialAccuracy) accuracyChanged = true;

                  if (Date.now() - fakeStart > 3000) {
                    if (!accuracyChanged) {
                      navigator.geolocation.clearWatch(watchId);
                      line1.textContent = "Lokasi tidak valid";
                      line2.textContent = "Fake GPS terdeteksi";
                      spinner.classList.add('hidden');
                      return;
                    }
                    fakeValidated = true;
                  }
                }

                if (!bestPos || acc < bestPos.coords.accuracy) {
                  bestPos = pos;
                }

                if (fakeValidated && acc <= stage.threshold) {
                  finish(bestPos);
                  return;
                }

                if (Date.now() - stageStart > stage.duration) {
                  stageIndex++;
                  stageStart = Date.now();
                  initialAccuracy = null;
                  accuracyChanged = false;
                  fakeValidated = false;

                  if (stageIndex >= stages.length) {
                    finish(bestPos);
                  }
                }
              },
              err => {
                line1.textContent = "Gagal mengambil lokasi";
                line2.textContent = err.message;
                spinner.classList.add('hidden');
              },
              {
                enableHighAccuracy: true,
                maximumAge: 0,
                timeout: 130000
              }
            );

            function finish(pos) {
              navigator.geolocation.clearWatch(watchId);
              if (!pos) {
                line1.textContent = "Lokasi tidak ditemukan";
                line2.textContent = "Gunakan lokasi default";
                spinner.classList.add('hidden');
                return;
              }
              updateLocation(
                pos.coords.latitude,
                pos.coords.longitude,
                pos.coords.accuracy
              );
            }

              // =========================
              // VALIDASI KETERANGAN (POPUP SWEETALERT)
              // =========================
              const form = document.getElementById('formPresensi');
              const ketInput = document.getElementById('keterangan_masuk');

              // dari Laravel (terlambat)
              const terlambat = {{ $terlambat ? 'true' : 'false' }};

              form.addEventListener('submit', function(e) {
                  const keterangan = ketInput.value.trim();

                  // wajib keterangan jika terlambat ATAU di luar radius
                  const wajibKeterangan = terlambat || diLuarRadiusJS;

                  if (wajibKeterangan && keterangan === '') {
                      e.preventDefault();

                      let alasan = '';
                      if (terlambat && diLuarRadiusJS) {
                          alasan = 'Anda terlambat dan berada di luar area kantor.';
                      } else if (terlambat) {
                          alasan = 'Anda terlambat melakukan presensi.';
                      } else if (diLuarRadiusJS) {
                          alasan = 'Anda berada di luar radius kantor.';
                      }

                      Swal.fire({
                          icon: 'warning',
                          title: 'Keterangan Wajib Diisi',
                          html: `
                              <div style="text-align:left">
                                  <b>Alasan:</b><br>
                                  ${alasan}<br><br>
                                  Silakan isi keterangan sebelum menyimpan presensi.
                              </div>
                          `,
                          confirmButtonText: 'Isi Keterangan',
                          confirmButtonColor: '#16a34a'
                      });

                      ketInput.focus();
                      return false;
                  }
              });

          });


        </script>
        @endpush
    </x-user.webview>
@else
    <x-layout-web>
            <div class="container mx-auto px-4 py-8">
              <div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-6 text-center">
                <h1 class="text-2xl font-bold mb-3">PRESENSI MASUK</h1>
                <form method="POST" action="{{ route('presensi.masuk') }}" id="formPresensi">
                  @csrf
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="bg-gray-50 border rounded-lg p-4 text-center">
                      <p class="text-sm text-gray-500">Tanggal</p>
                      <p class="mt-1 text-lg font-semibold text-gray-800">{{ $serverDate }}</p>
                    </div>
                    <div class="bg-gray-50 border rounded-lg p-4 text-center">
                      <p class="text-sm text-gray-500">Waktu (Server)</p>
                      <p class="mt-1 text-lg font-semibold text-gray-800">{{ $serverTime }}</p>
                    </div>     
                    <div class="bg-gray-50 border rounded-lg p-4 text-center">
                      <p class="text-sm text-gray-500">Wilayah</p>
                      <p class="mt-1 text-lg font-semibold text-gray-800"> {{ $setting->wilayahBps->nama_wilayah }}</p>
                    </div>         
                  </div>

                  <input type="hidden" name="lat_masuk" id="lat_masuk">
                  <input type="hidden" name="long_masuk" id="long_masuk">
                  <input type="hidden" name="accuracy" id="accuracy">

                  <div class="relative overflow-hidden rounded border mb-3 z-0">
                    <div id="map" class="w-full h-[320px]"></div>
                  </div>

                  <!-- Status geotag visual -->
                  <div id="mapStatus" class="relative bg-gradient-to-r from-blue-500 to-indigo-600
                              text-white px-5 py-3 rounded-2xl shadow-lg
                              inline-flex flex-col items-center justify-center
                              mb-4 transition-all duration-500">

                    <span id="btn-geotag-line1" class="flex items-center gap-2 font-semibold text-sm md:text-base">
                      <span>Mencari akurasi</span>
                      <!-- Spinner animasi -->
                      <span id="geo-spinner" class="inline-block w-4 h-4 rounded-full border-2 border-white border-t-transparent animate-spin"></span>
                    </span>

                    <span id="btn-geotag-line2" class="text-xs md:text-sm mt-1 opacity-90">
                      Menunggu koordinat...
                    </span>
                  </div>  

                  @if(session('alert'))
                  <div class="bg-red-100 text-red-700 p-2 rounded mb-3">
                    {{ session('alert') }}
                  </div>
                  @endif

                  <div class="mb-4">
                      <label class="block text-sm font-medium text-gray-700 mb-1">
                        Keterangan (jika diperlukan)
                      </label>
                      <textarea name="keterangan_masuk" id="keterangan_masuk" rows="3" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200"
                        placeholder="Isi alasan jika terlambat atau di luar area..."></textarea>
                    </div>

                  <button type="submit" id="btnSubmit" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-semibold transition">
                    Simpan Presensi
                  </button>

                  <a href="{{ route('daftar-magang.presensi') }}" class="mt-6 inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-gray-800 bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Daftar Presensi
                  </a>
                </form>
              </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            @push('scripts')
            <script>
              document.addEventListener('DOMContentLoaded', () => {

              /* =========================
                DATA KANTOR DARI LARAVEL
              ========================= */
              const selectPengaturan = document.getElementById('selectPengaturan');
              let kantorLat = parseFloat(selectPengaturan?.selectedOptions[0]?.dataset.lat) || {{ $setting->lat_kantor ?? 0 }};
              let kantorLon = parseFloat(selectPengaturan?.selectedOptions[0]?.dataset.lon) || {{ $setting->long_kantor ?? 0 }};
              let radiusKantor = parseFloat(selectPengaturan?.selectedOptions[0]?.dataset.radius) || {{ $setting->radius_kantor ?? 0 }}; // meter

              let diLuarRadiusJS = false; // status radius (GLOBAL)

                /* =========================
                  ELEMENT
                ========================= */
                const line1 = document.getElementById('btn-geotag-line1');
                const line2 = document.getElementById('btn-geotag-line2');
                const spinner = document.getElementById('geo-spinner');

                const latInput = document.getElementById('lat_masuk');
                const lonInput = document.getElementById('long_masuk');
                const accInput = document.getElementById('accuracy');

                if (selectPengaturan) {
                  selectPengaturan.addEventListener('change', function(){
                    const opt = this.selectedOptions[0];
                    kantorLat = parseFloat(opt.dataset.lat) || 0;
                    kantorLon = parseFloat(opt.dataset.lon) || 0;
                    radiusKantor = parseFloat(opt.dataset.radius) || 0;
                    document.getElementById('pengaturan_presensi_id').value = this.value || '';
                    if (latInput.value && lonInput.value) {
                      updateLocation(parseFloat(latInput.value), parseFloat(lonInput.value), parseFloat(accInput.value || 0));
                    }
                  });
                }

                /* =========================
                  MAP INIT
                ========================= */
                const defaultLat = 	-2.15724761;
                const defaultLon = 106.16523656;
                const zoom = 17;

                const map = L.map('map', {
                  zoomControl: true,
                  attributionControl: true
                }).setView([defaultLat, defaultLon], zoom);

                const marker = L.marker([defaultLat, defaultLon]).addTo(map);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                  maxZoom: 19,
                  attribution: '&copy; OpenStreetMap'
                }).addTo(map);

                /* =========================
                  FUNGSI HITUNG JARAK (HAVERSINE)
                ========================= */
                function hitungJarak(lat1, lon1, lat2, lon2) {
                  const R = 6371000; // meter
                  const dLat = (lat2 - lat1) * Math.PI / 180;
                  const dLon = (lon2 - lon1) * Math.PI / 180;

                  const a =
                    Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                    Math.cos(lat1 * Math.PI / 180) *
                    Math.cos(lat2 * Math.PI / 180) *
                    Math.sin(dLon / 2) * Math.sin(dLon / 2);

                  const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

                  return R * c;
                }

                /*FIX MAP SAAT SCROLL */
                const refreshMap = () => map.invalidateSize();

                setTimeout(refreshMap, 300);
                window.addEventListener('resize', () => setTimeout(refreshMap, 200));
                window.addEventListener('scroll', refreshMap);

                /* UPDATE LOCATION */
                function updateLocation(lat, lon, accuracy) {
                  map.setView([lat, lon], zoom, { animate: true });
                  marker.setLatLng([lat, lon]);

                  latInput.value = lat;
                  lonInput.value = lon;
                  accInput.value = accuracy.toFixed(2);

                  // =========================
                  // HITUNG JARAK KE KANTOR
                  // =========================
                  let jarak = 0;

                  if (kantorLat && kantorLon) {
                    jarak = hitungJarak(lat, lon, kantorLat, kantorLon);
                  }

                  if (radiusKantor > 0 && jarak > radiusKantor) {
                    diLuarRadiusJS = true;
                  } else {
                    diLuarRadiusJS = false;
                  }

                  console.log("Jarak ke kantor:", jarak.toFixed(2), "meter");
                  console.log("Di luar radius:", diLuarRadiusJS);

                  // =========================
                  // STATUS UI
                  // =========================
                  let statusRadius = diLuarRadiusJS ? "DI LUAR AREA" : "DALAM AREA";

                  line1.innerHTML = "Lokasi terekam";
                  line2.textContent = `Akurasi ± ${accuracy.toFixed(1)} m | Jarak ${jarak.toFixed(1)} m | ${statusRadius}`;
                  spinner.classList.add('hidden');

                  setTimeout(refreshMap, 200);
                }


                /* GEOLOCATION CHECK */
                if (!navigator.geolocation) {
                  line1.textContent = "Geolocation tidak didukung";
                  line2.textContent = "Browser Anda tidak kompatibel";
                  spinner.classList.add('hidden');
                  return;
                }

                /* AKURASI BERTINGKAT */
                const stages = [
                  { duration: 15000, threshold: 5 },
                  { duration: 15000, threshold: 10 },
                  { duration: 15000, threshold: 15 },
                  { duration: 30000, threshold: 20 },
                  { duration: 0, threshold: Infinity }
                ];

                let stageIndex = 0;
                let stageStart = Date.now();
                let bestPos = null;

                // Fake GPS detection
                let initialAccuracy = null;
                let accuracyChanged = false;
                let fakeValidated = false;
                let fakeStart = Date.now();

                const watchId = navigator.geolocation.watchPosition(
                  pos => {
                    const lat = pos.coords.latitude;
                    const lon = pos.coords.longitude;
                    const acc = pos.coords.accuracy;

                    const stage = stages[stageIndex];

                    line1.innerHTML = `
                      <span>Mencari akurasi</span>
                      <span class="inline-block w-3 h-3 ml-2 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                    `;

                    line2.textContent = `Target ${stage.threshold} m • Jarak ${acc.toFixed(1)} m`;

                    // Fake GPS check
                    if (initialAccuracy === null) {
                      initialAccuracy = acc;
                      fakeStart = Date.now();
                    } else {
                      if (acc !== initialAccuracy) accuracyChanged = true;

                      if (Date.now() - fakeStart > 3000) {
                        if (!accuracyChanged) {
                          navigator.geolocation.clearWatch(watchId);
                          line1.textContent = "Lokasi tidak valid";
                          line2.textContent = "Fake GPS terdeteksi";
                          spinner.classList.add('hidden');
                          return;
                        }
                        fakeValidated = true;
                      }
                    }

                    if (!bestPos || acc < bestPos.coords.accuracy) {
                      bestPos = pos;
                    }

                    if (fakeValidated && acc <= stage.threshold) {
                      finish(bestPos);
                      return;
                    }

                    if (Date.now() - stageStart > stage.duration) {
                      stageIndex++;
                      stageStart = Date.now();
                      initialAccuracy = null;
                      accuracyChanged = false;
                      fakeValidated = false;

                      if (stageIndex >= stages.length) {
                        finish(bestPos);
                      }
                    }
                  },
                  err => {
                    line1.textContent = "Gagal mengambil lokasi";
                    line2.textContent = err.message;
                    spinner.classList.add('hidden');
                  },
                  {
                    enableHighAccuracy: true,
                    maximumAge: 0,
                    timeout: 130000
                  }
                );

                function finish(pos) {
                  navigator.geolocation.clearWatch(watchId);
                  if (!pos) {
                    line1.textContent = "Lokasi tidak ditemukan";
                    line2.textContent = "Gunakan lokasi default";
                    spinner.classList.add('hidden');
                    return;
                  }
                  updateLocation(
                    pos.coords.latitude,
                    pos.coords.longitude,
                    pos.coords.accuracy
                  );
                }

                  // =========================
                  // VALIDASI KETERANGAN (POPUP SWEETALERT)
                  // =========================
                  const form = document.getElementById('formPresensi');
                  const ketInput = document.getElementById('keterangan_masuk');

                  // dari Laravel (terlambat)
                  const terlambat = {{ $terlambat ? 'true' : 'false' }};

                  form.addEventListener('submit', function(e) {
                      const keterangan = ketInput.value.trim();

                      // wajib keterangan jika terlambat ATAU di luar radius
                      const wajibKeterangan = terlambat || diLuarRadiusJS;

                      if (wajibKeterangan && keterangan === '') {
                          e.preventDefault();

                          let alasan = '';
                          if (terlambat && diLuarRadiusJS) {
                              alasan = 'Anda terlambat dan berada di luar area kantor.';
                          } else if (terlambat) {
                              alasan = 'Anda terlambat melakukan presensi.';
                          } else if (diLuarRadiusJS) {
                              alasan = 'Anda berada di luar radius kantor.';
                          }

                          Swal.fire({
                              icon: 'warning',
                              title: 'Keterangan Wajib Diisi',
                              html: `
                                  <div style="text-align:left">
                                      <b>Alasan:</b><br>
                                      ${alasan}<br><br>
                                      Silakan isi keterangan sebelum menyimpan presensi.
                                  </div>
                              `,
                              confirmButtonText: 'Isi Keterangan',
                              confirmButtonColor: '#16a34a'
                          });

                          ketInput.focus();
                          return false;
                      }
                  });

              });


            </script>
            @endpush

          <x-footer class="fill-[#EEF0F2]" />
    </x-layout-web>
@endif


