@extends('jadwal.layout')
@section('content')

<div class="page-header-row">
    <div>
        <h1 class="page-title">Data Janji Temu</h1>
        <p class="page-sub">Daftar janji temu yang dijadwalkan dengan Anda</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-header-left">
            <i class="ti ti-calendar"></i>
            <span class="card-title">Semua Janji Temu</span>
        </div>
    </div>
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nama User</th>
                    <th>No HP</th>
                    <th>Instansi/Lembaga</th>
                    <th>Layanan</th>
                    <th>Keperluan Data</th>
                    <th>Data Diminta</th>
                    <th>Tanggal & Jam</th>
                    <th>Jenis</th>
                    <th>Jumlah Orang</th>
                    <th>Status</th>
                    <th>Alasan Pembatalan</th>
                    <th>Zoom</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jadwals as $item)
                    @php
                        $janji = $item->janjitemu;
                        $layananList = $janji && $janji->layanan_dibutuhkan
                            ? explode(', ', $janji->layanan_dibutuhkan)
                            : [];
                        $keperluanList = $janji && $janji->keperluan_data
                            ? explode(', ', $janji->keperluan_data)
                            : [];
                        $status = $janji->status ?? 'menunggu';
                    @endphp

                    <tr>
                        {{-- Nama User --}}
                        <td>
                            <div class="name-cell">{{ $janji->user->nama ?? '-' }}</div>
                            <div style="font-size:11px;color:var(--color-muted);margin-top:2px">{{ $janji->user->email ?? '-' }}</div>
                        </td>

                        {{-- No HP --}}
                        <td>{{ $janji->user->no_hp ?? '-' }}</td>

                        {{-- Instansi --}}
                        <td>{{ $janji->instansi_lembaga ?? '-' }}</td>

                        {{-- Layanan --}}
                        <td>
                            @if(count($layananList))
                                <div style="display:flex;flex-wrap:wrap;gap:4px">
                                    @foreach($layananList as $layanan)
                                        <span class="badge-status badge-active">{{ $layanan }}</span>
                                    @endforeach
                                </div>
                            @else
                                <span style="color:var(--color-muted)">-</span>
                            @endif
                        </td>

                        {{-- Keperluan Data --}}
                        <td>
                            @if(count($keperluanList))
                                <div style="display:flex;flex-wrap:wrap;gap:4px">
                                    @foreach($keperluanList as $keperluan)
                                        <span class="badge-status" style="background:var(--brand-blue-light);color:var(--brand-blue-dark);font-size:10px">{{ $keperluan }}</span>
                                    @endforeach
                                </div>
                            @else
                                <span style="color:var(--color-muted)">-</span>
                            @endif
                        </td>

                        {{-- Data Diminta --}}
                        <td>
                            <div style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap" title="{{ $janji->data_diminta ?? '' }}">
                                {{ $janji->data_diminta ?? '-' }}
                            </div>
                        </td>

                        {{-- Tanggal & Jam --}}
                        <td>
                            @if($janji && $janji->tanggal && $janji->jam)
                                <div class="name-cell">{{ \Carbon\Carbon::parse($janji->tanggal)->locale('id')->isoFormat('D MMMM Y') }}</div>
                                <div style="font-size:11px;color:var(--color-muted);margin-top:2px">
                                    Pukul {{ \Carbon\Carbon::parse($janji->jam)->format('H:i') }} WIB
                                </div>
                            @else
                                <span style="color:var(--color-muted);font-style:italic">Belum diatur</span>
                            @endif
                        </td>

                        {{-- Jenis --}}
                        <td>
                            <span class="badge-status {{ ($janji->jenis ?? '') === 'online' ? 'badge-active' : 'badge-inactive' }}">
                                {{ ucfirst($janji->jenis ?? '-') }}
                            </span>
                        </td>

                        {{-- Jumlah Orang --}}
                        <td style="text-align:center">{{ $janji->jumlah_orang ?? 1 }} orang</td>

                        {{-- Status --}}
                        <td>
                            @php
                                $statusClass = match($status) {
                                    'menunggu' => 'background:var(--amber-bg);color:var(--amber-dark)',
                                    'diterima' => 'background:var(--green-bg);color:var(--green-dark)',
                                    'batal' => 'background:var(--red-bg);color:var(--red-dark)',
                                    default => 'background:#f1f5f9;color:var(--color-muted)'
                                };
                            @endphp
                            <span class="badge-status" style="{{ $statusClass }}">
                                <span class="badge-dot" style="background:currentColor"></span>
                                {{ ucfirst($status) }}
                            </span>
                        </td>

                        {{-- Alasan Pembatalan --}}
                        <td>
                            @if($status === 'batal' && $janji->alasan_batal)
                                <div style="background:var(--red-bg);border:1px solid #F7C1C1;color:var(--red-dark);border-radius:8px;padding:8px 10px;font-size:11px;line-height:1.4">
                                    {{ $janji->alasan_batal }}
                                </div>
                            @elseif($status === 'batal')
                                <span style="color:var(--color-muted);font-style:italic;font-size:11px">Tidak ada alasan.</span>
                            @else
                                <span style="color:var(--color-muted)">-</span>
                            @endif
                        </td>

                        {{-- Zoom --}}
                        <td>
                            @if(($janji->jenis ?? '') === 'online' && $janji->zoom_link)
                                <a href="{{ $janji->zoom_link }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="btn-primary" style="padding:4px 10px;font-size:11px">
                                    <i class="ti ti-video"></i> Buka Zoom
                                </a>
                            @elseif(($janji->jenis ?? '') === 'online')
                                <span style="color:var(--color-muted);font-size:11px">Belum ada link</span>
                            @else
                                <span style="color:var(--color-muted)">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" style="text-align:center;padding:40px 16px;color:var(--color-muted);font-size:14px">
                            <i class="ti ti-calendar-off" style="font-size:24px;display:block;margin-bottom:8px"></i>
                            Belum ada jadwal tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="pagination-controls" style="display:flex;justify-content:center;gap:8px;margin-top:16px"></div>

@endsection