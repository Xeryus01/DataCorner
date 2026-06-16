<x-layout-web>
  <!-- Main Content -->
  <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @if ($errors->any())
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        <strong class="font-bold">Oops!</strong>
        <span class="block sm:inline">{{ $errors->first() }}</span>
      </div>
    @endif

    <div
      class="bg-white max-w-xs mx-auto sticky top-24 md:top-28 z-50 rounded-2xl shadow-lg border border-gray-200 py-3 mb-8">
      <h3 class="text-sm md:text-lg text-center font-bold">Sisa Waktu Pengerjaan:</h3>
      <div id="timerBox" class="text-center text-sm md:text-lg font-bold text-red-600">
        Sisa Waktu: --
      </div>
    </div>

    <form id="quizForm" class="space-y-8" action="{{ route('kuis.submit', $kuis->slug) }}" method="POST">
      @csrf
      <input type="hidden" name="start_time_js" id="start_time_js">

      <input type="hidden" name="kuis_id" value="{{ $kuis->id }}">
      @foreach ($soal as $index => $item)
        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden animate-fade-in">
          <div class="bg-primary p-6 text-white">
            <div class="flex items-center space-x-3 mb-4">
              <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                <span class="text-sm font-bold">{{ $index + 1 }}</span>
              </div>
              <span class="text-blue-100 text-sm font-medium">Pertanyaan {{ $index + 1 }}</span>
              <span class="bg-white/20 text-xs px-2 py-1 rounded-full">
                {{ $item->tipe_soal }}
              </span>
            </div>
            @if ($item->gambar)
              <div class="max-w-md mx-auto mb-4">
                <img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar Soal" class="w-full object-cover">
              </div>
            @endif
            <h2 class="text-base lg:text-xl font-bold leading-tight">
              {!! $item->soal !!}
            </h2>
          </div>
          <div class="p-6 sm:p-8">
            @if ($item->tipe_soal === 'Pilihan Ganda')
              <!-- Tampilan Pilihan Ganda -->
              <div class="space-y-4">
                @foreach ($item->opsi as $opsi)
                  <label
                    class="flex items-center space-x-4 p-4 rounded-xl border-2 border-gray-200 hover:border-primary cursor-pointer transition-all duration-200 question-option">
                    <input type="radio" name="jawaban_{{ $item->id }}" value="{{ $opsi->id }}"
                      data-question-id="{{ $item->id }}" data-question-type="multiple_choice"
                      data-correct-answer="{{ $item->jawaban }}"
                      class="text-primary border-gray-300 focus:ring-primary question-input">
                    <p class="text-gray-900 font-medium">{{ $opsi->label }}. {{ $opsi->teks_opsi }}</p>
                  </label>
                @endforeach
              </div>
            @elseif($item->tipe_soal === 'Isian Singkat')
              <!-- Tampilan Isian Singkat -->
              <div class="space-y-4">
                <div class="relative">
                  <label for="jawaban_{{ $item->id }}" class="block text-sm font-medium text-gray-700 mb-2">
                    Jawaban Anda:
                  </label>
                  <input type="text" id="jawaban_{{ $item->id }}" name="jawaban_{{ $item->id }}"
                    data-question-id="{{ $item->id }}" data-question-type="short_answer"
                    data-correct-answer="{{ $item->jawaban }}"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary focus:outline-none transition-all duration-200 question-input"
                    placeholder="Ketik jawaban Anda di sini..." autocomplete="off">
                  <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none mt-8">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                      </path>
                    </svg>
                  </div>
                </div>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                  <div class="flex">
                    <div class="flex-shrink-0">
                      <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                          d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                          clip-rule="evenodd"></path>
                      </svg>
                    </div>
                    <div class="ml-3">
                      <p class="text-sm text-blue-700">
                        <strong>Tips:</strong> Pastikan ejaan sesuai. Jawaban akan diperiksa
                        secara otomatis.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            @endif
          </div>
        </div>
      @endforeach

      <!-- Submit Button -->
      <div class="bg-white rounded-2xl shadow-xl border border-gray-200 p-8 text-center animate-fade-in">
        <div class="max-w-md mx-auto">
          <h3 class="text-2xl font-bold text-gray-900 mb-4">Selesai Mengerjakan?</h3>
          <p class="text-gray-600 mb-6">Pastikan semua jawaban sudah terisi sebelum mengirim kuis.</p>

          <!-- Progress Bar -->
          <div class="mb-6">
            <div class="flex justify-between text-sm text-gray-600 mb-2">
              <span>Progress</span>
              <span id="progressText">0/{{ count($soal) }}</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
              <div id="progressBar" class="bg-primary h-2 rounded-full transition-all duration-300" style="width: 0%">
              </div>
            </div>
          </div>
          <input type="hidden" name="durasi_pengerjaan" id="durasiPengerjaanInput">

          <button type="submit" id="submitButton" disabled
            class="w-full bg-gray-400 text-white font-bold py-4 px-8 rounded-xl transition-all duration-200 shadow-lg text-lg cursor-not-allowed">
            <span class="flex items-center justify-center space-x-3">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <span>Kirim Jawaban</span>
            </span>
          </button>
          <p class="text-sm text-gray-500 mt-4">Setelah dikirim, jawaban tidak dapat diubah lagi.</p>
        </div>
      </div>
    </form>

    <!-- Modal Konfirmasi -->
    <div id="confirmationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
      <div class="bg-white rounded-2xl shadow-2xl max-w-md mx-4 p-8">
        <div class="text-center">
          <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 mb-4">
            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <h3 class="text-lg font-medium text-gray-900 mb-2">Konfirmasi Pengiriman</h3>
          <p class="text-sm text-gray-500 mb-6">Apakah Anda yakin ingin mengirim jawaban?</p>
          <div class="flex space-x-3">
            <button id="cancelSubmit"
              class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors">
              Batal
            </button>
            <button id="confirmSubmit"
              class="flex-1 bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 transition-colors">
              Ya, Kirim
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Waktu Habis -->
    <div id="timeUpModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
      <div class="bg-white rounded-2xl shadow-2xl max-w-md mx-4 p-8">
        <div class="text-center">
          <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <h3 class="text-lg font-medium text-gray-900 mb-2">⏰ Waktu Habis!</h3>
          <p class="text-sm text-gray-500 mb-6">Jawaban Anda akan dikirim otomatis dalam <span id="countdown">5</span>
            detik.</p>
          <div class="w-full bg-gray-200 rounded-full h-2 mb-4">
            <div id="countdownBar" class="bg-red-600 h-2 rounded-full transition-all duration-1000"
              style="width: 100%"></div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <x-footer class="fill-[#EEF0F2]"></x-footer>

  <script>
    // Ganti bagian script timer di file Blade Anda dengan ini:

    document.addEventListener('DOMContentLoaded', function() {
      const form = document.getElementById('quizForm');
      const inputs = document.querySelectorAll('.question-input');
      const submitButton = document.getElementById('submitButton');
      const progressBar = document.getElementById('progressBar');
      const progressText = document.getElementById('progressText');
      const confirmationModal = document.getElementById('confirmationModal');
      const timeUpModal = document.getElementById('timeUpModal');
      const cancelSubmit = document.getElementById('cancelSubmit');
      const confirmSubmit = document.getElementById('confirmSubmit');
      const submitNow = document.getElementById('submitNow');

      const totalQuestions = {{ count($soal) }};
      let answeredQuestions = new Set();
      let timeUpTriggered = false;

      // =========================
      // 1. Progress Bar & Cek Jawaban
      // =========================
      inputs.forEach(input => {
        input.addEventListener('input', () => {
          const id = input.dataset.questionId;

          if (input.type === 'radio') {
            if (input.checked) answeredQuestions.add(id);
          } else if (input.type === 'text') {
            if (input.value.trim() !== '') answeredQuestions.add(id);
            else answeredQuestions.delete(id);
          }

          const answeredCount = answeredQuestions.size;
          progressText.textContent = `${answeredCount}/${totalQuestions}`;
          progressBar.style.width = `${(answeredCount / totalQuestions) * 100}%`;

          if (answeredQuestions.size === totalQuestions) {
            submitButton.disabled = false;
            submitButton.classList.remove('bg-gray-400', 'cursor-not-allowed');
            submitButton.classList.add('bg-primary', 'cursor-pointer');
          } else {
            submitButton.disabled = true;
            submitButton.classList.remove('bg-primary', 'cursor-pointer');
            submitButton.classList.add('bg-gray-400', 'cursor-not-allowed');
          }
        });
      });

      // =========================
      // 2. Timer Countdown - DIPERBAIKI
      // =========================
      const kuisId = {{ $kuis->id }};
      const startTimeKey = `quiz_start_time_${kuisId}`;
      const durasiAwal = {{ $durasi }} * 60; // dalam detik

      const isRefresh = performance.navigation.type === 1;
      let startTime = localStorage.getItem(startTimeKey);
      if (!startTime || !isRefresh) {
        startTime = Math.floor(Date.now() / 1000);
        localStorage.setItem(startTimeKey, startTime);
      } else {
        startTime = parseInt(startTime);
      }

      // Set start time ke hidden input
      document.getElementById('start_time_js').value = startTime;

      function getSisaWaktu() {
        const currentTime = Math.floor(Date.now() / 1000);
        const elapsedTime = currentTime - startTime;
        return Math.max(0, durasiAwal - elapsedTime);
      }

      function getDurasiPengerjaan() {
        const currentTime = Math.floor(Date.now() / 1000);
        const elapsedTime = currentTime - startTime;
        return Math.min(elapsedTime, durasiAwal); // Batasi max durasi
      }

      const timerInterval = setInterval(() => {
        const sisaWaktu = getSisaWaktu();
        let menit = Math.floor(sisaWaktu / 60);
        let detik = sisaWaktu % 60;
        let timerBox = document.getElementById('timerBox');

        if (timerBox) {
          timerBox.textContent =
            `Sisa Waktu: ${menit.toString().padStart(2, '0')}:${detik.toString().padStart(2, '0')}`;

          if (sisaWaktu <= 300) timerBox.classList.add('text-red-600', 'animate-pulse');
          else if (sisaWaktu <= 600) timerBox.classList.add('text-yellow-600');
        }

        if (sisaWaktu <= 0) {
          clearInterval(timerInterval);
          localStorage.removeItem(startTimeKey);
          showTimeUpModal();
        }
      }, 1000);

      // =========================
      // 3. Submit dan Modal Konfirmasi
      // =========================
      form.addEventListener('submit', function(e) {
        if (!timeUpTriggered) {
          e.preventDefault();
          confirmationModal.classList.remove('hidden');
          confirmationModal.classList.add('flex');
        }
      });

      confirmSubmit.addEventListener('click', function() {
        cleanUpBeforeSubmit();
        form.submit();
      });



      cancelSubmit.addEventListener('click', function() {
        confirmationModal.classList.add('hidden');
        confirmationModal.classList.remove('flex');
      });

      function showTimeUpModal() {
        timeUpTriggered = true;
        timeUpModal.classList.remove('hidden');
        timeUpModal.classList.add('flex');

        let countdownSeconds = 5;
        const countdownElement = document.getElementById('countdown');
        const countdownBar = document.getElementById('countdownBar');

        const countdownInterval = setInterval(() => {
          countdownSeconds--;
          countdownElement.textContent = countdownSeconds;
          countdownBar.style.width = `${(countdownSeconds / 5) * 100}%`;

          if (countdownSeconds <= 0) {
            clearInterval(countdownInterval);
            cleanUpBeforeSubmit();
            form.requestSubmit();
          }
        }, 1000);
      }

      // =========================
      // 4. Prevent Leave Page (beforeunload)
      // =========================
      function handleBeforeUnload(e) {
        if (!timeUpTriggered) {
          e.preventDefault();
          e.returnValue = '';
        }
      }

      window.addEventListener('beforeunload', handleBeforeUnload);

      function cleanUpBeforeSubmit() {
        sessionStorage.removeItem(startTimeKey);
        window.removeEventListener('beforeunload', handleBeforeUnload);

        // PERBAIKAN: Simpan durasi pengerjaan
        const durasiInput = document.getElementById('durasiPengerjaanInput');
        const durasi = getDurasiPengerjaan();

        if (durasiInput) {
          durasiInput.value = durasi;
          console.log('Durasi pengerjaan disimpan:', durasi);
        }
      }

    });
  </script>

</x-layout-web>
