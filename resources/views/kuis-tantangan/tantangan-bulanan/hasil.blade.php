<x-layout-web>

  <!-- Main Score Card -->
  <div
    class="max-w-lg mt-10 mx-10 md:mx-auto bg-white rounded-3xl p-8 shadow-2xl overflow-hidden border border-gray-100">
    <!-- Success Icon -->
    <div class="relative flex justify-center mb-6 z-10">
      <div class="relative">
        <div class="absolute inset-0 w-16 h-16 bg-green-400 rounded-full animate-ping opacity-30"></div>
        <div
          class="relative w-16 h-16 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center shadow-lg">
          <svg class="w-8 h-8 text-white animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
          </svg>
        </div>
      </div>
    </div>

    <!-- Title -->
    <div class="text-center mb-8 relative z-10">
      <h2 class="text-3xl font-bold mb-2">
        <span>🎉</span> Selamat!
      </h2>
      <p class="text-gray-600 font-medium text-lg">Kuis {{ $hasil->kuis_tantangan_bulanan->judul }} berhasil
        diselesaikan</p>
    </div>

    <!-- Score Display -->
    <div class="relative flex justify-center mb-4 z-10">
      <div class="relative">
        <!-- Score Circle -->
        <div
          class="w-32 h-32 rounded-full bg-gradient-to-br from-green-50 to-emerald-50 border-4 border-green-200 flex items-center justify-center relative shadow-inner">
          <div class="w-24 h-24 bg-white rounded-full flex flex-col items-center justify-center shadow-lg">
            <span
              class="text-4xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent"
              id="score-display">
              {{ $hasil->skor }}
            </span>
            <span class="text-xs text-gray-500 font-semibold tracking-wider">NILAI</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Performance Badge -->
    <div class="flex justify-center mb-8 z-10">
      @if ($hasil->skor >= 90)
        <div
          class="bg-gradient-to-r from-yellow-400 to-yellow-500 text-gray-900 px-6 py-2 rounded-full text-sm font-bold shadow-lg border-2 border-yellow-300">
          ⭐ Outstanding
        </div>
      @elseif($hasil->skor >= 80)
        <div
          class="bg-gradient-to-r from-green-500 to-emerald-500 text-white px-6 py-2 rounded-full text-sm font-bold shadow-lg">
          🏆 Excellent
        </div>
      @elseif($hasil->skor >= 70)
        <div
          class="bg-gradient-to-r from-blue-500 to-indigo-500 text-white px-6 py-2 rounded-full text-sm font-bold shadow-lg">
          👍 Good Job
        </div>
      @elseif($hasil->skor >= 60)
        <div
          class="bg-gradient-to-r from-orange-400 to-orange-500 text-white px-6 py-2 rounded-full text-sm font-bold shadow-lg">
          📈 Keep Going
        </div>
      @elseif($hasil->skor >= 50)
        <div
          class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white px-6 py-2 rounded-full text-sm font-bold shadow-lg">
          📚 Need Practice
        </div>
      @else
        <div
          class="bg-gradient-to-r from-red-500 to-red-600 text-white px-6 py-2 rounded-full text-sm font-bold shadow-lg">
          💪 Try Again
        </div>
      @endif
    </div>

    <!-- Stats Section -->
    <div class="grid grid-cols-3 gap-3 mb-6 relative z-10">
      <div class="text-center flex flex-col justify-between p-3 bg-primary rounded-xl border border-blue-200">
        <div class="text-xl font-bold text-white">{{ $hasil->durasi_format }}</div>
        <div class="text-xs text-white font-medium">Durasi Pengerjaan</div>
      </div>
      <div class="text-center flex flex-col justify-center p-3 bg-green-600 rounded-xl border border-green-200">
        <div class="text-xl font-bold text-white">
          {{ $hasil->jawaban_benar }}
        </div>
        <div class="text-xs text-white font-medium">Jawaban Benar</div>
      </div>
      <div class="text-center flex flex-col justify-center p-3 bg-red-600 rounded-xl border border-red-200">
        <div class="text-xl font-bold text-white">
          {{ $hasil->jawaban_salah }}
        </div>
        <div class="text-xs text-white font-medium">Jawaban Salah</div>
      </div>
      {{-- <div class="bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 p-3 rounded-xl text-center">
        <h4 class="font-medium text-gray-900">Waktu Tersisa</h4>
        @php
          $waktuTersisa = $hasil->kuis_reguler->durasi_menit * 60 - $hasil->durasi_pengerjaan;
          $menitTersisa = floor($waktuTersisa / 60);
          $detikTersisa = $waktuTersisa % 60;
        @endphp
        <p class="text-2xl font-bold text-blue-600">
          @if ($waktuTersisa > 0)
            {{ $menitTersisa }}:{{ str_pad($detikTersisa, 2, '0', STR_PAD_LEFT) }}
          @else
            00:00
          @endif
        </p>
      </div> --}}
    </div>

    <!-- Thank You Message -->
    <div
      class="text-center bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl p-4 relative z-10 border border-gray-200">
      <p class="text-gray-700 font-medium">
        <span class="text-lg">🙏</span> Terima kasih telah mengerjakan kuis!
      </p>
      <p class="text-sm text-gray-500 mt-1">Semangat terus belajar dan berkembang</p>
    </div>
  </div>

  <!-- Additional Motivational Card -->
  <div class="max-w-lg mb-10 mx-10 md:mx-auto mt-4 flex flex-col gap-4">
    <div class=" bg-white bg-opacity-80 backdrop-blur-sm rounded-2xl p-4 text-center shadow-lg border border-gray-100">
      @if ($hasil->skor >= 90)
        <p class="text-gray-600 text-sm">🌟 <strong>Luar biasa sekali!</strong> Prestasi sempurna yang membanggakan!
        </p>
      @elseif($hasil->skor >= 80)
        <p class="text-gray-600 text-sm">🏆 <strong>Excellent!</strong> Kerja yang sangat memuaskan!</p>
      @elseif($hasil->skor >= 70)
        <p class="text-gray-600 text-sm">🌟 <strong>Bagus sekali!</strong> Terus pertahankan semangat belajar!</p>
      @elseif($hasil->skor >= 60)
        <p class="text-gray-600 text-sm">📈 <strong>Cukup baik!</strong> Masih ada ruang untuk berkembang lebih
          baik!
        </p>
      @elseif($hasil->skor >= 50)
        <p class="text-gray-600 text-sm">📚 <strong>Perlu latihan lagi!</strong> Jangan menyerah, terus belajar!</p>
      @else
        <p class="text-gray-600 text-sm">💪 <strong>Jangan patah semangat!</strong> Setiap usaha adalah langkah
          menuju
          kesuksesan!</p>
      @endif
    </div>
    <a href="{{ route('kuis-tantangan.index') }}">
      <button class="w-full bg-primary text-white font-semibold py-4 rounded-lg hover:bg-[#00295A]">
        Halaman Kuis dan Tantangan
      </button>
    </a>
  </div>

  <x-footer class="fill-[#EEF0F2]"></x-footer>

  <script>
    document.addEventListener('DOMContentLoaded', function() {


      // Animate score counting (optional)
      const scoreElement = document.getElementById('score-display');
      const finalScore = {{ isset($hasil->skor) ? $hasil->skor : 0 }};
      let currentScore = 0;
      const increment = Math.ceil(finalScore / 20);

      const countUp = setInterval(() => {
        currentScore += increment;
        if (currentScore >= finalScore) {
          currentScore = finalScore;
          clearInterval(countUp);
        }
        scoreElement.textContent = currentScore;
      }, 80);
    });
  </script>
</x-layout-web>
