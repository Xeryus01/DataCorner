@extends('layout.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 px-4 py-8">

    @php
        $layananOptions = [
            'Perpustakaan',
            'Konsultasi Statistik',
            'Penjualan Produk Statistik',
            'Rekomendasi Kegiatan Statistik',
        ];

        $keperluanOptions = [
            'Tugas Sekolah/Kuliah',
            'Perencanaan',
            'Bekerja',
            'Skripsi/Tesis/Disertasi',
            'Evaluasi',
            'Ruang Bermain Anak',
            'Penelitian',
            'Diskusi',
            'Lainnya',
        ];

        $selectedLayanan = old('layanan_dibutuhkan')
            ? old('layanan_dibutuhkan')
            : explode(', ', $janjitemu->layanan_dibutuhkan ?? '');

        $selectedKeperluan = old('keperluan_data')
            ? old('keperluan_data')
            : explode(', ', $janjitemu->keperluan_data ?? '');
    @endphp

    <main class="w-full max-w-5xl mx-auto">

        {{-- Header --}}
        <div class="mb-6 bg-white/90 backdrop-blur-xl border border-white/70 rounded-3xl shadow-sm p-5">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-blue-600 mb-1">
                        Edit Janji Temu
                    </p>

                    <h1 class="text-2xl md:text-3xl font-black text-slate-800 tracking-tight">
                        Perbarui Jadwal Anda
                    </h1>

                    <p class="text-sm text-slate-500 mt-1">
                        Sesuaikan informasi janji temu sebelum dikonfirmasi oleh admin.
                    </p>
                </div>

                <a href="{{ route('janjitemu.jadwal') }}"
                   class="inline-flex items-center justify-center px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-2xl text-sm font-black transition">
                    Kembali
                </a>
            </div>
        </div>

        {{-- Error --}}
        @if ($errors->any())
            <div class="mb-5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-2xl text-sm font-semibold">
                <p class="font-black mb-1">Ada data yang perlu diperbaiki:</p>
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST"
              action="{{ route('janjitemu.update', $janjitemu->id) }}"
              class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-sm border border-white/70 overflow-hidden">
            @csrf
            @method('PUT')

            {{-- Top info --}}
            <div class="p-5 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <p class="text-xs font-black text-slate-500 uppercase tracking-wide mb-1">
                            Status Saat Ini
                        </p>

                        <div class="flex flex-wrap items-center gap-2">
                            <span class="px-3 py-1 rounded-full text-xs font-black
                                {{ $janjitemu->status == 'menunggu' ? 'bg-yellow-100 text-yellow-700' : ($janjitemu->status == 'diterima' ? 'bg-green-100 text-green-700' : ($janjitemu->status == 'batal' ? 'bg-slate-100 text-slate-600' : 'bg-red-100 text-red-700')) }}">
                                {{ ucfirst($janjitemu->status ?? 'menunggu') }}
                            </span>

                            <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-black">
                                {{ ucfirst($janjitemu->jenis ?? '-') }}
                            </span>
                        </div>
                    </div>

                    <div class="text-sm text-slate-500">
                        Terakhir diperbarui:
                        <span class="font-bold text-slate-700">
                            {{ $janjitemu->updated_at ? $janjitemu->updated_at->format('d/m/Y H:i') : '-' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="p-6 space-y-6">

                {{-- Instansi --}}
                <div>
                    <label for="instansi_lembaga" class="block text-sm font-black text-slate-700 mb-2">
                        Instansi / Lembaga <span class="text-red-500">*</span>
                    </label>

                    <input type="text"
                           id="instansi_lembaga"
                           name="instansi_lembaga"
                           value="{{ old('instansi_lembaga', $janjitemu->instansi_lembaga) }}"
                           placeholder="Contoh: BPS Provinsi Kepulauan Bangka Belitung"
                           class="w-full px-4 py-3 border-2 border-slate-200 rounded-2xl focus:border-primary focus:ring-0 focus:outline-none transition bg-white"
                           required>

                    @error('instansi_lembaga')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jenis layanan --}}
                <div>
                    <label class="block text-sm font-black text-slate-700 mb-3">
                        Jenis Layanan <span class="text-red-500">*</span>
                    </label>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="flex items-center gap-3 px-4 py-3 border-2 rounded-2xl cursor-pointer transition
                            {{ old('jenis', $janjitemu->jenis) == 'online' ? 'border-green-400 bg-green-50' : 'border-slate-200 bg-white hover:border-green-300' }}">
                            <input type="radio"
                                   name="jenis"
                                   value="online"
                                   class="w-4 h-4 accent-green-600"
                                   {{ old('jenis', $janjitemu->jenis) == 'online' ? 'checked' : '' }}
                                   required>

                            <div>
                                <p class="text-sm font-black text-slate-800">Online</p>
                                <p class="text-xs text-slate-500">Janji temu dilakukan secara daring.</p>
                            </div>
                        </label>

                        <label class="flex items-center gap-3 px-4 py-3 border-2 rounded-2xl cursor-pointer transition
                            {{ old('jenis', $janjitemu->jenis) == 'offline' ? 'border-blue-400 bg-blue-50' : 'border-slate-200 bg-white hover:border-blue-300' }}">
                            <input type="radio"
                                   name="jenis"
                                   value="offline"
                                   class="w-4 h-4 accent-blue-600"
                                   {{ old('jenis', $janjitemu->jenis) == 'offline' ? 'checked' : '' }}
                                   required>

                            <div>
                                <p class="text-sm font-black text-slate-800">Offline</p>
                                <p class="text-xs text-slate-500">Janji temu dilakukan langsung/luring.</p>
                            </div>
                        </label>
                    </div>

                    @error('jenis')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Layanan dibutuhkan --}}
                <div>
                    <label class="block text-sm font-black text-slate-700 mb-2">
                        Layanan yang Dibutuhkan <span class="text-red-500">*</span>
                    </label>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2 bg-slate-50 rounded-2xl p-4 border border-slate-100">
                        @foreach($layananOptions as $option)
                            <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                                <input type="checkbox"
                                       name="layanan_dibutuhkan[]"
                                       value="{{ $option }}"
                                       class="w-4 h-4 rounded border-slate-300 accent-primary cursor-pointer"
                                       {{ in_array($option, $selectedLayanan) ? 'checked' : '' }}>
                                <span>{{ $option }}</span>
                            </label>
                        @endforeach
                    </div>

                    @error('layanan_dibutuhkan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Keperluan data --}}
                <div>
                    <label class="block text-sm font-black text-slate-700 mb-2">
                        Keperluan Penggunaan Data <span class="text-red-500">*</span>
                    </label>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-4 gap-y-2 bg-slate-50 rounded-2xl p-4 border border-slate-100">
                        @foreach($keperluanOptions as $option)
                            <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                                <input type="checkbox"
                                       name="keperluan_data[]"
                                       value="{{ $option }}"
                                       class="w-4 h-4 rounded border-slate-300 accent-primary cursor-pointer"
                                       {{ in_array($option, $selectedKeperluan) ? 'checked' : '' }}>
                                <span>{{ $option }}</span>
                            </label>
                        @endforeach
                    </div>

                    @error('keperluan_data')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Data diminta --}}
                <div>
                    <label for="data_diminta" class="block text-sm font-black text-slate-700 mb-2">
                        Data yang Diminta <span class="text-red-500">*</span>
                    </label>

                    <textarea id="data_diminta"
                              name="data_diminta"
                              rows="4"
                              placeholder="Tuliskan data yang ingin diminta..."
                              class="w-full px-4 py-3 border-2 border-slate-200 rounded-2xl focus:border-primary focus:ring-0 focus:outline-none transition resize-none"
                              required>{{ old('data_diminta', $janjitemu->data_diminta) }}</textarea>

                    @error('data_diminta')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal, jam, jumlah --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="tanggal" class="block text-sm font-black text-slate-700 mb-2">
                            Pilihan Hari <span class="text-red-500">*</span>
                        </label>

                        <input type="date"
                               id="tanggal"
                               name="tanggal"
                               min="{{ now()->format('Y-m-d') }}"
                               value="{{ old('tanggal', $janjitemu->tanggal ? \Carbon\Carbon::parse($janjitemu->tanggal)->format('Y-m-d') : '') }}"
                               class="w-full px-4 py-3 border-2 border-slate-200 rounded-2xl focus:border-primary focus:ring-0 focus:outline-none transition"
                               required>

                        @error('tanggal')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jam" class="block text-sm font-black text-slate-700 mb-2">
                            Pilihan Jam <span class="text-red-500">*</span>
                        </label>

                        <input type="time"
                               id="jam"
                               name="jam"
                               value="{{ old('jam', $janjitemu->jam ? \Carbon\Carbon::parse($janjitemu->jam)->format('H:i') : '') }}"
                               class="w-full px-4 py-3 border-2 border-slate-200 rounded-2xl focus:border-primary focus:ring-0 focus:outline-none transition"
                               required>

                        @error('jam')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jumlah_orang" class="block text-sm font-black text-slate-700 mb-2">
                            Jumlah Orang <span class="text-red-500">*</span>
                        </label>

                        <input type="number"
                               id="jumlah_orang"
                               name="jumlah_orang"
                               min="1"
                               max="50"
                               value="{{ old('jumlah_orang', $janjitemu->jumlah_orang ?? 1) }}"
                               class="w-full px-4 py-3 border-2 border-slate-200 rounded-2xl focus:border-primary focus:ring-0 focus:outline-none transition"
                               required>

                        @error('jumlah_orang')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Action --}}
            <div class="p-5 border-t border-slate-100 bg-slate-50 flex flex-col sm:flex-row sm:justify-end gap-3">
                <a href="{{ route('janjitemu.jadwal') }}"
                   class="px-5 py-3 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 rounded-2xl text-sm font-black text-center transition">
                    Batal
                </a>

                <button type="submit"
                        class="px-5 py-3 bg-primary hover:bg-blue-800 text-white rounded-2xl text-sm font-black transition shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </main>
</div>
@endsection