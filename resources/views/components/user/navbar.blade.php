<nav id="navbar" class="site-navbar navbar-sticky glass-nav">
    <div class="site-navbar-container">
        <div class="site-navbar-row">

            {{-- Logo Section --}}
            <a href="{{ url('/') }}" class="site-navbar-brand" style="text-decoration: none; color: inherit;">
                <div class="site-navbar-logo">
                    <img src="{{ asset('image/logo-pst.png') }}" alt="Datapedia Logo">
                </div>

                <div class="site-navbar-text">
                    <h1 class="site-navbar-title">
                        DATA<span>PEDIA</span>
                    </h1>
                    <p class="site-navbar-tagline">
                        BPS Provinsi Kepulauan Bangka Belitung
                    </p>
                </div>
            </a>

            {{-- Desktop Navigation --}}
            <div class="site-navbar-desktop">
                <nav class="site-navbar-menu">
                    <a href="{{ route('tentang') }}" class="site-navbar-link">
                        Tentang
                    </a>

                    <a href="{{ url('/') }}#layanan" class="site-navbar-link">
                        Layanan
                    </a>
                    
                    <a href="{{ url('/') }}#konsultasi" class="site-navbar-link">
                        Akses
                    </a>

                    <a href="{{ route('konten-edukasi.index') }}" class="site-navbar-link">
                        Edukasi
                    </a>

                    <a href="{{ route('alat-statistik.index') }}" class="site-navbar-link">
                        Alat Statistik
                    </a>

                    <a href="{{ route('kuis-tantangan.index') }}" class="site-navbar-link">
                        Kuis
                    </a>

                    <a href="{{ route('program-magang.index') }}" class="site-navbar-link">
                        Magang
                    </a>

                    <a href="{{ route('program-riset.index') }}" class="site-navbar-link">
                        Riset
                    </a>

                    @if(session('login_user') && session('user_id'))
                        <a href="{{ route('profile.index') }}" class="site-navbar-link">
                            Profil
                        </a>
                    @endif
                </nav>

                <div class="site-navbar-auth">
                    @if(session('login_user') && session('user_id'))
                        <form action="{{ route('logoutUser') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="site-navbar-logout" onmouseenter="speakOnHover(this)">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('loginUser') }}" class="site-navbar-login">
                            Login
                        </a>
                    @endif
                </div>
            </div>

            {{-- Mobile Menu Button --}}
            <div class="site-navbar-mobile-toggle-wrap">
                <button id="mobile-menu-btn" class="site-navbar-mobile-btn" type="button" aria-label="Buka menu navigasi" aria-expanded="false" aria-controls="mobile-menu">
                    <svg id="menu-icon" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Menu Container --}}
        <div id="mobile-menu" class="hidden site-navbar-mobile-panel">
            <div class="site-navbar-mobile-card">
                <div class="site-navbar-mobile-list">
                    <a href="{{ route('tentang') }}" class="site-navbar-mobile-link">
                        Tentang
                    </a>
                    <a href="{{ url('/') }}#layanan" class="site-navbar-mobile-link">
                        Layanan
                    </a>
                    <a href="{{ url('/') }}#konsultasi" class="site-navbar-mobile-link">
                        Akses
                    </a>
                    <a href="{{ route('konten-edukasi.index') }}" class="site-navbar-mobile-link">
                        Edukasi
                    </a>
                    <a href="{{ route('alat-statistik.index') }}" class="site-navbar-mobile-link">
                        Alat Statistik
                    </a>
                    <a href="{{ route('kuis-tantangan.index') }}" class="site-navbar-mobile-link">
                        Kuis
                    </a>
                    <a href="{{ route('program-magang.index') }}" class="site-navbar-mobile-link">
                        Magang
                    </a>
                    <a href="{{ route('program-riset.index') }}" class="site-navbar-mobile-link">
                        Riset
                    </a>

                    <div class="site-navbar-mobile-divider border-t border-white/10 my-3"></div>

                    @if(session('login_user') && session('user_id'))
                        <a href="{{ route('profile.index') }}" class="site-navbar-mobile-link">
                            Profil
                        </a>
                        <form action="{{ route('logoutUser') }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" class="site-navbar-mobile-logout">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('loginUser') }}" class="site-navbar-mobile-link">
                            Login
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    // Minimal fallback toggle to ensure mobile menu works even if bundled JS didn't attach yet
    function toggleMobileMenu(e) {
        if (e && e.stopPropagation) e.stopPropagation();
        const menu = document.getElementById('mobile-menu');
        const btn = document.getElementById('mobile-menu-btn');
        const svg = document.getElementById('menu-icon');
        if (!menu || !btn || !svg) return;

        const isOpen = menu.classList.toggle('open');
        btn.setAttribute('aria-expanded', String(isOpen));
        console.log('[mobile-menu] toggleMobileMenu ->', isOpen);

        const path = svg.querySelector('path');
        if (path) {
            if (isOpen) path.setAttribute('d', 'M6 18L18 6M6 6l12 12');
            else path.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
        }
    }
</script>
