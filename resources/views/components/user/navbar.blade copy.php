s{{-- ============================================================
     NAVBAR DATAPEDIA
     Layout & gaya mengacu pada index.html, dengan logo & fungsi
     asli tetap dipertahankan. Dropdown desktop hover/click,
     mobile accordion dengan animasi slide.
============================================================ --}}
<nav id="navbar" class="nav">
    <div class="nav-inner">

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="nav-brand" style="text-decoration:none;color:inherit;">
            <div class="nav-brand-logo">
                <img src="{{ asset('image/logo-pst.png') }}" alt="Datapedia"
                     style="width:100%;height:100%;object-fit:contain;padding:3px;">
            </div>
            <div class="nav-brand-text">
                <h1>DATA<span>PEDIA</span></h1>
                <p>BPS Prov. Kepulauan Bangka Belitung</p>
            </div>
        </a>

        {{-- Desktop Links --}}
        <ul class="nav-links">
            <li><a href="{{ route('tentang') }}" class="nav-link-item">Tentang</a></li>
            <li><a href="{{ url('/') }}#layanan" class="nav-link-item">Layanan</a></li>
            <li><a href="{{ url('/') }}#konsultasi" class="nav-link-item">Akses</a></li>

            {{-- Dropdown: Literasi Statistik --}}
            <li class="nav-dropdown">
                <button class="nav-link-item nav-dropdown-toggle" type="button" aria-haspopup="true" aria-expanded="false">
                    Literasi Statistik
                    <svg class="nav-chevron" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <div class="nav-dropdown-menu">
                    <a href="{{ route('konten-edukasi.index') }}" class="nav-dropdown-link">Edukasi</a>
                    <a href="{{ route('alat-statistik.index') }}" class="nav-dropdown-link">Alat Statistik</a>
                    <a href="{{ route('kuis-tantangan.index') }}" class="nav-dropdown-link">Kuis</a>
                </div>
            </li>

            {{-- Dropdown: Magang dan Riset --}}
            <li class="nav-dropdown">
                <button class="nav-link-item nav-dropdown-toggle" type="button" aria-haspopup="true" aria-expanded="false">
                    Magang dan Riset
                    <svg class="nav-chevron" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <div class="nav-dropdown-menu">
                    <a href="{{ route('program-magang.index') }}" class="nav-dropdown-link">Magang BPS</a>
                    <a href="{{ route('program-riset.index') }}" class="nav-dropdown-link">Riset Bersama</a>
                </div>
            </li>

            @if(session('login_user') && session('user_id'))
                <li><a href="{{ route('profile.index') }}" class="nav-link-item">Profil</a></li>
            @endif

            {{-- Auth Button --}}
            <li class="nav-auth-desktop">
                @if(session('login_user') && session('user_id'))
                    <form action="{{ route('logoutUser') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="nav-cta nav-cta-logout">Logout</button>
                    </form>
                @else
                    <a href="{{ route('loginUser') }}" class="nav-cta">Login</a>
                @endif
            </li>
        </ul>

        {{-- Hamburger --}}
        <button class="nav-hamburger" id="navToggle" aria-label="Menu" aria-expanded="false" aria-controls="navMobile">
            <svg id="hamburgerIcon" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    {{-- Mobile Menu --}}
    <div class="nav-mobile" id="navMobile">
        <a href="{{ route('tentang') }}" class="nav-mobile-link">Tentang</a>
        <a href="{{ url('/') }}#layanan" class="nav-mobile-link">Layanan</a>
        <a href="{{ url('/') }}#konsultasi" class="nav-mobile-link">Akses</a>

        {{-- Mobile Accordion: Literasi Statistik --}}
        <div class="mobile-accordion">
            <button class="nav-mobile-link mobile-accordion-toggle" type="button" aria-expanded="false">
                <span>Literasi Statistik</span>
                <svg class="mobile-chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </button>
            <div class="mobile-submenu">
                <a href="{{ route('konten-edukasi.index') }}" class="nav-mobile-link mobile-submenu-link">Edukasi</a>
                <a href="{{ route('alat-statistik.index') }}" class="nav-mobile-link mobile-submenu-link">Alat Statistik</a>
                <a href="{{ route('kuis-tantangan.index') }}" class="nav-mobile-link mobile-submenu-link">Kuis</a>
            </div>
        </div>

        {{-- Mobile Accordion: Magang dan Riset --}}
        <div class="mobile-accordion">
            <button class="nav-mobile-link mobile-accordion-toggle" type="button" aria-expanded="false">
                <span>Magang dan Riset</span>
                <svg class="mobile-chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </button>
            <div class="mobile-submenu">
                <a href="{{ route('program-magang.index') }}" class="nav-mobile-link mobile-submenu-link">Magang BPS</a>
                <a href="{{ route('program-riset.index') }}" class="nav-mobile-link mobile-submenu-link">Riset Bersama</a>
            </div>
        </div>

        @if(session('login_user') && session('user_id'))
            <a href="{{ route('profile.index') }}" class="nav-mobile-link">Profil</a>
            <form action="{{ route('logoutUser') }}" method="POST" style="padding:0.25rem 0.5rem;">
                @csrf
                <button type="submit" class="nav-mobile-link" style="width:100%;background:rgba(239,68,68,.15);border:1px solid rgba(239,68,68,.4);color:#fca5a5;border-radius:.5rem;font-weight:700;text-align:center;">Logout</button>
            </form>
        @else
            <a href="{{ route('loginUser') }}" class="nav-mobile-link" style="color:var(--sky-lt);font-weight:700;">Login →</a>
        @endif
    </div>
</nav>

<script>
    // =========================================================
    // MOBILE MENU TOGGLE
    // =========================================================
    (function() {
        const navToggle = document.getElementById('navToggle');
        const navMobile = document.getElementById('navMobile');
        const hamburgerIcon = document.getElementById('hamburgerIcon');

        function openMenu() {
            navMobile.classList.add('open');
            navToggle.setAttribute('aria-expanded', 'true');
            if (hamburgerIcon) {
                hamburgerIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>';
            }
        }

        function closeMenu() {
            navMobile.classList.remove('open');
            navToggle.setAttribute('aria-expanded', 'false');
            if (hamburgerIcon) {
                hamburgerIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>';
            }
        }

        navToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            navMobile.classList.contains('open') ? closeMenu() : openMenu();
        });

        // Close on outside click
        document.addEventListener('click', function(e) {
            if (navMobile.classList.contains('open') &&
                !navMobile.contains(e.target) &&
                !navToggle.contains(e.target)) {
                closeMenu();
            }
        });

        // =========================================================
        // MOBILE ACCORDION
        // =========================================================
        document.querySelectorAll('.mobile-accordion-toggle').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const accordion = this.closest('.mobile-accordion');
                const isOpen = accordion.classList.contains('open');

                // Close all others
                document.querySelectorAll('.mobile-accordion.open').forEach(function(other) {
                    if (other !== accordion) {
                        other.classList.remove('open');
                        other.querySelector('.mobile-accordion-toggle').setAttribute('aria-expanded', 'false');
                    }
                });

                if (isOpen) {
                    accordion.classList.remove('open');
                    this.setAttribute('aria-expanded', 'false');
                } else {
                    accordion.classList.add('open');
                    this.setAttribute('aria-expanded', 'true');
                }
            });
        });

        // Close mobile menu when a submenu link is clicked
        document.querySelectorAll('.mobile-submenu-link').forEach(function(link) {
            link.addEventListener('click', function() {
                closeMenu();
            });
        });

        // Close mobile menu when any direct mobile link is clicked (except accordion toggles)
        navMobile.querySelectorAll('.nav-mobile-link:not(.mobile-accordion-toggle)').forEach(function(link) {
            link.addEventListener('click', function() {
                closeMenu();
            });
        });
    })();

    // =========================================================
    // DESKTOP DROPDOWN (click toggle for touch + accessibility)
    // =========================================================
    (function() {
        if (window.matchMedia('(min-width: 768px)').matches) {
            document.querySelectorAll('.nav-dropdown-toggle').forEach(function(toggle) {
                toggle.addEventListener('click', function(e) {
                    const dropdown = this.closest('.nav-dropdown');
                    const wasOpen = dropdown.classList.contains('open');

                    // Close all
                    document.querySelectorAll('.nav-dropdown.open').forEach(function(d) {
                        d.classList.remove('open');
                        var b = d.querySelector('.nav-dropdown-toggle');
                        if (b) b.setAttribute('aria-expanded', 'false');
                    });

                    if (!wasOpen) {
                        dropdown.classList.add('open');
                        this.setAttribute('aria-expanded', 'true');
                    }
                    e.preventDefault();
                    e.stopPropagation();
                });
            });

            // Close desktop dropdowns on outside click
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.nav-dropdown')) {
                    document.querySelectorAll('.nav-dropdown.open').forEach(function(d) {
                        d.classList.remove('open');
                        var b = d.querySelector('.nav-dropdown-toggle');
                        if (b) b.setAttribute('aria-expanded', 'false');
                    });
                }
            });
        }
    })();
</script>