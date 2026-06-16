@extends('admin.layout')
@section('content')

<div class="w-full p-6 bg-gray-100">
    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-md overflow-hidden">

        {{-- Header --}}
        <div class="bg-blue-500 px-5 py-4">
            <h2 class="text-lg font-bold text-white">
                Kirim Link Zoom Janji Temu
            </h2>
            <p class="text-xs text-blue-100 mt-1">
                Masukkan link Zoom untuk dikirimkan ke WhatsApp pengguna.
            </p>
        </div>

        <div class="p-5">

            {{-- Info compact --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-5">
                <div class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-3">
                    <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wide">
                        Nama
                    </p>
                    <p class="text-sm font-bold text-gray-800 truncate mt-1">
                        {{ $janjiTemu->user->nama ?? '-' }}
                    </p>
                </div>

                <div class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-3">
                    <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wide">
                        Tanggal
                    </p>
                    <p class="text-sm font-bold text-gray-800 mt-1">
                        {{ $janjiTemu->tanggal ? \Carbon\Carbon::parse($janjiTemu->tanggal)->isoFormat('D MMM Y') : '-' }}
                    </p>
                </div>

                <div class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-3">
                    <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wide">
                        Jam
                    </p>
                    <p class="text-sm font-bold text-gray-800 mt-1">
                        {{ $janjiTemu->jam ? \Carbon\Carbon::parse($janjiTemu->jam)->format('H:i') : '-' }} WIB
                    </p>
                </div>
            </div>

            {{-- Form --}}
            <form action="{{ route('jadwal.kirimZoom', $janjiTemu->id) }}" method="POST">
                @csrf

                <label for="link_zoom" class="block text-sm font-semibold text-gray-700 mb-2">
                    Link Zoom <span class="text-red-500">*</span>
                </label>

                <div class="flex flex-col md:flex-row gap-3">
                    <input
                        type="url"
                        id="link_zoom"
                        name="link_zoom"
                        required
                        value="{{ old('link_zoom', $janjiTemu->zoom_link ?? '') }}"
                        placeholder="https://zoom.us/j/xxxxxx"
                        class="flex-1 border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-200 focus:border-blue-500 focus:outline-none"
                    >

                    <button
                        type="submit"
                        class="md:w-48 bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl text-sm font-bold transition">
                        Kirim WA
                    </button>
                </div>

                @error('link_zoom')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </form>

            {{-- Footer action --}}
            <div class="mt-5 pt-4 border-t border-gray-100 flex justify-end">
                <a href="{{ route('jadwal.index') }}"
                   class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-semibold">
                    Kembali
                </a>
            </div>

        </div>
    </div>
</div>

@endsection