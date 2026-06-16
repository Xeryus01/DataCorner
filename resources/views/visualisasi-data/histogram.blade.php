<x-layout-web>
  <div class="min-h-screen bg-[#EEF0F2]">
    <!-- Header -->
    <div class="bg-blue-900 text-white py-8">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold">Histogram</h1>
        <p class="mt-2 text-blue-100">Ubah data numerik Anda menjadi histogram untuk melihat distribusi frekuensi dan
          pola data secara visual.</p>
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
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Pilih File Data
              </label>
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
                  <p class="text-sm text-gray-600">
                    <span class="font-medium text-primary">Klik untuk upload</span> atau drag & drop
                  </p>
                  <p class="text-xs text-gray-500 mt-1">CSV, XLSX, XLS (Max 2MB)</p>
                </label>
              </div>
              <div id="fileInfo" class="mt-2 text-sm text-gray-600 hidden"></div>
            </div>

            <!-- Column Selection -->
            <div id="columnSelection" class="mb-6 hidden">
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Pilih Kolom
              </label>
              <select id="columnSelect"
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Pilih kolom untuk histogram...</option>
              </select>
            </div>

            <!-- Histogram Settings -->
            <div id="histogramSettings" class="mb-6 hidden">
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Jumlah Data Sumbu-X
              </label>
              <input type="number" id="binsInput" value="10" min="5" max="50"
                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
              <p class="text-xs text-gray-500 mt-1">Rentang: 5-50 bins</p>
            </div>

            <!-- Generate Button -->
            <button id="generateBtn"
              class="w-full bg-primary text-white py-3 px-4 rounded-lg hover:bg-[#00295A] transition-colors disabled:opacity-50 disabled:cursor-not-allowed hidden">
              <span id="generateBtnText">Generate Histogram</span>
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
                <h2 class="text-xl font-semibold text-gray-900">Histogram</h2>
                <button id="downloadChart"
                  class="bg-button text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                  Download Chart
                </button>
              </div>
              <div id="histogram-chart" style="height: 400px;"></div>
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="text-center py-12">
              <div class="text-gray-400 mb-4">
                <svg class="mx-auto h-16 w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                  </path>
                </svg>
              </div>
              <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada data</h3>
              <p class="text-gray-500">Upload file data terlebih dahulu untuk membuat histogram</p>
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
      const binsInput = document.getElementById('binsInput');

      // File upload handler
      fileInput.addEventListener('change', handleFileUpload);

      // Generate button handler
      generateBtn.addEventListener('click', generateHistogram);

      // Bins input change handler
      binsInput.addEventListener('input', function() {
        if (uploadedData.length > 0 && columnSelect.value) {
          generateHistogram();
        }
      });

      // Column selection change handler
      columnSelect.addEventListener('change', function() {
        if (this.value && uploadedData.length > 0) {
          generateHistogram();
        }
      });
    });

    function handleFileUpload(event) {
      const file = event.target.files[0];
      if (!file) return;

      const formData = new FormData();
      formData.append('data_file', file);

      // Show loading state
      showLoading();

      fetch('{{ route('visualisasi.histogram.upload') }}', {
          method: 'POST',
          body: formData,
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
        })
        .then(response => response.json())
        .then(data => {
          hideLoading();

          if (data.success) {
            uploadedData = data.data;
            populateColumnSelect(data.columns, data.numericColumns, data.columnTypes);
            showDataPreview(data.data.slice(0, 5)); // Show first 5 rows
            document.getElementById('fileInfo').innerHTML =
              `File uploaded: ${file.name} (${data.numericColumns ? data.numericColumns.length : 0} numeric columns detected)`;
            document.getElementById('fileInfo').classList.remove('hidden');
            document.getElementById('columnSelection').classList.remove('hidden');
            document.getElementById('histogramSettings').classList.remove('hidden');
            document.getElementById('generateBtn').classList.remove('hidden');
            document.getElementById('dataPreview').classList.remove('hidden');
          } else {
            showToast(data.error || 'File tidak sesuai format', 'error');
          }
        })
        .catch(error => {
          hideLoading();
          showToast('Error uploading file', 'error');
          console.error('Error:', error);
        });
    }

    function populateColumnSelect(columns, numericColumns = null, columnTypes = null) {
      const select = document.getElementById('columnSelect');
      select.innerHTML = '<option value="">Pilih kolom untuk histogram...</option>';

      // If we have numeric column information, prioritize those
      if (numericColumns && numericColumns.length > 0) {
        // Add numeric columns first
        const numericGroup = document.createElement('optgroup');
        numericGroup.label = 'Numeric Columns (Recommended)';

        numericColumns.forEach(column => {
          const option = document.createElement('option');
          option.value = column;
          option.textContent = column + ' (numeric)';
          numericGroup.appendChild(option);
        });
        select.appendChild(numericGroup);

        // Add other columns
        const otherColumns = columns.filter(col => !numericColumns.includes(col));
        if (otherColumns.length > 0) {
          const otherGroup = document.createElement('optgroup');
          otherGroup.label = 'Other Columns';

          otherColumns.forEach(column => {
            const option = document.createElement('option');
            option.value = column;
            option.textContent = column + ' (' + (columnTypes[column] || 'text') + ')';
            otherGroup.appendChild(option);
          });
          select.appendChild(otherGroup);
        }
      } else {
        // Fallback to all columns
        columns.forEach(column => {
          const option = document.createElement('option');
          option.value = column;
          option.textContent = column;
          select.appendChild(option);
        });
      }
    }

    function showDataPreview(data) {
      if (data.length === 0) return;

      const headers = Object.keys(data[0]);
      const headerRow = document.getElementById('previewHeader');
      const tbody = document.getElementById('previewBody');

      // Clear existing content
      headerRow.innerHTML = '';
      tbody.innerHTML = '';

      // Add headers
      headers.forEach(header => {
        const th = document.createElement('th');
        th.className = 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider';
        th.textContent = header;
        headerRow.appendChild(th);
      });

      // Add data rows
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

    function generateHistogram() {
      const column = document.getElementById('columnSelect').value;
      const bins = document.getElementById('binsInput').value;

      if (!column || uploadedData.length === 0) {
        showToast('Please select a column first', 'error');
        return;
      }

      // Show loading state
      showGenerateLoading();

      fetch('{{ route('visualisasi.histogram.generate') }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify({
            column: column,
            data: uploadedData,
            bins: parseInt(bins)
          })
        })
        .then(response => response.json())
        .then(data => {
          hideGenerateLoading();

          if (data.success) {
            renderHistogram(data.histogram, column);
            document.getElementById('emptyState').classList.add('hidden');
            document.getElementById('chartContainer').classList.remove('hidden');
          } else {
            showToast(data.error || 'Error generating histogram', 'error');
            console.log('Error details:', data);

            // Show debug information
            if (data.error && data.error.includes('Found data types:')) {
              console.log('Column data analysis:', data.error);
            }
          }
        })
        .catch(error => {
          hideGenerateLoading();
          showToast('Error generating histogram', 'error');
          console.error('Error:', error);
        });
    }

    function renderHistogram(histogramData, columnName) {
      const options = {
        series: [{
          name: 'Frequency',
          data: histogramData.map(item => ({
            x: item.range,
            y: item.y
          }))
        }],
        chart: {
          type: 'bar',
          height: 400,
          toolbar: {
            show: true,
            tools: {
              download: true,
              selection: true,
              zoom: true,
              zoomin: true,
              zoomout: true,
              pan: true,
              reset: true
            }
          }
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '90%',
            borderRadius: 2
          }
        },
        colors: ['#3B82F6'],
        dataLabels: {
          enabled: false
        },
        stroke: {
          show: true,
          width: 1,
          colors: ['#1E40AF']
        },
        xaxis: {
          title: {
            text: columnName
          },
          labels: {
            rotate: -45
          }
        },
        yaxis: {
          title: {
            text: 'Frequency'
          }
        },
        title: {
          text: `Histogram of ${columnName}`,
          align: 'center',
          style: {
            fontSize: '16px',
            fontWeight: 'bold'
          }
        },
        tooltip: {
          y: {
            formatter: function(val) {
              return val + " data points"
            }
          }
        },
        grid: {
          show: true,
          borderColor: ['#008FFB'],
          strokeDashArray: 3
        }
      };

      // Destroy existing chart if it exists
      if (currentChart) {
        currentChart.destroy();
      }

      currentChart = new ApexCharts(document.querySelector("#histogram-chart"), options);
      currentChart.render();
    }

    function showLoading() {
      // Add loading state UI
    }

    function hideLoading() {
      // Remove loading state UI
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

    function showToast(message, type = 'error') {
      const toast = document.getElementById('toast');
      const toastMessage = document.getElementById('toastMessage');

      toastMessage.textContent = message;

      if (type === 'success') {
        toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
      } else {
        toast.className = 'fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
      }

      toast.classList.remove('hidden');

      setTimeout(() => {
        hideToast();
      }, 5000);
    }

    function hideToast() {
      document.getElementById('toast').classList.add('hidden');
    }

    // Download chart functionality
    document.getElementById('downloadChart').addEventListener('click', function() {
      if (currentChart) {
        currentChart.dataURI().then(({
          imgURI,
          blob
        }) => {
          const link = document.createElement('a');
          link.href = imgURI;
          link.download = 'histogram.png';
          link.click();
        });
      }
    });
  </script>
</x-layout-web>
