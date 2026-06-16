@extends('admin.layout')

@section('content')

<div class="min-h-screen bg-slate-100 overflow-x-hidden">
    <main class="px-6 py-8 lg:px-10">

        <!-- <div class="mb-8 rounded-[2rem] bg-gradient-to-r from-sky-600 via-cyan-500 to-teal-500 text-white p-8 shadow-2xl ring-1 ring-white/20 overflow-hidden">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div class="max-w-2xl">
                    <p class="text-xs font-semibold uppercase tracking-[0.35em] text-cyan-100/80">Dashboard Admin</p>
                    <h1 class="mt-3 text-3xl md:text-4xl font-black tracking-tight">Ringkasan Operasional Datapedia</h1>
                    <p class="mt-4 text-sm md:text-base text-cyan-100/85 leading-relaxed">Pantau pengguna, jadwal, konsultasi, presensi, dan modul edukasi dari panel admin yang lebih rapi dan responsif.</p>
                </div>
                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
                    <div class="rounded-3xl bg-white/10 border border-white/20 p-4 text-center">
                        <p class="text-[10px] uppercase tracking-[0.35em] text-cyan-100/75">Admin</p>
                        <p class="mt-3 text-3xl font-black">{{ $totalAdmin ?? 0 }}</p>
                    </div>
                    <div class="rounded-3xl bg-white/10 border border-white/20 p-4 text-center">
                        <p class="text-[10px] uppercase tracking-[0.35em] text-cyan-100/75">User</p>
                        <p class="mt-3 text-3xl font-black">{{ $totalUser ?? 0 }}</p>
                    </div>
                    <div class="rounded-3xl bg-white/10 border border-white/20 p-4 text-center">
                        <p class="text-[10px] uppercase tracking-[0.35em] text-cyan-100/75">Jadwal</p>
                        <p class="mt-3 text-3xl font-black">{{ $totalJadwal ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div> -->

        <h2 class="text-3xl font-bold mb-6 text-slate-800">Ringkasan Modul Utama</h2>

        <div id="dashboard-cards" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">

            <!-- Card 1: Admin -->
            <div class="group bg-white p-6 rounded-[1.75rem] border border-slate-200 border-t-4 border-green-500 shadow-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl">
            <a href="{{ route('dashboard.index') }}">

                <div class="flex items-center justify-between mb-2">
                    <div class="text-gray-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <div class="text-xs font-semibold text-green-600 bg-green-100 px-2 py-1 rounded-full">ADMIN</div>
                </div>
                <div class="text-4xl font-bold text-gray-800 counter" data-target="{{ $totalAdmin ?? '0' }}">0</div>
                <div class="text-sm text-gray-500 mt-1">Jumlah Admin</div>
            </a>
            </div>

            <!-- Card 2: User -->
            <div class="group bg-white p-6 rounded-[1.75rem] border border-slate-200 border-t-4 border-blue-500 shadow-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl">
            <a href="{{ route('dataUser') }}">
                <div class="flex items-center justify-between mb-2">
                    <div class="text-gray-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div class="text-xs font-semibold text-blue-600 bg-blue-100 px-2 py-1 rounded-full">USERS</div>
                </div>
                <div class="text-4xl font-bold text-gray-800 counter" data-target="{{ $totalUser ?? '0' }}">0</div>
                <div class="text-sm text-gray-500 mt-1">Jumlah User</div>
            </a>
            </div>

            <!-- Card 3: Konsultan -->
            <div class="group bg-white p-6 rounded-[1.75rem] border border-slate-200 border-t-4 border-pink-500 shadow-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl">
            <a href="{{ route('konsultan.index') }}">
                <div class="flex items-center justify-between mb-2">
                    <div class="text-gray-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="text-xs font-semibold text-pink-600 bg-pink-100 px-2 py-1 rounded-full">KONSULTAN</div>
                </div>
                <div class="text-4xl font-bold text-gray-800 counter" data-target="{{ $totalKonsultan ?? '0' }}">0</div>
                <div class="text-sm text-gray-500 mt-1">Jumlah Konsultan</div>
            </a>
            </div>

            <!-- Card 4: Petugas -->
            <div class="group bg-white p-6 rounded-[1.75rem] border border-slate-200 border-t-4 border-orange-500 shadow-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl">
            <a href="{{ route('petugas.index') }}">
                <div class="flex items-center justify-between mb-2">
                    <div class="text-gray-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="text-xs font-semibold text-orange-600 bg-orange-100 px-2 py-1 rounded-full">PETUGAS</div>
                </div>
                <div class="text-4xl font-bold text-gray-800 counter" data-target="{{ $totalPetugas ?? '0' }}">0</div>
                <div class="text-sm text-gray-500 mt-1">Jumlah Petugas Hari Ini</div>
            </a>
            </div>

            <!-- Card 5: Jadwal -->
            <div class="group bg-white p-6 rounded-[1.75rem] border border-slate-200 border-t-4 border-cyan-500 shadow-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl">
            <a href="{{ route('jadwal.index') }}">
                <div class="flex items-center justify-between mb-2">
                    <div class="text-gray-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="text-xs font-semibold text-cyan-600 bg-cyan-100 px-2 py-1 rounded-full">JADWAL</div>
                </div>
                <div class="text-4xl font-bold text-gray-800 counter" data-target="{{ $totalJadwal ?? '0' }}">0</div>
                <div class="text-sm text-gray-500 mt-1">Jumlah Jadwal Janji Temu</div>
            </a>
            </div>

            <!-- Card 6: Maklumat -->
            <div class="group bg-white p-6 rounded-[1.75rem] border border-slate-200 border-t-4 border-purple-500 shadow-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl">
            <a href="{{ route('maklumat.index') }}">
                <div class="flex items-center justify-between mb-2">
                    <div class="text-gray-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                    </div>
                    <div class="text-xs font-semibold text-purple-600 bg-purple-100 px-2 py-1 rounded-full">MAKLUMAT</div>
                </div>
                <div class="text-4xl font-bold text-gray-800 counter" data-target="{{ $totalMaklumat ?? '0' }}">0</div>
                <div class="text-sm text-gray-500 mt-1">Jumlah Maklumat Layanan</div>
            </a>
            </div>


            <!-- Card 7: Standar -->
            <div class="group bg-white p-6 rounded-[1.75rem] border border-slate-200 border-t-4 border-yellow-500 shadow-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl">
            <a href="{{ route('standar.index') }}">
                <div class="flex items-center justify-between mb-2">
                    <div class="text-gray-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="text-xs font-semibold text-yellow-600 bg-yellow-100 px-2 py-1 rounded-full">STANDAR</div>
                </div>
                <div class="text-4xl font-bold text-gray-800 counter" data-target="{{ $totalStandar ?? '0' }}">0</div>
                <div class="text-sm text-gray-500 mt-1">Jumlah Standar Pelayanan</div>
            </a>
            </div>


            <!-- Card 8: Layanan -->
            <div class="group bg-white p-6 rounded-[1.75rem] border border-slate-200 border-t-4 border-red-500 shadow-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl">
            <a href="{{ route('layanan.index') }}">
                <div class="flex items-center justify-between mb-2">
                    <div class="text-gray-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div class="text-xs font-semibold text-red-600 bg-red-100 px-2 py-1 rounded-full">24/7</div>
                </div>
                <div class="text-4xl font-bold text-gray-800 counter" data-target="{{ $totalLayanan ?? '0' }}">0</div>
                <div class="text-sm text-gray-500 mt-1">Jumlah Layanan 24 Jam</div>
            </a>
            </div>


            <!-- Card 9: FAQ -->
            <div class="group bg-white p-6 rounded-[1.75rem] border border-slate-200 border-t-4 border-indigo-500 shadow-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl">
            <a href="{{ route('faq.index') }}">
                <div class="flex items-center justify-between mb-2">
                    <div class="text-gray-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="text-xs font-semibold text-indigo-600 bg-indigo-100 px-2 py-1 rounded-full">FAQ</div>
                </div>
                <div class="text-4xl font-bold text-gray-800 counter" data-target="{{ $totalFaq ?? '0' }}">0</div>
                <div class="text-sm text-gray-500 mt-1">Jumlah FAQ</div>
            </a>
            </div>            

        </div>

        <div class="mt-8 bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100">
                <p class="text-[10px] font-black uppercase tracking-[0.25em] text-blue-600 mb-2">
                    Fitur Utama Datapedia dari Student Corner
                </p>
                <h2 class="text-xl md:text-2xl font-black text-slate-800">
                    Dashboard Pengelolaan Literasi, Magang, Riset, Kuis, dan Alat Statistik
                </h2>
                <p class="text-sm text-slate-500 mt-2 max-w-4xl">
                    Semua fitur pindahan Student Corner sudah menjadi modul utama Datapedia. Admin dapat mengisi konten edukasi,
                    informasi magang, informasi riset, kuis, presensi, dan melihat alat statistik dari dashboard ini tanpa login terpisah.
                </p>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
                @php
                    $studentCornerCards = [
                        ['label' => 'Subjek Materi', 'count' => $totalSubjekMateri ?? 0, 'route' => route('admin_subjek-materi.index'), 'tag' => 'EDUKASI'],
                        ['label' => 'Artikel Edukasi', 'count' => $totalArtikel ?? 0, 'route' => route('admin_artikel.index'), 'tag' => 'EDUKASI'],
                        ['label' => 'Video Pembelajaran', 'count' => $totalVideoPembelajaran ?? 0, 'route' => route('admin_video-pembelajaran.index'), 'tag' => 'EDUKASI'],
                        ['label' => 'Infografis', 'count' => $totalInfografis ?? 0, 'route' => route('admin_infografis.index'), 'tag' => 'EDUKASI'],
                        ['label' => 'Informasi Magang', 'count' => $totalInformasiMagang ?? 0, 'route' => route('admin_informasi-magang.index'), 'tag' => 'MAGANG'],
                        ['label' => 'Pendaftar Magang', 'count' => $totalPendaftaranMagang ?? 0, 'route' => route('admin_daftar-magang.index-admin'), 'tag' => 'MAGANG'],
                        ['label' => 'Informasi Riset', 'count' => $totalInformasiRiset ?? 0, 'route' => route('admin_informasi-riset.index'), 'tag' => 'RISET'],
                        ['label' => 'Pendaftar Riset', 'count' => $totalPendaftaranRiset ?? 0, 'route' => route('admin_daftar-riset.index-admin'), 'tag' => 'RISET'],
                        ['label' => 'Kuis Reguler', 'count' => $totalKuisReguler ?? 0, 'route' => route('admin_kuis-reguler.index'), 'tag' => 'KUIS'],
                        ['label' => 'Tantangan Bulanan', 'count' => $totalTantanganBulanan ?? 0, 'route' => route('admin_kuis-tantangan-bulanan.index'), 'tag' => 'KUIS'],
                        ['label' => 'Pengaturan Presensi', 'count' => '-', 'route' => route('admin_pengaturan-presensi.index'), 'tag' => 'PRESENSI'],
                        ['label' => 'Wilayah BPS', 'count' => '-', 'route' => route('admin_wilayah-bps.index'), 'tag' => 'MASTER'],
                    ];
                @endphp

                @foreach ($studentCornerCards as $card)
                    @include('components.admin.dashboard-card', ['route' => $card['route'], 'label' => $card['label'], 'count' => $card['count'], 'tag' => $card['tag']])
                @endforeach
            </div>

            <div class="px-6 pb-6 grid grid-cols-1 md:grid-cols-3 gap-3">
                <a href="{{ route('alat-statistik.index') }}" target="_blank" rel="noopener noreferrer" class="rounded-2xl bg-blue-950 text-white p-4 font-bold hover:bg-blue-800 transition">Preview Alat Statistik →</a>
                <a href="{{ route('visualisasi.index') }}" target="_blank" rel="noopener noreferrer" class="rounded-2xl bg-blue-950 text-white p-4 font-bold hover:bg-blue-800 transition">Preview Visualisasi Data →</a>
                <a href="{{ route('simulasi.index') }}" target="_blank" rel="noopener noreferrer" class="rounded-2xl bg-blue-950 text-white p-4 font-bold hover:bg-blue-800 transition">Preview Simulasi Statistik →</a>
            </div>
        </div>

        <div class="mt-6 bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-[0.25em] text-blue-600 mb-1">
                        Statistik Konsultasi
                    </p>

                    <h2 class="text-lg md:text-xl font-black text-slate-800">
                        Grafik Konsultasi Bulanan
                    </h2>

                    <p class="text-xs text-slate-500 mt-1">
                        Rekap jumlah konsultasi berdasarkan posisi pengunjung.
                    </p>
                </div>

                <form method="GET" action="{{ route('dashboard.index') }}">
                    <select name="tahun"
                            onchange="this.form.submit()"
                            class="px-4 py-2 rounded-xl border border-slate-200 bg-slate-50 text-sm font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-200">
                        @foreach ($availableYears as $year)
                            <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="p-5">
                <div id="no-data-message" class="hidden text-center py-10 text-slate-500">
                    Tidak ada data konsultasi untuk tahun {{ $selectedYear }}.
                </div>

                <div class="relative w-full bg-slate-50 rounded-2xl border border-slate-100 p-4" style="height: 330px;">
                    <canvas id="grafikKonsultasi"></canvas>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-2 gap-3 mt-4">                                       
                    <div class="flex-1 bg-slate-50 rounded-2xl p-4 border border-slate-100 flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold text-slate-500">
                                Total Konsultasi Tahun {{ $selectedYear }}
                            </p>
                            <h3 id="totalKonsultasi" class="text-2xl font-black text-slate-800 mt-1">0</h3>
                        </div>

                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-8 0h8m-8 0H5a2 2 0 01-2-2V7a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-4" />
                            </svg>
                        </div>
                    </div>

                    <div class="flex-1 bg-slate-50 rounded-2xl p-4 border border-slate-100 flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold text-slate-500">
                                Bulan Tertinggi
                            </p>
                            <h3 id="bulanTertinggi" class="text-2xl font-black text-slate-800 mt-1">-</h3>
                        </div>

                        <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                    </div>                
                </div>
            </div>
        </div>

    </main>
</div>



@vite(['resources/css/admin/dashboard.css','resources/js/admin/dashboard.js'])

<script>window.dataKonsultasiBulanan = @json($dataKonsultasiBulanan);</script>

@endsection
