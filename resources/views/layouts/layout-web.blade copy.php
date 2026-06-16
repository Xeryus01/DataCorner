<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <link rel="icon" href="{{ asset('gambar/logo-bps.jpg') }}" type="image/jpg">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" defer></script>
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    .cursor-large,
    .cursor-large * {
      cursor: url('{{ asset('gambar/cursor.png') }}'), auto;
    }

    .cursor-medium,
    .cursor-medium * {
      cursor: url('{{ asset('gambar/cursor-sedang.png') }}'), auto;
    }

    .accessibility-btn {
      transition: all 0.3s ease;
    }

    .accessibility-btn:hover {
      transform: scale(1.1);
    }

    .accessibility-modal {
      transition: all 0.3s ease;
    }

    .accessibility-modal.show {
      opacity: 1;
      visibility: visible;
    }

    .accessibility-modal.hide {
      opacity: 0;
      visibility: hidden;
    }

    /* * {
      border: solid 1px red;
    } */
  </style>

  <title>Pojok Literasi Statistik</title>
</head>

<body class="bg-[#EEF0F2]" id="main-body">
  <div id="accessibilityWrapper">
    <x-navbar />
    {{ $slot }}
  </div>

  <!-- Tombol Aksesibilitas -->
  {{-- <div class="fixed bottom-6 left-6 z-50">
    <button id="accessibilityBtn"
      class="accessibility-btn bg-button text-white p-4 rounded-full shadow-lg hover:bg-[#02a66b]">
      <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
        <path
          d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
      </svg>
    </button>
  </div> --}}

  <!-- Modal Aksesibilitas -->
  {{-- <div id="accessibilityModal" class="accessibility-modal hide fixed top-24 left-20 z-50">
    <div class="bg-zinc-100 rounded-lg p-6 max-w-md w-full mx-4 max-h-[70vh] overflow-y-auto">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">Menu Aksesibilitas</h2>
        <button id="closeModal" class="text-gray-500 hover:text-gray-700">
          <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
            <path
              d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" />
          </svg>
        </button>
      </div>

      <div class="space-y-3">
        <!-- Kursor Besar -->
        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
          <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="text-blue-600">
                <path d="M3 2l17 10-7 2-2 7-8-19z" />
              </svg>


            </div>
            <div>
              <div class="font-medium text-gray-800">Kursor Perbesar</div>
            </div>
          </div>
          <label class="relative inline-flex items-center cursor-pointer">
            <input id="largeCursorToggle" type="checkbox" class="sr-only peer">
            <div
              class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-button rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-button">
            </div>
          </label>
        </div>

        <!-- Kursor Sedang -->
        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
          <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="text-green-600">
                <path d="M4 4l7 16 2-6 6-2z" />
              </svg>


            </div>
            <div>
              <div class="font-medium text-gray-800">Cursor Sedang</div>
            </div>
          </div>
          <label class="relative inline-flex items-center cursor-pointer">
            <input id="mediumCursorToggle" type="checkbox" class="sr-only peer">
            <div
              class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-button rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-button">
            </div>
          </label>
        </div>

        <!-- Font Besar -->
        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
          <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
              <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24" class="text-yellow-600">
                <path d="M4 20h2l1.5-4h9L18 20h2L13 4h-2L4 20zm4.24-6L12 7.66 15.76 14H8.24z" />
              </svg>

            </div>
            <div>
              <div class="font-medium text-gray-800">Font Besar</div>
            </div>
          </div>
          <label class="relative inline-flex items-center cursor-pointer">
            <input id="largeFontToggle" type="checkbox" class="sr-only peer" />
            <div
              class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-button rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-button">
            </div>
          </label>
        </div>

      </div>

      <!-- Reset Button -->
      <div class="mt-6">
        <button id="resetAll" class="w-full bg-primary text-white py-3 px-4 rounded-lg hover:bg-[#00295A]">
          Reset Semua Pengaturan
        </button>
      </div>
    </div>
  </div> --}}

  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script src="https://website-widgets.pages.dev/dist/sienna.min.js" defer></script>
  <script>
    AOS.init();

    let isLargeCursorActive = false;
    let isMediumCursorActive = false;

    const accessibilityBtn = document.getElementById('accessibilityBtn');
    const accessibilityModal = document.getElementById('accessibilityModal');
    const closeModal = document.getElementById('closeModal');
    const largeCursorToggle = document.getElementById('largeCursorToggle');
    const mediumCursorToggle = document.getElementById('mediumCursorToggle');
    const largeFontToggle = document.getElementById('largeFontToggle');
    const resetAll = document.getElementById('resetAll');
    const mainBody = document.getElementById('main-body');

    document.addEventListener('DOMContentLoaded', () => {
      loadSettings();
    });

    accessibilityBtn.addEventListener('click', () => {
      accessibilityModal.classList.remove('hide');
      accessibilityModal.classList.add('show');
    });

    closeModal.addEventListener('click', () => {
      accessibilityModal.classList.remove('show');
      accessibilityModal.classList.add('hide');
    });

    accessibilityModal.addEventListener('click', (e) => {
      if (e.target === accessibilityModal) {
        accessibilityModal.classList.remove('show');
        accessibilityModal.classList.add('hide');
      }
    });

    largeCursorToggle.addEventListener('change', () => {
      if (largeCursorToggle.checked) {
        mediumCursorToggle.checked = false;
        isMediumCursorActive = false;
        isLargeCursorActive = true;
      } else {
        isLargeCursorActive = false;
      }
      applyCursorStyles();
      saveSettings();
    });

    mediumCursorToggle.addEventListener('change', () => {
      if (mediumCursorToggle.checked) {
        largeCursorToggle.checked = false;
        isLargeCursorActive = false;
        isMediumCursorActive = true;
      } else {
        isMediumCursorActive = false;
      }
      applyCursorStyles();
      saveSettings();
    });

    // Font Besar Toggle
    largeFontToggle.addEventListener('change', () => {
      applyFontSize();
      saveSettings();
    });

    resetAll.addEventListener('click', () => {
      isLargeCursorActive = false;
      isMediumCursorActive = false;
      largeCursorToggle.checked = false;
      mediumCursorToggle.checked = false;
      largeFontToggle.checked = false;

      // Hapus cursor class
      mainBody.classList.remove('cursor-large', 'cursor-medium');

      // Reset font ukuran
      const wrapper = document.getElementById('accessibilityWrapper');

      // Reset elemen dengan inline style font-size
      const allResized = wrapper.querySelectorAll('[data-original-font-size]');
      allResized.forEach(el => {
        el.style.fontSize = el.dataset.originalFontSize;
        delete el.dataset.originalFontSize;
      });

      saveSettings();
    });

    function applyCursorStyles() {
      mainBody.classList.remove('cursor-large', 'cursor-medium');
      if (isLargeCursorActive) {
        mainBody.classList.add('cursor-large');
      } else if (isMediumCursorActive) {
        mainBody.classList.add('cursor-medium');
      }
    }

    function applyFontSize() {
      const wrapper = document.getElementById('accessibilityWrapper');

      // Tangani elemen dengan class text-*
      const textElements = wrapper.querySelectorAll('[class*="text-"]');

      textElements.forEach(el => {
        const computedFontSize = window.getComputedStyle(el).fontSize;
        const fontSizeValue = parseFloat(computedFontSize);

        if (largeFontToggle.checked) {
          if (!el.dataset.originalFontSize) {
            // Skip jika font terlalu besar
            if (fontSizeValue >= 32) return;

            el.dataset.originalFontSize = computedFontSize;
            const newSize = Math.min(fontSizeValue * 1.25, 32); // Maksimal 32px
            el.style.fontSize = `${newSize}px`;
          }
        } else {
          if (el.dataset.originalFontSize) {
            el.style.fontSize = el.dataset.originalFontSize;
            delete el.dataset.originalFontSize;
          }
        }
      });

      // Tangani heading yang mungkin tidak punya class text-*
      const headings = wrapper.querySelectorAll('h1, h2, h3, h4, h5, h6');
      headings.forEach(el => {
        const computedFontSize = window.getComputedStyle(el).fontSize;
        const fontSizeValue = parseFloat(computedFontSize);

        if (largeFontToggle.checked) {
          if (!el.dataset.originalFontSize && fontSizeValue < 32) {
            el.dataset.originalFontSize = computedFontSize;
            const newSize = Math.min(fontSizeValue * 1.25, 32);
            el.style.fontSize = `${newSize}px`;
          }
        } else {
          if (el.dataset.originalFontSize) {
            el.style.fontSize = el.dataset.originalFontSize;
            delete el.dataset.originalFontSize;
          }
        }
      });
    }

    function saveSettings() {
      const settings = {
        largeCursor: isLargeCursorActive,
        mediumCursor: isMediumCursorActive,
        fontLarge: largeFontToggle.checked
      };
      localStorage.setItem('studentCornerAccessibility', JSON.stringify(settings));
    }

    function loadSettings() {
      const settings = JSON.parse(localStorage.getItem('studentCornerAccessibility')) || {
        largeCursor: false,
        mediumCursor: false,
        fontLarge: false
      };

      isLargeCursorActive = settings.largeCursor;
      isMediumCursorActive = settings.mediumCursor;
      largeFontToggle.checked = settings.fontLarge;

      applyCursorStyles();
      applyFontSize();
    }
  </script>
  @stack('scripts')
</body>

</html>
