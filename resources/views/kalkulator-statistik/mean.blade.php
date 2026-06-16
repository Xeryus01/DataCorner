<x-layout-web>
  <div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="bg-white max-w-6xl mx-auto rounded-lg shadow-sm p-6 mb-6">
      <div class="flex items-center space-x-4">
        <div class="bg-yellow-400 rounded-lg p-3">
          <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24">
            <!-- Garis bar di atas huruf x -->
            <line x1="8" y1="6" x2="16" y2="6" stroke="white" stroke-width="2" />
            <!-- Huruf x -->
            <text x="6" y="20" font-size="18" font-family="Arial" fill="white">x</text>
          </svg>
        </div>
        <div>
          <h1 class="text-2xl font-bold text-gray-900">Kalkulator Mean, Median, Modus</h1>
          <p class="text-gray-600 text-sm text-justify">Alat praktis untuk menghitung mean, median, dan modus dari data
            Anda dengan mudah.</p>
        </div>
      </div>
    </div>
    <div class="max-w-6xl mx-auto">

      <!-- Input Section -->
      <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex space-x-2 mb-4">
          <button id="tabSingle" class="tab-btn bg-blue-900 text-white px-4 py-2 rounded-lg">Data Tunggal</button>
          <button id="tabGrouped" class="tab-btn bg-gray-200 text-gray-800 px-4 py-2 rounded-lg">Data Kelompok</button>
        </div>
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Set Data</h2>
        <div id="singleInputSection" class="mb-4">
          <div class="mb-4">
            <textarea id="dataInput" placeholder="10, 2, 38, 23, 38, 23, 21, 234"
              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
              rows="3"></textarea>
            <p class="text-xs text-gray-500 mt-1">Angka dipisahkan dengan koma</p>
            <div id="inputError" class="text-red-600 text-sm mt-2" role="alert" aria-live="polite"></div>
          </div>

          <button id="calculateBtnSingle"
            class="bg-primary text-white px-8 py-2 rounded-lg font-semibold hover:bg-[#00295A] transition-opacity">
            Hitung
          </button>
        </div>
        <div id="groupedInputSection" class="hidden mb-4">
          <div class="mb-4">
            <label class="block font-medium text-gray-700 mb-2">Upload Data Berkelompok (Unduh Template : 📥 <a
                href="{{ asset('template_file_web/Template_Kalkulator.xlsx') }}" download
                class="text-primary hover:underline">
                Template_Mean_Median_Modus
              </a>)</label>
            <input type="file" id="groupedExcelInput" accept=".xlsx,.xls"
              class="block w-full text-base text-gray-700 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
            <p class="text-xs text-gray-500 mt-1">Isi interval dan frekuensi berdasarkan data anda</p>
            <div id="groupedError" class="text-red-600 text-sm mt-2" role="alert" aria-live="polite"></div>
          </div>
          <button id="calculateBtnGrouped"
            class="bg-primary text-white px-8 py-2 rounded-lg font-semibold hover:bg-[#00295A] transition-opacity">
            Hitung
          </button>
        </div>

        {{-- Result Section --}}
        <div class="bg-primary rounded-t-lg p-4 mb-4">
          <h2 class="text-center text-white font-semibold tracking-wide">Hasil</h2>
        </div>



        <!-- Statistics Grid -->

        <div class="max-w-xs mx-auto space-y-3">
          <div class="flex justify-between items-center py-3 border-b border-primary">
            <span class="font-medium text-black">Jumlah</span>
            <span id="sum" class="font-mono text-black">-</span>
          </div>
          <div class="flex justify-between items-center py-3 border-b border-primary">
            <span class="font-medium text-black">Banyak Data</span>
            <span id="count" class="font-mono text-black">-</span>
          </div>
          <div class="flex justify-between items-center py-3 border-b border-primary">
            <span class="font-medium text-black">Rata-rata (Mean)</span>
            <span id="mean" class="font-mono text-black">-</span>
          </div>
          <div class="flex justify-between items-center py-3 border-b border-primary">
            <span class="font-medium text-black">Median</span>
            <span id="median" class="font-mono text-black">-</span>
          </div>
          <div class="flex justify-between items-center py-3 border-b border-primary">
            <span class="font-medium text-black">Modus</span>
            <span id="mode" class="font-mono text-black">-</span>
          </div>
          <div class="flex justify-between items-center py-3 border-b border-primary">
            <span class="font-medium text-black">Terbesar</span>
            <span id="max" class="font-mono text-black">-</span>
          </div>
          <div class="flex justify-between items-center py-3 border-b border-primary">
            <span class="font-medium text-black">Terkecil</span>
            <span id="min" class="font-mono text-black">-</span>
          </div>
        </div>
      </div>

    </div>
  </div>
  <x-footer class="fill-[#EEF0F2]" />

  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const tabSingle = document.getElementById('tabSingle');
      const tabGrouped = document.getElementById('tabGrouped');
      const singleInputSection = document.getElementById('singleInputSection');
      const groupedInputSection = document.getElementById('groupedInputSection');

      tabSingle.addEventListener('click', () => {
        tabSingle.classList.add('bg-blue-900', 'text-white');
        tabGrouped.classList.remove('bg-blue-900', 'text-white');
        tabGrouped.classList.add('bg-gray-200', 'text-gray-800');
        tabSingle.classList.remove('bg-gray-200', 'text-gray-800');
        singleInputSection.classList.remove('hidden');
        groupedInputSection.classList.add('hidden');
      });

      tabGrouped.addEventListener('click', () => {
        tabGrouped.classList.add('bg-blue-900', 'text-white');
        tabSingle.classList.remove('bg-blue-900', 'text-white');
        tabSingle.classList.add('bg-gray-200', 'text-gray-800');
        tabGrouped.classList.remove('bg-gray-200', 'text-gray-800');
        singleInputSection.classList.add('hidden');
        groupedInputSection.classList.remove('hidden');
      });

      new MeanCalculator();
    });

    class MeanCalculator {
      constructor() {
        this.dataInput = document.getElementById('dataInput');
        this.calculateBtnSingle = document.getElementById('calculateBtnSingle');
        this.calculateBtnGrouped = document.getElementById('calculateBtnGrouped');
        this.groupedExcelInput = document.getElementById('groupedExcelInput');
        this.lastGroupedData = null;

        this.calculateBtnSingle.addEventListener('click', () => this.calculateSingle());
        this.groupedExcelInput.addEventListener('change', (e) => this.handleGroupedExcelUpload(e));
        this.calculateBtnGrouped.addEventListener('click', () => this.calculateGrouped());

        this.dataInput.value = '10, 2, 38, 23, 38, 23, 21, 234';
        this.calculateSingle();
      }
      parseData(input) {
        const raw = (input || '').trim();
        if (!raw) return { numbers: [], invalid: [], warningSeparated: false };

        const hasComma = raw.indexOf(',') !== -1;
        let tokens;
        if (hasComma) {
          tokens = raw.split(',').map(item => item.trim()).filter(item => item !== '');
        } else {
          // Auto-normalize: split on whitespace or semicolon when no comma is present
          tokens = raw.split(/[\s;]+/).map(item => item.trim()).filter(item => item !== '');
        }

        const numberRegex = /^-?\d+(?:\.\d+)?$/;
        const numbers = [];
        const invalid = [];
        tokens.forEach(tok => {
          if (numberRegex.test(tok)) {
            numbers.push(parseFloat(tok));
          } else {
            invalid.push(tok);
          }
        });
        return { numbers, invalid, warningSeparated: !hasComma && tokens.length > 0 };
      }

      displayError(message, targetId = 'inputError') {
        const el = document.getElementById(targetId);
        if (el) el.textContent = message;
      }

      displayWarning(message, targetId = 'inputWarning') {
        const el = document.getElementById(targetId);
        if (el) el.textContent = message;
      }

      clearErrors() {
        const ie = document.getElementById('inputError');
        const ge = document.getElementById('groupedError');
        const iw = document.getElementById('inputWarning');
        if (ie) ie.textContent = '';
        if (ge) ge.textContent = '';
        if (iw) iw.textContent = '';
      }

      calculateSingle() {
        const { numbers: data, invalid, warningSeparated } = this.parseData(this.dataInput.value);
        this.clearErrors();
        if (invalid.length) {
          this.displayError('Input mengandung nilai tidak valid: ' + invalid.join(', '), 'inputError');
          return this.clearDisplay();
        }
        if (!data.length) {
          this.displayError('Tidak ada data numerik pada input.', 'inputError');
          return this.clearDisplay();
        }

        if (warningSeparated) {
          this.displayWarning('Format: tidak ditemukan koma — input otomatis dinormalisasi. Disarankan gunakan koma sebagai pemisah.');
        }

        const sum = data.reduce((a, b) => a + b, 0);
        const mean = sum / data.length;
        const median = this.calculateMedian(data);
        const mode = this.calculateMode(data);

        this.updateDisplay({
          sum,
          count: data.length,
          mean,
          median,
          mode,
          max: Math.max(...data),
          min: Math.min(...data)
        });
      }

      handleGroupedExcelUpload(e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = (event) => {
          const data = new Uint8Array(event.target.result);
          const workbook = XLSX.read(data, {
            type: 'array'
          });
          const sheet = workbook.Sheets[workbook.SheetNames[0]];
          const jsonData = XLSX.utils.sheet_to_json(sheet, {
            defval: ""
          });

          const { data: groupedData, errors } = this.parseGroupedData(jsonData);
          this.clearErrors();
          if (errors.length) {
            this.displayError('File mengandung kesalahan: ' + errors.join('; '), 'groupedError');
            return;
          }
          if (groupedData.length === 0) {
            this.displayError('Data berkelompok kosong atau tidak valid.', 'groupedError');
            return;
          }

          this.lastGroupedData = groupedData; //Simpan data setelah upload
          alert('File berhasil diupload. Silakan klik tombol Hitung!');
        };
        reader.readAsArrayBuffer(file);
      }

      calculateGrouped() {
        this.clearErrors();
        if (!this.lastGroupedData) {
          this.displayError('Silakan upload file terlebih dahulu!', 'groupedError');
          return;
        }

        const groupedData = this.lastGroupedData;
        const totalFx = groupedData.reduce((acc, item) => acc + (item.midpoint * item.freq), 0);
        const totalF = groupedData.reduce((acc, item) => acc + item.freq, 0);
        const meanGrouped = totalF === 0 ? 0 : totalFx / totalF;

        const max = Math.max(...groupedData.map(item => item.upper));
        const min = Math.min(...groupedData.map(item => item.lower));
        const median = this.calculateGroupedMedian(groupedData, totalF);
        const mode = this.calculateGroupedMode(groupedData);

        this.updateDisplay({
          sum: totalFx,
          count: totalF,
          mean: meanGrouped,
          median,
          mode,
          max,
          min
        });
      }

      parseGroupedData(jsonData) {
        const result = [];
        const errors = [];
        jsonData.forEach((item, idx) => {
          const interval = item['Interval'] || item['interval'];
          const freqRaw = item['Frekuensi'] || item['frekuensi'];
          const freq = parseFloat(freqRaw);
          if (!interval) {
            errors.push(`Baris ${idx+1}: interval kosong`);
            return;
          }
          const parts = interval.toString().split('-').map(s => s.trim());
          if (parts.length !== 2) {
            errors.push(`Baris ${idx+1}: interval tidak valid (${interval})`);
            return;
          }
          const lower = Number(parts[0]);
          const upper = Number(parts[1]);
          if (isNaN(lower) || isNaN(upper)) {
            errors.push(`Baris ${idx+1}: interval harus angka (${interval})`);
            return;
          }
          if (isNaN(freq)) {
            errors.push(`Baris ${idx+1}: frekuensi tidak valid (${freqRaw})`);
            return;
          }
          const midpoint = (lower + upper) / 2;
          result.push({ lower, upper, midpoint, freq });
        });
        return { data: result, errors };
      }

      calculateGroupedMedian(groupedData, totalF) {
        let cumulative = 0;
        const half = totalF / 2;
        for (let i = 0; i < groupedData.length; i++) {
          cumulative += groupedData[i].freq;
          if (cumulative >= half) {
            const medianClass = groupedData[i];
            const L = medianClass.lower - 0.5;
            const f = medianClass.freq;
            const F = cumulative - medianClass.freq;
            const c = medianClass.upper - medianClass.lower + 1;
            return L + ((half - F) / f) * c;
          }
        }
        return 0;
      }

      calculateGroupedMode(groupedData) {
        let maxFreq = 0;
        let index = -1;
        groupedData.forEach((item, i) => {
          if (item.freq > maxFreq) {
            maxFreq = item.freq;
            index = i;
          }
        });
        if (index === -1) return 0;
        const L = groupedData[index].lower - 0.5;
        const f1 = groupedData[index].freq;
        const f0 = index > 0 ? groupedData[index - 1].freq : 0;
        const f2 = index < groupedData.length - 1 ? groupedData[index + 1].freq : 0;
        const c = groupedData[index].upper - groupedData[index].lower + 1;
        return L + ((f1 - f0) / ((f1 - f0) + (f1 - f2))) * c;
      }

      calculateMedian(data) {
        const sorted = [...data].sort((a, b) => a - b);
        const mid = Math.floor(sorted.length / 2);
        return sorted.length % 2 === 0 ?
          (sorted[mid - 1] + sorted[mid]) / 2 :
          sorted[mid];
      }

      calculateMode(data) {
        const freq = {};
        data.forEach(num => freq[num] = (freq[num] || 0) + 1);
        const maxFreq = Math.max(...Object.values(freq));
        if (maxFreq === 1) return 'Tidak ada';
        return Object.keys(freq).filter(k => freq[k] === maxFreq).join(', ');
      }

      updateDisplay({
        sum,
        count,
        mean,
        median,
        mode,
        max,
        min
      }) {
        document.getElementById('sum').textContent = this.formatNumber(sum);
        document.getElementById('count').textContent = count;
        document.getElementById('mean').textContent = this.formatNumber(mean);
        document.getElementById('median').textContent = this.formatNumber(median);
        document.getElementById('mode').textContent = this.formatNumber(mode);
        document.getElementById('max').textContent = max;
        document.getElementById('min').textContent = min;
      }

      clearDisplay() {
        this.updateDisplay({
          sum: '-',
          count: '-',
          mean: '-',
          median: '-',
          mode: '-',
          max: '-',
          min: '-'
        });
      }

      formatNumber(num) {
        if (num === '-' || num === undefined) return '-';
        if (typeof num === 'number') return Number.isInteger(num) ? num : num.toFixed(2);
        return num;
      }
    }
  </script>

</x-layout-web>
