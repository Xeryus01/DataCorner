<x-layout-web>
  <!-- Hero Section -->
  <section class="bg-primary text-white min-h-[60vh] flex items-center">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
      <div class="text-center">

        <h1 class="text-4xl md:text-6xl font-black mb-6 leading-tight">
          Kolaborasi Riset Mandiri
        </h1>

        <p class="text-lg md:text-xl text-blue-100 max-w-4xl mx-auto leading-relaxed font-semibold">
          Buka peluang kolaborasi penelitian bagi mahasiswa yang ingin mengembangkan skripsi atau karya ilmiah. Melalui
          program ini, kamu dapat bekerja sama untuk mendapatkan akses data dan bimbingan, serta menghasilkan riset yang
          bermanfaat secara akademik maupun praktis.
        </p>

        <!-- Scroll Indicator -->
        <div class="mt-12 animate-bounce">
          <svg class="w-6 h-6 mx-auto text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
          </svg>
        </div>
      </div>
    </div>
  </section>

  <!-- Main Content Section -->
  <section class="py-20 bg-[#EEF0F2] min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
      <div class="bg-white rounded-3xl p-6 lg:p-10 shadow-xl border border-slate-200">
        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-8">
          <div class="lg:max-w-3xl">
            <div class="inline-flex items-center rounded-full bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700 mb-4">
              <span class="mr-2">Program</span>
              <span class="rounded-full bg-blue-600 px-3 py-1 text-white">Riset Mandiri</span>
            </div>
            <h2 class="text-3xl lg:text-4xl font-black text-slate-900 mb-4">Kolaborasi Riset Mandiri</h2>
            <p class="text-lg text-slate-600 leading-relaxed">Buka peluang kolaborasi penelitian bagi mahasiswa yang ingin mengembangkan skripsi atau karya ilmiah. Program ini memberikan akses data, bimbingan ahli, dan hasil riset yang berdampak.</p>
          </div>
          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div class="rounded-3xl bg-gradient-to-br from-cyan-50 to-blue-100 p-6 shadow-sm border border-slate-200">
              <h3 class="text-xl font-bold text-slate-900 mb-3">Data Terpercaya</h3>
              <p class="text-slate-600">Akses data statistik resmi untuk mendukung riset berkualitas.</p>
            </div>
            <div class="rounded-3xl bg-gradient-to-br from-fuchsia-50 to-pink-100 p-6 shadow-sm border border-slate-200">
              <h3 class="text-xl font-bold text-slate-900 mb-3">Dukungan Akademik</h3>
              <p class="text-slate-600">Bimbingan dari tim ahli untuk memperkuat metodologi dan analisis riset.</p>
            </div>
          </div>
        </div>
      </div>

      <div class="grid gap-6 lg:grid-cols-2">
        <div class="bg-white rounded-3xl p-6 lg:p-10 shadow-xl border border-slate-200">
          <div class="flex items-center gap-4 mb-6">
            <div class="w-14 h-14 rounded-2xl bg-primary flex items-center justify-center text-white text-2xl">01</div>
            <div>
              <h3 class="text-2xl font-bold text-slate-900">Deskripsi Program</h3>
              <p class="text-slate-500 mt-1">Pelajari ruang lingkup dan tujuan riset yang bisa kamu capai bersama Datapedia.</p>
            </div>
          </div>
          <div class="prose lg:prose-lg max-w-none text-base lg:text-lg text-justify font-semibold text-slate-700">
            {!! $info->deskripsi !!}
          </div>
        </div>

        <div class="space-y-6">
          <div class="bg-white rounded-3xl p-6 lg:p-10 shadow-xl border border-slate-200">
            <div class="flex items-center gap-4 mb-6">
              <div class="w-14 h-14 rounded-2xl bg-button flex items-center justify-center text-white text-2xl">02</div>
              <div>
                <h3 class="text-2xl font-bold text-slate-900">Persyaratan</h3>
                <p class="text-slate-500 mt-1">Pastikan kamu memenuhi kriteria dan dokumen yang diperlukan.</p>
              </div>
            </div>
            <div class="prose lg:prose-lg max-w-none text-base lg:text-lg text-justify font-semibold text-slate-700">
              {!! $info->persyaratan !!}
            </div>
          </div>

          <div class="bg-white rounded-3xl p-6 lg:p-10 shadow-xl border border-slate-200">
            <div class="flex items-center gap-4 mb-6">
              <div class="w-14 h-14 rounded-2xl bg-purple-500 flex items-center justify-center text-white text-2xl">03</div>
              <div>
                <h3 class="text-2xl font-bold text-slate-900">Benefit</h3>
                <p class="text-slate-500 mt-1">Manfaat riset yang akan kamu peroleh selama berkolaborasi.</p>
              </div>
            </div>
            <div class="prose lg:prose-lg max-w-none text-base lg:text-lg text-justify font-semibold text-slate-700">
              {!! $info->benefit !!}
            </div>
          </div>
        </div>
      </div>

      <div class="bg-gradient-to-r from-orange-50 to-red-50 rounded-3xl p-8 lg:p-12 shadow-xl border border-orange-200">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
          <div>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-orange-700">Info Kontak</p>
            <p class="mt-3 text-lg lg:text-xl font-semibold text-slate-900">Hubungi tim riset untuk mendiskusikan peluang kolaborasi dan dukungan data.</p>
          </div>
          <div class="prose lg:prose-lg max-w-2xl text-base font-semibold text-slate-800">
            {!! $info->info_kontak !!}
          </div>
        </div>
      </div>

      <div class="bg-primary rounded-3xl p-8 lg:p-12 shadow-xl text-white">
        <div class="max-w-4xl mx-auto text-center space-y-6">
          <h3 class="text-3xl lg:text-4xl font-black">Gabung Sekarang</h3>
          <p class="text-lg text-blue-100">Lengkapi pendaftaran riset mandiri dan wujudkan karya ilmiah yang bermutu bersama Datapedia.</p>
          <div class="grid gap-4 md:grid-cols-2">
            <a href="{{ route('daftar-riset.index') }}" class="rounded-3xl bg-orange-500 px-6 py-4 font-bold hover:bg-orange-600 transition">Daftar Sekarang</a>
            <a href="{{ route('program-riset.arsipKarya') }}" class="rounded-3xl bg-white text-primary px-6 py-4 font-bold hover:bg-slate-100 transition">Lihat Arsip Karya</a>
          </div>
        </div>
      </div>

      <section class="rounded-3xl bg-white p-8 lg:p-12 shadow-xl border border-slate-200">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8">
          <div>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-slate-400">Cara Bergabung</p>
            <h3 class="text-3xl font-bold text-slate-900 mt-3">Langkah Mudah Kolaborasi Riset</h3>
          </div>
          <p class="text-slate-600 max-w-2xl">Mendaftarkan risetmu sekarang dan mulai proses kerja sama dengan tim ahli serta data resmi.</p>
        </div>
        <div class="grid gap-6 md:grid-cols-4">
          <div class="rounded-3xl border border-slate-200 p-6 text-center">
            <div class="mb-4 inline-flex items-center justify-center w-14 h-14 rounded-full bg-blue-50 text-blue-700 mx-auto">1</div>
            <h4 class="text-lg font-semibold mb-2">Daftar</h4>
            <p class="text-sm text-slate-600">Ajukan proposal atau topik risetmu melalui formulir pendaftaran.</p>
          </div>
          <div class="rounded-3xl border border-slate-200 p-6 text-center">
            <div class="mb-4 inline-flex items-center justify-center w-14 h-14 rounded-full bg-cyan-50 text-cyan-700 mx-auto">2</div>
            <h4 class="text-lg font-semibold mb-2">Seleksi</h4>
            <p class="text-sm text-slate-600">Tim akan menilai kelayakan riset dan kesiapan data.</p>
          </div>
          <div class="rounded-3xl border border-slate-200 p-6 text-center">
            <div class="mb-4 inline-flex items-center justify-center w-14 h-14 rounded-full bg-amber-50 text-amber-700 mx-auto">3</div>
            <h4 class="text-lg font-semibold mb-2">Kolaborasi</h4>
            <p class="text-sm text-slate-600">Bekerja sama dengan mentor dan akses data resmi untuk risetmu.</p>
          </div>
          <div class="rounded-3xl border border-slate-200 p-6 text-center">
            <div class="mb-4 inline-flex items-center justify-center w-14 h-14 rounded-full bg-lime-50 text-lime-700 mx-auto">4</div>
            <h4 class="text-lg font-semibold mb-2">Publikasi</h4>
            <p class="text-sm text-slate-600">Hasil risetmu siap dipresentasikan dan dibagikan untuk manfaat akademik.</p>
          </div>
        </div>
      </section>
    </div>
  </section>
</x-layout-web>
