<x-layout-web>
  <section class="bg-primary py-16 px-16 mb-10">
    <div class="flex flex-col items-center">
      <h1 class="mb-4 text-3xl font-bold text-white">
        Simulasi Statistik
      </h1>
      <p class="mb-8 text-base text-center text-white">
        Buat dan jalankan simulasi statistik untuk memprediksi hasil dan memahami dinamika data dalam berbagai
        skenario.
      </p>
    </div>
  </section>

  <section class="bg-[#EEF0F2] text-black grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 lg:gap-7 px-20 mb-10">
    <a href="{{ route('simulasi.sampling') }}" class="block">
      <div class="rounded-lg bg-white p-4 sm:p-6 shadow-md transition-all duration-300 hover:shadow-lg mb-6 sm:mb-0">
        <div class="mb-4 flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-lg bg-yellow-400">
          <svg viewBox="0 0 600 300" xmlns="http://www.w3.org/2000/svg">
            <!-- Axis -->
            <line x1="0" y1="250" x2="600" y2="250" stroke="#999" stroke-width="1.5" />

            <!-- Population distribution (putih transparan) -->
            <path d="M 50 250 Q 150 50 250 250 T 450 250" fill="rgba(255, 255, 255, 0.2)" stroke="white"
              stroke-width="2" />
            <text x="120" y="40" fill="white" font-size="14">Distribusi Populasi</text>

            <!-- Sampling distribution (lebih sempit) -->
            <path d="M 200 250 Q 300 120 400 250" fill="rgba(255, 255, 255, 0.2)" stroke="white" stroke-width="2" />
            <text x="250" y="110" fill="white" font-size="14">Distribusi Rata-rata Sampel</text>

            <!-- Labels -->
            <text x="50" y="270" font-size="12" fill="white">x̄ rendah</text>
            <text x="500" y="270" font-size="12" fill="white">x̄ tinggi</text>
          </svg>
        </div>
        <h3 class="mb-2 text-lg font-semibold text-gray-800">Simulasi Random Sampling</h3>
        <p class="text-justify text-sm text-gray-500">
          Jalankan simulasi pengambilan sampel acak untuk memahami bagaimana sampel merepresentasikan populasi dan
          pengaruhnya terhadap analisis data.
        </p>
      </div>
    </a>
    <a href="{{ route('simulasi.slovin') }}" class="block">
      <div class="rounded-lg bg-white p-4 sm:p-6 shadow-md transition-all duration-300 hover:shadow-lg mb-6 sm:mb-0">
        <div class="mb-4 flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-lg bg-green-400">
          <svg width="30" height="30" viewBox="0 0 100 100" fill="white" xmlns="http://www.w3.org/2000/svg">
            <!-- Lingkaran populasi -->
            <circle cx="50" cy="50" r="45" stroke="white" stroke-width="4" fill="none" />

            <!-- Sampel (representasi titik-titik) -->
            <circle cx="30" cy="40" r="4" fill="white" />
            <circle cx="40" cy="55" r="4" fill="white" />
            <circle cx="50" cy="35" r="4" fill="white" />
            <circle cx="60" cy="60" r="4" fill="white" />
            <circle cx="70" cy="45" r="4" fill="white" />

            <!-- Garis panah dari populasi ke sampel -->
            <line x1="80" y1="80" x2="95" y2="95" stroke="white" stroke-width="3"
              marker-end="url(#arrowhead)" />

            <!-- Panah marker -->
            <defs>
              <marker id="arrowhead" markerWidth="6" markerHeight="6" refX="0" refY="3" orient="auto">
                <polygon points="0 0, 6 3, 0 6" fill="white" />
              </marker>
            </defs>
          </svg>

        </div>
        <h3 class="mb-2 text-lg font-semibold text-gray-800">Simulasi Ukuran Sampel Slovin</h3>
        <p class="text-justify text-sm text-gray-500">
          Jalankan simulasi pengambilan sampel acak untuk memahami bagaimana sampel merepresentasikan populasi dan
          pengaruhnya terhadap analisis data.
        </p>
      </div>
    </a>
    <a href="{{ route('simulasi.normal.index') }}" class="block">
      <div class="rounded-lg bg-white p-4 sm:p-6 shadow-md transition-all duration-300 hover:shadow-lg mb-6 sm:mb-0">
        <div class="mb-4 flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-lg bg-purple-400">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 400" width="800" height="400" role="img"
            aria-labelledby="titleDesc">
            <title id="titleDesc">Distribusi Normal (Bell Curve)</title>

            <!-- Area di bawah kurva (putih semi-transparan) -->
            <path d="M80 320 C180 160 260 120 400 120 C540 120 620 160 720 320 L720 320 L80 320 Z" fill="white"
              fill-opacity="0.12" stroke="none" />

            <!-- Kurva (garis putih tegas) -->
            <path d="M80 320 C180 160 260 120 400 120 C540 120 620 160 720 320" fill="none" stroke="white"
              stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />

            <!-- Sumbu horizontal (baseline) -->
            <line x1="40" y1="320" x2="760" y2="320" stroke="white" stroke-width="1.2"
              opacity="0.9" />

            <!-- Garis mean (rata-rata) vertikal -->
            <line x1="400" y1="320" x2="400" y2="120" stroke="white" stroke-width="1.5"
              stroke-dasharray="6 6" opacity="0.9" />

            <!-- Tanda mean dan teks -->
            <circle cx="400" cy="120" r="3" fill="white" />
            <text x="400" y="100" fill="white" font-family="sans-serif" font-size="14" text-anchor="middle"
              opacity="0.95">μ</text>

            <!-- Label kecil -->
            <text x="100" y="350" fill="white" font-family="sans-serif" font-size="13" opacity="0.95">Distribusi
              Normal</text>
          </svg>


        </div>
        <h3 class="mb-2 text-lg font-semibold text-gray-800">Distribusi Normal</h3>
        <p class="text-justify text-sm text-gray-500">
          Jalankan simulasi pengambilan sampel acak untuk memahami bagaimana sampel merepresentasikan populasi dan
          pengaruhnya terhadap analisis data.
        </p>
      </div>
    </a>
  </section>
  <x-footer class="fill-[#EEF0F2]" />
</x-layout-web>
