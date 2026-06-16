<x-layout-web>
  <div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="bg-white max-w-6xl mx-auto rounded-lg shadow-sm p-6 mb-6">
      <div class="flex items-center space-x-4">
        <div class="bg-yellow-400 rounded-lg p-3">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
            <!-- Kotak hijau sebagai background -->
            <rect width="48" height="48" rx="8" ry="8" fill="#facc15"/>
            <text x="50%" y="55%" text-anchor="middle" dominant-baseline="middle" font-size="28" font-family="Arial, sans-serif" fill="white">⚖</text>
          </svg>
        </div>
        <div>
          <h1 class="text-2xl font-bold text-gray-900">Kalkulator Odds & Probabilitas</h1>
          <p class="text-gray-600 text-sm text-justify">
            Masukkan dua angka rasio (x : y) lalu pilih arah perhitungan.
          </p>
        </div>
      </div>
    </div>

    <div class="max-w-6xl mx-auto">
      <!-- Input Panel -->
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Set Perbandingan</h2>

        <div class="mb-6 flex items-center space-x-2">
          <input type="number" id="ratio1"
            class="w-1/2 h-12 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
            placeholder="Angka pertama" value="3" min="0">
          <span class="text-xl font-bold">:</span>
          <input type="number" id="ratio2"
            class="w-1/2 h-12 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
            placeholder="Angka kedua" value="9" min="0">
        </div>

        <div class="mb-6">
          <h3 class="text-lg font-medium text-gray-900 mb-3">Hitung Untuk</h3>
          <div class="flex space-x-2">
            <button id="winBtn"
              class="flex-1 py-2 px-4 rounded-lg border border-primary bg-primary text-white font-medium transition-colors"
              onclick="setCalculationType('win')">
              Peluang Menang
            </button>
            <button id="loseBtn"
              class="flex-1 py-2 px-4 rounded-lg border border-gray-300 text-gray-700 font-medium transition-colors hover:bg-gray-50"
              onclick="setCalculationType('lose')">
              Melawan Kemenangan
            </button>
          </div>
        </div>

        <div class="bg-primary rounded-t-lg p-4 mb-4">
          <h2 class="text-center text-white font-semibold tracking-wide">Hasil</h2>
        </div>

        <div id="results" class="max-w-md mx-auto space-y-4">
          <div class="flex justify-between items-center py-3 border-b border-primary">
            <span class="font-medium text-black">Probabilitas Odds</span>
            <span class="font-mono text-black" id="oddsRatio">-</span>
          </div>

          <div class="flex justify-between items-center py-3 border-b border-primary">
            <span class="font-medium text-black">Probabilitas Menang</span>
            <span class="font-mono text-black" id="winProb">-</span>
          </div>

          <div class="flex justify-between items-center py-3 border-b border-primary">
            <span class="font-medium text-black">Probabilitas Kalah</span>
            <span class="font-mono text-black" id="loseProb">-</span>
          </div>

          <div class="flex justify-between items-center py-3 border-b border-primary">
            <span class="font-medium text-black">"Odds untuk" menang</span>
            <span class="font-mono text-black" id="oddsForWin">-</span>
          </div>

          <div class="flex justify-between items-center py-3">
            <span class="font-medium text-black">"Odds melawan" menang</span>
            <span class="font-mono text-black" id="oddsAgainstWin">-</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <x-footer class="fill-[#EEF0F2]" />

  <script>
    let calculationType = 'win';

    function setCalculationType(type) {
      calculationType = type;

      const winBtn = document.getElementById('winBtn');
      const loseBtn = document.getElementById('loseBtn');

      if (type === 'win') {
        winBtn.className = 'flex-1 py-2 px-4 rounded-lg border border-primary bg-primary text-white font-medium transition-colors';
        loseBtn.className = 'flex-1 py-2 px-4 rounded-lg border border-gray-300 text-gray-700 font-medium transition-colors hover:bg-gray-50';
      } else {
        winBtn.className = 'flex-1 py-2 px-4 rounded-lg border border-gray-300 text-gray-700 font-medium transition-colors hover:bg-gray-50';
        loseBtn.className = 'flex-1 py-2 px-4 rounded-lg border border-primary bg-primary text-white font-medium transition-colors';
      }

      calculateOdds();
    }

    function calculateOdds() {
      const ratio1 = parseFloat(document.getElementById('ratio1').value);
      const ratio2 = parseFloat(document.getElementById('ratio2').value);

      if (isNaN(ratio1) || isNaN(ratio2) || ratio1 <= 0 || ratio2 <= 0) return;

      let forWin = ratio1, againstWin = ratio2;
      if (calculationType === 'lose') [forWin, againstWin] = [againstWin, forWin];

      const total = forWin + againstWin;
      const winProb = Math.round((forWin / total) * 100);
      const loseProb = 100 - winProb;

      // Fungsi GCD untuk menyederhanakan rasio
      function gcd(a, b) {
        return b === 0 ? a : gcd(b, a % b);
      }

      // Hitung rasio odds
      const g = gcd(againstWin, forWin);
      const simplifiedAgainst = againstWin / g;
      const simplifiedFor = forWin / g;

      const oddsForWin = `${simplifiedFor}:${simplifiedAgainst}`;
      const oddsAgainstWin = `${simplifiedAgainst}:${simplifiedFor}`;

      document.getElementById('oddsRatio').textContent = `${ratio1} ke ${ratio2}`;
      document.getElementById('winProb').textContent = `${winProb}%`;
      document.getElementById('loseProb').textContent = `${loseProb}%`;
      document.getElementById('oddsForWin').textContent = oddsForWin;
      document.getElementById('oddsAgainstWin').textContent = oddsAgainstWin;
    }


    document.addEventListener('DOMContentLoaded', () => {
      document.getElementById('ratio1').addEventListener('input', calculateOdds);
      document.getElementById('ratio2').addEventListener('input', calculateOdds);
      calculateOdds();
    });
  </script>
</x-layout-web>
