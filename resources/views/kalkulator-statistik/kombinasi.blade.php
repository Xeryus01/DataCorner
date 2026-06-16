<x-layout-web>
  <div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="bg-white max-w-6xl mx-auto rounded-lg shadow-sm p-6 mb-6">
      <div class="flex items-center space-x-4">
        <div class="bg-purple-400 rounded-lg p-3">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="white">
            <!-- Body kalkulator -->
            <rect x="4" y="2" width="16" height="20" rx="2" ry="2" stroke="white" stroke-width="2"
              fill="none" />

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
        <div>
          <h1 class="text-2xl font-bold text-gray-900">Kalkulator Kombinasi</h1>
          <p class="text-gray-600 text-sm text-justify">Alat untuk menghitung jumlah kombinasi yang mungkin dari suatu
            kumpulan objek tanpa mempertimbangkan urutan.</p>
        </div>
      </div>
    </div>
    <div class="max-w-6xl mx-auto">

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Input Section -->
        <div class="bg-white rounded-xl shadow-sm p-6">
          <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
              <label for="objek" class="block text-sm font-medium text-gray-700 mb-2">Objek (n)</label>
              <input type="number" id="objek" value="4" min="0"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
              <label for="sampel" class="block text-sm font-medium text-gray-700 mb-2">Sampel (r)</label>
              <input type="number" id="sampel" value="2" min="0"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
          </div>
        </div>


        <!-- Result Section -->
        <div class="bg-white rounded-xl p-6">
          <div class="bg-primary rounded-t-lg p-4 mb-4">
            <h2 class="text-center text-white font-semibold tracking-wide">Hasil</h2>
          </div>
          <div class="text-center">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">KOMBINASI</h2>
            <div id="hasil" class="text-4xl font-bold text-gray-800 mb-4">6</div>
            <div id="formula" class="text-sm text-gray-600 mb-2">C(4,2) = 4! / (2! × (4-2)!)</div>
            <div id="calculation" class="text-sm text-gray-600">= 24 / (2 × 2) = 6</div>
          </div>

          <!-- Back button -->

        </div>
      </div>

    </div>
  </div>
  <x-footer class="fill-[#EEF0F2]" />

  <script>
    // Fungsi untuk menghitung faktorial
    function faktorial(n) {
      if (n <= 1) return 1;
      let result = 1;
      for (let i = 2; i <= n; i++) {
        result *= i;
      }
      return result;
    }

    // Fungsi untuk menghitung kombinasi
    function kombinasi(n, r) {
      if (r > n || r < 0 || n < 0) return 0;
      if (r === 0 || r === n) return 1;

      // C(n,r) = n! / (r! × (n-r)!)
      return faktorial(n) / (faktorial(r) * faktorial(n - r));
    }

    // Fungsi untuk menghitung dan menampilkan hasil
    function hitungKombinasi() {
      const n = parseInt(document.getElementById('objek').value) || 0;
      const r = parseInt(document.getElementById('sampel').value) || 0;

      // Validasi input
      if (n < 0 || r < 0) {
        alert('Nilai tidak boleh negatif!');
        return;
      }

      if (r > n) {
        alert('Sampel (r) tidak boleh lebih besar dari Objek (n)!');
        return;
      }

      // Hitung kombinasi
      const hasil = kombinasi(n, r);

      // Update tampilan hasil
      document.getElementById('hasil').textContent = hasil;

      // Update formula
      document.getElementById('formula').textContent = `C(${n},${r}) = ${n}! / (${r}! × (${n}-${r})!)`;

      // Update calculation detail
      const nFakt = faktorial(n);
      const rFakt = faktorial(r);
      const nrFakt = faktorial(n - r);

      if (n <= 10) { // Tampilkan detail perhitungan untuk nilai kecil
        document.getElementById('calculation').textContent = `= ${nFakt} / (${rFakt} × ${nrFakt}) = ${hasil}`;
      } else {
        document.getElementById('calculation').textContent = `= ${hasil}`;
      }
    }

    // Fungsi reset
    function reset() {
      document.getElementById('objek').value = 4;
      document.getElementById('sampel').value = 2;
      hitungKombinasi();
    }

    // Event listeners untuk auto-calculate saat input berubah
    document.getElementById('objek').addEventListener('input', hitungKombinasi);
    document.getElementById('sampel').addEventListener('input', hitungKombinasi);

    // Hitung hasil awal saat halaman dimuat
    document.addEventListener('DOMContentLoaded', hitungKombinasi);
  </script>
</x-layout-web>
