<!-- HERO -->
<section id="home" class="hero">
  <div class="floating-orb orb-1"></div><div class="floating-orb orb-2"></div><div class="floating-orb orb-3"></div>
  <div class="hero-inner">
    <div>
      <div class="hero-badge fade-up"><div class="hero-badge-dot"></div>Layanan Aktif {{ date('Y') }}</div>
      <h1 class="hero-title fade-up fade-up-2">DATA<span style="color:#60A5FA">PEDIA</span></h1>
      <p class="hero-subtitle fade-up fade-up-2">Pelayanan Statistik Terpadu<br><em>BPS Provinsi Kepulauan Bangka Belitung</em></p>
      <p class="hero-desc fade-up fade-up-3">Akses data resmi, layanan konsultasi, dan informasi statistik dalam satu portal yang cepat dan mudah. Datapedia hadir mendukung pelayanan publik dan kebutuhan riset Anda.</p>
      <div class="hero-btns fade-up fade-up-4">
        <a href="#layanan" class="btn-primary-hero"><svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>Jelajahi Layanan</a>
        @if(session('login_user') && session('user_id'))
            <a href="{{ route('konsultasi.index') }}" class="btn-secondary-hero"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.46 1.33 4.97L2 22l5.25-1.38a9.86 9.86 0 004.79 1.22h.01c5.46 0 9.91-4.45 9.91-9.91S17.5 2 12.04 2z"/></svg>Hubungi Kami</a>
        @else
            <a href="{{ route('loginUser') }}" class="btn-secondary-hero"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.46 1.33 4.97L2 22l5.25-1.38a9.86 9.86 0 004.79 1.22h.01c5.46 0 9.91-4.45 9.91-9.91S17.5 2 12.04 2z"/></svg>Hubungi Kami</a>
        @endif
      </div>
    </div>
    <div class="hero-cards fade-up fade-up-3">
      <div class="hero-card-main">
        <div class="hero-card-logo-img"><img src="{{ asset('image/logo-pst.png') }}" alt="Logo" style="width:100%;height:100%;object-fit:contain;padding:4px"></div>
        <h2>&#8220;Siap Membantu Anda&#8221;</h2>
        <p>Kerja Amanah &middot; Melayani dengan Ramah</p>
        <div class="hero-card-tags"><span>Responsive</span><span>Adaptive</span><span>Measurable</span><span>Akuntabel</span><span>Harmonis</span></div>
      </div>
      <div class="hero-card-hours">
        <div class="hero-card-hours-header"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg><span>Jam Layanan</span></div>
        @forelse ($jamOperasional ?? [] as $jam)
        <div class="hours-row">
            <!-- <span class="hours-day">{{ $jam->keterangan_hari }}</span>
            <span class="hours-time @if($jam->isTutup()) hours-closed @endif">
                @if($jam->isTutup())
                    @if($jam->keterangan_hari == 'Sabtu - Minggu') Tutup
                    @else Sesuai janji temu
                    @endif
                @else
                    {{ \Carbon\Carbon::parse($jam->jam_mulai)->format('H.i') }} &ndash; {{ \Carbon\Carbon::parse($jam->jam_selesai)->format('H.i') }}
                @endif
            </span> -->

            @if($jam->isTutup())
                <span class="hours-day">Di luar hari kerja</span>
                <span class="hours-time @if($jam->isTutup()) hours-closed @endif">
                        Sesuai janji temu
                </span>
            @else
                <span class="hours-day">{{ $jam->keterangan_hari }}</span>
                <span class="hours-time @if($jam->isTutup()) hours-closed @endif">
                    {{ \Carbon\Carbon::parse($jam->jam_mulai)->format('H.i') }} &ndash; {{ \Carbon\Carbon::parse($jam->jam_selesai)->format('H.i') }}
                </span>
            @endif

        </div>
        @empty
        <div class="hours-row"><span class="hours-day">Senin &ndash; Kamis</span><span class="hours-time">08.00 &ndash; 16.00</span></div>
        <div class="hours-row"><span class="hours-day">Jumat</span><span class="hours-time">08.00 &ndash; 16.30</span></div>
        <div class="hours-row"><span class="hours-day">Sabtu &ndash; Minggu</span><span class="hours-time hours-closed">Tutup</span></div>
        @endforelse
        <div class="hero-hours-note">&#10024; Tanpa Jeda Pelayanan</div>
      </div>
    </div>
  </div>
</section>