<x-layout-web>
  <section class="w-full flex px-4 md:px-8 lg:px-10 py-16 bg-[#EEF0F2] min-h-screen">
    <div class="max-w-7xl mx-auto w-full">
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Profil Saya</h1>
        <p class="text-gray-600">Lihat dan kelola informasi akun Anda</p>
      </div>

      <!-- Main Content Grid -->
      <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Sidebar Navigation -->
        <x-user.sidebar />


        <!-- Main Profile Content -->
        <div class="lg:col-span-3">
          <!-- Main Profile Card -->
          <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Profile Header Section -->
            <div class="relative bg-primary px-8 py-5">
              <h1 class="text-2xl text-white md:text-3xl font-bold mb-2">Video Dilihat</h1>
            </div>

            <!-- Profile Details -->
            <div class="p-8">
              <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($videoDilihat as $dilihat)
                  <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden flex flex-col">
                    <img src="{{ $dilihat->video->thumbnail }}" alt=""
                      class="aspect-video object-cover w-full" />

                    <div class="p-4 flex flex-col flex-grow">
                      <h3 class="text-sm font-semibold text-gray-900 mb-1">
                        {{ $dilihat->video->judul }}
                      </h3>
                      <p class="text-xs text-gray-600 flex-grow">
                        {{ Str::limit($dilihat->video->deskripsi, 80, '...') }}
                      </p>

                      <a href="{{ route('konten-edukasi.showVideo', ['subjek_slug' => $dilihat->video->subjek_materi->slug, 'slug' => $dilihat->video->slug]) }}"
                        class="mt-3 inline-block text-center bg-button hover:bg-[#02a66b] text-white text-xs font-semibold py-2 px-4 rounded-md">
                        Lihat Video
                      </a>
                    </div>
                  </div>
                @empty
                  <p class="text-sm text-gray-500 col-span-full">Belum ada video yang dilihat.</p>
                @endforelse
              </div>
            </div>
            {{ $videoDilihat->links('vendor.pagination.custom') }}
          </div>
        </div>
      </div>
    </div>
    </div>
  </section>

  <x-footer class="fill-[#EEF0F2]" />

</x-layout-web>
