@extends('jadwal.layout')
@section('content')

<div class="page-header-row">
    <div>
        <h1 class="page-title">Petugas Berprestasi</h1>
        <p class="page-sub">Riwayat prestasi Anda sebagai petugas berprestasi</p>
    </div>
</div>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header">
        <div class="card-header-left">
            <i class="ti ti-star"></i>
            <span class="card-title">Riwayat Prestasi Saya</span>
        </div>
    </div>
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="text-align:center;width:48px">No</th>
                    <th>Nama</th>
                    <th>Triwulan</th>
                    <th>Tahun</th>
                    <th>Nilai</th>
                    <th>Sertifikat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prestasiData as $index => $item)
                    <tr>
                        <td class="num-cell">{{ $index + 1 }}</td>
                        <td class="name-cell">{{ $item->konsultan->nama ?? '-' }}</td>
                        <td>Triwulan {{ $item->triwulan }}</td>
                        <td>{{ $item->tahun }}</td>
                        <td>
                            <span style="font-weight:600">{{ $item->nilai }}</span>
                        </td>
                        <td>
                            @if($item->sertifikat)
                                <a href="{{ asset('storage/' . $item->sertifikat) }}" target="_blank" class="btn-edit-sm">
                                    <i class="ti ti-file"></i> Lihat
                                </a>
                            @else
                                <span style="color:var(--color-muted)">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:40px;color:var(--color-muted);font-size:14px">
                            <i class="ti ti-star-off" style="font-size:24px;display:block;margin-bottom:8px"></i>
                            Belum ada data prestasi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <span class="footer-info">Menampilkan {{ count($prestasiData) }} data prestasi</span>
    </div>
</div>

@endsection