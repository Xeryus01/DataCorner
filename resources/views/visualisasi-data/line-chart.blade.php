<x-layout-web>
  <div class="min-h-screen bg-[#EEF0F2]">
    <!-- Header -->
    <div class="bg-blue-900 text-white py-8">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold">Line Chart</h1>
        <p class="mt-2 text-blue-100">Upload data dan buat line chart interaktif</p>
      </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Upload Panel -->
        <div class="lg:col-span-1">
          <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Upload Data</h2>
            <p class="text-sm font-medium text-gray-700 mb-2">
              📥 Download template terlebih dahulu:
              <a href="{{ asset('template_file_web/Template_Visualisasi_Data.xlsx') }}" download
                class="text-primary hover:underline">
                Template_Visualisasi_Data
              </a>
            </p>
            <!-- File Upload -->
            <div class="mb-6">
              <label class="block text-sm font-medium text-gray-700 mb-2">Pilih File Data</label>
              <div
                class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary transition-colors">
                <input type="file" id="dataFile" accept=".csv,.xlsx,.xls" class="hidden">
                <label for="dataFile" class="cursor-pointer">
                  <div class="text-gray-400 mb-2">
                    <svg class="mx-auto h-12 w-12" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                      <path
                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                  </div>
                  <p class="text-sm text-gray-600"><span class="font-medium text-primary">Klik untuk upload</span> atau
                    drag & drop</p>
                  <p class="text-xs text-gray-500 mt-1">CSV, XLSX, XLS (Max 2MB)</p>
                </label>
              </div>
              <div id="fileInfo" class="mt-2 text-sm text-gray-600 hidden"></div>
            </div>

            <!-- Column Selection -->
            <div id="columnSelection" class="mb-6 hidden">
              <label class="block text-sm font-medium text-gray-700 mb-2">Kolom Sumbu X</label>
              <select id="xColumnSelect"
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Pilih kolom sumbu X...</option>
              </select>

              <label class="block text-sm font-medium text-gray-700 mt-4 mb-2">Kolom Sumbu Y</label>
              <select id="yColumnSelect"
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Pilih kolom sumbu Y...</option>
              </select>
            </div>

            <!-- Generate Button -->
            <button id="generateBtn"
              class="w-full bg-primary text-white py-3 px-4 rounded-lg hover:bg-[#00295A] transition-colors disabled:opacity-50 disabled:cursor-not-allowed hidden">
              <span id="generateBtnText">Generate Line Chart</span>
              <div id="generateBtnLoader" class="hidden">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg"
                  fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                    stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                  </path>
                </svg>
                Generating...
              </div>
            </button>
          </div>

          <!-- Data Preview -->
          <div id="dataPreview" class="bg-white rounded-lg shadow-md p-6 mt-6 hidden">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Preview Data</h3>
            <div class="overflow-x-auto">
              <table id="previewTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr id="previewHeader"></tr>
                </thead>
                <tbody id="previewBody" class="bg-white divide-y divide-gray-200"></tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Chart Panel -->
        <div class="lg:col-span-2">
          <div class="bg-white rounded-lg shadow-md p-6">
            <div id="chartContainer" class="hidden">
              <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Line Chart</h2>
                <button id="downloadChart"
                  class="bg-button text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                  Download Chart
                </button>
              </div>
              <div id="linechart" style="height: 400px;"></div>
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="text-center py-12">
              <div class="text-gray-400 mb-4">
                <svg class="mx-auto h-16 w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 17l6-6 4 4 8-8" />
                </svg>
              </div>
              <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada data</h3>
              <p class="text-gray-500">Upload file data terlebih dahulu untuk membuat line chart</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Toast -->
  <div id="toast" class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg hidden z-50">
    <div class="flex items-center">
      <span id="toastMessage"></span>
      <button onclick="hideToast()" class="ml-4 text-white hover:text-gray-200">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>
  </div>

  <x-footer class="fill-[#EEF0F2]" />

  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script>
    let uploadedData = [];
    let currentChart = null;

    document.addEventListener('DOMContentLoaded', function() {
      const fileInput = document.getElementById('dataFile');
      const generateBtn = document.getElementById('generateBtn');
      const xSelect = document.getElementById('xColumnSelect');
      const ySelect = document.getElementById('yColumnSelect');

      fileInput.addEventListener('change', handleFileUpload);
      generateBtn.addEventListener('click', generateLineChart);

      xSelect.addEventListener('change', checkSelect);
      ySelect.addEventListener('change', checkSelect);

      function checkSelect() {
        if (xSelect.value && ySelect.value && uploadedData.length > 0) {
          generateBtn.classList.remove('hidden');
        }
      }
    });

    function handleFileUpload(event) {
      const file = event.target.files[0];
      if (!file) return;

      const formData = new FormData();
      formData.append('data_file', file);

      fetch('{{ route('visualisasi.linechart.upload') }}', {
          method: 'POST',
          body: formData,
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            uploadedData = data.data;
            populateColumnSelect(data.columns, data.columnTypes);
            showDataPreview(data.data.slice(0, 5));
            document.getElementById('fileInfo').innerHTML = `File uploaded: ${file.name}`;
            document.getElementById('fileInfo').classList.remove('hidden');
            document.getElementById('columnSelection').classList.remove('hidden');
            document.getElementById('dataPreview').classList.remove('hidden');
          } else {
            showToast(data.error);
          }
        })
        .catch(() => showToast('Gagal upload file'));
    }

    function populateColumnSelect(columns, types) {
      const xSelect = document.getElementById('xColumnSelect');
      const ySelect = document.getElementById('yColumnSelect');

      xSelect.innerHTML = '<option value=\"\">Pilih kolom sumbu X...</option>';
      ySelect.innerHTML = '<option value=\"\">Pilih kolom sumbu Y...</option>';

      columns.forEach(column => {
        const xOption = document.createElement('option');
        xOption.value = column;
        xOption.textContent = `${column}`;
        xSelect.appendChild(xOption);

        const yOption = document.createElement('option');
        yOption.value = column;
        yOption.textContent = `${column}`;
        ySelect.appendChild(yOption);
      });
    }

    function showDataPreview(data) {
      if (!data.length) return;
      const headers = Object.keys(data[0]);
      const headerRow = document.getElementById('previewHeader');
      const tbody = document.getElementById('previewBody');
      headerRow.innerHTML = '';
      tbody.innerHTML = '';

      headers.forEach(header => {
        const th = document.createElement('th');
        th.className = 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider';
        th.textContent = header;
        headerRow.appendChild(th);
      });

      data.forEach(row => {
        const tr = document.createElement('tr');
        headers.forEach(header => {
          const td = document.createElement('td');
          td.className = 'px-6 py-4 whitespace-nowrap text-sm text-gray-900';
          td.textContent = row[header] || '-';
          tr.appendChild(td);
        });
        tbody.appendChild(tr);
      });
    }

    function generateLineChart() {
      const xColumn = document.getElementById('xColumnSelect').value;
      const yColumn = document.getElementById('yColumnSelect').value;

      if (!xColumn || !yColumn || uploadedData.length === 0) {
        showToast('Pilih kolom X dan Y terlebih dahulu');
        return;
      }

      document.getElementById('generateBtnText').classList.add('hidden');
      document.getElementById('generateBtnLoader').classList.remove('hidden');
      document.getElementById('generateBtn').disabled = true;

      fetch('{{ route('visualisasi.linechart.generate') }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify({
            xColumn: xColumn,
            yColumn: yColumn,
            data: uploadedData
          })
        })
        .then(response => response.json())
        .then(data => {
          document.getElementById('generateBtnText').classList.remove('hidden');
          document.getElementById('generateBtnLoader').classList.add('hidden');
          document.getElementById('generateBtn').disabled = false;

          if (data.success) {
            renderLineChart(data.x, data.y, xColumn, yColumn);
            document.getElementById('emptyState').classList.add('hidden');
            document.getElementById('chartContainer').classList.remove('hidden');
          } else {
            showToast(data.error || 'Gagal membuat line chart');
          }
        })
        .catch(() => showToast('Gagal membuat line chart'));
    }

    function renderLineChart(xData, yData, xLabel, yLabel) {
      const options = {
        chart: {
          type: 'line',
          height: 400,
          zoom: {
            enabled: true
          }
        },
        series: [{
          name: yLabel,
          data: yData
        }],
        xaxis: {
          categories: xData,
          title: {
            text: xLabel
          }
        },
        yaxis: {
          title: {
            text: yLabel
          }
        }
      };

      if (currentChart) currentChart.destroy();
      currentChart = new ApexCharts(document.querySelector("#linechart"), options);
      currentChart.render();
    }

    function showToast(message) {
      const toast = document.getElementById('toast');
      document.getElementById('toastMessage').textContent = message;
      toast.classList.remove('hidden');
      setTimeout(() => toast.classList.add('hidden'), 5000);
    }

    function hideToast() {
      document.getElementById('toast').classList.add('hidden');
    }

    document.getElementById('downloadChart').addEventListener('click', () => {
      if (currentChart) {
        currentChart.dataURI().then(({
          imgURI
        }) => {
          const link = document.createElement('a');
          link.href = imgURI;
          link.download = 'line_chart.png';
          link.click();
        });
      }
    });
  </script>
</x-layout-web>
