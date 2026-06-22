{{-- NAVBAR v2 --}}
<nav id="navbar" class="nav navbar-scrolled" x-data="{ mobileOpen: false, openDropdown: null, toggleDropdown(key) { this.openDropdown = this.openDropdown === key ? null : key; } }" @click.outside="openDropdown = null; mobileOpen = false">
  <div class="nav-inner">
    <a href="{{ url('/') }}" class="nav-brand">
      <div class="nav-brand-logo"><img src="{{ asset('image/logo-pst.png') }}" alt="Datapedia" style="width:100%;height:100%;object-fit:contain;padding:3px"></div>
      <div class="nav-brand-text"><h1>DATA<span>PEDIA</span></h1><p>BPS Prov. Kepulauan Bangka Belitung</p></div>
    </a>
    <ul class="nav-links">
      <li><a href="{{ route('tentang') }}" class="nav-link-item">Tentang</a></li>
      <li><a href="{{ url('/') }}#layanan" class="nav-link-item">Layanan</a></li>
      <li><a href="{{ url('/') }}#konsultasi" class="nav-link-item">Akses</a></li>
      <li class="nav-dropdown" :class="{ 'open': openDropdown === 'literasi' }">
        <button class="nav-link-item nav-dropdown-toggle" type="button" @click.prevent="toggleDropdown('literasi')">Literasi Statistik <svg class="nav-chevron" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg></button>
        <div class="nav-dropdown-menu"><a href="{{ route('konten-edukasi.index') }}" class="nav-dropdown-link">Edukasi</a><a href="{{ route('alat-statistik.index') }}" class="nav-dropdown-link">Alat Statistik</a><a href="{{ route('kuis-tantangan.index') }}" class="nav-dropdown-link">Kuis</a></div>
      </li>
      <li class="nav-dropdown" :class="{ 'open': openDropdown === 'magang' }">
        <button class="nav-link-item nav-dropdown-toggle" type="button" @click.prevent="toggleDropdown('magang')">Magang & Riset <svg class="nav-chevron" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg></button>
        <div class="nav-dropdown-menu"><a href="{{ route('program-magang.index') }}" class="nav-dropdown-link">Magang BPS</a><a href="{{ route('program-riset.index') }}" class="nav-dropdown-link">Riset Bersama</a></div>
      </li>
      @if(session('login_user') && session('user_id'))<li><a href="{{ route('profile.index') }}" class="nav-link-item">Profil</a></li>@endif
      <li class="nav-auth-desktop">
        @if(session('login_user') && session('user_id'))
          <form action="{{ route('logoutUser') }}" method="POST" style="display:inline">
            @csrf
            <button type="submit" class="nav-cta-logout">
              <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
              Logout
            </button>
          </form>
        @else
          <a href="{{ route('loginUser') }}" class="nav-cta">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
            Login
          </a>
        @endif
      </li>
    </ul>
    <button class="nav-hamburger" aria-label="Menu" @click="mobileOpen = !mobileOpen">
      <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" :d="mobileOpen ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'"/>
      </svg>
    </button>
  </div>
  <div class="nav-mobile" :class="{ 'open': mobileOpen }">
    <a href="{{ route('tentang') }}" class="nav-mobile-link">Tentang</a>
    <a href="{{ url('/') }}#layanan" class="nav-mobile-link">Layanan</a>
    <a href="{{ url('/') }}#konsultasi" class="nav-mobile-link">Akses</a>
    <div class="mobile-accordion" :class="{ 'open': openDropdown === 'm-literasi' }">
      <button class="nav-mobile-link mobile-accordion-toggle" type="button" @click="toggleDropdown('m-literasi')"><span>Literasi Statistik</span><svg class="mobile-chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg></button>
      <div class="mobile-submenu"><a href="{{ route('konten-edukasi.index') }}" class="nav-mobile-link" style="font-size:.82rem">Edukasi</a><a href="{{ route('alat-statistik.index') }}" class="nav-mobile-link" style="font-size:.82rem">Alat Statistik</a><a href="{{ route('kuis-tantangan.index') }}" class="nav-mobile-link" style="font-size:.82rem">Kuis</a></div>
    </div>
    <div class="mobile-accordion" :class="{ 'open': openDropdown === 'm-magang' }">
      <button class="nav-mobile-link mobile-accordion-toggle" type="button" @click="toggleDropdown('m-magang')"><span>Magang & Riset</span><svg class="mobile-chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg></button>
      <div class="mobile-submenu"><a href="{{ route('program-magang.index') }}" class="nav-mobile-link" style="font-size:.82rem">Magang BPS</a><a href="{{ route('program-riset.index') }}" class="nav-mobile-link" style="font-size:.82rem">Riset Bersama</a></div>
    </div>
    @if(session('login_user') && session('user_id'))
      <a href="{{ route('profile.index') }}" class="nav-mobile-link">Profil</a>
      <form action="{{ route('logoutUser') }}" method="POST" style="margin-top:4px">
        @csrf
        <button type="submit" class="nav-mobile-cta-logout">
          <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
          Logout
        </button>
      </form>
    @else
      <a href="{{ route('loginUser') }}" class="nav-mobile-cta" style="margin-top:4px">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
        Login
      </a>
    @endif
  </div>
</nav>
