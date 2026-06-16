<x-layout-web>
  <div class="container mx-auto px-4 py-8">

    <!-- Header -->
    <div class="bg-white max-w-6xl mx-auto rounded-lg shadow-sm p-6 mb-6">
      <div class="flex items-center space-x-4">
        <div class="bg-blue-500 rounded-lg p-3">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" viewBox="0 0 24 24">
            <rect x="4" y="2" width="16" height="20" rx="2" ry="2" fill="none" stroke="white" stroke-width="2"/>
            <rect x="7" y="4" width="10" height="4" fill="white"/>
            <circle cx="8" cy="10" r="1.2"/>
            <circle cx="12" cy="10" r="1.2"/>
            <circle cx="16" cy="10" r="1.2"/>
            <circle cx="8" cy="14" r="1.2"/>
            <circle cx="12" cy="14" r="1.2"/>
            <circle cx="16" cy="14" r="1.2"/>
            <circle cx="8" cy="18" r="1.2"/>
            <circle cx="12" cy="18" r="1.2"/>
            <circle cx="16" cy="18" r="1.2"/>
          </svg>
        </div>

        <div>
          <h1 class="text-2xl font-bold text-gray-900">Kalkulator Ukuran Sampel</h1>
          <p class="text-gray-600 text-sm text-justify">
            Menghitung ukuran sampel atau margin of error berdasarkan tingkat kepercayaan,
            proporsi populasi, dan ukuran populasi.
          </p>
        </div>
      </div>
    </div>

    <!-- MODE -->
    <div class="max-w-6xl mx-auto mb-4 flex gap-2">
      <button id="btnSample"
        class="px-4 py-2 rounded bg-blue-600 text-white font-medium transition-all duration-200">
        Ukuran Sampel
      </button>
      <button id="btnMargin"
        class="px-4 py-2 rounded bg-gray-200 text-gray-700 font-medium transition-all duration-200">
        Margin of Error
      </button>
    </div>

    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-6">

      <!-- INPUT -->
      <div class="bg-white rounded-xl shadow-sm p-6 space-y-4">

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Tingkat Kepercayaan
          </label>
          <select id="confidence" class="w-full border rounded-md px-3 py-2">
            <option value="70">70%</option>
            <option value="75">75%</option>
            <option value="80">80%</option>
            <option value="85">85%</option>
            <option value="92">92%</option>
            <option value="95" selected>95%</option>
            <option value="96">96%</option>
            <option value="98">98%</option>
            <option value="99">99%</option>
            <option value="99.9">99.9%</option>
            <option value="99.99">99.99%</option>
            <option value="99.999">99.999%</option>
          </select>
        </div>

        <div>
          <label id="dynamicLabel" class="block text-sm font-medium text-gray-700 mb-1">
            Margin of Error (%)
          </label>
          <input id="dynamicInput" type="number" value="5"
            class="w-full border rounded-md px-3 py-2">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Proporsi Populasi (%)
          </label>
          <input id="proportion" type="number" value="50"
            class="w-full border rounded-md px-3 py-2">
          <p class="text-xs text-gray-500 mt-1">
            Jika tidak diketahui, gunakan 50%.
          </p>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Ukuran Populasi (opsional)
          </label>
          <input id="population" type="number"
            class="w-full border rounded-md px-3 py-2"
            placeholder="Kosongkan jika tidak diketahui">
        </div>

      </div>

      <!-- HASIL -->
      <div class="bg-white rounded-xl shadow-sm p-6">

        <div class="bg-blue-600 rounded-t-lg p-4 mb-4">
          <h2 class="text-center text-white font-semibold tracking-wide">Hasil</h2>
        </div>

        <div class="text-center mb-4">
          <div id="hasilLabel" class="text-gray-600 text-sm uppercase">
            Ukuran Sampel
          </div>
          <div id="hasil" class="text-4xl font-bold text-gray-800">385</div>
        </div>

        <div id="penjelasan"
          class="text-sm text-gray-600 bg-gray-50 rounded-lg p-4 space-y-1">
        </div>
      </div>

    </div>
  </div>

  <x-footer class="fill-[#EEF0F2]" />

  <script>
    const Z_TABLE = {
      70: 1.036, 75: 1.150, 80: 1.282, 85: 1.440,
      92: 1.751, 95: 1.960, 96: 2.054, 98: 2.326,
      99: 2.576, 99.9: 3.291, 99.99: 3.890, 99.999: 4.417
    };

    let mode = 'sample';

    const btnSample = document.getElementById('btnSample');
    const btnMargin = document.getElementById('btnMargin');
    const confidenceEl = document.getElementById('confidence');
    const dynamicInput = document.getElementById('dynamicInput');
    const dynamicLabel = document.getElementById('dynamicLabel');
    const proportionEl = document.getElementById('proportion');
    const populationEl = document.getElementById('population');
    const hasilEl = document.getElementById('hasil');
    const hasilLabelEl = document.getElementById('hasilLabel');
    const penjelasanEl = document.getElementById('penjelasan');

    function setActiveButton(active, inactive) {
      active.classList.add('bg-blue-600','text-white');
      active.classList.remove('bg-gray-200','text-gray-700');

      inactive.classList.remove('bg-blue-600','text-white');
      inactive.classList.add('bg-gray-200','text-gray-700');
    }

    function hitung() {
      const Z = Z_TABLE[confidenceEl.value];
      const p = proportionEl.value / 100;
      const N = parseInt(populationEl.value);
      const x = parseFloat(dynamicInput.value);

      if (!Z || !p || !x) return;

      let detail = `<div>Z = ${Z}</div><div>p = ${p}</div>`;

      if (mode === 'sample') {
        const e = x / 100;
        let n0 = (Z*Z*p*(1-p))/(e*e);
        let n = n0;

        if (!isNaN(N) && N > 0) {
          n = n0 / (1 + (n0 - 1) / N);
        }

        hasilLabelEl.textContent = 'Ukuran Sampel';
        hasilEl.textContent = Math.ceil(n);
        detail += `<div>n = ${Math.ceil(n)}</div>`;
      } else {
        let e = Z * Math.sqrt((p*(1-p))/x);
        if (!isNaN(N) && N > x) {
          e *= Math.sqrt((N-x)/(N-1));
        }
        hasilLabelEl.textContent = 'Margin of Error';
        hasilEl.textContent = (e*100).toFixed(2) + '%';
        detail += `<div>e = ${(e*100).toFixed(2)}%</div>`;
      }

      penjelasanEl.innerHTML = detail;
    }

    btnSample.onclick = () => {
      mode = 'sample';
      dynamicLabel.textContent = 'Margin of Error (%)';
      dynamicInput.value = 5;
      setActiveButton(btnSample, btnMargin);
      hitung();
    };

    btnMargin.onclick = () => {
      mode = 'margin';
      dynamicLabel.textContent = 'Ukuran Sampel';
      dynamicInput.value = 385;
      setActiveButton(btnMargin, btnSample);
      hitung();
    };

    [confidenceEl, dynamicInput, proportionEl, populationEl]
      .forEach(el => el.addEventListener('input', hitung));

    document.addEventListener('DOMContentLoaded', hitung);
  </script>
</x-layout-web>
