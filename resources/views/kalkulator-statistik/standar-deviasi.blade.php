<x-layout-web>
  <div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="bg-white max-w-6xl mx-auto rounded-lg shadow-sm p-6 mb-6">
      <div class="flex items-center space-x-4">
        <div class="bg-green-400 rounded-lg p-3">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
            <text x="2" y="22" font-size="35" font-family="Arial" fill="white">σ</text>
          </svg>
        </div>
        <div>
          <h1 class="text-2xl font-bold text-gray-900">Kalkulator Standar Deviasi</h1>
          <p class="text-gray-600 text-sm text-justify">Hitung standar deviasi untuk mengukur penyebaran dan
            variabilitas data Anda dari nilai rata-rata.</p>
        </div>
      </div>
    </div>
    <div class="max-w-6xl mx-auto">


      <!-- Left Panel - Input -->
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Set Data</h2>

        <div class="mb-6">
          <textarea id="dataInput"
            class="w-full h-32 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent resize-none"
            placeholder="9, 11, 13, 13, 15, 16, 23" oninput="formatInput()">9, 11, 13, 13, 15, 16, 23</textarea>
          <p class="text-sm text-gray-500 mt-2">Angka dipisahkan koma</p>
        </div>

        <div class="mb-6">
          <h3 class="text-lg font-medium text-gray-900 mb-3">Kelompok</h3>
          <div class="flex space-x-2">
            <button id="sampelBtn"
              class="flex-1 py-2 px-4 rounded-lg border border-primary bg-primary text-white font-medium transition-colors"
              onclick="setCalculationType('sampel')">
              Sampel
            </button>
            <button id="populasiBtn"
              class="flex-1 py-2 px-4 rounded-lg border border-gray-300 text-gray-700 font-medium transition-colors hover:bg-gray-50"
              onclick="setCalculationType('populasi')">
              Populasi
            </button>
          </div>
        </div>
        <div class="bg-primary rounded-t-lg p-4 mb-4">
          <h2 class="text-center text-white font-semibold tracking-wide">Hasil</h2>
        </div>

        <div id="results" class="max-w-md mx-auto space-y-4">
          <div class="flex justify-between items-center py-3 border-b border-primary">
            <span class="font-medium text-black">Deviasi Standar</span>
            <span class="font-mono text-black" id="standardDeviation">s = 4.5</span>
          </div>

          <div class="flex justify-between items-center py-3 border-b border-primary">
            <span class="font-medium text-black">Varian</span>
            <span class="font-mono text-black" id="variance">s² = 20.24</span>
          </div>

          <div class="flex justify-between items-center py-3 border-b border-primary">
            <span class="font-medium text-black">Jumlah</span>
            <span class="font-mono text-black" id="count">n = 7</span>
          </div>

          <div class="flex justify-between items-center py-3 border-b border-primary">
            <span class="font-medium text-black">Rata-rata</span>
            <span class="font-mono text-black" id="mean">x̄ = 14.29</span>
          </div>

          <div class="flex justify-between items-center py-3">
            <span class="font-medium text-black">Jumlah Kuadrat</span>
            <span class="font-mono text-black" id="sumOfSquares">SS = 100</span>
          </div>
        </div>
      </div>

      <!-- Right Panel - Results -->
      {{-- <div class="bg-blue-50 rounded-lg border border-blue-200 p-6">
          <h2 class="text-xl font-semibold text-blue-900 mb-6">HASIL</h2>

          <div id="results" class="space-y-4">
            <div class="flex justify-between items-center py-3 border-b border-blue-200">
              <span class="font-medium text-blue-900">Deviasi Standar</span>
              <span class="font-mono text-blue-900" id="standardDeviation">s = 4.5</span>
            </div>

            <div class="flex justify-between items-center py-3 border-b border-blue-200">
              <span class="font-medium text-blue-900">Varian</span>
              <span class="font-mono text-blue-900" id="variance">s² = 20.24</span>
            </div>

            <div class="flex justify-between items-center py-3 border-b border-blue-200">
              <span class="font-medium text-blue-900">Jumlah</span>
              <span class="font-mono text-blue-900" id="count">n = 7</span>
            </div>

            <div class="flex justify-between items-center py-3 border-b border-blue-200">
              <span class="font-medium text-blue-900">Rata-rata</span>
              <span class="font-mono text-blue-900" id="mean">x̄ = 14.29</span>
            </div>

            <div class="flex justify-between items-center py-3">
              <span class="font-medium text-blue-900">Jumlah Kuadrat</span>
              <span class="font-mono text-blue-900" id="sumOfSquares">SS = 100</span>
            </div>
          </div>
        </div> --}}

    </div>
  </div>
  <x-footer class="fill-[#EEF0F2]" />

  <script>
    let calculationType = 'sampel';

    // function formatInput() {
    //   const input = document.getElementById('dataInput');
    //   let value = input.value;

    //   // Remove any non-numeric characters except commas, periods, and spaces
    //   value = value.replace(/[^0-9,.\s-]/g, '');

    //   // Replace multiple spaces/commas with single comma
    //   value = value.replace(/[\s,]+/g, ', ');

    //   // Remove trailing comma and space
    //   value = value.replace(/,\s*$/, '');

    //   input.value = value;
    // }

    function setCalculationType(type) {
      calculationType = type;

      const sampelBtn = document.getElementById('sampelBtn');
      const populasiBtn = document.getElementById('populasiBtn');

      if (type === 'sampel') {
        sampelBtn.className =
          'flex-1 py-2 px-4 rounded-lg border border-primary bg-primary text-white font-medium transition-colors';
        populasiBtn.className =
          'flex-1 py-2 px-4 rounded-lg border border-gray-300 text-gray-700 font-medium transition-colors hover:bg-gray-50';
      } else {
        sampelBtn.className =
          'flex-1 py-2 px-4 rounded-lg border border-gray-300 text-gray-700 font-medium transition-colors hover:bg-gray-50';
        populasiBtn.className =
          'flex-1 py-2 px-4 rounded-lg border border-primary bg-primary text-white font-medium transition-colors';
      }

      // Recalculate if there's data
      const input = document.getElementById('dataInput').value.trim();
      if (input) {
        calculate();
      }
    }

    function calculate() {
      const input = document.getElementById('dataInput').value.trim();

      if (!input) {
        alert('Silakan masukkan data terlebih dahulu');
        return;
      }

      try {
        // Parse the input data
        const dataArray = input.split(',').map(item => {
          const num = parseFloat(item.trim());
          if (isNaN(num)) {
            throw new Error(`"${item.trim()}" bukan angka yang valid`);
          }
          return num;
        });

        if (dataArray.length < 2) {
          alert('Minimal 2 data diperlukan untuk menghitung standar deviasi');
          return;
        }

        // Calculate statistics
        const n = dataArray.length;
        const sum = dataArray.reduce((acc, val) => acc + val, 0);
        const mean = sum / n;

        // Calculate sum of squared differences
        const sumOfSquaredDifferences = dataArray.reduce((acc, val) => {
          return acc + Math.pow(val - mean, 2);
        }, 0);

        // Calculate variance and standard deviation
        let variance, standardDev;
        if (calculationType === 'sampel') {
          variance = sumOfSquaredDifferences / (n - 1);
        } else {
          variance = sumOfSquaredDifferences / n;
        }

        standardDev = Math.sqrt(variance);

        // Update display
        const symbol = calculationType === 'sampel' ? 's' : 'σ';
        const countSymbol = calculationType === 'sampel' ? 'n' : 'N';

        document.getElementById('standardDeviation').textContent = `${symbol} = ${standardDev.toFixed(2)}`;
        document.getElementById('variance').textContent = `${symbol}² = ${variance.toFixed(2)}`;
        document.getElementById('count').textContent = `${countSymbol} = ${n}`;
        document.getElementById('mean').textContent = `x̄ = ${mean.toFixed(2)}`;
        document.getElementById('sumOfSquares').textContent = `SS = ${sumOfSquaredDifferences.toFixed(2)}`;

      } catch (error) {
        alert('Error: ' + error.message);
      }
    }

    // Calculate with initial data on page load
    document.addEventListener('DOMContentLoaded', function() {
      calculate();
    });
  </script>
</x-layout-web>
