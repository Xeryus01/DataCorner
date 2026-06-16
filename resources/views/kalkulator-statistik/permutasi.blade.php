<x-layout-web>
  <div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="bg-white max-w-6xl mx-auto rounded-lg shadow-sm p-6 mb-6">
      <div class="flex items-center space-x-4">
        <div class="bg-blue-500 rounded-lg p-3">
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
          <h1 class="text-2xl font-bold text-gray-900">Kalkulator Permutasi</h1>
          <p class="text-gray-600 text-sm text-justify">Alat untuk menghitung jumlah permutasi (susunan) yang mungkin dari suatu kumpulan objek, dengan atau tanpa pengulangan.</p>
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
            <div class="col-span-2">
              <label class="inline-flex items-center mt-2">
                <input id="pengulangan" type="checkbox" class="form-checkbox h-4 w-4 text-primary">
                <span class="ml-2 text-sm text-gray-700">Dengan Pengulangan (r dapat lebih besar dari n)</span>
              </label>
            </div>
          </div>
        </div>


        <!-- Result Section -->
        <div class="bg-white rounded-xl p-6">
          <div class="bg-primary rounded-t-lg p-4 mb-4">
            <h2 class="text-center text-white font-semibold tracking-wide">Hasil</h2>
          </div>
          <div class="text-center">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">PERMUTASI</h2>
            <div id="hasil" class="text-4xl font-bold text-gray-800 mb-4">12</div>
            <div id="formula" class="text-sm text-gray-600 mb-2">P(4,2) = 4! / (4-2)! = 4 × 3</div>
            <div id="calculation" class="text-sm text-gray-600">= 12</div>
          </div>

          <!-- Back button -->

        </div>
      </div>

    </div>
  </div>
  <x-footer class="fill-[#EEF0F2]" />

  <script>
    // Fungsi untuk menghitung permutasi
    // P(n,r) tanpa pengulangan: n! / (n-r)! = n*(n-1)*...*(n-r+1)
    function permutasi(n, r, withRepetition = false) {
      if (n < 0 || r < 0) return 0;
      if (withRepetition) {
        // Dengan pengulangan: n^r
        return Math.pow(n, r);
      }
      if (r > n) return 0;
      let result = 1;
      for (let i = 0; i < r; i++) {
        result *= (n - i);
      }
      return result;
    }

    // Fungsi untuk menghitung dan menampilkan hasil
    function hitungPermutasi() {
      const n = parseInt(document.getElementById('objek').value) || 0;
      const r = parseInt(document.getElementById('sampel').value) || 0;
      const withRepetition = document.getElementById('pengulangan').checked;

      // Validasi input
      if (n < 0 || r < 0) {
        alert('Nilai tidak boleh negatif!');
        return;
      }
      if (!withRepetition && r > n) {
        alert('Sampel (r) tidak boleh lebih besar dari Objek (n) untuk permutasi tanpa pengulangan!');
        return;
      }

      // Hitung permutasi
      const hasil = permutasi(n, r, withRepetition);

      // Update tampilan hasil
      document.getElementById('hasil').textContent = hasil;

      // Update formula
      if (withRepetition) {
        document.getElementById('formula').textContent = `P(${n},${r}) dengan pengulangan = ${n}^${r}`;
        document.getElementById('calculation').textContent = `= ${hasil}`;
      } else {
        document.getElementById('formula').textContent = `P(${n},${r}) = ${n}! / (${n}-${r})!`;
        // Update calculation detail: show product form for kecil n
        if (n <= 15 && r <= 15) {
          const terms = [];
          for (let i = 0; i < r; i++) terms.push(n - i);
          document.getElementById('calculation').textContent = `= ${terms.join(' × ')} = ${hasil}`;
        } else {
          document.getElementById('calculation').textContent = `= ${hasil}`;
        }
      }
    }

    // Event listeners untuk auto-calculate saat input berubah
    document.getElementById('objek').addEventListener('input', hitungPermutasi);
    document.getElementById('sampel').addEventListener('input', hitungPermutasi);
    document.getElementById('pengulangan').addEventListener('change', hitungPermutasi);

    // Hitung hasil awal saat halaman dimuat
    document.addEventListener('DOMContentLoaded', hitungPermutasi);
  </script>
</x-layout-web>
