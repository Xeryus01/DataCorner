<x-layout-web>
  <!-- Hero Section -->
  <section class="bg-primary text-white min-h-[60vh] flex items-center">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
      <div class="text-center">

        <h1 class="text-4xl md:text-6xl font-black mb-6 leading-tight">
          Magang
        </h1>

        <p class="text-lg md:text-xl text-blue-100 max-w-4xl mx-auto leading-relaxed font-semibold">
          Dapatkan pengalaman kerja nyata dan kembangkan keterampilan profesionalmu melalui program magang kami.
          Belajar langsung dari para ahli, berkontribusi pada proyek-proyek inovatif, dan persiapkan dirimu untuk
          karier yang cemerlang.
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
    <!-- Program Description -->
    <div class="bg-white rounded-3xl p-6 lg:p-10 shadow-xl mx-4 sm:mx-6 lg:mx-28 space-y-6 max-w-7xl mx-auto">
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div class="flex items-center gap-4">
          <div class="w-12 h-12 bg-primary rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <div>
            <h3 class="text-2xl font-bold text-gray-900">Deskripsi Program</h3>
            <p class="text-sm text-gray-500 mt-1">Informasi lengkap mengenai kesempatan magang dan pengalaman profesional yang kamu dapatkan.</p>
          </div>
        </div>
        <div class="inline-flex items-center rounded-full bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700">
          <span class="mr-2">Program</span>
          <span class="rounded-full bg-blue-600 px-3 py-1 text-white">Magang Datapedia</span>
        </div>
      </div>
      <div class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-2xl p-6 border-l-4 border-blue-500">
        <div class="prose lg:prose-lg max-w-none text-base lg:text-lg text-justify font-semibold">
          {!! $info->deskripsi !!}
        </div>
      </div>
      <div class="flex items-center gap-4 mb-6">
        <div class="w-12 h-12 bg-button rounded-xl flex items-center justify-center">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-900">Persyaratan</h3>
      </div>
      <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl p-6 border-l-4 border-green-500">
        <div class="prose lg:prose-lg max-w-none text-base lg:text-lg text-justify font-semibold">
          {!! $info->persyaratan !!}
        </div>
      </div>
      <div class="flex items-center gap-4 mb-6">
        <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
          </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-900">Benefit</h3>
      </div>
      <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-2xl p-6 border-l-4 border-purple-500">
        <div class="prose lg:prose-lg max-w-none text-base lg:text-lg text-justify font-semibold">
          {!! $info->benefit !!}
        </div>
      </div>
      <div class="flex items-center gap-4 mb-6">
        <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
          </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-900">Info Kontak</h3>
      </div>
      <div class="bg-gradient-to-r from-orange-50 to-red-50 rounded-2xl p-6 border-l-4 border-orange-500">
        <div class="prose lg:prose-lg max-w-none text-base lg:text-lg text-justify font-semibold">
          {!! $info->info_kontak !!}
        </div>
      </div>
    </div>

<div class="bg-primary mt-10 rounded-2xl p-8 text-white text-center flex flex-col gap-8 mx-4 sm:mx-6 lg:mx-28">
      <p class="text-blue-100 text-lg font-semibold max-w-2xl mx-auto">
        Jangan lewatkan kesempatan ini untuk mengembangkan karir dan memperluas jaringan profesional Anda!
      </p>
      <a href="{{ route('daftar-magang.index') }}">
        <button
          class="bg-orange-500 w-full hover:bg-orange-600 text-white font-bold py-4 px-8 rounded-xl flex items-center justify-center max-w-xl mx-auto">
          Daftar Sekarang
        </button>
      </a>
      <div class="w-full max-w-xl mx-auto flex flex-col md:flex-row gap-4">
        @if ($sertifikat)
          <a href="{{ Storage::url($sertifikat) }}" class="flex-1" target="_blank">
            <button
              class="bg-button w-full hover:bg-[#02a66b] text-white font-bold py-4 px-8 rounded-xl flex items-center justify-center">
              Unduh Sertifikat Anda
            </button>
          </a>
        @endif
        <a href="{{ route('program-magang.arsipKarya') }}" class="flex-1">
          <button
            class="bg-button w-full hover:bg-[#02a66b] text-white font-bold py-4 px-8 rounded-xl flex items-center justify-center">
            Arsip Karya Magang
          </button>
        </a>
      </div>
    </div>

    <section class="mt-16 mx-4 sm:mx-6 lg:mx-28">
      <div class="max-w-7xl mx-auto grid gap-6 lg:grid-cols-3">
        <div class="bg-white rounded-3xl p-8 shadow-lg border border-slate-200">
          <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-blue-50 text-blue-700 mb-6">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8c-1.11 0-2.08.402-2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <h4 class="text-xl font-bold mb-3">Mentor Profesional</h4>
          <p class="text-gray-600 leading-relaxed">Bekerja langsung bersama tim ahli dengan pengalaman di bidang statistik dan data.</p>
        </div>

        <div class="bg-white rounded-3xl p-8 shadow-lg border border-slate-200">
          <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-cyan-50 text-cyan-700 mb-6">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5 13l4 4L19 7" />
            </svg>
          </div>
          <h4 class="text-xl font-bold mb-3">Proyek Nyata</h4>
          <p class="text-gray-600 leading-relaxed">Ikut serta dalam proyek yang berdampak, bukan hanya teori, dan kembangkan portofolio yang kuat.</p>
        </div>

        <div class="bg-white rounded-3xl p-8 shadow-lg border border-slate-200">
          <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-amber-50 text-amber-700 mb-6">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m7 4v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6" />
            </svg>
          </div>
          <h4 class="text-xl font-bold mb-3">Sertifikat Resmi</h4>
          <p class="text-gray-600 leading-relaxed">Dapatkan sertifikat resmi yang bisa kamu tunjukkan kepada calon pemberi kerja.</p>
        </div>
      </div>
    </section>

    <section class="mt-16 mx-4 sm:mx-6 lg:mx-28 mb-24">
      <div class="max-w-7xl mx-auto bg-white rounded-3xl p-8 shadow-xl border border-slate-200">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8">
          <div>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-slate-400">Alur Pendaftaran</p>
            <h3 class="text-3xl font-bold text-slate-900 mt-3">Langkah Mudah Menuju Magang</h3>
          </div>
          <p class="text-slate-600 max-w-2xl">Ajukan sekarang, ikuti seleksi, dan mulai pengembangan kemampuanmu dengan dukungan penuh dari Datapedia.</p>
        </div>

        <div class="grid gap-6 md:grid-cols-4">
          <div class="rounded-3xl border border-slate-200 p-6 text-center">
            <div class="mb-4 inline-flex items-center justify-center w-14 h-14 rounded-full bg-blue-50 text-blue-700 mx-auto">
              1
            </div>
            <h4 class="text-lg font-semibold mb-2">Daftar</h4>
            <p class="text-sm text-slate-600">Isi formulir magang dan kirim data diri lengkap.</p>
          </div>
          <div class="rounded-3xl border border-slate-200 p-6 text-center">
            <div class="mb-4 inline-flex items-center justify-center w-14 h-14 rounded-full bg-cyan-50 text-cyan-700 mx-auto">
              2
            </div>
            <h4 class="text-lg font-semibold mb-2">Seleksi</h4>
            <p class="text-sm text-slate-600">Tim kami memproses pendaftaran dan memilih kandidat terbaik.</p>
          </div>
          <div class="rounded-3xl border border-slate-200 p-6 text-center">
            <div class="mb-4 inline-flex items-center justify-center w-14 h-14 rounded-full bg-amber-50 text-amber-700 mx-auto">
              3
            </div>
            <h4 class="text-lg font-semibold mb-2">Magang</h4>
            <p class="text-sm text-slate-600">Kamu akan bekerja pada tugas nyata dengan mentor berpengalaman.</p>
          </div>
          <div class="rounded-3xl border border-slate-200 p-6 text-center">
            <div class="mb-4 inline-flex items-center justify-center w-14 h-14 rounded-full bg-lime-50 text-lime-700 mx-auto">
              4
            </div>
            <h4 class="text-lg font-semibold mb-2">Sertifikat</h4>
            <p class="text-sm text-slate-600">Setelah selesai, terima sertifikat dan rekomendasi untuk karir berikutnya.</p>
          </div>
        </div>
      </div>
    </section>
  </section>
</x-layout-web>
