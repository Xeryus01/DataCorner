import Chart from 'chart.js/auto';

function prefersReducedMotion() {
  try {
    return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  } catch (e) {
    return false;
  }
}

function easeOutQuart(t) {
  return 1 - (--t) * t * t * t;
}

function animateCounterEased(element, target, duration = 1200) {
  if (prefersReducedMotion()) {
    element.textContent = target;
    return;
  }

  const start = 0;
  const startTime = performance.now();

  function updateCounter(now) {
    const elapsed = now - startTime;
    const progress = Math.min(elapsed / duration, 1);
    const eased = easeOutQuart(progress);
    const current = Math.floor(start + (target - start) * eased);
    element.textContent = current;

    if (progress < 1) requestAnimationFrame(updateCounter);
    else element.textContent = target;
  }

  requestAnimationFrame(updateCounter);
}

function initCounters() {
  const counters = document.querySelectorAll('.counter');
  if (!counters.length) return;

  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      const el = entry.target;
      const target = parseInt(el.getAttribute('data-target')) || 0;
      animateCounterEased(el, target, 1200);
      observer.unobserve(el);
    });
  }, { threshold: 0.4 });

  counters.forEach((c) => observer.observe(c));
}

function safeParseNumberArray(arr) {
  return Array.isArray(arr) ? arr.map(v => Number(v) || 0) : [];
}

function initChart() {
  const canvas = document.getElementById('grafikKonsultasi');
  if (!canvas || !window.dataKonsultasiBulanan) return;

  const data = window.dataKonsultasiBulanan;
  const totalBulanan = safeParseNumberArray(data.totalBulanan || []);
  const totalKeseluruhan = totalBulanan.reduce((s, v) => s + v, 0);

  const noDataMessage = document.getElementById('no-data-message');
  const totalElement = document.getElementById('totalKonsultasi');
  const bulanTertinggiElement = document.getElementById('bulanTertinggi');

  if (totalKeseluruhan === 0) {
    if (canvas) canvas.style.display = 'none';
    if (noDataMessage) noDataMessage.classList.remove('hidden');
    if (totalElement) totalElement.textContent = '0';
    if (bulanTertinggiElement) bulanTertinggiElement.textContent = '-';
    return;
  }

  // build chart
  /* eslint-disable no-new */
  new Chart(canvas, {
    type: 'bar',
    data: {
      labels: data.labels || [],
      datasets: data.datasets || []
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        x: { stacked: true },
        y: { stacked: true, beginAtZero: true, ticks: { precision: 0 } }
      },
      plugins: {
        legend: { position: 'bottom' },
        tooltip: {
          callbacks: {
            label(ctx) { return `${ctx.dataset.label}: ${ctx.raw} konsultasi`; },
            afterBody(ctx) {
              const idx = ctx[0].dataIndex;
              const total = totalBulanan[idx] || 0;
              return `Total bulan ini: ${total}`;
            }
          }
        }
      }
    }
  });

  if (totalElement) totalElement.textContent = totalKeseluruhan;

  const maxTotal = Math.max(...totalBulanan);
  const maxIndex = totalBulanan.indexOf(maxTotal);
  if (bulanTertinggiElement && maxIndex !== -1) {
    bulanTertinggiElement.textContent = `${(data.labels || [])[maxIndex]} (${maxTotal})`;
  }
}

document.addEventListener('DOMContentLoaded', () => {
  initCounters();
  initChart();
});

export {};
