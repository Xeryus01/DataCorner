<!-- Sidebar Navigation -->
<div class="lg:col-span-1">
  <div class="bg-white rounded-2xl shadow-xl">
    <div class="p-6">
      <h3 class="text-lg font-bold text-gray-900 mb-4">Menu Profil</h3>
      <nav class="space-y-2">
        <!-- Profil Saya - Active -->
        <a href="{{ route('profil.show', Auth::user()->slug) }}"
          class="flex items-center gap-3 px-4 py-3 {{ Route::is('profil.show') ? 'bg-primary text-white hover:bg-primary' : '' }} text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
          </svg>
          <span class="font-bold">Profil Saya</span>
        </a>

        <div class="collapse collapse-arrow text-gray-700 rounded-lg transition-colors duration-200">
          <input type="checkbox" />
          <div class="collapse-title flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
              </path>
            </svg>
            <span class="font-bold">Progres Belajar</span>
          </div>
          <div class="collapse">
            <a href="{{ route('profil.artikel', Auth::user()->slug) }}"
              class="flex items-center gap-3 pl-4 py-3 {{ Route::is('profil.artikel') ? 'bg-primary text-white hover:bg-primary' : '' }} text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200">
              <span class="font-bold">Artikel Dibaca</span>
            </a>
            <a href="{{ route('profil.video', Auth::user()->slug) }}"
              class="flex items-center gap-3 pl-4 py-3 {{ Route::is('profil.video') ? 'bg-primary text-white hover:bg-primary' : '' }} text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200">
              <span class="font-bold">Video Dilihat</span>
            </a>
            <div class="collapse collapse-arrow text-gray-700 rounded-lg transition-colors duration-200">
              <input type="checkbox" />
              <div class="collapse-title flex items-center gap-3">
                <span class="font-bold">Kuis Diselesaikan</span>
              </div>
              <div class="collapse">
                <a href="{{ route('profil.kuis-reguler', Auth::user()->slug) }}"
                  class="flex items-center gap-3 pl-4 py-3 {{ Route::is('profil.kuis-reguler') ? 'bg-primary text-white hover:bg-primary' : '' }} text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                  <span class="font-bold">Kuis Reguler</span>
                </a>
                <a href="{{ route('profil.kuis-tantangan', Auth::user()->slug) }}"
                  class="flex items-center gap-3 pl-4 py-3 {{ Route::is('profil.kuis-tantangan') ? 'bg-primary text-white hover:bg-primary' : '' }} text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                  <span class="font-bold">Kuis Tantangan Bulanan</span>
                </a>
              </div>
            </div>
          </div>
      </nav>
    </div>
  </div>
</div>
