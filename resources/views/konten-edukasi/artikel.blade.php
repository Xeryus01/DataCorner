<x-layout-web>
  <section class="w-full px-4 lg:px-36 py-16">
    <h1 class="text-2xl lg:text-5xl mb-20 font-bold text-center">{{ $artikel->judul }}</h1>
    @foreach ($artikel->subjudul_artikel as $sub)
      <h1 class="text-lg lg:text-3xl text-orange-400 font-bold">{{ $sub->sub_judul }}</h1>

      @foreach ($sub->detail_sub_judul_artikel as $d)
        <div class="flex flex-col items-center my-4 gap-7">
          <div class="prose lg:prose-lg max-w-none text-base lg:text-lg text-justify font-semibold">
            {!! $d->konten_text !!}
          </div>
          {!! $d->link_embed !!}
          <img src="{{ asset('storage/' . $d->gambar) }}" alt="" class="w-full lg:w-1/2">
        </div>
      @endforeach
    @endforeach

  </section>
  <x-footer class="fill-[#EEF0F2]" />
</x-layout-web>
