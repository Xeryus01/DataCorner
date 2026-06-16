<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Riwayat Log Harian Magang</title>

    <style>

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        /* HEADER */

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 18px;
            margin-bottom: 4px;
        }

        .header p {
            font-size: 12px;
            margin: 0;
        }

        /* INFO PESERTA */

        .info {
            margin-bottom: 20px;
        }

        .info table {
            width: 100%;
        }

        .info td {
            padding: 3px 0;
        }

        /* TABEL */

        .table-data {
            width: 100%;
            border-collapse: collapse;
        }

        .table-data th {
            background: #f3f4f6;
            font-weight: bold;
            text-align: center;
        }

        .table-data th,
        .table-data td {
            border: 1px solid #ccc;
            padding: 6px;
        }

        .table-data td {
            vertical-align: top;
            word-wrap: break-word;
        }

        /* STATUS */

        .status-hadir {
            color: #15803d;
            font-weight: bold;
        }

        .status-izin {
            color: #b45309;
            font-weight: bold;
        }

        /* KETERANGAN */

        .keterangan {
            font-size: 11px;
            line-height: 1.4;
        }

        /* FOOTER */

        .footer {
            margin-top: 40px;
            width: 100%;
        }

        .footer td {
            text-align: center;
        }

    </style>

</head>

<body>

    <!-- HEADER -->

    <div class="header">
        <h1>LAPORAN LOG HARIAN MAGANG</h1>
        <p>Program Magang</p>
    </div>


    <!-- INFORMASI PESERTA -->

    <div class="info">

        <table>

            <tr>
                <td width="150">Nama Peserta</td>
                <td width="10">:</td>
                <td>{{ auth()->user()->name }}</td>
            </tr>

            <tr>
                <td>Periode Laporan</td>
                <td>:</td>
                <td>

                    @if(request('start_date') && request('end_date'))

                        {{ \Carbon\Carbon::parse(request('start_date'))->translatedFormat('d F Y') }}
                        sampai
                        {{ \Carbon\Carbon::parse(request('end_date'))->translatedFormat('d F Y') }}

                    @else

                        Semua Periode

                    @endif

                </td>
            </tr>

            <tr>
                <td>Tanggal Cetak</td>
                <td>:</td>
                <td>
                    {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                </td>
            </tr>

        </table>

    </div>


    <!-- TABEL DATA -->

    <table class="table-data">

        <thead>

            <tr>
                <th width="5%">No</th>
                <th width="12%">Tanggal</th>
                <th width="9%">Jam Masuk</th>
                <th width="9%">Jam Pulang</th>
                <th width="7%">Status</th>
                <th width="14%">Keterangan Presensi</th>
                <th width="34%">Uraian Kegiatan</th>
                <th width="10%">Catatan</th>
            </tr>

        </thead>

        <tbody>

            @foreach($logs as $log)

                <tr>

                    <!-- NO -->
                    <td align="center">
                        {{ $loop->iteration }}
                    </td>

                    <!-- TANGGAL -->
                    <td align="center">
                        {{ \Carbon\Carbon::parse($log->tanggal)->format('d-m-Y') }}
                    </td>

                    <!-- JAM MASUK -->
                    <td align="center">
                        {{
                            $log->presensi?->jam_masuk
                                ? \Carbon\Carbon::parse($log->presensi->jam_masuk)->format('H:i')
                                : '-'
                        }}
                    </td>

                    <!-- JAM PULANG -->
                    <td align="center">
                        {{
                            $log->presensi?->jam_pulang
                                ? \Carbon\Carbon::parse($log->presensi->jam_pulang)->format('H:i')
                                : '-'
                        }}
                    </td>

                    <!-- STATUS -->
                    <td align="center">

                        @if($log->presensi?->jam_masuk && $log->presensi?->jam_pulang)

                            <span class="status-hadir">
                                Hadir
                            </span>

                        @else

                            <span class="status-izin">
                                {{ ucfirst($log->status_kehadiran) }}
                            </span>

                        @endif

                    </td>

                    <!-- KETERANGAN PRESENSI -->
                    <td class="keterangan">

                        <div>
                            <strong>Masuk :</strong>
                            {{ $log->presensi?->keterangan_masuk ?? '-' }}
                        </div>

                        <div>
                            <strong>Pulang :</strong>
                            {{ $log->presensi?->keterangan_pulang ?? '-' }}
                        </div>

                    </td>

                    <!-- URAIAN KEGIATAN -->
                    <td>
                        {!! $log->uraian_kegiatan !!}
                    </td>

                    <!-- CATATAN -->
                    <td>
                        {!! $log->catatan ?? '-' !!}
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>


    <!-- TANDA TANGAN -->

    <table class="footer">

        <tr>

            <td width="60%"></td>

            <td>

                <p>
                    {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                </p>

                <p>
                    Pembimbing Magang
                </p>

                <br><br><br>

                <p>
                    ________________________
                </p>

            </td>

        </tr>

    </table>

</body>
</html>