<x-layout-web>
  <div class="min-h-screen bg-[#EEF0F2]">
    <!-- Header -->
    <div class="bg-blue-900 text-white py-8">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold">Pie Chart</h1>
        <p class="mt-2 text-blue-100">Buat pie chart untuk memvisualisasikan komposisi data Anda, menunjukkan proporsi
          masing-masing kategori dari total.</p>
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
              <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Kolom</label>
              <select id="columnSelect"
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Pilih kolom untuk pie chart...</option>
              </select>
            </div>

            <!-- Generate Button -->
            <button id="generateBtn"
              class="w-full bg-primary text-white py-3 px-4 rounded-lg hover:bg-[#00295A] transition-colors disabled:opacity-50 disabled:cursor-not-allowed hidden">
              <span id="generateBtnText">Generate Pie Chart</span>
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
                <h2 class="text-xl font-semibold text-gray-900">Pie Chart</h2>
                <button id="downloadChart"
                  class="bg-button text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                  Download Chart
                </button>
              </div>
              <div id="piechart" style="height: 400px;"></div>
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="text-center py-12">
              <div class="mx-auto flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="55" height="55" viewBox="0 0 24 24"
                  style="fill: rgb(183, 176, 176)">
                  <path
                    d="M13 2.051V11h8.949c-.47-4.717-4.232-8.479-8.949-8.949zm4.969 17.953c2.189-1.637 3.694-4.14 3.98-7.004h-8.183l4.203 7.004z">
                  </path>
                  <path
                    d="M11 12V2.051C5.954 2.555 2 6.824 2 12c0 5.514 4.486 10 10 10a9.93 9.93 0 0 0 4.255-.964s-5.253-8.915-5.254-9.031A.02.02 0 0 0 11 12z">
                  </path>
                </svg>
              </div>
              <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada data</h3>
              <p class="text-gray-500">Upload file data terlebih dahulu untuk membuat pie chart</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Toast Notification -->
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
      const columnSelect = document.getElementById('columnSelect');

      fileInput.addEventListener('change', handleFileUpload);
      generateBtn.addEventListener('click', generatePieChart);
      columnSelect.addEventListener('change', () => {
        if (columnSelect.value && uploadedData.length > 0) {
          generateBtn.classList.remove('hidden');
        }
      });
    });

    function handleFileUpload(event) {
      const file = event.target.files[0];
      if (!file) return;

      const formData = new FormData();
      formData.append('data_file', file);

      fetch('{{ route('visualisasi.piechart.upload') }}', {
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
            showToast(data.error || 'File tidak sesuai format', 'error');
          }
        })
        .catch(() => showToast('Gagal upload file'));
    }

    function populateColumnSelect(columns, types) {
      const select = document.getElementById('columnSelect');
      select.innerHTML = '<option value="">Pilih kolom untuk pie chart...</option>';
      columns.forEach(column => {
        const option = document.createElement('option');
        option.value = column;
        option.textContent = `${column} (${types[column]})`;
        select.appendChild(option);
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

    function generatePieChart() {
      const column = document.getElementById('columnSelect').value;
      if (!column || uploadedData.length === 0) {
        showToast('Pilih kolom terlebih dahulu');
        return;
      }

      document.getElementById('generateBtnText').classList.add('hidden');
      document.getElementById('generateBtnLoader').classList.remove('hidden');
      document.getElementById('generateBtn').disabled = true;

      fetch('{{ route('visualisasi.piechart.generate') }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify({
            column: column,
            data: uploadedData
          })
        })
        .then(response => response.json())
        .then(data => {
          document.getElementById('generateBtnText').classList.remove('hidden');
          document.getElementById('generateBtnLoader').classList.add('hidden');
          document.getElementById('generateBtn').disabled = false;

          if (data.success) {
            renderPieChart(data.labels, data.values);
            document.getElementById('emptyState').classList.add('hidden');
            document.getElementById('chartContainer').classList.remove('hidden');
          } else {
            showToast(data.error || 'Gagal membuat pie chart');
          }
        })
        .catch(() => showToast('Gagal membuat pie chart'));
    }

    function renderPieChart(labels, values) {
      const options = {
        series: values,
        labels: labels,
        chart: {
          type: 'pie',
          height: 400
        },
        legend: {
          position: 'right'
        },
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 300
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
      };
      if (currentChart) currentChart.destroy();
      currentChart = new ApexCharts(document.querySelector("#piechart"), options);
      currentChart.render();
    }

    function showToast(message) {
      const toast = document.getElementById('toast');
      const toastMessage = document.getElementById('toastMessage');
      toastMessage.textContent = message;
      toast.classList.remove('hidden');
      setTimeout(() => toast.classList.add('hidden'), 4000);
    }

    document.getElementById('downloadChart').addEventListener('click', function() {
      if (currentChart) {
        currentChart.dataURI().then(({
          imgURI
        }) => {
          const link = document.createElement('a');
          link.href = imgURI;
          link.download = 'pie_chart.png';
          link.click();
        });
      }
    });

    function hideToast() {
      document.getElementById('toast').classList.add('hidden');
    }
  </script>
</x-layout-web>
