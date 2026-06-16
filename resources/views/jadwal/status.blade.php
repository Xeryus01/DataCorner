@extends('jadwal.layout') {{-- disamakan layout-nya --}}
@section('content')
<div class="w-full p-6 bg-gray-100">
    <div class="w-full bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-blue-400 p-4">
            <h2 class="text-xl font-bold text-blue-800">Status Ketersediaan Konsultan</h2>
        </div>

        <div class="p-6">
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('status.store') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <p class="font-semibold mb-2">Pilih status Anda:</p>
                    <label class="block mb-2">
                        <input type="radio" name="status" value="tersedia" onclick="toggleFields(false)" {{ old('status', $konsultan->status) == 'tersedia' ? 'checked' : '' }}>
                        ✅ Tersedia
                    </label>
                    <label class="block">
                    <input type="radio" name="status" value="tidak tersedia" onclick="toggleFields(true)" {{ old('status', $konsultan->status) == 'tidak tersedia' ? 'checked' : '' }}>
                        ❌ Tidak Tersedia
                    </label>

                </div>

                <div id="tanggal-box" class="mb-4" style="display: none;">
                    <label for="tanggal_mulai" class="block font-medium mb-1">Tanggal Mulai Tidak Tersedia:</label>
                    <input type="date" name="tanggal_mulai_tidak_tersedia"
                    min="{{ now()->format('Y-m-d') }}"
                    value="{{ old('tanggal_mulai_tidak_tersedia', isset($konsultan->tanggal_mulai_tidak_tersedia) ? \Carbon\Carbon::parse($konsultan->tanggal_mulai_tidak_tersedia)->format('Y-m-d') : '') }}"
                    class="w-full border rounded p-2">

                    @error('tanggal_mulai_tidak_tersedia')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror

                    <label for="tanggal_selesai" class="block font-medium mt-2 mb-1">Tanggal Selesai Tidak Tersedia:</label>
                    <input type="date" name="tanggal_selesai_tidak_tersedia"
                    min="{{ old('tanggal_mulai_tidak_tersedia', now()->format('Y-m-d')) }}"
                    value="{{ old('tanggal_selesai_tidak_tersedia', isset($konsultan->tanggal_selesai_tidak_tersedia) ? \Carbon\Carbon::parse($konsultan->tanggal_selesai_tidak_tersedia)->format('Y-m-d') : '') }}"
                    class="w-full border rounded p-2">
                    @error('tanggal_selesai_tidak_tersedia')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div id="alasan-box" class="mb-4" style="display: none;">
                    <label for="alasan" class="block font-medium mb-1">Alasan:</label>
                    <textarea name="alasan" class="w-full border rounded p-2" rows="3">{{ old('alasan', $konsultan->alasan ?? '') }}</textarea>
                    @error('alasan')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="bg-blue-300 hover:bg-blue-400 text-blue-800 font-medium px-4 py-2 rounded">
                    Simpan Status
                </button>
            </form>

            <div class="mt-6">
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4 flex items-center">
            <svg class="w-6 h-6 text-blue-500 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13 16h-1v-4h-1m1-4h.01M12 6a9 9 0 11-6.219 15.362L3 21l.638-2.783A9 9 0 0112 6z" />
            </svg>
            Status Konsultan Saat Ini
        </h2>

        @php
            use Carbon\Carbon;
            $status = $konsultan->status ?? null;
            $mulai = $konsultan->tanggal_mulai_tidak_tersedia ?? null;
            $selesai = $konsultan->tanggal_selesai_tidak_tersedia ?? null;
        @endphp

        @if ($status === 'tersedia')
            <div class="flex items-center bg-green-100 border border-green-300 rounded-md p-4 mb-2">
                <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1.707-6.707l5-5a1 1 0 111.414 1.414L9 15l-3.707-3.707a1 1 0 111.414-1.414z" />
                </svg>
                <p class="text-green-700 font-medium">Konsultan tersedia untuk konsultasi.</p>
            </div>
        @elseif ($status === 'tidak tersedia')
            <div class="bg-red-50 border border-red-300 rounded-md p-4 mb-4">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M18 10A8 8 0 11.004 9.999 8 8 0 0118 10zM9 4a1 1 0 112 0v4a1 1 0 11-2 0V4zm1 6a1.5 1.5 0 110 3 1.5 1.5 0 010-3z" />
                    </svg>
                    <p class="text-red-700 font-semibold">Konsultan sedang tidak tersedia.</p>
                </div>

                <ul class="ml-7 list-disc text-sm text-gray-700 space-y-1">
                    @if($konsultan->alasan)
                        <li><strong>Alasan:</strong> {{ $konsultan->alasan }}</li>
                    @endif
                    <li><strong>Dari:</strong> {{ $mulai ? Carbon::parse($mulai)->translatedFormat('d F Y') : '-' }}</li>
                    <li><strong>Sampai:</strong> {{ $selesai ? Carbon::parse($selesai)->translatedFormat('d F Y') : '-' }}</li>
                </ul>
            </div>
        @else
            <div class="text-gray-500 italic">Belum ada status yang ditentukan.</div>
        @endif
    </div>
</div>


        </div>
    </div>
</div>

<script>
    function toggleFields(show) {
        document.getElementById('alasan-box').style.display = show ? 'block' : 'none';
        document.getElementById('tanggal-box').style.display = show ? 'block' : 'none';
    }

    document.addEventListener("DOMContentLoaded", function () {
        const status = "{{ old('status', $konsultan->status) }}";
        if (status === 'tidak tersedia') {
            document.querySelector('input[value="tidak tersedia"]').checked = true;
            toggleFields(true);
        } else if (status === 'tersedia') {
            document.querySelector('input[value="tersedia"]').checked = true;
            toggleFields(false);
        }
    });
</script>
@endsection
