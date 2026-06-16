<x-layout-web>
  <div class="container mx-auto px-4 py-8">

    <!-- Header -->
    <div class="bg-white max-w-6xl mx-auto rounded-lg shadow-sm p-6 mb-6">
      <div class="flex items-center space-x-4">
        <div class="bg-yellow-400 rounded-lg p-3">
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
        <div>
          <h1 class="text-2xl font-bold text-gray-900">Kalkulator Persentil</h1>
          <p class="text-gray-600 text-sm text-justify">
            Kalkulator persentil akan membantu Anda menemukan nilai persentil untuk dataset. Gunakanlah kalkulator persentil ini untuk membuat sebuah daftar tabel setiap persentil ke-5.
          </p>
        </div>
      </div>
    </div>

    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-6">

      <!-- Input -->
      <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Set Data (pisahkan dengan koma)
          </label>
          <textarea id="data"
            class="w-full h-32 px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
          >10, 2, 38, 23, 38, 23, 21, 234</textarea>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Persentil
          </label>
          <input type="number" id="persentil" value="15" min="0" max="100"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
        </div>
      </div>

      <!-- Result -->
      <div class="bg-white rounded-xl p-6">
        <div class="bg-primary rounded-t-lg p-4 mb-4">
          <h2 class="text-center text-white font-semibold tracking-wide">Jawaban</h2>
        </div>

        <div class="text-center mb-6">
          <div class="text-gray-700 mb-2">
            Persentil ke-<span id="pText">15</span> adalah
          </div>
          <div id="hasil" class="text-4xl font-bold text-gray-800">10.55</div>
        </div>

        <div class="text-sm text-gray-600 mb-2" id="formula"></div>
        <div class="text-sm text-gray-600" id="sorted"></div>
      </div>

    </div>

    <!-- Table -->
    <div class="max-w-6xl mx-auto mt-8 bg-white rounded-xl shadow-sm p-6">
      <h3 class="text-lg font-semibold text-gray-800 mb-4 text-center">
        Tabel Persentil
      </h3>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-4" id="tabelPersentil"></div>
    </div>

  </div>

  <x-footer class="fill-[#EEF0F2]" />

  <script>
    function parseData() {
      return document.getElementById('data').value
        .split(',')
        .map(v => parseFloat(v.trim()))
        .filter(v => !isNaN(v))
        .sort((a, b) => a - b);
    }

    function percentileLinear(data, P) {
      const n = data.length;
      const i = (P / 100) * (n - 1);
      const b = Math.floor(i);
      const a = Math.ceil(i);
      const f = i - b;

      if (b === a) return data[b];
      return data[b] + f * (data[a] - data[b]);
    }

    function hitung() {
      const data = parseData();
      const P = parseFloat(document.getElementById('persentil').value);

      if (data.length === 0 || isNaN(P)) return;

      const hasil = percentileLinear(data, P);
      const n = data.length;
      const i = (P / 100) * (n - 1);

      document.getElementById('pText').textContent = P;
      document.getElementById('hasil').textContent = hasil.toFixed(2);
      document.getElementById('formula').textContent =
        `i = (${P} / 100) × (${n} − 1) = ${i.toFixed(2)}`;
      document.getElementById('sorted').textContent =
        `Data terurut: ${data.join(', ')}`;

      generateTable(data);
      }

        function generateTable(data) {
        const container = document.getElementById('tabelPersentil');
        container.innerHTML = '';

        const columns = [[], [], []];
        let idx = 0;

        for (let p = 0; p <= 100; p += 5) {
          const val = percentileLinear(data, p);
          columns[idx].push({ p, val });
          idx = (idx + 1) % 3;
        }

        columns.forEach(col => {
          const div = document.createElement('div');
          div.className = 'space-y-2';

          col.forEach(item => {
            const box = document.createElement('div');
            box.className =
              'border rounded-md px-3 py-2 text-sm cursor-pointer hover:bg-blue-50';
            box.textContent = `ke-${item.p} = ${item.val.toFixed(2)}`;

            box.onclick = () => {
              document.getElementById('persentil').value = item.p;
              hitung();
            };

            div.appendChild(box);
          });

          container.appendChild(div);
        });
      }

    document.getElementById('data').addEventListener('input', hitung);
    document.getElementById('persentil').addEventListener('input', hitung);
    document.addEventListener('DOMContentLoaded', hitung);
  </script>
</x-layout-web>
