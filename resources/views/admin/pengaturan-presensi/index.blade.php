@extends('admin.layout')
@section('content')
<div class="page-header-row">
    <div>
        <div class="page-title">Data Pengaturan Presensi</div>
        <div class="page-sub">Kelola konfigurasi lokasi dan jam presensi</div>
    </div>
    <a href="{{ route('admin_pengaturan-presensi.create') }}" class="btn-primary"><i class="ti ti-plus"></i>Tambah Pengaturan</a>
</div>

@if(session('success'))
<div style="background:var(--green-bg);border:1px solid #C0DD97;color:var(--green-dark);padding:10px 14px;border-radius:8px;font-size:12px;margin-bottom:0">
    <i class="ti ti-check"></i> {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="card-header">
        <div class="card-header-left">
            <div class="card-title"><i class="ti ti-fingerprint"></i>Daftar Pengaturan <span style="font-size:11px;font-weight:400;color:#94a3b8;margin-left:4px">— {{ $setting->count() }} data</span></div>
        </div>
        <form action="{{ route('admin_pengaturan-presensi.index') }}" method="GET">
            <div class="search-box">
                <i class="ti ti-search"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari lokasi...">
            </div>
        </form>
    </div>
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th class="num-cell">No</th>
                    <th>Lokasi</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Radius (m)</th>
                    <th>Masuk</th>
                    <th>Selesai</th>
                    <th>Pulang</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($setting as $item)
                <tr>
                    <td class="num-cell">{{ $loop->iteration }}</td>
                    <td class="name-cell">{{ $item->wilayahBps->nama_wilayah ?? '-' }}</td>
                    <td>{{ $item->lat_kantor }}</td>
                    <td>{{ $item->long_kantor }}</td>
                    <td>{{ $item->radius_kantor }}</td>
                    <td>{{ $item->jam_masuk_mulai }}</td>
                    <td>{{ $item->jam_masuk_selesai }}</td>
                    <td>{{ $item->jam_pulang_mulai }}</td>
                    <td>
                        @if($item->is_active)
                        <span class="badge-status badge-active"><span class="badge-dot" style="background:#3B6D11"></span>Aktif</span>
                        @else
                        <span class="badge-status badge-inactive">Tidak Aktif</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:5px">
                            <a href="{{ route('admin_pengaturan-presensi.edit', $item->id) }}" class="btn-edit-sm"><i class="ti ti-edit"></i>Edit</a>
                            <form action="{{ route('admin_pengaturan-presensi.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengaturan ini?')" style="margin:0">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-del-sm"><i class="ti ti-trash"></i>Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
                @if($setting->count() == 0)
                <tr><td colspan="10" style="padding:40px;text-align:center;color:#94a3b8;font-size:13px">Belum ada data pengaturan presensi</td></tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="footer-info">Menampilkan {{ $setting->count() }} data</div>
    </div>
</div>
@endsection