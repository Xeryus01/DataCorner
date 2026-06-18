<section id="home" class="gradient-hero relative overflow-hidden pt-12 sm:pt-16 lg:pt-6">
    <!-- Floating Orbs -->
    <div class="floating-orb orb-1 opacity-40 sm:opacity-100"></div>
    <div class="floating-orb orb-2 opacity-40 sm:opacity-100"></div>
    <div class="floating-orb orb-3 opacity-40 sm:opacity-100"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-0 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center lg:min-h-screen">
            <!-- LEFT -->
            <div class="animate-fadeInUp space-y-5 text-center lg:text-left">
                <div>
                    <h1 class="hero-title text-3xl sm:text-4xl md:text-5xl lg:text-7xl">DATAPEDIA</h1>
                    <h2 class="hero-subtitle mt-3 text-lg sm:text-xl md:text-2xl lg:text-3xl">
                        <span class="block">Pelayanan Statistik Terpadu</span>
                        <span class="hero-subtitle-accent">BPS Provinsi Kepulauan Bangka Belitung</span>
                    </h2>
                    <p class="hero-description mt-3 text-base sm:text-lg md:text-xl max-w-xl mx-auto lg:mx-0 text-slate-100 leading-relaxed">
                        Akses data resmi, layanan konsultasi, dan informasi statistik dalam satu portal yang cepat dan mudah digunakan.
                        Datapedia hadir untuk mendukung pelayanan publik dan kebutuhan riset Anda.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center lg:justify-start">
                    @if(session('login_user') && session('user_id'))
                        <a href="{{ route('konsultasi.index') }}" class="btn-modern inline-flex items-center justify-center gap-2 px-5 sm:px-6 py-3 rounded-xl text-white font-semibold group text-sm sm:text-base leading-none">
                            <svg class="w-6 h-6 shrink-0 text-white group-hover:text-[#25D366] group-hover:scale-110 transition-all duration-300" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.46 1.33 4.97L2 22l5.25-1.38a9.86 9.86 0 0 0 4.79 1.22h.01c5.46 0 9.91-4.45 9.91-9.91S17.5 2 12.04 2Zm0 18.16h-.01a8.18 8.18 0 0 1-4.17-1.14l-.3-.18-3.12.82.83-3.04-.2-.31a8.2 8.2 0 0 1-1.26-4.4c0-4.54 3.7-8.23 8.24-8.23a8.2 8.2 0 0 1 8.23 8.24c0 4.54-3.7 8.24-8.24 8.24Zm4.51-6.16c-.25-.12-1.46-.72-1.69-.8-.23-.08-.39-.12-.56.12-.16.25-.64.8-.78.96-.14.16-.29.18-.54.06-.25-.12-1.05-.39-2-1.23-.74-.66-1.24-1.48-1.38-1.73-.14-.25-.02-.38.11-.5.11-.11.25-.29.37-.43.12-.14.16-.25.25-.41.08-.16.04-.31-.02-.43-.06-.12-.56-1.35-.77-1.85-.2-.48-.41-.42-.56-.43h-.48c-.16 0-.43.06-.66.31-.23.25-.87.85-.87 2.08s.89 2.41 1.02 2.58c.12.16 1.76 2.69 4.27 3.77.6.26 1.07.41 1.43.52.6.19 1.15.16 1.58.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.08.15-1.18-.06-.1-.23-.16-.48-.29Z"/>
                            </svg>
                            <span class="leading-none">Hubungi Kami</span>
                        </a>
                    @else
                        <button onclick="showLoginAlert()" class="btn-modern inline-flex items-center justify-center gap-2 px-5 sm:px-6 py-3 rounded-xl text-white font-semibold group text-sm sm:text-base leading-none">
                            <svg class="w-6 h-6 shrink-0 text-white group-hover:text-[#25D366] group-hover:scale-110 transition-all duration-300" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.46 1.33 4.97L2 22l5.25-1.38a9.86 9.86 0 0 0 4.79 1.22h.01c5.46 0 9.91-4.45 9.91-9.91S17.5 2 12.04 2Zm0 18.16h-.01a8.18 8.18 0 0 1-4.17-1.14l-.3-.18-3.12.82.83-3.04-.2-.31a8.2 8.2 0 0 1-1.26-4.4c0-4.54 3.7-8.23 8.24-8.23a8.2 8.2 0 0 1 8.23 8.24c0 4.54-3.7 8.24-8.24 8.24Zm4.51-6.16c-.25-.12-1.46-.72-1.69-.8-.23-.08-.39-.12-.56.12-.16.25-.64.8-.78.96-.14.16-.29.18-.54.06-.25-.12-1.05-.39-2-1.23-.74-.66-1.24-1.48-1.38-1.73-.14-.25-.02-.38.11-.5.11-.11.25-.29.37-.43.12-.14.16-.25.25-.41.08-.16.04-.31-.02-.43-.06-.12-.56-1.35-.77-1.85-.2-.48-.41-.42-.56-.43h-.48c-.16 0-.43.06-.66.31-.23.25-.87.85-.87 2.08s.89 2.41 1.02 2.58c.12.16 1.76 2.69 4.27 3.77.6.26 1.07.41 1.43.52.6.19 1.15.16 1.58.1.48-.07 1.46-.6 1.67-1.18.21-.58.21-1.08.15-1.18-.06-.1-.23-.16-.48-.29Z"/>
                            </svg>
                            <span class="leading-none">Hubungi Kami</span>
                        </button>
                    @endif
                </div>
            </div>

            <!-- RIGHT -->
            <div class="animate-slideInRight flex justify-center">
                <div class="w-full max-w-xs sm:max-w-sm md:max-w-md lg:max-w-xs space-y-4">
                    <!-- CARD 1 -->
                    <div class="hero-info-card text-center hover:scale-[1.01] transition bg-blue-800 text-white rounded-xl p-4 max-w-xs mx-auto shadow-lg space-y-3">
                        <img class="w-24 sm:w-26 md:w-28 mx-auto object-contain" src="{{ asset('image/logo-pst.png') }}" alt="Datapedia Logo">
                        <div class="space-y-1">
                            <span class="font-black text-blue-300 text-[12px] font-semibold tracking-wider uppercase block">"Siap Membantu Anda"</span>
                            <h2 class="font-extrabold text-base uppercase leading-tight tracking-wide">
                                Kerja Amanah Melayani<br>Dengan <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-300 to-white font-black">Ramah</span>
                            </h2>
                        </div>
                        <div class="pt-1 border-t border-white/10 text-[8px] font-bold text-blue-200 uppercase flex justify-center gap-x-1 gap-y-0.5 flex-wrap whitespace-nowrap">
                            <span>Responsive</span><span class="text-cyan-400">•</span>
                            <span>Adaptive</span><span class="text-cyan-400">•</span>
                            <span>Measurable</span><span class="text-cyan-400">•</span>
                            <span>Akuntabel</span><span class="text-cyan-400">•</span>
                            <span>Harmonis</span>
                        </div>
                    </div>

                    <!-- CARD 2 -->
                    <div class="relative group">
                        <div class="absolute inset-0 bg-blue-900/20 blur-xl rounded-2xl"></div>
                        <div class="hero-panel p-4 flex flex-col gap-3 transition hover:scale-[1.01]">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center justify-center w-10 h-10 bg-white/15 border border-white/20 rounded-full">
                                    <svg class="w-5 h-5 text-blue-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-white">Jam Layanan</h3>
                            </div>
                            <div class="space-y-2 text-xs">
                                @forelse ($jamOperasional as $jam)
                                    <div class="hero-schedule-row">
                                        <span class="hero-schedule-label">
                                            @if($jam->keterangan_hari = "Sabtu - Minggu") Di luar jam kerja
                                            @else {{$jam->keterangan_hari}} - {{ \Carbon\Carbon::parse($jam->jam_selesai)->format('H.i') }}
                                            @endif
                                        </span>
                                        <span class="hero-schedule-time">
                                            @if($jam->isTutup()) Sesuai
                                            @else {{ \Carbon\Carbon::parse($jam->jam_mulai)->format('H.i') }} - {{ \Carbon\Carbon::parse($jam->jam_selesai)->format('H.i') }}
                                            @endif
                                        </span>
                                    </div>
                                @empty
                                    <div class="hero-schedule-label"><p>Informasi belum tersedia</p></div>
                                @endforelse
                                <div class="pt-2 border-t border-white/15 text-center"><p class="hero-schedule-label italic">✨ Tanpa Jeda Pelayanan</p></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 h-16 sm:h-20 bg-gradient-to-t from-primary to-transparent"></div>
</section>