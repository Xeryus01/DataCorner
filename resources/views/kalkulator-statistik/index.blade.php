<x-layout-web>
  <section class="bg-primary py-16 px-16 mb-10">
    <div class="flex flex-col items-center">
      <h1 class="mb-4 text-3xl font-bold text-white">
        Kalkulator Statistik
      </h1>
      <p class="mb-8 text-base text-center text-white">
        Selesaikan berbagai operasi statistik, dari rata-rata hingga regresi. Dapatkan hasil instan untuk setiap
        perhitungan data Anda.
      </p>
    </div>
  </section>

  <section
    class="bg-[#EEF0F2] text-black grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 lg:gap-7 px-20 mb-10 items-stretch">
    <a href="{{ route('kalkulator-statistik.mean') }}" class="block h-full">
      <div
        class="flex flex-col justify-between h-full  rounded-lg bg-white p-4 sm:p-6 shadow-md transition-all duration-300 hover:shadow-lg mb-6 sm:mb-0">
        <div class="mb-4 flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-lg bg-yellow-400">
          <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24">
            <!-- Garis bar di atas huruf x -->
            <line x1="8" y1="6" x2="16" y2="6" stroke="white" stroke-width="2" />
            <!-- Huruf x -->
            <text x="6" y="20" font-size="18" font-family="Arial" fill="white">x</text>
          </svg>

        </div>
        <h3 class="mb-2 text-lg font-semibold text-gray-800">Mean, Median, Modus</h3>
        <p class="text-justify text-sm text-gray-500">
          Alat praktis untuk menghitung mean, median, dan modus dari data Anda dengan mudah.
        </p>
      </div>
    </a>
    <a href="{{ route('kalkulator-statistik.standar-deviasi') }}" class="block h-full">
      <div
        class="flex flex-col justify-between h-full  rounded-lg bg-white p-4 sm:p-6 shadow-md transition-all duration-300 hover:shadow-lg mb-6 sm:mb-0">
        <div class="mb-4 flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-lg bg-green-400">
          <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24">
            <text x="4" y="20" font-size="25" font-family="Arial" fill="white">σ</text>
          </svg>
        </div>
        <h3 class="mb-2 text-lg font-semibold text-gray-800">Standard Deviasi</h3>
        <p class="text-justify text-sm text-gray-500">
          Hitung standar deviasi untuk mengukur penyebaran dan variabilitas data Anda dari nilai rata-rata.
        </p>
      </div>
    </a>
    <a href="{{ route('kalkulator-statistik.kombinasi') }}" class="block h-full">
      <div
        class="flex flex-col justify-between h-full  rounded-lg bg-white p-4 sm:p-6 shadow-md transition-all duration-300 hover:shadow-lg mb-6 sm:mb-0">
        <div class="mb-4 flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-lg bg-purple-400">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="white">
            <!-- Body kalkulator -->
            <rect x="4" y="2" width="16" height="20" rx="2" ry="2" stroke="white"
              stroke-width="2" fill="none" />

            <!-- Layar kalkulator -->
            <rect x="7" y="4" width="10" height="4" fill="white" />

            <!-- Tombol-tombol -->
            <circle cx="8" cy="10" r="1.2" fill="white" />
            <circle cx="12" cy="10" r="1.2" fill="white" />
            <circle cx="16" cy="10" r="1.2" fill="white" />

            <circle cx="8" cy="14" r="1.2" fill="white" />
            <circle cx="12" cy="14" r="1.2" fill="white" />
            <circle cx="16" cy="14" r="1.2" fill="white" />

            <circle cx="8" cy="18" r="1.2" fill="white" />
            <circle cx="12" cy="18" r="1.2" fill="white" />
            <circle cx="16" cy="18" r="1.2" fill="white" />
          </svg>

        </div>
        <h3 class="mb-2 text-lg font-semibold text-gray-800">Kombinasi</h3>
        <p class="text-justify text-sm text-gray-500">
          Alat untuk menghitung jumlah kombinasi yang mungkin dari suatu kumpulan objek tanpa mempertimbangkan urutan.
        </p>
      </div>
    </a>
    <a href="{{ route('kalkulator-statistik.permutasi') }}" class="block h-full">
      <div
        class="flex flex-col justify-between h-full  rounded-lg bg-white p-4 sm:p-6 shadow-md transition-all duration-300 hover:shadow-lg mb-6 sm:mb-0">
        <div class="mb-4 flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-lg bg-blue-500">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="white">
            <!-- Body kalkulator -->
            <rect x="4" y="2" width="16" height="20" rx="2" ry="2" stroke="white"
              stroke-width="2" fill="none" />

            <!-- Layar kalkulator -->
            <rect x="7" y="4" width="10" height="4" fill="white" />

            <!-- Tombol-tombol -->
            <circle cx="8" cy="10" r="1.2" fill="white" />
            <circle cx="12" cy="10" r="1.2" fill="white" />
            <circle cx="16" cy="10" r="1.2" fill="white" />

            <circle cx="8" cy="14" r="1.2" fill="white" />
            <circle cx="12" cy="14" r="1.2" fill="white" />
            <circle cx="16" cy="14" r="1.2" fill="white" />

            <circle cx="8" cy="18" r="1.2" fill="white" />
            <circle cx="12" cy="18" r="1.2" fill="white" />
            <circle cx="16" cy="18" r="1.2" fill="white" />
          </svg>

        </div>
        <h3 class="mb-2 text-lg font-semibold text-gray-800">Permutasi</h3>
        <p class="text-justify text-sm text-gray-500">
          Alat untuk menghitung jumlah permutasi (susunan) yang mungkin dari suatu kumpulan objek, dengan atau tanpa pengulangan.
        </p>
      </div>
    </a>
    <a href="{{ route('kalkulator-statistik.kuartil') }}" class="block h-full">
      <div
        class="flex flex-col justify-between h-full  rounded-lg bg-white p-4 sm:p-6 shadow-md transition-all duration-300 hover:shadow-lg mb-6 sm:mb-0">
        <div class="mb-4 flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-lg bg-green-400">
          <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48">
            <!-- Kotak hijau sebagai background -->
            <rect width="48" height="48" rx="8" ry="8" fill="#4ade80"/>
            <!-- Huruf Q -->
            <text x="50%" y="55%" text-anchor="middle" dominant-baseline="middle"
                  font-size="28" font-family="Arial, sans-serif" fill="white" font-weight="bold">Q</text>
          </svg>

        </div>
        <h3 class="mb-2 text-lg font-semibold text-gray-800">Kalkulator Kuartil</h3>
        <p class="text-justify text-sm text-gray-500">
          Hitung kuartil (Q1, Q2, Q3), jangkauan, dan IQR dari data numerik.
        </p>
      </div>
    </a>

    <a href="{{ route('kalkulator-statistik.odds-probabilitas') }}" class="block h-full">
      <div
        class="flex flex-col justify-between h-full  rounded-lg bg-white p-4 sm:p-6 shadow-md transition-all duration-300 hover:shadow-lg mb-6 sm:mb-0">
        <div class="mb-4 flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-lg bg-yellow-400">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
            <rect width="48" height="48" rx="8" ry="8" fill="#facc15"/>
            <text x="50%" y="55%" text-anchor="middle" dominant-baseline="middle" font-size="28" font-family="Arial, sans-serif" fill="white">⚖</text>
          </svg>
        </div>
        <h3 class="mb-2 text-lg font-semibold text-gray-800">Kalkulator Odds Probabilitas</h3>
        <p class="text-justify text-sm text-gray-500">
          Kalkulator odds probabilitas dapat mengubah odds menang dan kalah menjadi probabilitas menang dan kalah.Pelajari perbedaan antara odds dan probabilitas.
        </p>
      </div>
    </a>

    <a href="{{ route('kalkulator-statistik.probabilitas') }}" class="block h-full">
      <div
        class="flex flex-col justify-between h-full  rounded-lg bg-white p-4 sm:p-6 shadow-md transition-all duration-300 hover:shadow-lg mb-6 sm:mb-0">
        <div class="mb-4 flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-lg bg-blue-500">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="white">
            <!-- Body kalkulator -->
            <rect x="4" y="2" width="16" height="20" rx="2" ry="2" stroke="white"
              stroke-width="2" fill="none" />

            <!-- Layar kalkulator -->
            <rect x="7" y="4" width="10" height="4" fill="white" />

            <!-- Tombol-tombol -->
            <circle cx="8" cy="10" r="1.2" fill="white" />
            <circle cx="12" cy="10" r="1.2" fill="white" />
            <circle cx="16" cy="10" r="1.2" fill="white" />

            <circle cx="8" cy="14" r="1.2" fill="white" />
            <circle cx="12" cy="14" r="1.2" fill="white" />
            <circle cx="16" cy="14" r="1.2" fill="white" />

            <circle cx="8" cy="18" r="1.2" fill="white" />
            <circle cx="12" cy="18" r="1.2" fill="white" />
            <circle cx="16" cy="18" r="1.2" fill="white" />
          </svg>

        </div>
        <h3 class="mb-2 text-lg font-semibold text-gray-800">Probabilitas</h3>
        <p class="text-justify text-sm text-gray-500">
          Alat untuk menghitung jumlah permutasi (susunan) yang mungkin dari suatu kumpulan objek, dengan atau tanpa pengulangan.
        </p>
      </div>
    </a>

    <a href="{{ route('kalkulator-statistik.persentil') }}" class="block h-full">
      <div
        class="flex flex-col justify-between h-full rounded-lg bg-white p-4 sm:p-6 shadow-md transition-all duration-300 hover:shadow-lg mb-6 sm:mb-0">

        <!-- Icon -->
        <div class="mb-4 flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-lg bg-yellow-400">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" viewBox="0 0 24 24">
            <rect x="3" y="2" width="18" height="20" rx="2" />
            <rect x="6" y="5" width="12" height="4" fill="#facc15"/>
            <circle cx="8" cy="12" r="1.2"/>
            <circle cx="12" cy="12" r="1.2"/>
            <circle cx="16" cy="12" r="1.2"/>
            <circle cx="8" cy="16" r="1.2"/>
            <circle cx="12" cy="16" r="1.2"/>
            <circle cx="16" cy="16" r="1.2"/>
          </svg>
        </div>

        <!-- Title -->
        <h3 class="mb-2 text-lg font-semibold text-gray-800">
          Persentil
        </h3>

        <!-- Description -->
        <p class="text-justify text-sm text-gray-500">
          Alat untuk menentukan nilai persentil pada sekumpulan data menggunakan metode interpolasi linear.
        </p>

      </div>
    </a>

    <a href="{{ route('kalkulator-statistik.ukuran-sampel') }}" class="block h-full">
      <div
        class="flex flex-col justify-between h-full  rounded-lg bg-white p-4 sm:p-6 shadow-md transition-all duration-300 hover:shadow-lg mb-6 sm:mb-0">
        <div class="mb-4 flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-lg bg-blue-500">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="white">
            <!-- Body kalkulator -->
            <rect x="4" y="2" width="16" height="20" rx="2" ry="2" stroke="white"
              stroke-width="2" fill="none" />

            <!-- Layar kalkulator -->
            <rect x="7" y="4" width="10" height="4" fill="white" />

            <!-- Tombol-tombol -->
            <circle cx="8" cy="10" r="1.2" fill="white" />
            <circle cx="12" cy="10" r="1.2" fill="white" />
            <circle cx="16" cy="10" r="1.2" fill="white" />

            <circle cx="8" cy="14" r="1.2" fill="white" />
            <circle cx="12" cy="14" r="1.2" fill="white" />
            <circle cx="16" cy="14" r="1.2" fill="white" />

            <circle cx="8" cy="18" r="1.2" fill="white" />
            <circle cx="12" cy="18" r="1.2" fill="white" />
            <circle cx="16" cy="18" r="1.2" fill="white" />
          </svg>

        </div>
        <h3 class="mb-2 text-lg font-semibold text-gray-800">Ukuran Sampel</h3>
        <p class="text-justify text-sm text-gray-500">
          Menghitung ukuran sampel atau margin of error berdasarkan tingkat kepercayaan, proporsi populasi, dan ukuran populasi.
        </p>
      </div>
    </a>

    
    
  </section>
  <x-footer class="fill-[#EEF0F2]" />
</x-layout-web>
