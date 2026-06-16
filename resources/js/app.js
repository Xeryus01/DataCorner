import './bootstrap';

const rawBaseUrl = window.APP_BASE_URL || document.querySelector('meta[name="app-base-url"]')?.content || '';
const APP_BASE_URL = rawBaseUrl.replace(/\/$/, '');


// ==========================
// GLOBAL INIT
// ==========================
document.addEventListener('DOMContentLoaded', () => {
    initNavbar();
    initSmoothScroll();
    //initChart();
    initCarouselUtama();
    initCarouselGeneric();
    initPetugas();
    initPaginationLayanan();
    initAOS();
    // Load admin dashboard assets only on dashboard page
    try {
        if (document.getElementById('dashboard-cards')) {
            import('./admin/dashboard.js');
            import('../css/admin/dashboard.css');
        }
    } catch (e) {
        // ignore dynamic import errors
        console.warn('Failed to load admin dashboard assets', e);
    }
    // Load forms validation when any form needs client-side validation
    try {
        if (document.querySelector('form.needs-validation')) {
            import('./admin/forms.js');
        }
    } catch (e) {
        console.warn('Failed to load forms validation', e);
    }
});

// ==========================
// NAVBAR
// ==========================
function initNavbar() {
    const navbar = document.getElementById('navbar');

    window.addEventListener('scroll', () => {
        navbar?.classList.toggle('navbar-scrolled', window.scrollY > 50);
    });

    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    const icon = btn?.querySelector('svg path');

    if (!btn || !menu || !icon) return;

    btn.addEventListener('click', function (e) {
        e.stopPropagation();
        const isOpen = menu.classList.toggle('open');
        btn.setAttribute('aria-expanded', String(isOpen));
        console.log('[initNavbar] btn click, isOpen=', isOpen);

        if (isOpen) {
            icon.setAttribute('d', 'M6 18L18 6M6 6l12 12');
        } else {
            icon.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
        }
    });

    document.addEventListener('click', (e) => {
        if (!menu.contains(e.target) && !btn.contains(e.target) && menu.classList.contains('open')) {
            menu.classList.remove('open');
            btn.setAttribute('aria-expanded', 'false');
            icon.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
            console.log('[initNavbar] closed by outside click');
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && menu.classList.contains('open')) {
            menu.classList.remove('open');
            btn.setAttribute('aria-expanded', 'false');
            icon.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
            btn.focus();
            console.log('[initNavbar] closed by Escape');
        }
    });
}

// ==========================
// SMOOTH SCROLL
// ==========================
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href'))?.scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
}

// ==========================
// CHART (BAR)
// ==========================
// function initChart() {
//     const canvas = document.getElementById('grafikPieKonsultasi');
//     if (!canvas) return;
//     if (typeof Chart === 'undefined') {
//         console.error('Chart.js belum dimuat sebelum initChart() dijalankan.');
//         return;
//     }

//     const dataAttr = canvas.dataset.bulanan;
//     let data = [];

//     if (dataAttr) {
//         try {
//             data = JSON.parse(dataAttr);
//         } catch (error) {
//             console.error('Gagal parse data-bulanan:', error, dataAttr);
//             data = [];
//         }
//     }

//     const total = data.reduce((a, b) => a + b, 0);

//     if (total === 0) {
//         canvas.parentElement.innerHTML = `
//             <div class="no-data-message">
//                 <div>Tidak ada data</div>
//             </div>`;
//         // Update statistik dengan nilai kosong
//         updateStatistics(new Array(12).fill(0));
//         return;
//     }

//     new Chart(canvas.getContext('2d'), {
//         type: 'bar',
//         data: {
//             labels: [
//                 'Januari','Februari','Maret','April','Mei','Juni',
//                 'Juli','Agustus','September','Oktober','November','Desember'
//             ],
//             datasets: [{
//                 label: 'Jumlah Konsultasi',
//                 data: data,
//                 backgroundColor: [
//                     '#667eea','#764ba2','#f093fb','#f5576c',
//                     '#4facfe','#00f2fe','#43e97b','#38f9d7',
//                     '#ffecd2','#fcb69f','#a8edea','#fed6e3'
//                 ],
//                 borderColor: '#fff',
//                 borderWidth: 2
//             }]
//         },
//         options: {
//             responsive: true,
//             plugins: {
//                 legend: {
//                     display: false
//                 },
//                 tooltip: {
//                     callbacks: {
//                         label: function(context) {
//                             return context.raw + ' konsultasi';
//                         }
//                     }
//                 }
//             },
//             scales: {
//                 y: {
//                     beginAtZero: true,
//                     ticks: {
//                         stepSize: 5
//                     }
//                 },
//                 x: {
//                     grid: {
//                         display: false
//                     }
//                 }
//             },
//             animation: {
//                 duration: 1000,
//                 easing: 'easeOutQuart'
//             }
//         }
//     });

//     // Update statistik
//     updateStatistics(data);
// }

// // ==========================
// // UPDATE STATISTICS
// // ==========================
// function updateStatistics(data) {
//     // Hitung total konsultasi
//     const total = data.reduce((a, b) => a + b, 0);
//     const totalElement = document.getElementById('totalKonsultasi');
//     if (totalElement) {
//         totalElement.textContent = total;
//     }

//     // Temukan bulan tertinggi
//     let maxValue = 0;
//     let maxIndex = -1;
//     data.forEach((value, index) => {
//         if (value > maxValue) {
//             maxValue = value;
//             maxIndex = index;
//         }
//     });

//     const bulanNames = [
//         'Januari','Februari','Maret','April','Mei','Juni',
//         'Juli','Agustus','September','Oktober','November','Desember'
//     ];

//     const bulanTertinggiElement = document.getElementById('bulanTertinggi');
//     if (bulanTertinggiElement) {
//         bulanTertinggiElement.textContent = maxIndex >= 0 && maxValue > 0 ? bulanNames[maxIndex] : '-';
//     }
// }

// function initChart() {
//     const canvas = document.getElementById('grafikPieKonsultasi');
//     if (!canvas) return;

//     if (typeof Chart === 'undefined') {
//         console.error('Chart.js belum dimuat');
//         return;
//     }

//     // Ambil data dari blade
//     let data = [];
//     try {
//         data = JSON.parse(canvas.dataset.bulanan);
//     } catch (e) {
//         console.error('Error parsing data:', e);
//         data = [];
//     }

//     const total = data.reduce((a, b) => a + b, 0);

//     // Jika tidak ada data
//     if (total === 0) {
//         canvas.parentElement.innerHTML = `
//             <div class="no-data-message text-center py-10">
//                 <h3 class="text-lg font-semibold text-gray-600">Tidak ada data konsultasi</h3>
//                 <p class="text-sm text-gray-400">Silakan pilih tahun lain</p>
//             </div>
//         `;
//         updateStatistics(new Array(12).fill(0));
//         return;
//     }

//     // 🔥 Cari nilai tertinggi
//     const maxValue = Math.max(...data);

//     // 🔥 Warna dinamis (highlight tertinggi)
//     const backgroundColors = data.map(value =>
//         value === maxValue && value !== 0
//             ? '#f5576c' // merah (highlight)
//             : '#667eea' // biru (normal)
//     );

//     // 🔥 Destroy chart lama (biar tidak double render)
//     if (window.myChart) {
//         window.myChart.destroy();
//     }

//     // 🔥 Inisialisasi chart
//     window.myChart = new Chart(canvas.getContext('2d'), {
//         type: 'bar',
//         data: {
//             labels: [
//                 'Jan','Feb','Mar','Apr','Mei','Jun',
//                 'Jul','Ags','Sep','Okt','Nov','Des'
//             ],
//             datasets: [{
//                 label: 'Jumlah Konsultasi',
//                 data: data,
//                 backgroundColor: backgroundColors,
//                 borderRadius: 10,
//                 barThickness: 25,
//                 hoverBackgroundColor: '#0052b8'
//             }]
//         },
//         options: {
//             responsive: true,
//             maintainAspectRatio: false,

//             plugins: {
//                 legend: {
//                     display: false
//                 },
//                 tooltip: {
//                     backgroundColor: '#1f2937',
//                     titleColor: '#fff',
//                     bodyColor: '#fff',
//                     padding: 10,
//                     cornerRadius: 8,
//                     callbacks: {
//                         label: function(context) {
//                             return context.raw + ' konsultasi';
//                         }
//                     }
//                 }
//             },

//             scales: {
//                 x: {
//                     ticks: {
//                         maxRotation: 0,
//                         minRotation: 0,
//                         color: '#4b5563'
//                     },
//                     grid: {
//                         display: false
//                     }
//                 },
//                 y: {
//                     beginAtZero: true,
//                     ticks: {
//                         stepSize: 1,
//                         color: '#4b5563'
//                     },
//                     grid: {
//                         color: 'rgba(0,0,0,0.05)'
//                     }
//                 }
//             },

//             animation: {
//                 duration: 1000,
//                 easing: 'easeOutQuart'
//             }
//         }
//     });

//     // 🔥 Update statistik
//     updateStatistics(data);
// }


// function updateStatistics(data) {
//     // Total
//     const total = data.reduce((a, b) => a + b, 0);
//     const totalElement = document.getElementById('totalKonsultasi');
//     if (totalElement) {
//         totalElement.textContent = total;
//     }

//     // Cari bulan tertinggi
//     let maxValue = 0;
//     let maxIndex = -1;

//     data.forEach((value, index) => {
//         if (value > maxValue) {
//             maxValue = value;
//             maxIndex = index;
//         }
//     });

//     const bulanNames = [
//         'Januari','Februari','Maret','April','Mei','Juni',
//         'Juli','Agustus','September','Oktober','November','Desember'
//     ];

//     const bulanTertinggiElement = document.getElementById('bulanTertinggi');
//     if (bulanTertinggiElement) {
//         bulanTertinggiElement.textContent =
//             maxIndex >= 0 && maxValue > 0 ? bulanNames[maxIndex] : '-';
//     }
// }


// // 🔥 WAJIB: jalankan saat halaman load
// document.addEventListener('DOMContentLoaded', function () {
//     initChart();
// });

function initChart() {
    const canvas = document.getElementById('grafikPieKonsultasi');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    
    // Ambil data
    let data = JSON.parse(canvas.dataset.bulanan || '[]');

    // 1. BUAT GRADIENT (Ini kunci agar tampilan menarik)
    const chartGradient = ctx.createLinearGradient(0, 0, 0, 200);
    chartGradient.addColorStop(0, '#1e3a8a'); // Biru Tua (Blue 950)
    chartGradient.addColorStop(1, '#3b82f6'); // Biru Cerah (Blue 500)

    const maxValue = Math.max(...data);

    // 2. DESTROY CHART LAMA (Wajib agar tidak tumpang tindih)
    if (window.myChart instanceof Chart) {
        window.myChart.destroy();
    }

    // 3. INCOPORATE MODERN STYLING
    window.myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'],
            datasets: [{
                data: data,
                // Gunakan fungsi map untuk highlight warna tertinggi
                backgroundColor: data.map(v => (v === maxValue && v !== 0) ? '#f43f5e' : chartGradient),
                borderRadius: 8, // Membuat batang membulat
                borderSkipped: false,
                barThickness: 20
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0f172a',
                    cornerRadius: 8,
                    padding: 10
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { weight: 'bold', size: 10 }, color: '#94a3b8' }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9' },
                    ticks: { color: '#94a3b8' }
                }
            }
        }
    });

    updateStatistics(data);
}

function updateStatistics(data) {
    const total = data.reduce((a, b) => a + b, 0);
    const totalElement = document.getElementById('totalKonsultasi');
    if (totalElement) {
        // Animasi angka sederhana
        totalElement.textContent = total.toLocaleString(); 
    }

    let maxValue = 0, maxIndex = -1;
    data.forEach((val, i) => { if (val > maxValue) { maxValue = val; maxIndex = i; } });

    const bulanNames = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    const bElement = document.getElementById('bulanTertinggi');
    if (bElement) {
        bElement.textContent = maxIndex >= 0 && maxValue > 0 ? bulanNames[maxIndex] : 'N/A';
    }
}

// ==========================
// CAROUSEL UTAMA (HERO)
// ==========================
function initCarouselUtama() {
    const wrapper = document.getElementById('carouselWrapper');
    if (!wrapper) return;

    let index = 0;
    const slides = document.querySelectorAll('.carousel-slide');
    const total = slides.length;

    function update() {
        wrapper.style.transform = `translateX(-${index * 100}%)`;
    }

    document.getElementById('nextBtn')?.addEventListener('click', () => {
        index = (index + 1) % total;
        update();
    });

    document.getElementById('prevBtn')?.addEventListener('click', () => {
        index = (index - 1 + total) % total;
        update();
    });

    if (total > 1) {
        setInterval(() => {
            index = (index + 1) % total;
            update();
        }, 4000);
    }
}

// ==========================
// CAROUSEL GENERIC (REUSABLE)
// ==========================
function initCarouselGeneric() {
    function init(id) {
        const container = document.getElementById(id);
        if (!container) return;

        const wrapper = container.querySelector('.carousel-wrapper');
        const items = container.querySelectorAll('.carousel-item');
        const prev = container.querySelector('[data-action="prev"]');
        const next = container.querySelector('[data-action="next"]');

        let index = 0;
        let itemWidth = items[0]?.offsetWidth + 16;

        function update() {
            wrapper.style.transform = `translateX(-${index * itemWidth}px)`;
        }

        next?.addEventListener('click', () => {
            index = (index + 1) % items.length;
            update();
        });

        prev?.addEventListener('click', () => {
            index = (index - 1 + items.length) % items.length;
            update();
        });

        if (items.length > 1) {
            setInterval(() => {
                index = (index + 1) % items.length;
                update();
            }, 5000);
        }
    }

    init('standarLayananCarousel');
    init('maklumatCarousel');
}

// ==========================
// PETUGAS (SLIDER + PAGINATION)
// ==========================
function initPetugas() {
    const wrapper = document.getElementById("mobilePetugasWrapper");
    if (!wrapper) return;

    let index = 0;

    function update() {
        const width = wrapper.children[0].offsetWidth + 16;
        wrapper.style.transform = `translateX(-${index * width}px)`;
    }

    setInterval(() => {
        index = (index + 1) % wrapper.children.length;
        update();
    }, 10000);

    paginatePetugas(1);

    window.addEventListener('resize', update);
}

window.paginatePetugas = function(page) {
    const items = document.querySelectorAll(".petugas-card");
    const perPage = 8;

    items.forEach((item, i) => {
        item.style.display = (i >= (page-1)*perPage && i < page*perPage)
            ? 'block' : 'none';
    });
};

// ==========================
// PAGINATION LAYANAN
// ==========================
function initPaginationLayanan() {
    const items = document.querySelectorAll('.layanan-item');
    const container = document.getElementById('pagination-controls');
    if (!container) return;

    let page = 1;
    const perPage = 6;
    const total = Math.ceil(items.length / perPage);

    function show() {
        items.forEach((el, i) => {
            el.style.display = (i >= (page-1)*perPage && i < page*perPage)
                ? 'block' : 'none';
        });
    }

    function render() {
        container.innerHTML = '';
        for (let i = 1; i <= total; i++) {
            const btn = document.createElement('button');
            btn.innerText = i;
            btn.className = i === page ? 'active' : '';
            btn.onclick = () => {
                page = i;
                show();
                render();
            };
            container.appendChild(btn);
        }
    }

    show();
    render();
}

// ==========================
// SWEET ALERT LOGIN
// ==========================
window.showLoginAlert = function () {
    Swal.fire({
        icon: 'warning',
        title: 'Akses Ditolak',
        text: 'Silakan login terlebih dahulu',
        showCancelButton: true
    }).then(res => {
        if (res.isConfirmed) {
            const loginUrl = APP_BASE_URL ? `${APP_BASE_URL}/loginUser` : '/loginUser';
            window.location.href = loginUrl;
        }
    });
};

// ==========================
// TOAST KONSULTAN
// ==========================
window.showKonsultanInfo = function(nama, posisi, keahlian, no_hp, email, gambar) {
    const el = document.createElement("div");
    el.className = "toast";
    el.innerHTML = `
        <img src="${gambar}" width="50">
        <div>
            <b>${nama}</b>
            <p>${posisi}</p>
        </div>
    `;
    document.body.appendChild(el);

    setTimeout(() => el.remove(), 5000);
};

// ==========================
// AOS
// ==========================
function initAOS() {
    if (typeof AOS !== 'undefined') {
        AOS.init();
    }
}

// ==========================
// AKSESIBILITAS (FONT & CURSOR)
// ==========================
let baseSizes = new Map();

window.adjustFontSize = function(action) {
    document.querySelectorAll('.speak-target').forEach((el, i) => {
        if (!baseSizes.has(i)) {
            baseSizes.set(i, parseFloat(getComputedStyle(el).fontSize));
        }

        let size = parseFloat(el.style.fontSize) || baseSizes.get(i);

        if (action === 'increase') size += 2;
        if (action === 'decrease') size = Math.max(10, size - 2);
        if (action === 'reset') size = baseSizes.get(i);

        el.style.fontSize = size + 'px';
    });
};

window.setCursorSize = function(size) {
    document.body.classList.remove('cursor-medium','cursor-large');

    if (size === 'medium') document.body.classList.add('cursor-medium');
    if (size === 'large') document.body.classList.add('cursor-large');
};

window.resetCursor = function() {
    document.body.classList.remove('cursor-medium','cursor-large');
};