@extends('user.layout')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/user-page.css') }}">
@endpush

@section('content')
<main class="user-page">

    {{-- STATISTIK LAYANAN --}}
    <section id="statistik" class="up-section up-stat-section relative z-30 -mt-20 lg:-mt-28 px-4">
        <div data-aos="fade-up" data-aos-duration="1000"
            class="up-stat-panel max-w-6xl mx-auto p-6 md:p-8 lg:p-10">

            <div class="up-stat-header flex flex-col items-center text-center mb-10 relative">
                <h3 class="up-stat-title text-3xl md:text-5xl">
                    Statistik Layanan
                    <span class="up-stat-year">
                        {{ $tahun ?? date('Y') }}
                    </span>
                </h3>

                <div class="up-stat-title-line"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 md:gap-4">
                @foreach($stats as $stat)
                    <div class="up-stat-item">
                        <div class="up-stat-card">

                            <div class="up-stat-number stat-number"
                                data-target="{{ $stat['jumlah'] ?? 0 }}"
                                data-animated="false">
                                <span class="value">0</span>
                            </div>

                            <p class="up-stat-label">
                                {{ $stat['label'] }}
                            </p>

                            <div class="up-stat-line"></div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- LAYANAN - Premium Cards --}}
    <section id="layanan" class="up-section up-section-soft scroll-section py-16 lg:py-24 relative overflow-hidden">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full bg-[radial-gradient(circle_at_top,_rgba(59,130,246,0.03),transparent)] -z-10"></div>

        <div class="max-w-7xl mx-auto px-6">
            
            <div class="flex flex-col items-center text-center mb-3" data-aos="fade-up">                            
                <h3 class="text-3xl md:text-5xl font-black text-blue-900 leading-[1.1] tracking-tighter mb-6">
                    Layanan Statistik Digital <span class="text-blue-500">untuk Semua Instansi</span>
                </h3>
                
                <div class="h-1 w-12 bg-blue-600 rounded-full mb-6"></div>
                <p class="max-w-2xl text-slate-600 text-base md:text-lg leading-relaxed mb-6">
                    Akses data resmi, konsultasi, dan rekomendasi statistik melalui satu portal terpadu.
                    Datapedia memudahkan pengambilan keputusan dengan informasi BPS yang terpercaya.
                </p>
                <div class="flex items-center gap-3 mb-6">
                    <span class="h-[1px] w-8 bg-slate-200"></span>
                    <span class="text-[10px] font-black text-gray-600 uppercase tracking-[0.3em]">Layanan Utama</span>
                    <span class="h-[1px] w-8 bg-slate-200"></span> 
                </div>
            </div>

            <!-- Grid Content -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8" data-aos="fade-up">

                <!-- Kartu 1 -->
                <div class="group theme-blue">
                    <div class="service-card">
                        <div class="status-badge bg-blue-500">Gratis</div>
                        <div class="icon-box bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <h3 class="font-header text-xl font-bold text-slate-900 mb-2">Perpustakaan</h3>
                        <p class="text-blue-600 text-[10px] font-bold uppercase tracking-widest mb-4">Layanan Umum</p>
                        <p class="text-slate-500 text-sm leading-relaxed mb-8">Akses publikasi statistik dari kategori kependudukan hingga pertanian secara digital.</p>
                        <a href="https://webapi.bps.go.id/consumen/88582261b976073c4aee562850e51881?redirect_uri=https%3A%2F%2Fpst.bps.go.id%2Flogin" target="_blank" rel="noopener noreferrer" class="action-btn">
                            <span>Cari Pustaka</span>
                            <svg class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Kartu 2 -->
                <div class="group theme-blue">
                    <div class="service-card">
                        <div class="status-badge bg-blue-500">Berbayar</div>
                        <div class="icon-box bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        </div>
                        <h3 class="font-header text-xl font-bold text-slate-900 mb-2">Produk Statistik Berbayar</h3>
                        <p class="text-blue-600 text-[10px] font-bold uppercase tracking-widest mb-4">Layanan Umum</p>
                        <p class="text-slate-500 text-sm leading-relaxed mb-8">Penjualan produk statistik berbayar, publikasi elektronik, dan peta wilayah statistik terlengkap.</p>
                        <a href="https://webapi.bps.go.id/consumen/88582261b976073c4aee562850e51881?redirect_uri=https%3A%2F%2Fpst.bps.go.id%2Flogin" target="_blank" rel="noopener noreferrer" class="action-btn">
                            <span>Beli Data</span>
                            <svg class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Kartu 3 -->
                <div class="group theme-blue">
                    <div class="service-card">
                        <div class="status-badge bg-blue-500">Gratis</div>
                        <div class="icon-box bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        </div>
                        <h3 class="font-header text-xl font-bold text-slate-900 mb-2">Konsultasi</h3>
                        <p class="text-blue-600 text-[10px] font-bold uppercase tracking-widest mb-4">Layanan Umum</p>
                        <p class="text-slate-500 text-sm leading-relaxed mb-8">Bantuan metadata, klasifikasi, dan asistensi produk statistik melalui kanal resmi.</p>
                        <a href="https://webapi.bps.go.id/consumen/88582261b976073c4aee562850e51881?redirect_uri=https%3A%2F%2Fpst.bps.go.id%2Flogin" target="_blank" rel="noopener noreferrer" class="action-btn">
                            <span>Ajukan Konsul</span>
                            <svg class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Kartu 4 -->
                <div class="group theme-blue">
                    <div class="service-card">
                        <div class="status-badge bg-blue-600">Gratis</div>
                        <div class="icon-box bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <h3 class="font-header text-xl font-bold text-slate-900 mb-2">Rekomendasi</h3>
                        <p class="text-blue-600 text-[10px] font-bold uppercase tracking-widest mb-4">Layanan Instansi</p>
                        <p class="text-slate-500 text-sm leading-relaxed mb-8">Layanan survei dan pengajuan rekomendasi statistik bagi instansi pemerintah.</p>
                        <a href="https://webapi.bps.go.id/consumen/88582261b976073c4aee562850e51881?redirect_uri=https%3A%2F%2Fpst.bps.go.id%2Flogin" class="action-btn">
                            <span>Minta Akses</span>
                            <svg class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>
    
    {{-- KONSULTASI - Modern Platforms --}}
    <section id="konsultasi" class="up-section up-section-white py-12 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-blue-50/60 rounded-full blur-[100px] -z-10"></div>

        <div class="max-w-6xl mx-auto px-6">
            
            <div class="max-w-3xl mx-auto mb-8" data-aos="fade-up">
                <div class="relative flex flex-col items-center">                                    

                    <div class="text-center mb-4">                       
                        <h3 class="text-3xl md:text-5xl font-black text-blue-900 leading-[1.1] tracking-tighter mb-6">
                            DataFast <span class="text-blue-500">Respon Cepat Tanpa Jarak</span>
                        </h3> 
                        <div class="h-1 w-12 bg-blue-600 rounded-full mt-3 mb-6 mx-auto"></div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 -mt-10">
                
                {{-- Kartu 1: Tanya Pakar (WhatsApp) --}}
                <div class="up-consult-card group bg-white border-2 border-slate-100 p-7 rounded-[2.5rem] transition-all duration-500 hover:border-blue-500 hover:shadow-[0_20px_50px_-20px_rgba(16,185,129,0.2)]"data-aos="fade-up" data-aos-delay="100">
                    <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center mb-6 transition-all duration-500 group-hover:bg-blue-500 group-hover:text-white group-hover:rotate-6">
                        <svg class="w-6 h-6 shrink-0 text-[#25D366] group-hover:text-[#25D366] group-hover:scale-110 transition-all duration-300"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.46 1.33 4.97L2 22l5.25-1.38a9.86 9.86 0 0 0 4.79 1.22h.01c5.46 0 9.91-4.45 9.91-9.91S17.5 2 12.04 2Zm0 18.16h-.01a8.18 8.18 0 0 1-4.17-1.14l-.3-.18-3.12.82.83-3.04-.2-.31a8.2 8.2 0 0 1-1.26-4.4c0-4.54 3.7-8.23 8.24-8.23a8.2 8.2 0 0 1 8.23 8.24c0 4.54-3.7 8.24-8.24 8.24Zm4.51-6.16c-.25-.12-1.46-.72-1.69-.8-.23-.08-.39-.12-.56.12-.16.25-.64.8-.78.96-.14.16-.29.18-.54.06-.25-.12-1.05-.39-2-1.23-.74-.66-1.24-1.48-1.38-1.73-.14-.25-.02-.38.11-.5.11-.11.25-.29.37-.43.12-.14.16-.25.25-.41.08-.16.04-.31-.02-.43-.06-.12-.56-1.35-.77-1.85-.2-.48-.41-.42-.56-.43h-.48c-.16 0-.43.06-.66.31-.23.25-.87.85-.87 2.08s.89 2.41 1.02 2.58c.12.16 1.76 2.69 4.27 3.77.6.26 1.07.41 1.43.52.6.19 1.15.16 1.58.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.08.15-1.18-.06-.1-.23-.16-.48-.29Z"/>
                        </svg>
                    </div>
                    <h4 class="font-black text-blue-950 text-xl mb-2 tracking-tight italic uppercase">Konsultasi Kilat</h4>
                    <p class="text-slate-500 text-[11px] leading-relaxed mb-8 font-medium italic">Integrasi layanan chat cerdas yang menghubungkan Anda langsung dengan pakar statistik BPS.</p>
                    
                    @if(session('login_user') && session('user_id'))
                        <a href="{{ route('konsultasi.index') }}" class="flex items-center justify-between w-full p-4 bg-blue-500 text-white rounded-2xl text-[9px] font-black uppercase tracking-widest shadow-lg shadow-blue-50 hover:bg-blue-600 transition-all speak-target" onmouseenter="speakOnHover(this)">
                            <span>Hubungi Pakar</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    @else
                        <a href="{{ route('loginUser') }}" class="flex items-center justify-between w-full p-4 bg-blue-500 text-white rounded-2xl text-[9px] font-black uppercase tracking-widest shadow-lg shadow-blue-50 hover:bg-blue-600 transition-all speak-target">
                            <span>Hubungi Pakar</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    @endif
                </div>

                {{-- Kartu 2: Temu Jadwal (Online/Offline) --}}
                <div class="up-consult-card group bg-white border-2 border-slate-100 p-7 rounded-[2.5rem] transition-all duration-500 hover:border-blue-500 hover:shadow-[0_20px_50px_-20px_rgba(59,130,246,0.2)]" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center transition-all duration-500 group-hover:bg-blue-500 group-hover:text-white group-hover:-rotate-6">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="m9 16 2 2 4-4"/></svg>
                        </div>
                        
                        <div class="text-right">
                            <span class="text-[8px] font-black text-blue-600 bg-blue-50 px-2 py-1 rounded-lg uppercase tracking-widest">Jam Layanan Fleksibel</span>
                        </div>
                    </div>             
                    <h4 class="font-black text-blue-950 text-xl mb-2 tracking-tight italic uppercase">Temu Lintas Waktu</h4>
                    <p class="text-slate-500 text-[11px] leading-relaxed mb-8 font-medium italic">Layanan tetap hadir melampaui jam operasional kantor. Atur sesi daring atau luring sesuai waktu pilihan Anda.</p>
                    
                    <div class="flex flex-row gap-2">
                        <div class="flex-[2]"> 
                            @if(session('login_user') && session('user_id'))
                                <a href="{{ route('janjitemu.index') }}" class="w-full p-4 bg-blue-500 text-white rounded-2xl text-[9px] font-black uppercase tracking-tight shadow-lg shadow-blue-50 hover:bg-blue-600 transition-all speak-target flex items-center justify-between" onmouseenter="speakOnHover(this)">
                            <span>Atur Jadwal</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    @else
                        <a href="{{ route('loginUser') }}" class="w-full p-4 bg-blue-500 text-white rounded-2xl text-[9px] font-black uppercase tracking-tight shadow-lg shadow-blue-50 hover:bg-blue-600 transition-all speak-target flex items-center justify-between">
                            <span>Atur Jadwal</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    @endif
                        </div>

                        @if(isset($janjiTemu) && $janjiTemu)
                            <div class="flex-1">
                                <a href="{{ route('janjitemu.jadwal') }}" class="block h-full">
                                    <button title="Lihat Jadwal Saya" class="w-full h-full p-4 border-2 border-blue-100 text-blue-500 rounded-2xl hover:bg-blue-50 transition-all flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </button>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Kartu 3: Antrean Utama --}}
                <div class="up-consult-card group bg-white border-2 border-slate-100 p-7 rounded-[2.5rem] transition-all duration-500 hover:border-blue-500 hover:shadow-[0_20px_50px_-20px_rgba(249,115,22,0.2)]" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center mb-6 transition-all duration-500 group-hover:bg-blue-500 group-hover:text-white group-hover:rotate-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <h4 class="font-black text-blue-950 text-xl mb-2 tracking-tight italic uppercase">Reservasi Cerdas</h4>
                    <p class="text-slate-500 text-[11px] leading-relaxed mb-8 font-medium italic">Efisiensi kunjungan langsung melalui reservasi antrean digital untuk pelayanan prima tanpa antre lama.</p>
                    
                    <a href="https://webapps.bps.go.id/babel/antrianbabel/frontend/web/index.php?r=site/index#services" target="_blank" rel="noopener noreferrer" class="flex items-center justify-between w-full p-4 bg-blue-500 text-white rounded-2xl text-[9px] font-black uppercase tracking-widest shadow-lg shadow-blue-50 hover:bg-blue-600 transition-all speak-target" onmouseenter="speakOnHover(this)">
                        <span>Pesan Antrean</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- DIREKTORI PETUGAS --}}
    <section 
        x-data="{ 
            selectedBidang: 'all',
            selectedBidangName: 'Semua Petugas',
            filterOpen: false,

            scrollPetugas(direction) {
                const sliderId = this.selectedBidang === 'all'
                    ? 'slider-all'
                    : 'slider-' + this.selectedBidang;
                const slider = document.getElementById(sliderId);
                if (slider) {
                    slider.scrollBy({
                        left: direction * slider.clientWidth,
                        behavior: 'smooth'
                    });
                }
            },

            pilihBidang(slug, nama) {
                this.selectedBidang = slug;
                this.selectedBidangName = nama;
                this.filterOpen = false;
                this.$nextTick(() => {
                    const sliderId = this.selectedBidang === 'all' ? 'slider-all' : 'slider-' + this.selectedBidang;
                    const slider = document.getElementById(sliderId);
                    if (slider) slider.scrollTo({ left: 0, behavior: 'smooth' });
                });
            }
        }"
        class="up-section up-staff-section py-16 lg:py-24 font-sans bg-white relative"
        style="overflow:visible;z-index:10;"
    >
        {{-- Background Gradient --}}
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full bg-[radial-gradient(circle_at_bottom,_rgba(59,130,246,0.04),transparent)] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-6 relative" style="overflow:visible;">

            {{-- HEADER --}}
            <div class="flex flex-col items-center justify-center mb-4"data-aos="fade-up">
                <div class="text-center mb-2">
                    <h2 class="text-xl font-black text-[#002B6A] tracking-tighter leading-none">
                        Direktori <span class="text-blue-500">Petugas</span>
                    </h2>
                </div>

                {{-- PETUGAS BERPRESTASI --}}
                <div class="up-achievement-panel">
                    <div class="up-achievement-header">
                        <div class="up-achievement-title-wrap">
                            <span class="up-achievement-star">★</span>

                            <div class="up-achievement-title">
                                Petugas <span>Berprestasi</span>
                            </div>

                            <span class="up-achievement-separator">/</span>

                            <div class="up-achievement-period">
                                {{ $labelTriwulanBerprestasi ?? 'Triwulan' }} {{ $tahunPetugasBerprestasi ?? date('Y') }}
                            </div>
                        </div>
                    </div>

                    <div class="up-achievement-list">
                        @forelse ($petugasBerprestasiTriwulan as $item)
                            <div class="up-achievement-card group">

                                {{-- Foto --}}
                                <div class="up-achievement-photo-wrap">
                                    <div class="up-achievement-photo-frame">
                                        @if($item->konsultan && $item->konsultan->gambar)
                                            <img src="{{ Storage::url($item->konsultan->gambar) }}"
                                                alt="{{ $item->konsultan->nama }}"
                                                class="up-achievement-photo">
                                        @else
                                            <div class="up-achievement-photo-empty">
                                                {{ substr($item->konsultan->nama ?? 'P', 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Info --}}
                                <div class="up-achievement-info">
                                    <div class="up-achievement-label">
                                        Best Performance
                                    </div>

                                    <div class="up-achievement-name">
                                        {{ $item->konsultan->nama ?? 'Petugas' }}
                                    </div>

                                    <div class="up-achievement-position">
                                        {{ $item->konsultan->posisi ?? '-' }}
                                    </div>

                                    @if($item->sertifikat)
                                        <div class="up-achievement-certificate-wrap">
                                            <a href="{{ Storage::url($item->sertifikat) }}"
                                            target="_blank"
                                            class="up-achievement-certificate">
                                                <span>Lihat Sertifikat</span>

                                                <svg class="up-achievement-certificate-icon"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="3"
                                                        d="M13 7l5 5m0 0l-5 5m5-5H6">
                                                    </path>
                                                </svg>
                                            </a>
                                        </div>
                                    @endif
                                </div>

                                {{-- Medali --}}
                                <div class="up-achievement-medal">
                                    <div class="up-achievement-medal-shape">
                                        <svg class="up-achievement-ribbon" viewBox="0 0 40 40" fill="none">
                                            <path d="M12 0L20 15L28 0H12Z" fill="#002B6A" />
                                            <path d="M15 0L20 10L25 0H15Z" fill="#3B82F6" />
                                        </svg>

                                        <div class="up-achievement-medal-circle-wrap">
                                            <div class="up-achievement-medal-circle">
                                                <div class="up-achievement-medal-inner"></div>
                                                <span class="up-achievement-medal-star">★</span>
                                            </div>
                                        </div>
                                    </div>

                                    <span class="up-achievement-medal-period">
                                        {{ $labelTriwulanBerprestasi ?? 'Triwulan' }}
                                        <br>
                                        {{ $tahunPetugasBerprestasi ?? date('Y') }}
                                    </span>
                                </div>

                            </div>
                        @empty
                            <div class="up-achievement-empty">
                                Awaiting Achievement Data
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- FILTER + DAFTAR PETUGAS --}}
            <div class="flex flex-col md:flex-row gap-8" data-aos="fade-up" data-aos-delay="100">

                {{-- FILTER BIDANG --}}
                <div class="md:w-1/4">
                    <div class="mb-4">
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">
                            Filter Bidang
                        </h3>

                        <p class="text-[11px] text-slate-400 font-medium leading-relaxed">
                            Pilih bidang petugas untuk menampilkan daftar sesuai keahlian.
                        </p>
                    </div>

                    <div class="relative" @click.outside="filterOpen = false">
                        <button 
                            type="button"
                            @click="filterOpen = !filterOpen"
                            class="w-full bg-white border border-blue-100 rounded-2xl p-4 text-left shadow-sm hover:border-blue-200 hover:bg-blue-50/40 transition-all"
                        >
                            <div class="flex items-center justify-between gap-3">
                                <div class="min-w-0">
                                    <span class="block text-[9px] font-black text-blue-600 uppercase tracking-widest mb-1">
                                        Bidang Terpilih
                                    </span>

                                    <span class="block text-xs font-black text-slate-700 uppercase truncate"
                                        x-text="selectedBidangName">
                                    </span>
                                </div>

                                <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center border border-blue-100">
                                    <svg class="w-4 h-4 transition-transform duration-300"
                                        :class="filterOpen ? 'rotate-180' : ''"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="3"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </button>

                        <div 
                            x-show="filterOpen"
                            x-cloak
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                            x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                            class="absolute z-40 mt-2 w-full bg-white border border-slate-100 rounded-2xl shadow-xl p-2"
                        >
                            {{-- Semua Petugas --}}
                            <button 
                                type="button"
                                @click="pilihBidang('all', 'Semua Petugas')"
                                :class="selectedBidang === 'all' ? 'bg-blue-50 text-blue-700 border-blue-100' : 'text-slate-500 border-transparent hover:bg-gray-50'"
                                class="w-full px-4 py-3 rounded-xl text-xs font-bold transition-all border text-left flex items-center justify-between group"
                            >
                                <span>Semua Petugas</span>

                                <span class="bg-white px-2 py-0.5 rounded-md text-[9px] border border-gray-100 group-hover:border-blue-200">
                                    {{ $konsultan->count() }}
                                </span>
                            </button>

                            {{-- Bidang Keahlian --}}
                            @foreach ($bidangKeahlian as $bidang)
                                @php
                                    $slugBidang = \Illuminate\Support\Str::slug($bidang->nama_bidang);

                                    $jumlahPetugasBidang = $konsultan->filter(function ($item) use ($bidang) {
                                        return $item->bidangKeahlian->contains('id', $bidang->id);
                                    })->count();
                                @endphp

                                <button 
                                    type="button"
                                    @click="pilihBidang(@js($slugBidang), @js($bidang->nama_bidang))"
                                    :class="selectedBidang === @js($slugBidang) ? 'bg-blue-50 text-blue-700 border-blue-100' : 'text-slate-500 border-transparent hover:bg-gray-50'"
                                    class="w-full px-4 py-3 rounded-xl text-xs font-bold transition-all border text-left flex items-center justify-between group uppercase tracking-tight"
                                >
                                    <span class="truncate">{{ $bidang->nama_bidang }}</span>

                                    <span class="bg-white px-2 py-0.5 rounded-md text-[9px] border border-gray-100 group-hover:border-blue-200">
                                        {{ $jumlahPetugasBidang }}
                                    </span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- DAFTAR PETUGAS --}}
                <div class="md:w-3/4 min-w-0">

                    <div class="flex items-center justify-between gap-4 mb-3">
                        <div>
                            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Daftar Petugas
                            </h3>

                            <p class="text-[10px] text-slate-400 font-medium mt-1">
                                Geser untuk melihat petugas lainnya.
                            </p>
                        </div>

                        <div class="flex items-center gap-2">
                            <button 
                                type="button"
                                @click="scrollPetugas(-1)"
                                class="w-8 h-8 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-100 flex items-center justify-center transition-all"
                                aria-label="Sebelumnya"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="3"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>

                            <button 
                                type="button"
                                @click="scrollPetugas(1)"
                                class="w-8 h-8 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-100 flex items-center justify-center transition-all"
                                aria-label="Selanjutnya"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="3"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- SLIDER SEMUA PETUGAS --}}
                    <div x-show="selectedBidang === 'all'">
                        <div 
                            id="slider-all"
                            data-petugas-slider
                            class="flex overflow-x-auto no-scrollbar scroll-smooth snap-x snap-mandatory pb-2"
                        >
                            @foreach ($konsultan->chunk(9) as $slide)
                                <div class="min-w-full snap-start pr-1">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                                        @foreach ($slide as $item)
                                            <div class="up-staff-card bg-white border border-gray-100 p-2 rounded-xl hover:shadow-md hover:shadow-slate-200/50 hover:border-blue-200 transition-all flex items-center gap-2 group w-full">
                                                <div class="relative flex-shrink-0">
                                                    @if($item->gambar)
                                                        <img 
                                                            src="{{ Storage::url($item->gambar) }}"
                                                            alt="{{ $item->nama }}"
                                                            class="w-10 h-10 rounded-lg object-cover shadow-sm group-hover:shadow-blue-100 transition-all"
                                                        >
                                                    @else
                                                        <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center text-xs font-bold shadow-sm">
                                                            ?
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="flex-1 min-w-0">
                                                    <h4 class="text-[12px] font-bold text-slate-900 truncate tracking-tight leading-tight">
                                                        {{ $item->nama }}
                                                    </h4>

                                                    <p class="text-[9px] text-slate-400 font-medium truncate mt-0.5 leading-tight">
                                                        {{ $item->posisi }}
                                                    </p>

                                                    <div class="flex flex-wrap gap-1 mt-1">
                                                        @forelse($item->bidangKeahlian as $bidangItem)
                                                            <span class="inline-block px-1.5 py-0.5 bg-blue-50 text-blue-600 rounded-md text-[7px] font-bold uppercase tracking-tight leading-none">
                                                                {{ $bidangItem->nama_bidang }}
                                                            </span>
                                                        @empty
                                                            <span class="text-[7px] font-bold text-slate-400">
                                                                -
                                                            </span>
                                                        @endforelse
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- SLIDER PER BIDANG --}}
                    @foreach ($bidangKeahlian as $bidang)
                        @php
                            $slugBidang = \Illuminate\Support\Str::slug($bidang->nama_bidang);

                            $petugasBidang = $konsultan->filter(function ($item) use ($bidang) {
                                return $item->bidangKeahlian->contains('id', $bidang->id);
                            });
                        @endphp

                        <div x-show="selectedBidang === @js($slugBidang)">
                            <div 
                                id="slider-{{ $slugBidang }}"
                                data-petugas-slider
                                class="flex overflow-x-auto no-scrollbar scroll-smooth snap-x snap-mandatory pb-2"
                            >
                                @forelse ($petugasBidang->chunk(9) as $slide)
                                    <div class="min-w-full snap-start pr-1">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                                            @foreach ($slide as $item)
                                                <div class="up-staff-card bg-white border border-gray-100 p-2 rounded-xl hover:shadow-md hover:shadow-slate-200/50 hover:border-blue-200 transition-all flex items-center gap-2 group w-full">
                                                    <div class="relative flex-shrink-0">
                                                        @if($item->gambar)
                                                            <img 
                                                                src="{{ Storage::url($item->gambar) }}"
                                                                alt="{{ $item->nama }}"
                                                                class="w-10 h-10 rounded-lg object-cover shadow-sm group-hover:shadow-blue-100 transition-all"
                                                            >
                                                        @else
                                                            <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center text-xs font-bold shadow-sm">
                                                                ?
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="flex-1 min-w-0">
                                                        <h4 class="text-[12px] font-bold text-slate-900 truncate tracking-tight leading-tight">
                                                            {{ $item->nama }}
                                                        </h4>

                                                        <p class="text-[9px] text-slate-400 font-medium truncate mt-0.5 leading-tight">
                                                            {{ $item->posisi }}
                                                        </p>

                                                        <div class="flex flex-wrap gap-1 mt-1">
                                                            @forelse($item->bidangKeahlian as $bidangItem)
                                                                <span class="inline-block px-1.5 py-0.5 bg-blue-50 text-blue-600 rounded-md text-[7px] font-bold uppercase tracking-tight leading-none">
                                                                    {{ $bidangItem->nama_bidang }}
                                                                </span>
                                                            @empty
                                                                <span class="text-[7px] font-bold text-slate-400">
                                                                    -
                                                                </span>
                                                            @endforelse
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @empty
                                    <div class="min-w-full py-6 text-center">
                                        <p class="text-xs text-slate-400 font-semibold">
                                            Belum ada petugas pada bidang ini.
                                        </p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- LAYANAN 24 JAM --}}
    <section id="layanan-24" class="up-section up-service24-section py-16 overflow-hidden">
        <div class="max-w-5xl mx-auto px-6">
            
            <div class="flex flex-col items-center text-center mb-16" 
                data-aos="fade-up" 
                data-aos-duration="1000">
                
                <h2 class="text-3xl md:text-5xl font-[1000] text-[#002B6A] tracking-tighter leading-none">
                    STAT-24 <span class="text-blue-600">Data Tanpa Jeda</span>
                </h2>

                <div class="h-1 w-12 bg-blue-600 rounded-full mt-3 mb-6 mx-auto"></div>

                <div class="flex items-center gap-3 mb-6">
                    <span class="h-[1px] w-8 bg-slate-200"></span>
                    <span class="text-[10px] font-black text-gray-600 uppercase tracking-[0.3em]">
                        Layanan Pendukung 24 Jam
                    </span>
                    <span class="h-[1px] w-8 bg-slate-200"></span>
                </div>
            </div>

            <div class="service24-slider-wrap -mt-10">

                {{-- Tombol Kiri --}}
                <button type="button"
                    class="service24-slider-btn service24-slider-prev"
                    onclick="slideService24('prev')"
                    aria-label="Layanan sebelumnya">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>

                {{-- Tombol Kanan --}}
                <button type="button"
                    class="service24-slider-btn service24-slider-next"
                    onclick="slideService24('next')"
                    aria-label="Layanan berikutnya">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>

                {{-- Track Carousel --}}
                <div id="service24Slider" class="service24-slider">
                    @foreach ($layanan as $item)
                        <div class="service24-slide" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="up-service24-card service24-card group">
                                
                                <div class="service24-card-image">
                                    <img 
                                        src="{{ Storage::url($item->gambar) }}" 
                                        alt="{{ $item->judul }}"
                                        class="service24-card-img"
                                    >
                                </div>

                                <div class="service24-card-body">
                                    <h3 class="service24-card-title">
                                        {{ $item->judul }}
                                    </h3>
                                    
                                    <p class="service24-card-desc">
                                        {{ $item->deskripsi }}
                                    </p>                            

                                    <a href="{{ $item->link }}" target="_blank" class="service24-card-btn group/btn">
                                        <span>Akses Layanan</span>

                                        <svg xmlns="http://www.w3.org/2000/svg" 
                                            class="h-3 w-3 transition-all duration-500 transform group-hover/btn:-rotate-45 group-hover/btn:-translate-y-0.5 group-hover/btn:translate-x-0.5" 
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                        </svg>
                                    </a>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </section>


    {{-- EDUKASI STATISTIK - Fitur Student Corner menjadi fitur utama Datapedia --}}
    <section id="literasi-statistik" class="up-section up-section-soft py-16 lg:py-24 relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(59,130,246,0.08),transparent_35%)] -z-10"></div>

        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col items-center text-center mb-10" data-aos="fade-up">
                <div class="flex items-center gap-3 mb-5">
                    <span class="h-[1px] w-8 bg-slate-200"></span>
                    <span class="text-[10px] font-black text-blue-600 uppercase tracking-[0.3em]">Literasi Statistik</span>
                    <span class="h-[1px] w-8 bg-slate-200"></span>
                </div>

                <h3 class="text-3xl md:text-5xl font-black text-blue-900 leading-[1.1] tracking-tighter mb-5">
                    Belajar, Berlatih, dan Berkarya <span class="text-blue-500">di Datapedia</span>
                </h3>

                <p class="max-w-3xl text-slate-500 text-sm md:text-base leading-relaxed">
                    Fitur Student Corner sudah menjadi bagian utama Datapedia: konten edukasi, program magang, riset,
                    kuis, simulasi, kalkulator, dan visualisasi data dapat diakses dari satu sistem dan satu login.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" data-aos="fade-up">
                <a href="{{ route('konten-edukasi.index') }}" class="group bg-white border-2 border-slate-100 rounded-[2rem] p-7 hover:border-blue-500 hover:shadow-xl transition-all">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-5 group-hover:bg-blue-600 group-hover:text-white transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <h4 class="font-black text-blue-950 text-xl mb-2">Konten Edukasi</h4>
                    <p class="text-slate-500 text-sm leading-relaxed mb-5">Artikel, video pembelajaran, dan infografis statistik.</p>
                    <span class="text-blue-600 text-sm font-bold">Buka Materi →</span>
                </a>

                <a href="{{ route('program-magang.index') }}" class="group bg-white border-2 border-slate-100 rounded-[2rem] p-7 hover:border-blue-500 hover:shadow-xl transition-all">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-5 group-hover:bg-blue-600 group-hover:text-white transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m12 0H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V8a2 2 0 00-2-2z"/></svg>
                    </div>
                    <h4 class="font-black text-blue-950 text-xl mb-2">Program Magang</h4>
                    <p class="text-slate-500 text-sm leading-relaxed mb-5">Daftar magang, presensi, log harian, laporan, dan sertifikat.</p>
                    <span class="text-blue-600 text-sm font-bold">Lihat Magang →</span>
                </a>

                <a href="{{ route('program-riset.index') }}" class="group bg-white border-2 border-slate-100 rounded-[2rem] p-7 hover:border-blue-500 hover:shadow-xl transition-all">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-5 group-hover:bg-blue-600 group-hover:text-white transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19.428 15.428a8 8 0 01-12.856 0M12 2v6m0 0L9 5m3 3l3-3M4 13h16"/></svg>
                    </div>
                    <h4 class="font-black text-blue-950 text-xl mb-2">Kolaborasi Riset</h4>
                    <p class="text-slate-500 text-sm leading-relaxed mb-5">Informasi riset, pendaftaran, arsip karya, dan sertifikat.</p>
                    <span class="text-blue-600 text-sm font-bold">Lihat Riset →</span>
                </a>

                <a href="{{ route('kuis-tantangan.index') }}" class="group bg-white border-2 border-slate-100 rounded-[2rem] p-7 hover:border-blue-500 hover:shadow-xl transition-all">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-5 group-hover:bg-blue-600 group-hover:text-white transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 11l3 3L22 4M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
                    </div>
                    <h4 class="font-black text-blue-950 text-xl mb-2">Kuis & Tantangan</h4>
                    <p class="text-slate-500 text-sm leading-relaxed mb-5">Kuis reguler, tantangan bulanan, hasil, riwayat, dan leaderboard.</p>
                    <span class="text-blue-600 text-sm font-bold">Mulai Kuis →</span>
                </a>
            </div>

            <div class="mt-8 bg-blue-950 rounded-[2rem] p-6 md:p-8 text-white" data-aos="fade-up">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 mb-6">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.3em] text-blue-100 mb-2">Alat Statistik</p>
                        <h4 class="text-2xl md:text-3xl font-black text-blue-300">Kalkulator, Visualisasi, dan Simulasi dalam satu menu</h4>
                        <p class="text-blue-100/90 text-sm mt-2 max-w-3xl">
                            Menu Tools sudah diubah menjadi Alat Statistik agar lebih jelas dan menyatu dengan layanan Datapedia.
                        </p>
                    </div>
                    <a href="{{ route('alat-statistik.index') }}" class="inline-flex items-center justify-center rounded-full bg-white text-blue-950 px-6 py-3 font-black hover:bg-blue-50 transition">
                        Buka Alat Statistik
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('kalkulator-statistik.index') }}" class="bg-white/10 border border-white/10 rounded-2xl p-5 font-bold hover:bg-white/20 transition">Kalkulator Statistik →</a>
                    <a href="{{ route('visualisasi.index') }}" class="bg-white/10 border border-white/10 rounded-2xl p-5 font-bold hover:bg-white/20 transition">Visualisasi Data →</a>
                    <a href="{{ route('simulasi.index') }}" class="bg-white/10 border border-white/10 rounded-2xl p-5 font-bold hover:bg-white/20 transition">Simulasi Statistik →</a>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section id="faq" class="up-section up-faq-section py-20 relative overflow-visible">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-100/50 blur-[120px] rounded-full"></div>
            <div class="absolute -bottom-24 -right-24 w-80 h-80 bg-indigo-100/50 blur-[120px] rounded-full"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10">

            <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 gap-4">
                <div class="space-y-1">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-[2px] bg-blue-600"></div>
                        <span class="text-blue-600 font-bold text-xs uppercase tracking-widest">
                            Informasi Publik
                        </span>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-black text-blue-900 leading-[1.1] tracking-tighter mb-6">
                        FAQ <span class="text-blue-500">Terpadu</span>
                    </h2>
                </div>

                <p class="text-slate-500 text-sm max-w-xs md:text-right border-l-2 md:border-l-0 md:border-r-2 border-blue-200 px-4 italic">
                    Temukan jawaban cepat atas pertanyaan yang sering diajukan mengenai layanan kami.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                @foreach ($faq as $item)

                <div x-data="{ open: false }" class="up-faq-item relative">

                   <div 
                        @mouseenter="open = true"
                        @mouseleave="open = false"
                        @click.outside="open = false"
                        @click="open = !open"

                        class="group relative rounded-2xl p-[1px] bg-gradient-to-br from-blue-200 via-white to-indigo-200 hover:from-blue-400 hover:to-indigo-400 transition-all duration-500 cursor-pointer"
                    >

                        <!-- INNER CARD -->
                        <div class="rounded-2xl bg-blue-100 border border-blue-100/70 p-6 transition-all duration-300 group-hover:bg-white group-hover:border-blue-200 group-hover:shadow-[0_12px_35px_rgba(37,99,235,0.10)]">

                            <div class="flex justify-between items-center gap-4">

                                <div class="flex items-center gap-4">
                                    <!-- ICON -->
                                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-md transition-all duration-300 group-hover:scale-110"
                                        :class="open ? 'scale-110 shadow-blue-400/50' : ''">
                                        <span class="text-white text-sm font-black">?</span>
                                    </div>

                                    <!-- TITLE -->
                                    <span class="font-semibold text-sm md:text-base text-slate-700 group-hover:text-blue-700 transition">
                                        {!! $item->judul !!}
                                    </span>

                                </div>

                                <!-- ICON + -->
                                <div class="relative w-5 h-5 transition-transform duration-300"
                                    :class="open ? 'rotate-180' : ''">
                                    <div class="absolute w-full h-0.5 bg-blue-600 top-1/2 -translate-y-1/2"></div>
                                    <div class="absolute h-full w-0.5 bg-blue-600 left-1/2 -translate-x-1/2" x-show="!open"></div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div 
                        x-show="open"
                        x-cloak
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 translate-y-3 scale-95"
                        class="absolute left-0 top-full mt-3 w-full z-50"
                    >

                        <div class="relative rounded-2xl bg-white border border-slate-200 shadow-[0_20px_50px_rgba(0,0,0,0.1)] p-6">

                            <div class="absolute -top-2 left-6 w-4 h-4 bg-white rotate-45 border-l border-t border-slate-200"></div>

                            <div class="prose prose-slate prose-sm max-w-none text-slate-600 leading-relaxed">
                                {!! $item->deskripsi !!}
                            </div>

                        </div>

                    </div>

                </div>

                @endforeach

            </div>

        </div>
    </section>

    {{-- Chatbot Toggle --}}
    <div x-data="{ open: false }" class="fixed bottom-6 right-6 z-50 flex gap-4 items-end flex-col md:flex-row">
        <div>
            <button
                id="chatbot-toggle"
                class="bg-gradient-to-br from-[#ffda6a] to-[#ffc107] rounded-full w-16 h-16 md:w-20 md:h-20 flex items-center justify-center shadow-2xl hover:scale-110 transition-all duration-300 relative group"
                style="box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 md:w-12 md:h-12 text-white group-hover:rotate-12 transition-transform duration-300" viewBox="0 0 64 64" fill="currentColor">
                    <g>
                        <rect x="20" y="16" width="24" height="32" rx="4" ry="4" fill="currentColor"/>
                        <circle cx="26" cy="28" r="4" fill="#ffffff"/>
                        <circle cx="38" cy="28" r="4" fill="#ffffff"/>
                        <rect x="28" y="36" width="8" height="4" rx="2" fill="#ffffff"/>
                        <rect x="30" y="8" width="4" height="8" rx="1" fill="currentColor"/>
                        <circle cx="32" cy="6" r="2" fill="currentColor"/>
                        <rect x="14" y="20" width="6" height="20" rx="2" fill="currentColor"/>
                        <rect x="44" y="20" width="6" height="20" rx="2" fill="currentColor"/>
                    </g>
                </svg>
                <div class="absolute bottom-full right-0 mb-2 px-3 py-1 bg-gray-800 text-white text-xs md:text-sm rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap pointer-events-none">
                    Buka Chatbot
                    <div class="absolute top-full right-4 w-0 h-0 border-l-4 border-r-4 border-t-4 border-transparent border-t-gray-800"></div>
                </div>
            </button>
        </div>

        {{-- <button
            @click="open = !open"
            class="bg-gradient-to-br from-[#a3c2f5] to-[#004B9A] rounded-full w-16 h-16 md:w-20 md:h-20 flex items-center justify-center shadow-2xl hover:scale-110 transition-all duration-300 relative group"
            style="box-shadow: 0 8px 32px rgba(0, 43, 106, 0.4);"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 md:w-12 md:h-12 text-white group-hover:rotate-12 transition-transform duration-300" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2a3 3 0 0 1 3 3 3 3 0 0 1-3 3 3 3 0 0 1-3-3 3 3 0 0 1 3-3M21 9v2a2 2 0 0 1-2 2h-1l-1.5 6h-2l1.3-5.4c-.4-.3-.9-.6-1.3-.6H9.5c-.4 0-.9.3-1.3.6L9.5 19h-2L6 13H5a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
            </svg>
            <div class="absolute bottom-full right-0 mb-2 px-3 py-1 bg-gray-800 text-white text-xs md:text-sm rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap pointer-events-none">
                Aksesibilitas
                <div class="absolute top-full right-4 w-0 h-0 border-l-4 border-r-4 border-t-4 border-transparent border-t-gray-800"></div>
            </div>
        </button> --}}

        {{-- <div
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 transform scale-95 translate-y-4"
            class="flex flex-col items-end space-y-3 mb-4"
        >
            <button onclick="adjustFontSize('increase')" class="px-4 py-3 rounded-xl text-sm bg-[#002B6A] text-white shadow hover:scale-105 transition">Perbesar Teks</button>
            <button onclick="adjustFontSize('decrease')" class="px-4 py-3 rounded-xl text-sm bg-[#002B6A] text-white shadow hover:scale-105 transition">Perkecil Teks</button>
            <button onclick="adjustFontSize('reset')" class="px-4 py-3 rounded-xl text-sm bg-[#002B6A] text-white shadow hover:scale-105 transition">Reset Teks</button>
            <button onclick="setCursorSize('medium')" class="hidden lg:flex px-4 py-3 rounded-xl text-sm bg-[#002B6A] text-white shadow hover:scale-105 transition">Cursor Sedang</button>
            <button onclick="setCursorSize('large')" class="hidden lg:flex px-4 py-3 rounded-xl text-sm bg-[#002B6A] text-white shadow hover:scale-105 transition">Cursor Besar</button>
            <button onclick="resetCursor('cursorSize')" class="hidden lg:flex px-4 py-3 rounded-xl text-sm bg-[#002B6A] text-white shadow hover:scale-105 transition">Reset Cursor</button>
        </div> --}}

        <div id="chatbot-container"
            class="rounded-xl overflow-hidden shadow-xl border"
            style="display: none; position: fixed; bottom: 120px; right: 20px; width: 90vw; max-width: 400px; height: 70vh; z-index: 9999;">
            <iframe src="http://localhost:8501" frameborder="0" style="width: 100%; height: 100%;"></iframe>
        </div>
    </div>

    {{-- Survey --}}    
    <section id="survey" class="up-section up-survey-section py-10">
        <div class="container mx-auto px-5 lg:px-6">
            <div class="max-w-6xl mx-auto">

                <div class="relative overflow-hidden rounded-[2rem] px-6 py-8 lg:px-10 lg:py-10 flex flex-col lg:flex-row items-center justify-between gap-6" style="background:linear-gradient(135deg,#1D4ED8,#002B6A)">
                    <div class="absolute top-0 right-0 w-56 h-56 bg-blue-400/10 blur-[70px] rounded-full -mr-16 -mt-16"></div>
                    <div class="relative z-10 w-full lg:max-w-[60%] text-center lg:text-left">
                        <h2 class="text-4xl lg:text-5xl font-black text-white leading-tight tracking-tight mb-3">Suara Anda Adalah<br><span class="text-blue-300 italic">Prioritas Kami</span></h2>
                        <p class="text-blue-100/80 text-sm lg:text-base leading-relaxed mb-5">Mutu layanan kami berkembang melalui suara Anda. Partisipasi Anda sangat berarti bagi peningkatan kualitas layanan statistik yang prima.</p>

                        @if($surveiLayananAktif)
                            <a href="{{ $surveiLayananAktif->link }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center justify-center bg-white text-[#002B6A] font-black px-8 py-5 rounded-xl hover:bg-blue-50 transition-all duration-300 shadow-lg shadow-black/10 uppercase tracking-[0.18em] text-[12px] hover:scale-[1.02]">
                                Isi Survei Sekarang
                            </a>
                        @else
                            <button type="button"
                                    disabled
                                    class="inline-flex items-center justify-center bg-white/70 text-[#002B6A]/60 font-black px-8 py-5 rounded-xl cursor-not-allowed shadow-lg shadow-black/10 uppercase tracking-[0.18em] text-[12px]">
                                Survei Belum Tersedia
                            </button>
                        @endif

                    </div>

                    <!-- Image -->
                    <div class="lg:w-1/3 relative z-10 flex justify-center">
                        <img 
                            src="{{ asset('image/survey.png') }}"
                            alt="Survey"
                            class="w-full max-w-[170px] lg:max-w-[220px] object-contain drop-shadow-[0_16px_35px_rgba(0,0,0,0.18)]"                        
                        >
                    </div>
                </div>
            </div>

        </div>
    </section>

</main>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // FAQ Pagination (Simplified)
        const faqItems = document.querySelectorAll('.faq-item');
        const faqPerPage = 5;
        let currentFaqPage = 1;

        function renderFaq() {
            faqItems.forEach((item, idx) => {
                item.style.display = (idx >= (currentFaqPage-1)*faqPerPage && idx < currentFaqPage*faqPerPage) ? 'block' : 'none';
            });
            updateFaqPagination();
        }

        function updateFaqPagination() {
            const total = Math.ceil(faqItems.length / faqPerPage);
            const container = document.getElementById('faq-pagination');
            if(total <= 1) return;
            container.innerHTML = '';
            for(let i=1; i<=total; i++) {
                const btn = document.createElement('button');
                btn.className = `w-10 h-10 rounded-full border-2 border-white/20 text-white font-bold transition-all ${i===currentFaqPage ? 'bg-white text-blue-900 border-white' : 'hover:bg-white/10'}`;
                btn.innerText = i;
                btn.onclick = () => { currentFaqPage = i; renderFaq(); };
                container.appendChild(btn);
            }
        }
        renderFaq();

        // Chatbot Toggle
        const btn = document.getElementById('chatbot-toggle');
        const box = document.getElementById('chatbot-container');
        btn.onclick = () => { box.classList.toggle('hidden'); };
    });

    // Stat Number Animation
    // function animateStats() {
    //     const stats = document.querySelectorAll('.stat-number');
    //     stats.forEach(stat => {
    //         const target = +stat.getAttribute('data-target');
    //         const update = () => {
    //             const current = +stat.innerText;
    //             const inc = target / 50;
    //             if(current < target) {
    //                 stat.innerText = Math.ceil(current + inc);
    //                 setTimeout(update, 20);
    //             } else {
    //                 stat.innerText = target;
    //             }
    //         }
    //         update();
    //     });
    // }

    // Intersection Observer for Stats
    const observer = new IntersectionObserver((entries) => {
        if(entries[0].isIntersecting) {
            animateStats();
            observer.disconnect();
        }
    }, { threshold: 0.5 });
    observer.observe(document.querySelector('#statistik'));
</script>

<script>
    const toggleBtn = document.getElementById('chatbot-toggle');
    const chatbotBox = document.getElementById('chatbot-container');

    toggleBtn.addEventListener('click', () => {
        chatbotBox.style.display = chatbotBox.style.display === 'none' ? 'block' : 'none';
    });    
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {

    const formatID = (num) => {
        return new Intl.NumberFormat('id-ID').format(num);
    };

    const counters = document.querySelectorAll('.stat-number');

    counters.forEach(el => {
        const target = parseInt(el.dataset.target) || 0;
        const display = el.querySelector('.value');

        if (!display) return;

        let start = 0;
        const duration = 1200; // ms
        const stepTime = 1000 / 60;
        const totalSteps = Math.round(duration / stepTime);
        let step = 0;

        const timer = setInterval(() => {

            step++;

            const progress = step / totalSteps;
            const value = Math.round(target * progress);

            display.innerText = formatID(value);

            if (step >= totalSteps) {
                display.innerText = formatID(target);
                clearInterval(timer);
            }

        }, stepTime);

    });

});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const slider = document.getElementById('service24Slider');
        if (!slider) return;

        let autoSlideTimer = null;
        const delay = 4500;

        function getSlideAmount() {
            const firstSlide = slider.querySelector('.service24-slide');
            if (!firstSlide) return 0;

            const sliderStyle = window.getComputedStyle(slider);
            const gap = parseFloat(sliderStyle.columnGap || sliderStyle.gap || 16);

            return firstSlide.offsetWidth + gap;
        }

        window.slideService24 = function (direction) {
            const amount = getSlideAmount();
            if (!amount) return;

            const maxScroll = slider.scrollWidth - slider.clientWidth;
            const isAtEnd = slider.scrollLeft >= maxScroll - 5;
            const isAtStart = slider.scrollLeft <= 5;

            if (direction === 'next') {
                if (isAtEnd) {
                    slider.scrollTo({
                        left: 0,
                        behavior: 'smooth'
                    });
                } else {
                    slider.scrollBy({
                        left: amount,
                        behavior: 'smooth'
                    });
                }
            }

            if (direction === 'prev') {
                if (isAtStart) {
                    slider.scrollTo({
                        left: maxScroll,
                        behavior: 'smooth'
                    });
                } else {
                    slider.scrollBy({
                        left: -amount,
                        behavior: 'smooth'
                    });
                }
            }
        };

        function startAutoSlide() {
            stopAutoSlide();

            autoSlideTimer = setInterval(function () {
                window.slideService24('next');
            }, delay);
        }

        function stopAutoSlide() {
            if (autoSlideTimer) {
                clearInterval(autoSlideTimer);
                autoSlideTimer = null;
            }
        }

        slider.addEventListener('mouseenter', stopAutoSlide);
        slider.addEventListener('mouseleave', startAutoSlide);

        slider.addEventListener('touchstart', stopAutoSlide, { passive: true });
        slider.addEventListener('touchend', startAutoSlide);

        window.addEventListener('resize', function () {
            slider.scrollTo({
                left: 0,
                behavior: 'auto'
            });
        });

        startAutoSlide();
    });
</script>

    <script src="https://cdn.jsdelivr.net/npm/sienna-accessibility@latest/dist/sienna-accessibility.umd.js" defer></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    
@endpush
@endsection