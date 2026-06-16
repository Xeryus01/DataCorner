# Dashboard QA Checklist

- [ ] Responsif: Periksa pada 320px / 375px / 768px / 1024px / 1440px
- [ ] Keyboard: Tab melalui semua kartu, tombol, dan form; pastikan fokus jelas
- [ ] Screen reader: Pastikan `aria-label` atau teks tersedia untuk semua tindakan penting
- [ ] Performance: Halaman harus memuat tanpa memblokir UI (cek Lighthouse)
- [ ] Animasi: Matikan jika `prefers-reduced-motion` diaktifkan
- [ ] Chart: Jika tidak ada data, tampilkan pesan informatif
- [ ] Link eksternal: memiliki `rel="noopener noreferrer"` dan `target="_blank"`
- [ ] Form: Validasi server ditampilkan, input fokus pada error
- [ ] Aset: Pastikan bundle Vite terbaru tersedia di `public/build`
- [ ] Accessibility: kontras warna minimal 4.5:1 untuk teks normal
