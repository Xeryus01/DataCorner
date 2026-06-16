<x-layout-web>
  <section class="w-full flex px-4 md:px-8 lg:px-10 py-16 bg-[#EEF0F2] min-h-screen">
    <div class="max-w-7xl mx-auto w-full">
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Profil Saya</h1>
        <p class="text-gray-600">Lihat dan kelola informasi akun Anda</p>
      </div>

      <!-- Main Content Grid -->
      <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Sidebar Navigation -->
        <x-user.sidebar />


        <!-- Main Profile Content -->
        <div class="lg:col-span-3">
          <!-- Main Profile Card -->
          <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Profile Header Section -->
            <div class="relative bg-primary px-8 py-5">
              <h1 class="text-2xl text-white md:text-3xl font-bold mb-2">Kuis Tantangan Bulanan Diselesaikan</h1>
            </div>

            <!-- Profile Details -->
            <div class="p-8">
              <div class="space-y-6">
                @forelse ($hasilTantangan as $item)
                  <div
                    class="bg-white rounded-xl shadow-md flex flex-col md:flex-row justify-between items-start md:items-center p-6 gap-4">

                    {{-- Isi Kuis --}}
                    <div class="flex-1">
                      <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $item->kuis_tantangan_bulanan->judul }}</h3>
                      <p class="text-sm font-semibold text-gray-600 mb-3">
                        {{ Str::limit($item->kuis_tantangan_bulanan->deskripsi, 120, '...') }}</p>

                      <div class="flex flex-wrap gap-4 text-sm text-gray-700">
                        <div>
                          <span class="font-semibold">Skor :</span> {{ $item->skor }}
                        </div>
                        <div>
                          <span class="font-semibold">Soal :</span>
                          {{ $item->kuis_tantangan_bulanan->soal_tantangan_bulanan->count() }}
                        </div>
                        <div>
                          <span class="font-semibold">Jawaban Benar :</span> {{ $item->jawaban_benar }}
                        </div>
                        <div>
                          <span class="font-semibold">Jawaban Salah :</span> {{ $item->jawaban_salah }}
                        </div>
                      </div>
                    </div>

                    {{-- Badge Skor --}}
                    <div class="w-full md:w-auto md:self-start">
                      @php $skor = $item->skor; @endphp
                      @if ($skor >= 90)
                        <div
                          class="bg-gradient-to-r from-yellow-400 to-yellow-500 text-gray-900 px-5 py-2 rounded-full text-sm font-bold shadow-lg border-2 border-yellow-300 text-center">
                          ⭐ Outstanding
                        </div>
                      @elseif($skor >= 80)
                        <div
                          class="bg-gradient-to-r from-green-500 to-emerald-500 text-white px-5 py-2 rounded-full text-sm font-bold shadow-lg text-center">
                          🏆 Excellent
                        </div>
                      @elseif($skor >= 70)
                        <div
                          class="bg-gradient-to-r from-blue-500 to-indigo-500 text-white px-5 py-2 rounded-full text-sm font-bold shadow-lg text-center">
                          👍 Good Job
                        </div>
                      @elseif($skor >= 60)
                        <div
                          class="bg-gradient-to-r from-orange-400 to-orange-500 text-white px-5 py-2 rounded-full text-sm font-bold shadow-lg text-center">
                          📈 Keep Going
                        </div>
                      @elseif($skor >= 50)
                        <div
                          class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white px-5 py-2 rounded-full text-sm font-bold shadow-lg text-center">
                          📚 Need Practice
                        </div>
                      @else
                        <div
                          class="bg-gradient-to-r from-red-500 to-red-600 text-white px-5 py-2 rounded-full text-sm font-bold shadow-lg text-center">
                          💪 Try Again
                        </div>
                      @endif
                    </div>
                  </div>
                @empty
                  <p class="text-sm text-gray-500">Belum ada kuis tantangan bulanan yang diselesaikan.</p>
                @endforelse
              </div>
            </div>
            {{ $hasilTantangan->links('vendor.pagination.custom') }}
          </div>
        </div>
      </div>
    </div>
    </div>
  </section>

  <x-footer class="fill-[#EEF0F2]" />

</x-layout-web>
