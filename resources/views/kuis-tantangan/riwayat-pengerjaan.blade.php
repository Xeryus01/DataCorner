<x-layout-web>

  <div class="max-w-4xl mx-auto px-4 my-10">

    <!-- Header Section -->
    <div class="bg-white rounded-3xl shadow-2xl p-8 mb-8 border border-gray-100">
      <div class="text-center mb-6">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">
          <span class="text-3xl">📊</span> Riwayat Pengerjaan
        </h1>
        <h2 class="text-xl text-gray-600 font-semibold">{{ $kuis->judul }}</h2>
        <p class="text-gray-500 mt-2 font-medium">{{ $kuis->deskripsi }}</p>
      </div>

      <!-- Statistics Cards -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-primary text-white p-4 rounded-xl text-center">
          <div class="text-2xl font-bold">{{ $totalAttempts }}</div>
          <div class="text-sm opacity-90">Total Percobaan</div>
        </div>
        <div class="bg-green-600 text-white p-4 rounded-xl text-center">
          <div class="text-2xl font-bold">{{ $bestScore }}</div>
          <div class="text-sm opacity-90">Skor Tertinggi</div>
        </div>
        <div class="bg-purple-600 text-white p-4 rounded-xl text-center">
          <div class="text-2xl font-bold">{{ round($averageScore, 1) }}</div>
          <div class="text-sm opacity-90">Rata-rata</div>
        </div>
        <div class="bg-orange-600 text-white p-4 rounded-xl text-center">
          <div class="text-2xl font-bold">{{ $latestScore }}</div>
          <div class="text-sm opacity-90">Skor Terakhir</div>
        </div>
      </div>
    </div>

    <!-- History List -->
    <div class="space-y-4">
      @forelse($riwayatPengerjaan as $hasil)
        <div
          class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
          <div class="flex flex-col md:flex-row md:items-center justify-between">

            <!-- Left Side - Date & Time -->
            <div class="mb-4 md:mb-0">
              <div class="flex items-center mb-2">
                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span class="text-gray-700 font-medium">{{ $hasil->created_at->format('d M Y') }}</span>
              </div>
              <div class="flex items-center text-sm text-gray-500">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ $hasil->created_at->format('H:i') }}
              </div>
            </div>

            <!-- Center - Score Display -->
            <div class="flex flex-col gap-3 items-center justify-center mb-4 md:mb-0">
              <p class="text-xl font-bold">Nilai</p>
              <div class="relative">
                <div
                  class="w-20 h-20 bg-gradient-to-br from-blue-50 to-indigo-50 border-4 border-blue-200 rounded-full flex items-center justify-center">
                  <div class="w-16 h-16 bg-white rounded-full flex flex-col items-center justify-center shadow-sm">
                    <span class="text-2xl font-bold bg-primary bg-clip-text text-transparent">
                      {{ $hasil->skor }}
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Right Side - Performance Badge & Details -->
            <div class="text-center md:text-right">

              <!-- Details -->
              <div class="grid grid-cols-3 gap-2 text-sm">
                <div class="text-center">
                  <div class="text-green-800 font-semibold">{{ $hasil->jawaban_benar }}</div>
                  <div class="text-gray-500 text-xs">Benar</div>
                </div>
                <div class="text-center">
                  <div class="text-red-800 font-semibold">{{ $hasil->jawaban_salah }}</div>
                  <div class="text-gray-500 text-xs">Salah</div>
                </div>
                <div class="text-center">
                  <div class="text-blue-800 font-semibold">
                    @if ($hasil->durasi_pengerjaan)
                      {{ floor($hasil->durasi_pengerjaan / 60) }}:{{ str_pad($hasil->durasi_pengerjaan % 60, 2, '0', STR_PAD_LEFT) }}
                    @else
                      -
                    @endif
                  </div>
                  <div class="text-gray-500 text-xs">Durasi</div>
                </div>
              </div>
            </div>
          </div>

          <!-- View Details Button -->
          <div class="mt-4 pt-4 border-t border-gray-100">
            <a href="{{ route('kuis.hasil', ['hasil_id' => $hasil->id, 'slug' => $hasil->kuis_reguler->slug]) }}"
              class="inline-flex items-center text-primary hover:text-[#00295A] text-sm font-medium">
              <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                </path>
              </svg>
              Lihat Hasil Kuis
            </a>
          </div>
        </div>
      @empty
        <div class="bg-white rounded-2xl shadow-lg p-12 text-center border border-gray-100">
          <div class="text-gray-400 mb-4">
            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
              </path>
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Riwayat</h3>
          <p class="text-gray-500 mb-6">Anda belum pernah mengerjakan kuis ini</p>
          <a href="{{ route('kuis.show', $kuis->slug) }}"
            class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-xl font-medium hover:bg-blue-700 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
              </path>
            </svg>
            Mulai Kuis Sekarang
          </a>
        </div>
      @endforelse
    </div>

    <!-- Pagination -->
    @if ($riwayatPengerjaan->hasPages())
      <div class="mt-8 flex justify-center">
        {{ $riwayatPengerjaan->links() }}
      </div>
    @endif

    <!-- Action Buttons -->
    {{-- <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
        <a href="{{ route('kuis.show', $kuis->slug) }}"
          class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-8 py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 text-center">
          🎯 Kerjakan Lagi
        </a>
        <a href="{{ route('kuis-tantangan.index') }}"
          class="bg-gradient-to-r from-gray-600 to-gray-700 text-white px-8 py-3 rounded-xl font-semibold hover:from-gray-700 hover:to-gray-800 transition-all duration-300 text-center">
          📚 Kembali ke Daftar Kuis
        </a>
      </div> --}}

  </div>
  <x-footer class="fill-[#EEF0F2]"></x-footer>
</x-layout-web>
