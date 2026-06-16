<x-layout-web>
  <div class="min-h-screen bg-[#EEF0F2]">
    <!-- Header -->
    <div class="bg-blue-900 text-white py-8">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold">Scatter Plot</h1>
        <p class="mt-2 text-blue-100">Buat scatter plot untuk memvisualisasikan hubungan dan korelasi antara dua set data
          numerik.</p>
      </div>
    </div>

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
              <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Kolom X</label>
              <select id="xColumnSelect" class="w-full p-3 border rounded-lg">
                <option value="">Pilih kolom X...</option>
              </select>

              <label class="block text-sm font-medium text-gray-700 mt-4 mb-2">Pilih Kolom Y</label>
              <select id="yColumnSelect" class="w-full p-3 border rounded-lg">
                <option value="">Pilih kolom Y...</option>
              </select>
            </div>

            <!-- Generate Button -->
            <button id="generateBtn"
              class="w-full bg-primary text-white py-3 px-4 rounded-lg hover:bg-[#00295A] transition-colors disabled:opacity-50 hidden">
              <span id="generateBtnText">Generate Scatter Plot</span>
              <div id="generateBtnLoader" class="hidden">
                <svg class="animate-spin h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none"
                  viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                    stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5 0 0 5 0 12h4zm2 5a7.962 7.962 0 01-2-5H0c0 3 1 6 3 8l3-3z"></path>
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
                <h2 class="text-xl font-semibold text-gray-900">Scatter Plot</h2>
                <button id="downloadChart"
                  class="bg-button text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                  Download Chart
                </button>
              </div>
              <div id="scatter-chart" style="height: 400px;"></div>
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="text-center py-12">
              <div class="mb-4">
                <svg width="64" height="64" viewBox="0 0 64 64" fill="none" class="mx-auto h-16 w-16"
                  xmlns="http://www.w3.org/2000/svg">
                  <rect width="64" height="64" fill="none" />
                  <circle cx="12" cy="52" r="4" fill="gray" />
                  <circle cx="20" cy="34" r="3" fill="gray" />
                  <circle cx="32" cy="44" r="5" fill="gray" />
                  <circle cx="44" cy="24" r="4" fill="gray" />
                  <circle cx="52" cy="12" r="3" fill="gray" />
                  <circle cx="36" cy="16" r="2" fill="gray" />
                </svg>
              </div>
              <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada data</h3>
              <p class="text-gray-500">Upload file data terlebih dahulu untuk membuat scatter plot</p>
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

      fileInput.addEventListener('change', handleFileUpload);
      generateBtn.addEventListener('click', generateScatterPlot);
    });

    function handleFileUpload(event) {
      const file = event.target.files[0];
      if (!file) return;

      const formData = new FormData();
      formData.append('data_file', file);

      fetch('{{ route('visualisasi.scatter.upload') }}', {
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
            populateSelects(data.numericColumns);
            showDataPreview(data.data.slice(0, 5));
            document.getElementById('fileInfo').innerHTML = `File uploaded: ${file.name}`;
            document.getElementById('fileInfo').classList.remove('hidden');
            document.getElementById('columnSelection').classList.remove('hidden');
            document.getElementById('generateBtn').classList.remove('hidden');
            document.getElementById('dataPreview').classList.remove('hidden');
          } else {
            showToast(data.error || 'File tidak sesuai format', 'error');
          }
        })
        .catch(() => showToast('Upload error'));
    }

    function populateSelects(columns) {
      const xSelect = document.getElementById('xColumnSelect');
      const ySelect = document.getElementById('yColumnSelect');
      xSelect.innerHTML = '<option value="">Pilih kolom X...</option>';
      ySelect.innerHTML = '<option value="">Pilih kolom Y...</option>';
      columns.forEach(col => {
        const optX = document.createElement('option');
        optX.value = col;
        optX.textContent = col;
        xSelect.appendChild(optX);

        const optY = optX.cloneNode(true);
        ySelect.appendChild(optY);
      });
    }

    function generateScatterPlot() {
      const xCol = document.getElementById('xColumnSelect').value;
      const yCol = document.getElementById('yColumnSelect').value;

      if (!xCol || !yCol || uploadedData.length === 0) {
        showToast('Pilih kolom X dan Y terlebih dahulu');
        return;
      }

      showGenerateLoading();

      fetch('{{ route('visualisasi.scatter.generate') }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify({
            x_column: xCol,
            y_column: yCol,
            data: uploadedData
          })
        })
        .then(response => response.json())
        .then(data => {
          hideGenerateLoading();
          if (data.success) {
            renderScatterChart(data.points, xCol, yCol);
            document.getElementById('emptyState').classList.add('hidden');
            document.getElementById('chartContainer').classList.remove('hidden');
          } else {
            showToast(data.error || 'Gagal membuat scatter plot');
          }
        })
        .catch(() => {
          hideGenerateLoading();
          showToast('Error scatter plot');
        });
    }

    function renderScatterChart(points, xLabel, yLabel) {
      if (currentChart) currentChart.destroy();

      currentChart = new ApexCharts(document.querySelector("#scatter-chart"), {
        chart: {
          type: 'scatter',
          height: 400,
          zoom: {
            enabled: true
          }
        },
        series: [{
          name: 'Data',
          data: points
        }],
        xaxis: {
          title: {
            text: xLabel
          }
        },
        yaxis: {
          title: {
            text: yLabel
          }
        },
        colors: ['#3B82F6']
      });

      currentChart.render();
    }

    function showDataPreview(data) {
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
          td.textContent = row[header] ?? '-';
          tr.appendChild(td);
        });
        tbody.appendChild(tr);
      });
    }

    function showGenerateLoading() {
      document.getElementById('generateBtnText').classList.add('hidden');
      document.getElementById('generateBtnLoader').classList.remove('hidden');
      document.getElementById('generateBtn').disabled = true;
    }

    function hideGenerateLoading() {
      document.getElementById('generateBtnText').classList.remove('hidden');
      document.getElementById('generateBtnLoader').classList.add('hidden');
      document.getElementById('generateBtn').disabled = false;
    }

    function showToast(message) {
      const toast = document.getElementById('toast');
      document.getElementById('toastMessage').textContent = message;
      toast.classList.remove('hidden');
      setTimeout(() => toast.classList.add('hidden'), 5000);
    }

    document.getElementById('downloadChart').addEventListener('click', function() {
      if (currentChart) {
        currentChart.dataURI().then(({
          imgURI
        }) => {
          const link = document.createElement('a');
          link.href = imgURI;
          link.download = 'scatter-plot.png';
          link.click();
        });
      }
    });
  </script>
</x-layout-web>
