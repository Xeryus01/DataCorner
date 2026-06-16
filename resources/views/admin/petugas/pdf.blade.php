<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Petugas Mingguan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .container { width: 90%; margin: 0 auto; }
        .header { text-align: center; margin-bottom: 20px; }
        h2, h3 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; vertical-align: top; }
        th { background-color: #f2f2f2; }

        /* Mencegah pemecahan halaman di dalam bagian tabel */
        .page-break-avoid {
            page-break-inside: avoid;
        }
        .section-header th { background-color: #e0e0e0; font-weight: bold; text-align: center !important; }
        .sub-header td { background-color: #f9f9f9; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Laporan Data Petugas Mingguan</h2>
            <p>
                @if (isset($filters['tanggal']) && $filters['tanggal'] != null)
                    Tanggal: {{ \Carbon\Carbon::parse($filters['tanggal'])->locale('id')->isoFormat('D MMMM Y') }}
                @elseif (isset($filters['bulan']) && $filters['bulan'] != null)
                    Bulan: {{ \Carbon\Carbon::create(null, $filters['bulan'])->locale('id')->isoFormat('MMMM') }} {{ isset($filters['tahun']) ? $filters['tahun'] : '' }}
                @elseif (isset($filters['tahun']) && $filters['tahun'] != null)
                    Tahun: {{ $filters['tahun'] }}
                @else
                    Semua Data
                @endif
            </p>
        </div>

        <table class="page-break-avoid">
            {{-- Bagian 1: Detail Jadwal Petugas --}}
            <thead>
                <tr class="section-header">
                    <th colspan="3">Daftar Jadwal Petugas</th>
                </tr>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 50%;">Nama Petugas</th>
                    <th style="width: 45%;">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($petugas as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->konsultan->nama }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('dddd, D MMMM Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Gunakan div untuk memastikan section ini tidak terpotong --}}
        <div class="page-break-avoid">
            <table>
                {{-- Bagian 2: Rekapitulasi Kehadiran Petugas --}}
                <thead>
                    <tr class="section-header">
                        <th colspan="3">Rekapitulasi Kehadiran Petugas</th>
                    </tr>
                    <tr>
                        <th colspan="2" style="width: 70%;">Nama Petugas</th>
                        <th style="width: 30%;">Jumlah Kehadiran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kehadiranPerPetugas as $nama => $jumlah)
                        <tr>
                            <td colspan="2">{{ $nama }}</td>
                            <td>{{ $jumlah }} kali</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Gunakan div untuk memastikan section ini tidak terpotong --}}
        <div class="page-break-avoid">
            <table>
                {{-- Bagian 3: Rekapitulasi Kehadiran Per Bulan --}}
                <thead>
                    <tr class="section-header">
                        <th colspan="3">Total Kehadiran Per Bulan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kehadiranPerBulan as $bulanTahun => $data)
                        <tr class="sub-header">
                            <td colspan="3" style="text-align: left !important;">{{ $bulanTahun }}</td>
                        </tr>
                        @foreach($data as $nama => $jumlah)
                            <tr>
                                <td colspan="2">{{ $nama }}</td>
                                <td>{{ $jumlah }} kali</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Gunakan div untuk memastikan section ini tidak terpotong --}}
        <div class="page-break-avoid">
            <table>
                {{-- Bagian 4: Rekapitulasi Kehadiran Per Tahun --}}
                <thead>
                    <tr class="section-header">
                        <th colspan="3">Total Kehadiran Per Tahun</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kehadiranPerTahun as $tahun => $data)
                        <tr class="sub-header">
                            <td colspan="3" style="text-align: left !important;">Tahun {{ $tahun }}</td>
                        </tr>
                        @foreach($data as $nama => $jumlah)
                            <tr>
                                <td colspan="2">{{ $nama }}</td>
                                <td>{{ $jumlah }} kali</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
