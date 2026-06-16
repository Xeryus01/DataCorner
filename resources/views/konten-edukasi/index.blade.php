<x-layout-web>
  <section class="relative overflow-hidden bg-[#071218] text-white">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(56,189,248,0.25),transparent_25%)]"></div>
    <div class="relative max-w-6xl mx-auto px-6 py-16 md:py-20">
      <p class="text-xs font-black tracking-[0.35em] uppercase text-cyan-300 mb-4">DATAPEDIA EDUKASI STATISTIK</p>
      <h1 class="text-4xl md:text-5xl lg:text-6xl font-black leading-tight text-white">Konten Edukasi Statistik yang Jelas dan Mudah Diikuti</h1>
      <p class="mt-6 max-w-3xl text-base md:text-lg text-slate-300 leading-8 font-medium">Pelajari statistik lewat artikel terstruktur, video pembelajaran, dan infografis yang dibuat untuk membantu kamu memahami konsep dengan cepat.</p>

      <div class="mt-10 flex flex-col gap-4 sm:flex-row sm:items-center">
        <a href="#subjek" class="inline-flex items-center justify-center rounded-full bg-cyan-500 px-7 py-3 text-sm font-semibold text-white shadow-lg shadow-cyan-500/20 hover:bg-cyan-400 transition">Jelajahi Topik</a>
        <span class="inline-flex items-center rounded-full border border-white/20 bg-white/10 px-5 py-3 text-sm font-semibold text-slate-100">{{ $subjek_materi->count() }} Topik</span>
      </div>

      <div class="mt-12 grid gap-4 sm:grid-cols-3">
        <div class="rounded-3xl border border-slate-800 bg-slate-950/90 p-6 shadow-xl shadow-slate-950/20">
          <p class="text-sm uppercase tracking-[0.35em] text-cyan-300 mb-3">Topik</p>
          <h2 class="text-3xl font-black text-white">{{ $subjek_materi->count() }}</h2>
          <p class="mt-3 text-sm text-slate-300 leading-relaxed font-medium">Jumlah topik edukasi statistik yang bisa kamu akses di halaman ini.</p>
        </div>
        <div class="rounded-3xl border border-slate-800 bg-slate-950/90 p-6 shadow-xl shadow-slate-950/20">
          <p class="text-sm uppercase tracking-[0.35em] text-cyan-300 mb-3">Konten</p>
          <h2 class="text-3xl font-black text-white">Artikel + Video</h2>
          <p class="mt-3 text-sm text-slate-300 leading-relaxed font-medium">Belajar lewat teks, visual, dan grafik yang ringkas.</p>
        </div>
        <div class="rounded-3xl border border-slate-800 bg-slate-950/90 p-6 shadow-xl shadow-slate-950/20">
          <p class="text-sm uppercase tracking-[0.35em] text-cyan-300 mb-3">Akses</p>
          <h2 class="text-3xl font-black text-white">Mudah</h2>
          <p class="mt-3 text-sm text-slate-300 leading-relaxed font-medium">Semua materi tersedia langsung tanpa perlu mencari berulang.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="max-w-7xl mx-auto px-6 py-14">
    <div class="flex flex-col gap-10 lg:flex-row lg:items-center lg:justify-between mb-10">
      <div class="max-w-3xl">
        <p class="text-xs font-black tracking-[0.35em] uppercase text-slate-400 mb-3">Mulai dari sini</p>
        <h2 class="text-3xl md:text-4xl font-black text-slate-900">Ringkas, tegas, dan fokus pada pembelajaran statistik</h2>
        <p class="mt-4 max-w-2xl text-base text-slate-600 leading-8 font-medium">Pilih topik yang kamu butuhkan, lalu jelajahi konten belajar yang dirancang agar mudah dibaca dan cepat dipahami.</p>
      </div>
      <div class="grid grid-cols-2 gap-3 sm:grid-cols-2">
        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5 text-center shadow-sm">
          <p class="text-xs uppercase tracking-[0.35em] text-slate-400">Artikel</p>
          <p class="mt-3 text-lg font-bold text-slate-900">Terstruktur</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5 text-center shadow-sm">
          <p class="text-xs uppercase tracking-[0.35em] text-slate-400">Video</p>
          <p class="mt-3 text-lg font-bold text-slate-900">Visual</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5 text-center shadow-sm">
          <p class="text-xs uppercase tracking-[0.35em] text-slate-400">Infografis</p>
          <p class="mt-3 text-lg font-bold text-slate-900">Ringkas</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5 text-center shadow-sm">
          <p class="text-xs uppercase tracking-[0.35em] text-slate-400">Latihan</p>
          <p class="mt-3 text-lg font-bold text-slate-900">Praktis</p>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3" id="subjek">
      @forelse($subjek_materi as $item)
        <a href="{{ route('konten-edukasi.show', $item->slug) }}" class="group block overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
          @if(!empty($item->gambar))
            <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="h-56 w-full object-cover transition duration-300 group-hover:scale-105" />
          @else
            <div class="flex h-56 items-center justify-center bg-slate-100 text-slate-700 font-black">DATAPEDIA</div>
          @endif
          <div class="p-6">
            <h3 class="text-2xl font-extrabold text-slate-900 mb-3 group-hover:text-cyan-600">{{ $item->judul }}</h3>
            <p class="text-sm text-slate-600 leading-relaxed font-medium">{{ Str::limit($item->deskripsi ?? 'Materi edukasi statistik Datapedia.', 130) }}</p>
            <div class="mt-6 flex items-center justify-between text-sm font-semibold text-blue-600">
              <span>Pelajari materi</span>
              <span class="transition group-hover:translate-x-1">→</span>
            </div>
          </div>
        </a>
      @empty
        <div class="md:col-span-2 lg:col-span-3 mx-auto max-w-2xl rounded-3xl bg-blue-50 p-10 text-center border border-blue-100 shadow-sm">
          <h2 class="text-2xl font-black text-blue-950">Belum ada konten edukasi.</h2>
          <p class="mt-3 text-slate-600 font-medium">Silakan tambahkan topik baru pada admin untuk menampilkan materi di halaman ini.</p>
        </div>
      @endforelse
    </div>
  </section>
</x-layout-web>
