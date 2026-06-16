<!-- Navigation Bar -->
<nav class="sticky top-0 z-50 bg-white px-6 py-4 border-b">
  <div class="container mx-auto flex items-center justify-between">
    <!-- Logo -->
    <div class="flex items-center justify-center gap-3">
      <img src="{{ asset('/gambar/logo-bps.jpg') }}" alt="" class="w-14">
      <div class="flex flex-col">
        <h1 class="text-base lg:text-lg font-extrabold text-primary tracking-tighter">Pojok Literasi</h1>
        <h1 class="text-xl lg:text-2xl font-extrabold text-primary tracking-wide md:tracking-tight">Statistik</h1>
      </div>
    </div>
    <!-- Mobile Menu Button (Hamburger) -->
    <div class="md:hidden">
      <button onclick="toggleMobileMenu()" class="text-gray-500 hover:text-orange-500 focus:outline-none">
        <svg id="hamburger-icon" xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
        <svg id="close-icon" xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 hidden" fill="none"
          viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>

    <!-- Desktop Navigation Links -->
    <div class="hidden space-x-4 lg:space-x-5 md:flex">
      <a href="{{ route('home') }}"
        class="bg-white hover:bg-gray-100 flex px-4 py-2 text-base text-slate-700 font-medium rounded-md">Home</a>
      <div class="dropdown dropdown-hover">
        <div tabindex="0" role="button"
          class="bg-white hover:bg-gray-100 flex gap-1 pl-4 pr-2 py-2 text-base text-slate-700 font-medium rounded-md">
          Konten
          Edukasi
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f">
            <path d="M480-344 240-584l56-56 184 184 184-184 56 56-240 240Z" />
          </svg>
        </div>
        <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-md">
          <li class="text-sm text-slate-700 font-medium mb-2 pl-3 border-b border-gray-400 py-2">Pilih Topik</li>
          @foreach ($semua_subjek_materi as $item)
            <li><a href="{{ route('konten-edukasi.show', $item->slug) }}">{{ $item->judul }}</a></li>
          @endforeach
        </ul>
      </div>
      <div class="dropdown dropdown-hover">
        <div tabindex="0" role="button"
          class="bg-white hover:bg-gray-100 flex gap-1 pl-4 pr-2 py-2 text-base text-slate-700 font-medium rounded-md">
          Alat
          Interaktif
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f">
            <path d="M480-344 240-584l56-56 184 184 184-184 56 56-240 240Z" />
          </svg>
        </div>
        <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-md">
          <li><a href="{{ route('kalkulator-statistik.index') }}">Kalkulator Statistik</a></li>
          <li><a href="{{ route('visualisasi.index') }}">Visualisasi Data</a></li>
          <li><a href="{{ route('simulasi.index') }}">Simulasi Statistik</a></li>
        </ul>
      </div>
      <a href="{{ route('kuis-tantangan.index') }}"
        class="bg-white hover:bg-gray-100 flex px-4 py-2 text-base text-slate-700 font-medium rounded-md">Kuis &
        Tantangan</a>
      <div class="dropdown dropdown-hover">
        <div tabindex="0" role="button"
          class="bg-white hover:bg-gray-100 flex gap-1 pl-4 pr-2 py-2 text-base text-slate-700 font-medium rounded-md">
          Magang dan Riset
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f">
            <path d="M480-344 240-584l56-56 184 184 184-184 56 56-240 240Z" />
          </svg>
        </div>
        <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-md">
          <li><a href="{{ route('program-magang.index') }}">Program Magang</a></li>
          <li><a href="{{ route('program-riset.index') }}">Kolaborasi Riset Mandiri</a></li>
        </ul>
      </div>
    </div>

    <!-- Sign Up Button (Desktop) -->
    @if (Auth::check())
      @if (Auth::user()->foto)
        {{-- Jika user punya foto upload --}}
        <div class="hidden lg:block">
          <div class="dropdown dropdown-end">
            <div tabindex="0" role="button"
              class="flex items-center gap-2 border border-gray-400 rounded-md px-2 py-1">
              <img src="{{ asset('storage/' . Auth::user()->foto) }}" class="w-7 h-7 rounded-full">
              <p class="text-sm text-slate-700 font-medium">
                {{ collect(explode(' ', Auth::user()->name))->take(2)->implode(' ') }}</p>
            </div>
            <ul tabindex="0"
              class="dropdown-content menu bg-white hover:bg-gray-100 rounded-box z-1 w-52 p-2 shadow-sm border border-gray-200">
              <li><a href="{{ route('profil.show', Auth::user()->slug) }}">Profil</a></li>
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <li>
                  <button type="submit">Logout</button>
                </li>
              </form>
            </ul>
          </div>
        </div>
      @else
        {{-- Gunakan laravolt avatar jika tidak ada foto --}}
        <div class="hidden lg:block">
          <div class="dropdown dropdown-end">
            <div tabindex="0" role="button"
              class="flex items-center gap-2 border border-gray-400 rounded-md px-2 py-1">
              <img src="{{ Avatar::create(Auth::user()->name)->toBase64() }}" class="w-7 h-7 rounded-full">
              <p class="text-sm text-slate-700 font-medium">
                {{ collect(explode(' ', Auth::user()->name))->take(2)->implode(' ') }}</p>
            </div>
            <ul tabindex="0"
              class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-sm border border-gray-200">
              <li><a href="{{ route('profil.show', Auth::user()->slug) }}">Profil</a></li>
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <li>
                  <button type="submit" class="text-red-600 hover:bg-red-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none"
                      viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Logout
                  </button>
                </li>
              </form>
            </ul>
          </div>
        </div>
      @endif
    @else
      <div class="hidden md:block">
        <a href="{{ route('login') }}">
          <button class="rounded-md bg-button hover:bg-[#02a66b] px-4 py-2 font-medium text-white">Login</button>
        </a>
      </div>
    @endif
  </div>
</nav>

<!-- Mobile Sidebar Overlay -->
<div id="mobile-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden"></div>

<!-- Mobile Sidebar -->
<div id="mobile-sidebar"
  class="fixed top-0 left-0 h-full w-80 bg-white shadow-lg transform -translate-x-full transition-transform duration-300 ease-in-out z-50 md:hidden overflow-y-auto">
  <div class="p-4">
    <!-- Sidebar Header -->
    <div class="mb-6 pb-4 flex items-center justify-start gap-3 border-b border-gray-200">
      <img src="{{ asset('/gambar/logo-bps.jpg') }}" alt="" class="w-16">
      <div class="flex flex-col">
        <h1 class="text-lg lg:text-xl font-extrabold text-primary tracking-tighter">Pojok Literasi</h1>
        <h1 class="text-2xl lg:text-3xl font-extrabold text-primary tracking-wide md:tracking-tight">Statistik</h1>
      </div>
    </div>

    <!-- Mobile Menu Items -->
    <div class="space-y-2">
      <!-- Home -->
      <a href="{{ route('home') }}"
        class="block w-full text-left px-4 py-3 text-slate-700 font-medium hover:bg-gray-100 rounded-md transition-colors">
        Home
      </a>

      <!-- Konten Edukasi -->
      <div class="w-full">
        <button onclick="toggleSubmenu('konten-submenu')"
          class="flex items-center justify-between w-full px-4 py-3 text-slate-700 font-medium hover:bg-gray-100 rounded-md transition-colors">
          <span>Konten Edukasi</span>
          <svg id="konten-arrow" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform transition-transform"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>
        <div id="konten-submenu" class="hidden ml-4 mt-2 space-y-1">
          <div class="text-sm text-slate-600 font-medium mb-2 pl-3 border-b border-gray-300 py-2">Pilih Topik</div>
          @foreach ($semua_subjek_materi as $item)
            <a href="{{ route('konten-edukasi.show', $item->slug) }}"
              class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 rounded-md">{{ $item->judul }}</a>
          @endforeach
        </div>
      </div>

      <!-- Alat Interaktif -->
      <div class="w-full">
        <button onclick="toggleSubmenu('alat-submenu')"
          class="flex items-center justify-between w-full px-4 py-3 text-slate-700 font-medium hover:bg-gray-100 rounded-md transition-colors">
          <span>Alat Interaktif</span>
          <svg id="alat-arrow" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform transition-transform"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>
        <div id="alat-submenu" class="hidden ml-4 mt-2 space-y-1">
          <a href="{{ route('kalkulator-statistik.index') }}"
            class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 rounded-md">Kalkulator
            Statistik</a>
          <a href="{{ route('visualisasi.index') }}"
            class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 rounded-md">Visualisasi
            Data</a>
          <a href="{{ route('simulasi.index') }}"
            class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 rounded-md">Simulasi
            Statistik</a>
        </div>
      </div>

      <!-- Kuis & Tantangan -->
      <a href="{{ route('kuis-tantangan.index') }}"
        class="block w-full text-left px-4 py-3 text-slate-700 font-medium hover:bg-gray-100 rounded-md transition-colors">
        Kuis & Tantangan
      </a>


      <!-- Magang dan Riset -->
      <div class="w-full">
        <button onclick="toggleSubmenu('magang-submenu')"
          class="flex items-center justify-between w-full px-4 py-3 text-slate-700 font-medium hover:bg-gray-100 rounded-md transition-colors">
          <span>Magang dan Riset</span>
          <svg id="magang-arrow" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform transition-transform"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>
        <div id="magang-submenu" class="hidden ml-4 mt-2 space-y-1">
          <a href="{{ route('program-magang.index') }}"
            class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 rounded-md">Program Magang</a>
          <a href="{{ route('program-riset.index') }}"
            class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 rounded-md">Kolaborasi Riset Mandiri</a>
        </div>
      </div>
    </div>



    <!-- Mobile Authentication Section -->
    <div class="mt-6 pt-4 border-t border-gray-200">
      @if (Auth::check())
        <!-- User Profile Section -->
        <div class="mb-4">
          <div class="flex items-center gap-3 px-4 py-3 bg-gray-50 rounded-md">
            @if (Auth::user()->foto)
              <img src="{{ asset('storage/' . Auth::user()->foto) }}" class="w-10 h-10 rounded-full">
            @else
              <img src="{{ Avatar::create(Auth::user()->name)->toBase64() }}" class="w-10 h-10 rounded-full">
            @endif
            <div class="flex-1">
              <p class="text-sm text-slate-700 font-medium">{{ Auth::user()->name }}</p>
              <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
            </div>
          </div>
          <div class="mt-3 space-y-2">
            <a href="{{ route('profil.show', Auth::user()->slug) }}"
              class="flex items-center w-full px-4 py-2 text-left text-slate-700 hover:bg-gray-100 rounded-md transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
              Profil
            </a>
            <form action="{{ route('logout') }}" method="POST" class="w-full">
              @csrf
              <button type="submit"
                class="w-full flex items-center px-4 py-2 text-left text-red-600 hover:bg-red-50 rounded-md transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-2" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Logout
              </button>
            </form>
          </div>
        </div>
      @else
        <!-- Login Button -->
        <a href="{{ route('login') }}" class="block w-full">
          <button
            class="w-full rounded-md bg-button hover:bg-[#02a66b] px-4 py-3 font-medium text-white transition-colors">
            Login
          </button>
        </a>
      @endif
    </div>
  </div>
</div>

<script>
  function toggleMobileMenu() {
    const sidebar = document.getElementById('mobile-sidebar');
    const overlay = document.getElementById('mobile-overlay');
    const hamburgerIcon = document.getElementById('hamburger-icon');
    const closeIcon = document.getElementById('close-icon');

    sidebar.classList.toggle('-translate-x-full');
    overlay.classList.toggle('hidden');
    hamburgerIcon.classList.toggle('hidden');
    closeIcon.classList.toggle('hidden');
  }

  function toggleSubmenu(submenuId) {
    const submenu = document.getElementById(submenuId);
    const arrow = document.getElementById(submenuId.replace('-submenu', '-arrow'));

    submenu.classList.toggle('hidden');
    arrow.classList.toggle('rotate-180');
  }

  // Close sidebar when clicking overlay
  document.getElementById('mobile-overlay').addEventListener('click', function() {
    toggleMobileMenu();
  });

  // Close sidebar when pressing Escape key
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      const sidebar = document.getElementById('mobile-sidebar');
      if (!sidebar.classList.contains('-translate-x-full')) {
        toggleMobileMenu();
      }
    }
  });
</script>
