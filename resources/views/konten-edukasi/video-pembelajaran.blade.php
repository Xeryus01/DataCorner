<x-layout-web>
  <section class="w-full px-5 py-5 lg:px-36 lg:py-16">
    <h1 class="text-2xl font-bold mb-4">{{ $video->judul }}</h1>
    <p class="mb-4 text-justify">{{ $video->deskripsi }}</p>
    <iframe src="{{ $video->embed_link }}" class="w-full aspect-video" frameborder="0" allowfullscreen></iframe>

  </section>
  <x-footer class="fill-[#EEF0F2]" />
</x-layout-web>
