@extends('layout.app')

@section('content')

@php
    $dokumenStandar = collect($standar ?? [])->map(function ($item) {
        $file = $item->gambar ?? '';
        $url = $file ? Storage::url($file) : '#';
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        return [
            'kategori' => 'Standar Pelayanan',
            'judul' => $item->judul ?? 'Dokumen Standar Pelayanan',
            'deskripsi' => 'Dokumen standar pelayanan yang menjadi acuan dalam penyelenggaraan layanan publik.',
            'url' => $url,
            'ext' => $ext ?: 'file',
            'label' => strtoupper($ext ?: 'FILE'),
        ];
    })->values();

    $dokumenMutu = collect($maklumat ?? [])->map(function ($item) {
        $file = $item->file ?? '';
        $url = $file ? Storage::url($file) : '#';
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        return [
            'kategori' => 'Manajemen Mutu',
            'judul' => $item->judul ?? 'Dokumen Manajemen Mutu',
            'deskripsi' => 'Dokumen pendukung komitmen peningkatan kualitas layanan dan manajemen mutu.',
            'url' => $url,
            'ext' => $ext ?: 'file',
            'label' => strtoupper($ext ?: 'FILE'),
        ];
    })->values();

    $dokumenData = [
        'standar' => $dokumenStandar,
        'mutu' => $dokumenMutu,
    ];

    $defaultGroup = $dokumenStandar->count() > 0 ? 'standar' : ($dokumenMutu->count() > 0 ? 'mutu' : null);
@endphp

<div class="about-page-simple">

    {{-- DESKRIPSI SISTEM --}}
    <section class="about-section about-section-white about-intro-spacing">
        <div class="about-orb about-orb-left"></div>
        <div class="about-orb about-orb-right"></div>

        <div class="about-container">
            <div class="about-intro-grid">

                {{-- PENJELASAN --}}
                <div class="about-card">
                    <div class="about-kicker">
                        <div class="about-kicker-line"></div>
                        <span class="about-kicker-text">
                            Tentang Sistem
                        </span>
                    </div>

                    <h1 class="about-title">
                        Mengenal <span>Datapedia</span>
                    </h1>

                    <div class="about-text-stack">
                        <p class="about-text">
                            Datapedia merupakan portal layanan informasi terpadu yang dikembangkan
                            untuk memudahkan masyarakat dalam memperoleh informasi terkait layanan
                            statistik, akses konsultasi, publikasi, serta dokumen pendukung pelayanan
                            secara lebih ringkas, jelas, dan terarah.
                        </p>

                        <p class="about-text">
                            Melalui Datapedia, pengguna dapat menemukan berbagai informasi pelayanan
                            dalam satu sistem yang lebih tertata, sehingga proses pencarian informasi
                            menjadi lebih efisien tanpa harus membuka banyak kanal secara terpisah.
                        </p>

                        <p class="about-text">
                            Sistem ini juga menjadi bagian dari upaya peningkatan kualitas layanan
                            publik yang transparan, informatif, dan mudah diakses oleh seluruh pengguna
                            layanan.
                        </p>
                    </div>
                </div>

                {{-- TUJUAN --}}
                <div class="about-purpose-card">
                    <div class="about-purpose-head">
                        <div class="about-purpose-icon">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2.3"
                                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>

                        <div>
                            <span class="about-purpose-label">
                                Tujuan Sistem
                            </span>
                            <h2 class="about-purpose-title">
                                Tujuan Datapedia
                            </h2>
                        </div>
                    </div>

                    <div class="about-text-stack">
                        <p class="about-text">
                            Tujuan utama Datapedia adalah menghadirkan pusat informasi layanan statistik
                            yang mudah dipahami, mudah diakses, dan tersusun secara terarah.
                        </p>

                        <p class="about-text">
                            Sistem ini membantu pengguna mengetahui jenis layanan yang tersedia,
                            memahami alur akses layanan, serta memperoleh dokumen pendukung seperti
                            standar pelayanan dan manajemen mutu secara lebih cepat.
                        </p>

                        <p class="about-text">
                            Datapedia juga mendukung penyelenggaraan pelayanan publik yang lebih terbuka
                            melalui penyajian informasi yang konsisten, terstruktur, dan selaras dengan
                            kebutuhan pengguna layanan.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- DOKUMENTASI LAYANAN --}}
    <section
        class="about-section about-section-soft about-doc-spacing"
        x-data="{
            activeGroup: @js($defaultGroup),
            activeIndex: 0,
            groups: @js($dokumenData),

            get activeItems() {
                return this.activeGroup ? (this.groups[this.activeGroup] || []) : [];
            },

            get selected() {
                return this.activeGroup ? (this.activeItems[this.activeIndex] || null) : null;
            },

            toggleGroup(group) {
                if (this.activeGroup === group) {
                    this.activeGroup = null;
                    this.activeIndex = 0;
                    return;
                }

                this.activeGroup = group;
                this.activeIndex = 0;
            },

            selectItem(index) {
                this.activeIndex = index;
            },

            isImage(ext) {
                return ['jpg', 'jpeg', 'png', 'webp', 'gif'].includes(ext);
            },

            isPdf(ext) {
                return ext === 'pdf';
            }
        }"
    >
        <div class="about-orb about-orb-left"></div>
        <div class="about-orb about-orb-right"></div>

        <div class="about-container-wide">

            {{-- HEADER --}}
            <div class="about-doc-header">
                <div class="about-kicker">
                    <div class="about-kicker-line"></div>
                    <span class="about-kicker-text">
                        Informasi Layanan
                    </span>
                </div>

                <h2 class="about-doc-title">
                    Telusuri Dokumentasi
                </h2>

                <p class="about-doc-description">
                    Pilih menu dokumen untuk melihat detail standar pelayanan dan manajemen mutu yang tersedia.
                </p>
            </div>

            <div class="about-doc-grid">

                {{-- SIDEBAR --}}
                <aside class="about-doc-sidebar">
                    <div class="about-doc-sidebar-head">
                        <p class="about-doc-sidebar-title">
                            Menu Informasi
                        </p>
                        <p class="about-doc-sidebar-subtitle">
                            Pilih kategori dokumen
                        </p>
                    </div>

                    <div class="about-doc-sidebar-body">

                        {{-- STANDAR PELAYANAN --}}
                        <div>
                            <button
                                type="button"
                                @click="toggleGroup('standar')"
                                class="about-doc-menu-btn"
                                :class="{ 'is-active': activeGroup === 'standar' }"
                            >
                                <div class="about-doc-menu-left">
                                    <div class="about-doc-icon">
                                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2.4"
                                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>

                                    <div>
                                        <p class="about-doc-menu-title">
                                            Standar Pelayanan
                                        </p>
                                        <p class="about-doc-menu-count">
                                            {{ $dokumenStandar->count() }} Dokumen
                                        </p>
                                    </div>
                                </div>

                                <svg
                                    class="about-doc-chevron"
                                    :class="{ 'is-open': activeGroup === 'standar' }"
                                    width="16"
                                    height="16"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2.5"
                                          d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div
                                x-show="activeGroup === 'standar'"
                                x-transition
                                class="about-doc-submenu"
                            >
                                <template x-for="(item, index) in groups.standar" :key="index">
                                    <button
                                        type="button"
                                        @click="selectItem(index)"
                                        class="about-doc-subitem"
                                        :class="{ 'is-active': activeIndex === index }"
                                    >
                                        <span x-text="item.judul"></span>
                                    </button>
                                </template>

                                <template x-if="groups.standar.length === 0">
                                    <p class="about-empty-small">
                                        Belum ada dokumen.
                                    </p>
                                </template>
                            </div>
                        </div>

                        {{-- MANAJEMEN MUTU --}}
                        <div>
                            <button
                                type="button"
                                @click="toggleGroup('mutu')"
                                class="about-doc-menu-btn"
                                :class="{ 'is-active': activeGroup === 'mutu' }"
                            >
                                <div class="about-doc-menu-left">
                                    <div class="about-doc-icon">
                                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2.4"
                                                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                    </div>

                                    <div>
                                        <p class="about-doc-menu-title">
                                            Manajemen Mutu
                                        </p>
                                        <p class="about-doc-menu-count">
                                            {{ $dokumenMutu->count() }} Dokumen
                                        </p>
                                    </div>
                                </div>

                                <svg
                                    class="about-doc-chevron"
                                    :class="{ 'is-open': activeGroup === 'mutu' }"
                                    width="16"
                                    height="16"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2.5"
                                          d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div
                                x-show="activeGroup === 'mutu'"
                                x-transition
                                class="about-doc-submenu"
                            >
                                <template x-for="(item, index) in groups.mutu" :key="index">
                                    <button
                                        type="button"
                                        @click="selectItem(index)"
                                        class="about-doc-subitem"
                                        :class="{ 'is-active': activeIndex === index }"
                                    >
                                        <span x-text="item.judul"></span>
                                    </button>
                                </template>

                                <template x-if="groups.mutu.length === 0">
                                    <p class="about-empty-small">
                                        Belum ada dokumen.
                                    </p>
                                </template>
                            </div>
                        </div>

                    </div>
                </aside>

                {{-- DETAIL --}}
                <div class="about-doc-shell">

                    <template x-if="selected">
                        <div>
                            {{-- DETAIL HEADER --}}
                            <div class="about-doc-detail-head">
                                <div class="about-doc-detail-kicker">
                                    <div class="about-doc-detail-icon">
                                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2.4"
                                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>

                                    <span class="about-doc-detail-category" x-text="selected.kategori"></span>
                                </div>

                                <h3 class="about-doc-detail-title" x-text="selected.judul"></h3>

                                <p class="about-doc-detail-desc" x-text="selected.deskripsi"></p>
                            </div>

                            {{-- DETAIL CONTENT --}}
                            <div class="about-doc-content-grid">

                                {{-- PREVIEW --}}
                                {{-- PREVIEW --}}
                                <div>
                                    <div class="document-preview-box">

                                        {{-- Preview PDF --}}
                                        <template x-if="isPdf(selected.ext)">
                                            <iframe
                                                :src="selected.url"
                                                class="document-preview-frame"
                                                frameborder="0">
                                            </iframe>
                                        </template>

                                        {{-- Preview Gambar --}}
                                        <template x-if="isImage(selected.ext)">
                                            <img
                                                :src="selected.url"
                                                :alt="selected.judul"
                                                class="document-preview-image">
                                        </template>

                                        {{-- Preview file dokumen selain PDF/Gambar --}}
                                        <template x-if="!isPdf(selected.ext) && !isImage(selected.ext)">
                                            <div class="document-preview-empty">
                                                <div class="about-empty-icon">
                                                    <svg width="30" height="30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2.3"
                                                            d="M7 21h10a2 2 0 002-2V9l-6-6H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                    </svg>
                                                </div>

                                                <p class="about-empty-title">
                                                    Dokumen tersedia
                                                </p>

                                                <p class="about-empty-text">
                                                    File ini tidak dapat ditampilkan langsung di browser. Gunakan tombol lihat atau unduh untuk membuka dokumen.
                                                </p>

                                                <div class="about-doc-actions" style="max-width: 260px; margin: 1rem auto 0;">
                                                    <a
                                                        :href="selected.url"
                                                        target="_blank"
                                                        class="about-doc-action-light">
                                                        Lihat
                                                    </a>

                                                    <a
                                                        :href="selected.url"
                                                        download
                                                        class="about-doc-action-primary">
                                                        Unduh
                                                    </a>
                                                </div>
                                            </div>
                                        </template>

                                    </div>
                                </div>

                                {{-- DOKUMEN TERKAIT --}}
                                <div>
                                    <div class="about-doc-related-title">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2.4"
                                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z"/>
                                        </svg>
                                        <span>Dokumen Terkait</span>
                                    </div>

                                    <div class="about-doc-related-card">
                                        <div class="about-doc-file-row">
                                            <div class="about-doc-file-icon">
                                                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round"
                                                          stroke-linejoin="round"
                                                          stroke-width="2.3"
                                                          d="M7 21h10a2 2 0 002-2V9l-6-6H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                </svg>
                                            </div>

                                            <div class="about-doc-file-meta">
                                                <div class="about-doc-file-badges">
                                                    <span class="about-doc-file-type" x-text="selected.label"></span>
                                                    <span class="about-doc-file-label">Dokumen</span>
                                                </div>

                                                <p class="about-doc-file-title" x-text="selected.judul"></p>
                                            </div>
                                        </div>

                                        <div class="about-doc-actions">
                                            <a
                                                :href="selected.url"
                                                target="_blank"
                                                class="about-doc-action-light">
                                                Lihat
                                            </a>

                                            <a
                                                :href="selected.url"
                                                download
                                                class="about-doc-action-primary">
                                                Unduh
                                            </a>
                                        </div>
                                    </div>                                    
                                </div>

                            </div>
                        </div>
                    </template>

                    <template x-if="!selected">
                        <div class="about-empty-state">
                            <div class="about-empty-icon">
                                <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2.3"
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z"/>
                                </svg>
                            </div>

                            <h3 class="about-empty-title">
                                Pilih Dokumen
                            </h3>

                            <p class="about-empty-text">
                                Buka salah satu menu di samping untuk melihat detail dokumen.
                            </p>
                        </div>
                    </template>

                </div>

            </div>
        </div>
    </section>

</div>

@endsection