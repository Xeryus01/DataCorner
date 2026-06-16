<x-layout-web>
  <div class="container mx-auto px-4 py-8">

    <!-- Header -->
    <div class="bg-white max-w-6xl mx-auto rounded-lg shadow-sm p-6 mb-6">
      <div class="flex items-center space-x-4">
        <div class="bg-green-500 rounded-lg p-3">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" viewBox="0 0 24 24">
            <path d="M3 3h18v18H3z" fill="none"/>
            <text x="6" y="18" font-size="14" fill="white">P</text>
          </svg>
        </div>
        <div>
          <h1 class="text-2xl font-bold text-gray-900">Kalkulator Probabilitas</h1>
          <p class="text-gray-600 text-sm text-justify">
            Menghitung peluang suatu kejadian berdasarkan jumlah kejadian yang diinginkan dan total kemungkinan.
          </p>
        </div>
      </div>
    </div>

    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-6">

      <!-- Input -->
      <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Jumlah kejadian yang diinginkan (k)
          </label>
          <input type="number" id="kejadian"
            value="3" min="0"
            class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-green-500">
        </div>

        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Jumlah seluruh kemungkinan (n)
          </label>
          <input type="number" id="total"
            value="10" min="1"
            class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-green-500">
        </div>
      </div>

      <!-- Hasil -->
      <div class="bg-white rounded-xl p-6">
        <div class="bg-primary rounded-t-lg p-4 mb-4">
          <h2 class="text-center text-white font-semibold tracking-wide">HASIL</h2>
        </div>

        <div class="text-center">
          <h2 class="text-lg font-semibold text-gray-700 mb-4">PROBABILITAS</h2>

          <div id="hasilPersen" class="text-4xl font-bold text-gray-800 mb-4">
            30%
          </div>

          <div id="hasilPecahan" class="text-sm text-gray-600 mb-2">
            P = 3 / 10
          </div>

          <div id="hasilDesimal" class="text-sm text-gray-600">
            = 0.30
          </div>
        </div>
      </div>

    </div>
  </div>

  <x-footer class="fill-[#EEF0F2]" />

  <script>
    function hitungProbabilitas() {
      const k = parseFloat(document.getElementById('kejadian').value) || 0;
      const n = parseFloat(document.getElementById('total').value) || 0;

      if (n <= 0 || k < 0 || k > n) {
        document.getElementById('hasilPersen').textContent = '-';
        document.getElementById('hasilPecahan').textContent = 'Input tidak valid';
        document.getElementById('hasilDesimal').textContent = '-';
        return;
      }

      const prob = k / n;
      const persen = (prob * 100).toFixed(2);

      document.getElementById('hasilPersen').textContent = `${persen}%`;
      document.getElementById('hasilPecahan').textContent = `P = ${k} / ${n}`;
      document.getElementById('hasilDesimal').textContent = `= ${prob.toFixed(2)}`;
    }

    document.getElementById('kejadian').addEventListener('input', hitungProbabilitas);
    document.getElementById('total').addEventListener('input', hitungProbabilitas);

    document.addEventListener('DOMContentLoaded', hitungProbabilitas);
  </script>
</x-layout-web>
