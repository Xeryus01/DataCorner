/* user-page-animated.js */
(function () {
    'use strict';

    const easeOutQuart = (t) => 1 - Math.pow(1 - t, 4);

    function initScrollProgress() {
        const progress = document.getElementById('scrollProgress');
        if (!progress) return;

        const update = () => {
            const scrollTop = window.scrollY || document.documentElement.scrollTop;
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            const percent = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
            progress.style.width = `${Math.min(100, Math.max(0, percent))}%`;
        };

        update();
        window.addEventListener('scroll', update, { passive: true });
        window.addEventListener('resize', update);
    }

    function initSectionReveal() {
        const sections = document.querySelectorAll('.scroll-section');
        if (!sections.length) return;

        const sectionObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) entry.target.classList.add('section-visible');
            });
        }, {
            threshold: 0.12,
            rootMargin: '0px 0px -8% 0px'
        });

        const activeObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                entry.target.classList.toggle('section-active', entry.isIntersecting);
            });
        }, { threshold: 0.45 });

        sections.forEach((section) => {
            sectionObserver.observe(section);
            activeObserver.observe(section);
        });
    }

    function initElementReveal() {
        const selectors = [
            '.scroll-animate',
            '.layanan-utama-card',
            '.konsultasi-card',
            '.petugas-card',
            '.petugas-today-card',
            '.layanan-item',
            '.faq-item',
            '.chart-card'
        ];

        const elements = Array.from(document.querySelectorAll(selectors.join(',')));
        if (!elements.length) return;

        const groups = new Map();
        elements.forEach((element) => {
            const parent = element.parentElement;
            if (!parent) return;
            if (!groups.has(parent)) groups.set(parent, []);
            groups.get(parent).push(element);
        });

        groups.forEach((items) => {
            items.forEach((item, index) => {
                if (!item.style.getPropertyValue('--scroll-delay')) {
                    item.style.setProperty('--scroll-delay', `${Math.min(index * 90, 450)}ms`);
                }
            });
        });

        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-visible');
                revealObserver.unobserve(entry.target);
            });
        }, {
            threshold: 0.16,
            rootMargin: '0px 0px -6% 0px'
        });

        elements.forEach((element) => revealObserver.observe(element));
    }

    function animateNumber(element, target, duration = 1800) {
        const start = performance.now();
        const numericTarget = Number(String(target).replace(/[^0-9]/g, '')) || 0;

        function tick(now) {
            const elapsed = now - start;
            const progress = Math.min(elapsed / duration, 1);
            const current = Math.round(easeOutQuart(progress) * numericTarget);
            element.textContent = current.toLocaleString('id-ID');
            if (progress < 1) requestAnimationFrame(tick);
        }

        requestAnimationFrame(tick);
    }

    function initCounterAnimation() {
        const counters = document.querySelectorAll('.stat-number[data-target]');
        if (!counters.length) return;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;

                const counter = entry.target;
                if (counter.dataset.counted === 'true') return;

                counter.dataset.counted = 'true';
                animateNumber(counter, counter.dataset.target || '0');

                const card = counter.closest('.stat-counter-card');
                if (card) card.classList.add('counted');

                observer.unobserve(counter);
            });
        }, { threshold: 0.45 });

        counters.forEach((counter) => observer.observe(counter));
    }

    function initLayananPagination() {
        const layananItems = Array.from(document.querySelectorAll('.layanan-item'));
        const paginationContainer = document.getElementById('layanan-pagination');
        if (!layananItems.length || !paginationContainer) return;

        const layananPerPage = 6;
        let currentPage = 1;

        function showPage(page) {
            const startIndex = (page - 1) * layananPerPage;
            const endIndex = startIndex + layananPerPage;

            layananItems.forEach((item, index) => {
                const visible = index >= startIndex && index < endIndex;
                item.style.display = visible ? 'block' : 'none';
                if (visible) {
                    item.classList.remove('is-visible');
                    setTimeout(() => item.classList.add('is-visible'), 40 + ((index - startIndex) * 70));
                }
            });
        }

        function renderPagination() {
            const totalPages = Math.ceil(layananItems.length / layananPerPage);
            if (totalPages <= 1) return;

            paginationContainer.innerHTML = '';
            for (let i = 1; i <= totalPages; i += 1) {
                const button = document.createElement('button');
                button.type = 'button';
                button.textContent = i;
                button.className = i === currentPage
                    ? 'px-4 py-2 mx-1 rounded-xl font-medium transition-all duration-300 bg-[#002B6A] text-white shadow-lg shadow-blue-900/20'
                    : 'px-4 py-2 mx-1 rounded-xl font-medium transition-all duration-300 bg-white text-[#002B6A] border border-[#002B6A]/20 hover:bg-[#002B6A] hover:text-white hover:shadow-lg';
                button.addEventListener('click', () => {
                    currentPage = i;
                    showPage(currentPage);
                    renderPagination();
                });
                paginationContainer.appendChild(button);
            }
        }

        showPage(currentPage);
        renderPagination();
    }

    function initFaqPagination() {
        const faqItems = Array.from(document.querySelectorAll('.faq-item'));
        const paginationContainer = document.getElementById('faq-pagination');
        if (!faqItems.length || !paginationContainer) return;

        const faqPerPage = 5;
        let currentPage = 1;

        function showPage(page) {
            const startIndex = (page - 1) * faqPerPage;
            const endIndex = startIndex + faqPerPage;

            faqItems.forEach((item, index) => {
                const visible = index >= startIndex && index < endIndex;
                item.style.display = visible ? 'block' : 'none';
                if (visible) {
                    item.classList.remove('is-visible');
                    setTimeout(() => item.classList.add('is-visible'), 40 + ((index - startIndex) * 70));
                }
            });
        }

        function renderPagination() {
            const totalPages = Math.ceil(faqItems.length / faqPerPage);
            if (totalPages <= 1) return;

            paginationContainer.innerHTML = '';
            for (let i = 1; i <= totalPages; i += 1) {
                const button = document.createElement('button');
                button.type = 'button';
                button.textContent = i;
                button.className = i === currentPage
                    ? 'px-4 py-2 mx-1 rounded-xl font-medium transition-all duration-300 bg-white text-[#002B6A] shadow-lg'
                    : 'px-4 py-2 mx-1 rounded-xl font-medium transition-all duration-300 bg-transparent text-white border border-white/30 hover:bg-white hover:text-[#002B6A]';
                button.addEventListener('click', () => {
                    currentPage = i;
                    showPage(currentPage);
                    renderPagination();
                });
                paginationContainer.appendChild(button);
            }
        }

        showPage(currentPage);
        renderPagination();
    }

    function initPetugasCarousel() {
        const wrapper = document.getElementById('carouselWrapper');
        const prevButton = document.getElementById('prevBtn');
        const nextButton = document.getElementById('nextBtn');
        const dotsContainer = document.getElementById('dotsContainer');
        if (!wrapper || !prevButton || !nextButton) return;

        const slides = Array.from(wrapper.querySelectorAll('.carousel-slide'));
        const realSlides = slides.filter((slide) => !slide.classList.contains('duplicate-slide'));
        if (!realSlides.length) return;

        let currentIndex = 0;
        let autoPlay;

        function updateCarousel(animate = true) {
            wrapper.style.transition = animate ? 'transform 500ms ease-in-out' : 'none';
            wrapper.style.transform = `translateX(-${currentIndex * 100}%)`;

            if (dotsContainer) {
                Array.from(dotsContainer.children).forEach((dot, index) => {
                    dot.className = index === currentIndex % realSlides.length
                        ? 'w-8 h-2 rounded-full bg-white transition-all duration-300'
                        : 'w-2 h-2 rounded-full bg-white/30 hover:bg-white/60 transition-all duration-300';
                });
            }
        }

        function goNext() {
            currentIndex += 1;
            updateCarousel(true);

            if (currentIndex === realSlides.length && slides.length > realSlides.length) {
                setTimeout(() => {
                    currentIndex = 0;
                    updateCarousel(false);
                }, 520);
            } else if (currentIndex >= realSlides.length) {
                currentIndex = 0;
                updateCarousel(true);
            }
        }

        function goPrev() {
            currentIndex = currentIndex === 0 ? realSlides.length - 1 : currentIndex - 1;
            updateCarousel(true);
        }

        function startAutoPlay() {
            stopAutoPlay();
            autoPlay = setInterval(goNext, 6000);
        }

        function stopAutoPlay() {
            if (autoPlay) clearInterval(autoPlay);
        }

        if (dotsContainer) {
            dotsContainer.innerHTML = '';
            realSlides.forEach((_, index) => {
                const dot = document.createElement('button');
                dot.type = 'button';
                dot.setAttribute('aria-label', `Slide ${index + 1}`);
                dot.addEventListener('click', () => {
                    currentIndex = index;
                    updateCarousel(true);
                    startAutoPlay();
                });
                dotsContainer.appendChild(dot);
            });
        }

        prevButton.addEventListener('click', () => { goPrev(); startAutoPlay(); });
        nextButton.addEventListener('click', () => { goNext(); startAutoPlay(); });
        wrapper.addEventListener('mouseenter', stopAutoPlay);
        wrapper.addEventListener('mouseleave', startAutoPlay);

        updateCarousel(false);
        startAutoPlay();
    }

    function initGenericCarousel(containerId) {
        const container = document.getElementById(containerId);
        if (!container) return;

        const wrapper = container.querySelector('.carousel-wrapper');
        const items = Array.from(container.querySelectorAll('.carousel-item'));
        const prev = container.querySelector('[data-action="prev"]');
        const next = container.querySelector('[data-action="next"]');
        if (!wrapper || !items.length || !prev || !next) return;

        let index = 0;

        function itemsPerView() {
            if (window.innerWidth >= 768) return 3;
            if (window.innerWidth >= 640) return 2;
            return 1;
        }

        function update() {
            const perView = itemsPerView();
            const maxIndex = Math.max(0, items.length - perView);
            index = Math.min(index, maxIndex);
            const itemWidth = 100 / perView;
            wrapper.style.transform = `translateX(-${index * itemWidth}%)`;
        }

        prev.addEventListener('click', () => {
            index = Math.max(0, index - 1);
            update();
        });

        next.addEventListener('click', () => {
            index = Math.min(Math.max(0, items.length - itemsPerView()), index + 1);
            update();
        });

        window.addEventListener('resize', update);
        update();
    }

    function initChatbotToggle() {
        const toggleBtn = document.getElementById('chatbot-toggle');
        const chatbotBox = document.getElementById('chatbot-container');
        if (!toggleBtn || !chatbotBox) return;

        toggleBtn.addEventListener('click', () => {
            chatbotBox.style.display = chatbotBox.style.display === 'none' ? 'block' : 'none';
        });
    }

    function initFilterLoadingHelper() {
        if (typeof window.showLoadingAndSubmit === 'function') return;

        window.showLoadingAndSubmit = function showLoadingAndSubmit(form) {
            const spinner = document.getElementById('loadingSpinner');
            if (spinner) spinner.style.display = 'flex';
            if (form && typeof form.submit === 'function') form.submit();
        };
    }

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

    document.addEventListener('DOMContentLoaded', () => {
        initScrollProgress();
        initSectionReveal();
        initElementReveal();
        initCounterAnimation();
        initLayananPagination();
        initFaqPagination();
        initPetugasCarousel();
        initGenericCarousel('maklumatCarousel');
        initGenericCarousel('standarLayananCarousel');
        initChatbotToggle();
        initFilterLoadingHelper();
        initChart();
    });
})();
