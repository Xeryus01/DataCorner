<x-layout-web>
  <section class="relative overflow-hidden bg-primary text-white py-16 lg:py-24">
    <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_top_left,_#ffffff,_transparent_35%)]"></div>
    <div class="relative max-w-7xl mx-auto px-6 text-center">
      <p class="text-xs font-black tracking-[0.35em] uppercase text-blue-100 mb-4">Datapedia</p>
      <h1 class="text-4xl md:text-6xl font-black mb-6 leading-tight">Alat Statistik</h1>
      <p class="max-w-3xl mx-auto text-blue-100 text-base md:text-lg leading-relaxed font-semibold">
        Kumpulan alat interaktif dari Student Corner yang sekarang menjadi fitur utama Datapedia. Gunakan untuk menghitung,
        memvisualisasikan, dan mensimulasikan konsep statistik secara cepat dalam satu sistem.
      </p>
    </div>
  </section>

  <section class="py-16 lg:py-20 bg-[#EEF0F2]">
    <div class="max-w-7xl mx-auto px-6">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('kalkulator-statistik.index') }}" class="group bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
          <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-all">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 7h6m-6 4h6m-6 4h3M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z" />
            </svg>
          </div>
          <h2 class="text-2xl font-black text-blue-950 mb-3">Kalkulator Statistik</h2>
          <p class="text-slate-500 text-sm leading-relaxed mb-6">
            Menghitung mean, median, modus, standar deviasi, kuartil, peluang, permutasi, kombinasi, hingga ukuran sampel.
          </p>
          <span class="font-bold text-blue-600">Buka Kalkulator →</span>
        </a>

        <a href="{{ route('visualisasi.index') }}" class="group bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
          <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-all">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 19V5m0 14h16M8 15v-4m4 4V8m4 7v-6" />
            </svg>
          </div>
          <h2 class="text-2xl font-black text-blue-950 mb-3">Visualisasi Data</h2>
          <p class="text-slate-500 text-sm leading-relaxed mb-6">
            Membuat histogram, scatter plot, pie chart, line chart, dan boxplot dari data agar lebih mudah dianalisis.
          </p>
          <span class="font-bold text-blue-600">Buka Visualisasi →</span>
        </a>

        <a href="{{ route('simulasi.index') }}" class="group bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
          <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-all">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v6h6M20 20v-6h-6M5 19A8 8 0 0019 5M19 5h-5m5 0v5" />
            </svg>
          </div>
          <h2 class="text-2xl font-black text-blue-950 mb-3">Simulasi Statistik</h2>
          <p class="text-slate-500 text-sm leading-relaxed mb-6">
            Menjalankan simulasi random sampling, ukuran sampel Slovin, dan distribusi normal untuk memahami konsep statistik.
          </p>
          <span class="font-bold text-blue-600">Buka Simulasi →</span>
        </a>
      </div>

      <div class="mt-10 bg-white rounded-[2rem] border border-slate-100 p-6 md:p-8 shadow-sm">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
          <div>
            <p class="text-xs font-black uppercase tracking-[0.25em] text-blue-600 mb-2">Satu pintu</p>
            <h3 class="text-2xl font-black text-blue-950">Semua alat statistik sudah menyatu dengan Datapedia</h3>
            <p class="text-slate-500 text-sm mt-2 max-w-2xl">
              Pengguna tidak perlu masuk ke sistem terpisah. Menu Alat Statistik berada langsung di navbar Datapedia.
            </p>
          </div>
          <a href="{{ route('home') }}#literasi-statistik" class="inline-flex items-center justify-center rounded-full bg-blue-600 text-white px-6 py-3 font-bold hover:bg-blue-700 transition">
            Kembali ke Beranda
          </a>
        </div>
      </div>
    </div>
  </section>
</x-layout-web>
