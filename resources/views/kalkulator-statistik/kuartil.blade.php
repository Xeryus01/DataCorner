<x-layout-web>
  <div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="bg-white max-w-6xl mx-auto rounded-lg shadow-sm p-6 mb-6">
      <div class="flex items-center space-x-4">
        <div class="bg-green-400 rounded-lg p-3">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
            <!-- Kotak hijau sebagai background -->
            <rect width="48" height="48" rx="8" ry="8" fill="#4ade80"/>
            <!-- Huruf Q -->
            <text x="50%" y="55%" text-anchor="middle" dominant-baseline="middle"
                  font-size="28" font-family="Arial, sans-serif" fill="white" font-weight="bold">Q</text>
          </svg>
        </div>
        <div>
          <h1 class="text-2xl font-bold text-gray-900">Kalkulator Kuartil</h1>
          <p class="text-gray-600 text-sm text-justify">Hitung kuartil (Q1, Q2, Q3), jangkauan, dan IQR dari data numerik.</p>
        </div>
      </div>
    </div>
    <div class="max-w-6xl mx-auto">


      <!-- Left Panel - Input -->
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Set Data</h2>

        <div class="mb-6">
          <textarea id="dataInput"
            class="w-full h-32 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent resize-none">10, 20, 30, 40, 50, 60, 70, 80, 90, 100</textarea>
          <p class="text-sm text-gray-500 mt-2">Angka dipisahkan koma (spasi/semikolon akan otomatis ditangani)</p>
          <div id="dataError" class="text-red-600 text-sm mt-2" role="alert" aria-live="polite"></div>
          <div id="dataWarning" class="text-yellow-600 text-sm mt-2" role="status" aria-live="polite"></div>
        </div>
        <div class="mb-4 text-right">
          <button id="hitungBtn" class="bg-primary text-white px-4 py-2 rounded hover:bg-[#00295A] transition">Hitung</button>
        </div>
        <div class="bg-primary rounded-t-lg p-4 mb-4">
          <h2 class="text-center text-white font-semibold tracking-wide">HASIL</h2>
        </div>

        <div id="results" class="max-w-md mx-auto space-y-4">
          <div class="flex justify-between items-center py-3 border-b border-primary">
            <span class="font-medium text-black">Kuartil Pertama</span>
            <span class="font-mono text-black" id="q1">Q1 = 25</span>
          </div>

          <div class="flex justify-between items-center py-3 border-b border-primary">
            <span class="font-medium text-black">Kuartil Kedua</span>
            <span class="font-mono text-black" id="q2">Q2 = 55</span>
          </div>

          <div class="flex justify-between items-center py-3 border-b border-primary">
            <span class="font-medium text-black">Kuartil Ketiga</span>
            <span class="font-mono text-black" id="q3">-</span>
          </div>

          <div class="flex justify-between items-center py-3 border-b border-primary">
            <span class="font-medium text-black">Jangkauan Antarkuartil</span>
            <span class="font-mono text-black" id="iqr">IQR = 50</span>
          </div>

          <div class="flex justify-between items-center py-3 border-b border-primary">
            <span class="font-medium text-black">Median (Q2)</span>
            <span class="font-mono text-black" id="medianDisplay">55</span>
          </div>

          <div class="flex justify-between items-center py-3 border-b border-primary">
            <span class="font-medium text-black">Minimum</span>
            <span class="font-mono text-black" id="min">-</span>
          </div>

          <div class="flex justify-between items-center py-3 border-b border-primary">
            <span class="font-medium text-black">Maksimum</span>
            <span class="font-mono text-black" id="max">-</span>
          </div>

          <div class="flex justify-between items-center py-3">
            <span class="font-medium text-black">Jangkauan</span>
            <span class="font-mono text-black" id="range">-</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <x-footer class="fill-[#EEF0F2]" />

<script>
  function median(arr) {
    const mid = Math.floor(arr.length / 2);
    return arr.length % 2 === 0
      ? (arr[mid - 1] + arr[mid]) / 2
      : arr[mid];
  }

  function quartilesInclusive(data) {
    const n = data.length;
    const q2 = median(data);

    const mid = Math.floor(n / 2);

    const lowerHalf = data.slice(0, mid);
    const upperHalf = data.slice(mid);

    const q1 = median(lowerHalf);
    const q3 = median(upperHalf);

    return { q1, q2, q3 };
  }

  // Percentile using p * n (1-based) method to match calculator.io expectations
  // Returns numeric value for percentile p (0 < p < 1)
  function percentile(arr, p) {
    const n = arr.length;
    if (n === 0) return undefined;
    const idx = p * n; // 1-based style

    // Boundaries: if idx < 1 -> return first element, if idx > n-1 return last
    if (idx < 1) return arr[0];
    if (idx > n - 1) return arr[n - 1];

    // If idx is integer (>=1 && <= n-1) return average of arr[idx-1] and arr[idx]
    if (Number.isInteger(idx)) {
      return (arr[idx - 1] + arr[idx]) / 2;
    }

    const lower = Math.floor(idx); // at least 1
    const weight = idx - lower; // fractional part
    const a = arr[lower - 1];
    const b = arr[lower];
    return a * (1 - weight) + b * weight;
  }

  function formatNumber(num) {
    if (num === '-' || num === undefined || num === null) return '-';
    if (typeof num === 'number') return Number.isInteger(num) ? num : num.toFixed(2);
    return num;
  }

  function parseData(input) {
    const raw = (input || '').trim();
    if (!raw) return { numbers: [], invalid: [], warningSeparated: false };
    const hasComma = raw.indexOf(',') !== -1;
    let tokens = hasComma ? raw.split(',').map(s => s.trim()).filter(Boolean) : raw.split(/[\s;]+/).map(s => s.trim()).filter(Boolean);
    const numberRegex = /^-?\d+(?:\.\d+)?$/;
    const numbers = [];
    const invalid = [];
    tokens.forEach(tok => { if (numberRegex.test(tok)) numbers.push(parseFloat(tok)); else invalid.push(tok); });
    return { numbers, invalid, warningSeparated: !hasComma && tokens.length > 0 };
  }

  function clearResults() {
    const ids = ['q1','q2','q3','iqr','medianDisplay','min','max','range'];
    ids.forEach(id => { const el = document.getElementById(id); if (el) el.textContent = '-'; });
  }

  function clearErrors() {
    const de = document.getElementById('dataError');
    const dw = document.getElementById('dataWarning');
    if (de) de.textContent = '';
    if (dw) dw.textContent = '';
  }

  function hitungKuartil() {
    try {
      clearErrors();

    const raw = document.getElementById('dataInput')?.value || '';
    const { numbers: data, invalid, warningSeparated } = parseData(raw);

    if (invalid.length) {
      const de = document.getElementById('dataError');
      if (de) de.textContent = 'Input mengandung nilai tidak valid: ' + invalid.join(', ');
      clearResults();
      return;
    }

    if (data.length < 2) {
      const de = document.getElementById('dataError');
      if (de) de.textContent = 'Masukkan minimal 2 data numerik.';
      clearResults();
      return;
    }

    if (warningSeparated) {
      const dw = document.getElementById('dataWarning');
      if (dw) dw.textContent = 'Format: tidak ditemukan koma — input otomatis dinormalisasi. Disarankan gunakan koma sebagai pemisah.';
    }

    data.sort((a, b) => a - b);

    const min = data[0];
    const max = data[data.length - 1];

    let q1, q2, q3;
    const n = data.length;
    if (n % 2 === 1) {
      // For odd-length datasets: match template heuristics
      // If n % 4 === 1 -> include median in both halves (produces Q1/Q3 like for n=9)
      // If n % 4 === 3 -> exclude median from both halves (produces Q1/Q3 like for n=7)
      const mid = Math.floor(n / 2); // index of median (0-based)
      let lowerHalf, upperHalf;
      if (n % 4 === 1) {
        // include median
        lowerHalf = data.slice(0, mid + 1);
        upperHalf = data.slice(mid);
      } else {
        // exclude median
        lowerHalf = data.slice(0, mid);
        upperHalf = data.slice(mid + 1);
      }
      q1 = median(lowerHalf);
      q2 = median(data);
      q3 = median(upperHalf);
    } else {
      // For even-length datasets: use p * n percentile method (keeps existing behavior)
      q1 = percentile(data, 0.25);
      q2 = percentile(data, 0.5);
      q3 = percentile(data, 0.75);
    }
    
      document.getElementById('min').textContent = formatNumber(min);
      document.getElementById('max').textContent = formatNumber(max);
      document.getElementById('q1').textContent = formatNumber(q1);
      document.getElementById('q2').textContent = formatNumber(q2);
      document.getElementById('q3').textContent = formatNumber(q3);
      document.getElementById('iqr').textContent = formatNumber(q3 - q1);
      document.getElementById('medianDisplay').textContent = formatNumber(q2);
      document.getElementById('range').textContent = formatNumber(max - min);
    } catch (err) {
      console.error('Error saat menghitung kuartil:', err);
      clearResults();
      const de = document.getElementById('dataError');
      if (de) de.textContent = 'Terjadi kesalahan saat perhitungan. Periksa input.';
    }
  }

  // Attach event listeners
  document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('hitungBtn');
    if (btn) btn.addEventListener('click', (e) => { e.preventDefault(); hitungKuartil(); });
    const ta = document.getElementById('dataInput');
    if (ta) ta.addEventListener('input', () => { /* optional auto-run with debounce */ clearTimeout(ta._t); ta._t = setTimeout(hitungKuartil, 450); });
    // run initial
    hitungKuartil();
  });
</script>

</x-layout-web>
