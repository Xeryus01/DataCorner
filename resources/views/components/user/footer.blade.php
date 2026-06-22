@php
    $sectionLabels = [
        'tentang_kami' => 'Tentang Kami',
        'magang' => 'Magang',
        'akademi_statistik' => 'Akademi Statistik',
        'kontak_kami' => 'Kontak Kami',
    ];
    $sectionIcons = [
        'tentang_kami' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        'magang' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m12 0H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V8a2 2 0 00-2-2z"/></svg>',
        'akademi_statistik' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>',
        'kontak_kami' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>',
    ];
@endphp

<!-- Wave Divider -->
<div class="footer-v2-wave">
    <svg viewBox="0 0 1440 80" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,40 C360,80 720,0 1080,40 C1260,60 1380,50 1440,40 L1440,80 L0,80 Z" fill="#001a3d"/>
    </svg>
</div>

<footer class="footer-v2">
    <div class="footer-v2-glow footer-v2-glow-1"></div>
    <div class="footer-v2-glow footer-v2-glow-2"></div>

    <div class="footer-v2-main">
        <div class="footer-v2-container">

            <!-- Top Row: Brand + Dynamic Sections -->
            <div class="footer-v2-grid">

                <!-- Brand Column -->
                <div class="footer-v2-brand">
                    <div class="footer-v2-brand-header">
                        <div class="footer-v2-brand-logo">
                            <svg viewBox="0 0 24 24" fill="white" width="24" height="24">
                                <path d="M3 3h18v2H3V3zm0 4h12v2H3V7zm0 4h18v2H3v-2zm0 4h12v2H3v-2zm0 4h18v2H3v-2z"/>
                            </svg>
                        </div>
                        <div class="footer-v2-brand-text">
                            <h2>DATA<span class="footer-v2-brand-accent">PEDIA</span></h2>
                            <p>BPS Prov. Kepulauan Bangka Belitung</p>
                        </div>
                    </div>

                    <p class="footer-v2-brand-desc">
                        Portal layanan statistik terpadu BPS Provinsi Kepulauan Bangka Belitung.
                        Melayani dengan data yang akurat, transparan, dan dapat diandalkan.
                    </p>

                    <div class="footer-v2-contact">
                        <div class="footer-v2-contact-item">
                            <div class="footer-v2-contact-icon">
                                <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none" stroke="currentColor">
                                    <path d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <span>Komplek Perkantoran Terpadu, Air Itam, Pangkalpinang.</span>
                        </div>
                        <div class="footer-v2-contact-item">
                            <div class="footer-v2-contact-icon">
                                <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none" stroke="currentColor">
                                    <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <span>(0717) 439422</span>
                        </div>
                        <div class="footer-v2-contact-item">
                            <div class="footer-v2-contact-icon">
                                <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none" stroke="currentColor">
                                    <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <span>bps1900@bps.go.id</span>
                        </div>
                    </div>

                    <div class="footer-v2-social-row">
                        <span class="footer-v2-social-label">Ikuti Kami</span>
                        <div class="footer-v2-social-list">
                            <a href="https://www.facebook.com/BPSBangkaBelitung" class="footer-v2-social-item" aria-label="Facebook">
                                <svg viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                            <a href="https://www.instagram.com/bpsbabel/" class="footer-v2-social-item" aria-label="Instagram">
                                <svg viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.668-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                            </a>
                            <a href="https://www.youtube.com/channel/UCxeIxmnf4h2uGDrymxR1d4g" class="footer-v2-social-item" aria-label="YouTube">
                                <svg viewBox="0 0 24 24"><path d="M23.498 6.186a2.974 2.974 0 00-2.094-2.104C19.556 3.586 12 3.586 12 3.586s-7.556 0-9.404.496A2.974 2.974 0 00.502 6.186C0 8.044 0 11.917 0 11.917s0 3.873.502 5.731a2.974 2.974 0 002.094 2.104c1.848.496 9.404.496 9.404.496s7.556 0 9.404-.496a2.974 2.974 0 002.094-2.104C24 15.79 24 11.917 24 11.917s0-3.873-.502-5.731zM9.545 15.568V8.266l6.273 3.651-6.273 3.651z"/></svg>
                            </a>
                            <a href="https://twitter.com/bpsbabel" class="footer-v2-social-item" aria-label="X/Twitter">
                                <svg viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Dynamic Sections Grid -->
                <div class="footer-v2-sections">
                    @if($footerSections->isNotEmpty())
                        @foreach($footerSections as $section => $items)
                            @php
                                $displayTitle = $sectionLabels[$section] ?? ucwords(str_replace('_', ' ', $section));
                                $icon = $sectionIcons[$section] ?? '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>';
                            @endphp
                            <div class="footer-v2-section-card">
                                <div class="footer-v2-section-header">
                                    <div class="footer-v2-section-icon">
                                        {!! $icon !!}
                                    </div>
                                    <h3 class="footer-v2-section-title">{{ $displayTitle }}</h3>
                                </div>
                                <nav class="footer-v2-section-nav">
                                    @foreach($items as $item)
                                        @php
                                            $href = $item->type === 'link' ? $item->url : Storage::url($item->file_path);
                                            $isExternal = $item->open_new_tab || $item->type !== 'link';
                                            $extIcon = $isExternal ? '<svg class="w-3 h-3 ml-1 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>' : '';
                                        @endphp
                                        <a href="{{ $href }}"
                                           class="footer-v2-link"
                                           @if($isExternal) target="_blank" rel="noopener noreferrer" @endif>
                                            <span class="footer-v2-link-dot"></span>
                                            <span class="footer-v2-link-text">{{ $item->title }}</span>
                                            {!! $extIcon !!}
                                        </a>
                                    @endforeach
                                </nav>
                            </div>
                        @endforeach
                    @else
                        <div class="footer-v2-section-card">
                            <div class="footer-v2-section-header">
                                <div class="footer-v2-section-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>
                                </div>
                                <h3 class="footer-v2-section-title">Navigasi</h3>
                            </div>
                            <nav class="footer-v2-section-nav">
                                <span class="footer-v2-link-empty">Belum ada data footer.</span>
                            </nav>
                        </div>
                    @endif
                </div>

            </div>

        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-v2-bottom">
        <div class="footer-v2-container">
            <div class="footer-v2-bottom-inner">
                <p class="footer-v2-copy">
                    <span class="footer-v2-copy-heart">♥</span>
                    &copy; {{ date('Y') }} <strong>BPS Provinsi Kepulauan Bangka Belitung</strong>
                </p>
                <div class="footer-v2-bottom-links">
                    <a href="#" class="footer-v2-bottom-link">Privasi</a>
                    <span class="footer-v2-bottom-sep"></span>
                    <a href="#" class="footer-v2-bottom-link">Ketentuan</a>
                    <span class="footer-v2-bottom-sep"></span>
                    <a href="https://bps.go.id" target="_blank" rel="noopener" class="footer-v2-bottom-link">bps.go.id</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
/* =========================================================
   FOOTER v2 — Modern Redesign
========================================================= */
.footer-v2-wave {
    line-height: 0;
    margin-bottom: -1px;
}
.footer-v2-wave svg {
    display: block;
    width: 100%;
    height: 60px;
}

.footer-v2 {
    position: relative;
    background: linear-gradient(180deg, #001a3d 0%, #00122e 50%, #000d21 100%);
    overflow: hidden;
    color: rgba(255,255,255,0.7);
}
.footer-v2::before {
    content: '';
    position: absolute;
    inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.015'%3E%3Ccircle cx='30' cy='30' r='1'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    pointer-events: none;
}

.footer-v2-glow {
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
    filter: blur(80px);
    opacity: 0.5;
}
.footer-v2-glow-1 {
    width: 400px; height: 400px;
    top: -100px; right: -100px;
    background: radial-gradient(circle, rgba(59,130,246,0.2) 0%, transparent 70%);
}
.footer-v2-glow-2 {
    width: 300px; height: 300px;
    bottom: 100px; left: -100px;
    background: radial-gradient(circle, rgba(139,92,246,0.15) 0%, transparent 70%);
}

.footer-v2-main {
    position: relative;
    z-index: 2;
    padding: 3rem 0 2rem;
}
.footer-v2-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1.5rem;
}

.footer-v2-grid {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 3rem;
    align-items: start;
}

/* Brand Column */
.footer-v2-brand {
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.06);
    border-radius: 1.5rem;
    padding: 1.75rem;
    backdrop-filter: blur(10px);
}
.footer-v2-brand-header {
    display: flex;
    align-items: center;
    gap: 0.875rem;
    margin-bottom: 1rem;
}
.footer-v2-brand-logo {
    width: 44px; height: 44px;
    background: linear-gradient(135deg, #3B82F6, #1D4ED8);
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 24px rgba(59,130,246,0.3);
}
.footer-v2-brand-text h2 {
    font-size: 1.25rem;
    font-weight: 900;
    color: white;
    letter-spacing: -0.02em;
    line-height: 1;
}
.footer-v2-brand-accent {
    color: #60A5FA;
}
.footer-v2-brand-text p {
    font-size: 0.65rem;
    font-weight: 700;
    color: rgba(255,255,255,0.4);
    text-transform: uppercase;
    letter-spacing: 0.08em;
    margin-top: 0.25rem;
}
.footer-v2-brand-desc {
    font-size: 0.8rem;
    line-height: 1.7;
    color: rgba(255,255,255,0.5);
    margin-bottom: 1.25rem;
}

/* Contact */
.footer-v2-contact {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    margin-bottom: 1.25rem;
}
.footer-v2-contact-item {
    display: flex;
    align-items: flex-start;
    gap: 0.625rem;
    font-size: 0.78rem;
    color: rgba(255,255,255,0.6);
    line-height: 1.5;
}
.footer-v2-contact-icon {
    width: 28px; height: 28px;
    min-width: 28px;
    border-radius: 0.5rem;
    background: rgba(96,165,250,0.1);
    color: #60A5FA;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 1px;
}
.footer-v2-contact-icon svg {
    width: 14px; height: 14px;
}

/* Social */
.footer-v2-social-row {
    display: flex;
    align-items: center;
    gap: 0.875rem;
    flex-wrap: wrap;
}
.footer-v2-social-label {
    font-size: 0.65rem;
    font-weight: 700;
    color: rgba(255,255,255,0.35);
    text-transform: uppercase;
    letter-spacing: 0.12em;
}
.footer-v2-social-list {
    display: flex;
    gap: 0.5rem;
}
.footer-v2-social-item {
    width: 36px; height: 36px;
    border-radius: 0.625rem;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.08);
    display: flex;
    align-items: center;
    justify-content: center;
    color: rgba(255,255,255,0.6);
    transition: all 0.3s ease;
    text-decoration: none;
}
.footer-v2-social-item svg {
    width: 16px; height: 16px;
    fill: currentColor;
}
.footer-v2-social-item:hover {
    background: #3B82F6;
    border-color: #3B82F6;
    color: white;
    transform: translateY(-3px) scale(1.08);
    box-shadow: 0 8px 20px rgba(59,130,246,0.3);
}

/* Dynamic Sections - auto-fill grid adapts to 1..4 sections */
.footer-v2-sections {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 1rem;
}

.footer-v2-section-card {
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.06);
    border-radius: 1.25rem;
    padding: 1.25rem;
    transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
}
.footer-v2-section-card:hover {
    background: rgba(255,255,255,0.05);
    border-color: rgba(255,255,255,0.1);
    transform: translateY(-3px);
    box-shadow: 0 16px 40px rgba(0,0,0,0.15);
}

.footer-v2-section-header {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    margin-bottom: 1rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid rgba(255,255,255,0.06);
}
.footer-v2-section-icon {
    width: 28px; height: 28px;
    border-radius: 0.5rem;
    background: rgba(96,165,250,0.1);
    color: #60A5FA;
    display: flex;
    align-items: center;
    justify-content: center;
}
.footer-v2-section-title {
    font-size: 0.85rem;
    font-weight: 800;
    color: white;
    letter-spacing: -0.01em;
}

.footer-v2-section-nav {
    display: flex;
    flex-direction: column;
    gap: 0.35rem;
}
.footer-v2-link {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.4rem 0.5rem;
    border-radius: 0.5rem;
    font-size: 0.78rem;
    font-weight: 600;
    color: rgba(255,255,255,0.55);
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
}
.footer-v2-link:hover {
    color: white;
    background: rgba(255,255,255,0.05);
}
.footer-v2-link-dot {
    width: 5px; height: 5px;
    border-radius: 50%;
    background: rgba(96,165,250,0.4);
    transition: all 0.3s ease;
    flex-shrink: 0;
}
.footer-v2-link:hover .footer-v2-link-dot {
    background: #60A5FA;
    box-shadow: 0 0 8px rgba(96,165,250,0.5);
    transform: scale(1.2);
}
.footer-v2-link-text {
    flex: 1;
}
.footer-v2-link-empty {
    font-size: 0.78rem;
    color: rgba(255,255,255,0.3);
    font-style: italic;
    padding: 0.5rem;
}

/* Footer Bottom */
.footer-v2-bottom {
    position: relative;
    z-index: 2;
    border-top: 1px solid rgba(255,255,255,0.06);
    padding: 1.25rem 0;
}
.footer-v2-bottom-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
}
.footer-v2-copy {
    font-size: 0.75rem;
    color: rgba(255,255,255,0.4);
    font-weight: 500;
}
.footer-v2-copy strong {
    color: rgba(255,255,255,0.7);
    font-weight: 700;
}
.footer-v2-copy-heart {
    color: #EF4444;
    display: inline-block;
    animation: heartBeat 2s ease-in-out infinite;
}
@keyframes heartBeat {
    0%, 100% { transform: scale(1); }
    14% { transform: scale(1.2); }
    28% { transform: scale(1); }
    42% { transform: scale(1.2); }
    70% { transform: scale(1); }
}
.footer-v2-bottom-links {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
.footer-v2-bottom-link {
    font-size: 0.72rem;
    font-weight: 600;
    color: rgba(255,255,255,0.45);
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
}
.footer-v2-bottom-link:hover {
    color: #60A5FA;
}
.footer-v2-bottom-link::after {
    content: '';
    position: absolute;
    bottom: -2px; left: 0;
    width: 0; height: 1px;
    background: #60A5FA;
    transition: width 0.3s ease;
}
.footer-v2-bottom-link:hover::after {
    width: 100%;
}
.footer-v2-bottom-sep {
    width: 3px; height: 3px;
    border-radius: 50%;
    background: rgba(255,255,255,0.15);
}

/* Responsive */
@media (max-width: 860px) {
    .footer-v2-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
}
@media (max-width: 640px) {
    .footer-v2-sections {
        grid-template-columns: 1fr;
    }
    .footer-v2-bottom-inner {
        flex-direction: column;
        text-align: center;
        gap: 0.75rem;
    }
    .footer-v2-main {
        padding: 2rem 0 1.5rem;
    }
    .footer-v2-brand {
        padding: 1.25rem;
    }
}
</style>
