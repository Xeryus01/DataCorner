<x-layout-web>
  <section class="bg-primary py-16 px-16 mb-10">
    <div class="flex flex-col items-center">
      <h1 class="mb-4 text-3xl font-bold text-white">
        Visualisasi Data
      </h1>
      <p class="mb-8 text-base text-center text-white">
        Konversikan data mentah menjadi grafik dan diagram yang interaktif untuk analisis yang lebih mudah.
      </p>
    </div>
  </section>

  <section class="bg-[#EEF0F2] text-black grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 lg:gap-7 px-20 mb-10">
    <a href="{{ route('visualisasi.histogram') }}" class="block">
      <div class="rounded-lg bg-white p-4 sm:p-6 shadow-md transition-all duration-300 hover:shadow-lg mb-6 sm:mb-0">
        <div class="mb-4 flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-lg bg-yellow-400">
          <svg width="35" height="35" viewBox="0 0 100 100" fill="white" xmlns="http://www.w3.org/2000/svg">
            <rect x="10" y="60" width="15" height="30" rx="2" fill="white" />
            <rect x="35" y="40" width="15" height="50" rx="2" fill="white" />
            <rect x="60" y="20" width="15" height="70" rx="2" fill="white" />
          </svg>


        </div>
        <h3 class="mb-2 text-lg font-semibold text-gray-800">Histogram</h3>
        <p class="text-justify text-sm text-gray-500">
          Ubah data numerik Anda menjadi histogram untuk melihat distribusi frekuensi dan pola data secara visual.
        </p>
      </div>
    </a>
    <a href="{{ route('visualisasi.scatter') }}" class="block">
      <div class="rounded-lg bg-white p-4 sm:p-6 shadow-md transition-all duration-300 hover:shadow-lg mb-6 sm:mb-0">
        <div class="mb-4 flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-lg bg-purple-400">
          <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="64" height="64" fill="none" />
            <circle cx="12" cy="52" r="4" fill="white" />
            <circle cx="20" cy="34" r="3" fill="white" />
            <circle cx="32" cy="44" r="5" fill="white" />
            <circle cx="44" cy="24" r="4" fill="white" />
            <circle cx="52" cy="12" r="3" fill="white" />
            <circle cx="36" cy="16" r="2" fill="white" />
          </svg>
        </div>
        <h3 class="mb-2 text-lg font-semibold text-gray-800">Scatter Plot</h3>
        <p class="text-justify text-sm text-gray-500">
          Buat scatter plot untuk memvisualisasikan hubungan dan korelasi antara dua set data numerik.
        </p>
      </div>
    </a>
    <a href="{{ route('visualisasi.piechart') }}" class="block">
      <div class="rounded-lg bg-white p-4 sm:p-6 shadow-md transition-all duration-300 hover:shadow-lg mb-6 sm:mb-0">
        <div class="mb-4 flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-lg bg-red-400">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
            style="fill: rgba(255, 255, 255, 1)">
            <path
              d="M13 2.051V11h8.949c-.47-4.717-4.232-8.479-8.949-8.949zm4.969 17.953c2.189-1.637 3.694-4.14 3.98-7.004h-8.183l4.203 7.004z">
            </path>
            <path
              d="M11 12V2.051C5.954 2.555 2 6.824 2 12c0 5.514 4.486 10 10 10a9.93 9.93 0 0 0 4.255-.964s-5.253-8.915-5.254-9.031A.02.02 0 0 0 11 12z">
            </path>
          </svg>

        </div>
        <h3 class="mb-2 text-lg font-semibold text-gray-800">Pie Chart</h3>
        <p class="text-justify text-sm text-gray-500">
          Buat pie chart untuk memvisualisasikan komposisi data Anda, menunjukkan proporsi masing-masing kategori dari
          total.
        </p>
      </div>
    </a>
    <a href="{{ route('visualisasi.linechart') }}" class="block">
      <div class="rounded-lg bg-white p-4 sm:p-6 shadow-md transition-all duration-300 hover:shadow-lg mb-6 sm:mb-0">
        <div class="mb-4 flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-lg bg-sky-400">
          <div class="text-white">
            <svg class="mx-auto h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 17l6-6 4 4 8-8" />
            </svg>
          </div>
        </div>
        <h3 class="mb-2 text-lg font-semibold text-gray-800">Line Chart</h3>
        <p class="text-justify text-sm text-gray-500">
          Buat pie chart untuk memvisualisasikan komposisi data Anda, menunjukkan proporsi masing-masing kategori dari
          total.
        </p>
      </div>
    </a>
    <a href="{{ route('visualisasi.boxplot') }}" class="block">
      <div class="rounded-lg bg-white p-4 sm:p-6 shadow-md transition-all duration-300 hover:shadow-lg mb-6 sm:mb-0">
        <div class="mb-4 flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-lg bg-sky-400">
          <div class="text-white">
            <svg class="mx-auto h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 17l6-6 4 4 8-8" />
            </svg>
          </div>
        </div>
        <h3 class="mb-2 text-lg font-semibold text-gray-800">Box Plot</h3>
        <p class="text-justify text-sm text-gray-500">
          Buat pie chart untuk memvisualisasikan komposisi data Anda, menunjukkan proporsi masing-masing kategori dari
          total.
        </p>
      </div>
    </a>
  </section>
  <x-footer class="fill-[#EEF0F2]" />
</x-layout-web>
