@extends('admin.layout')
@section('content')
<div class="page-header-row">
    <div>
        <div class="page-title">Topik Kuis Reguler</div>
        <div class="page-sub">Kelola topik kuis reguler dan soal-soalnya</div>
    </div>
    <a href="{{ route('admin_kuis-reguler.create') }}" class="btn-primary"><i class="ti ti-plus"></i>Tambah Data</a>
</div>

@if(session('success'))
<div style="background:var(--green-bg);border:1px solid #C0DD97;color:var(--green-dark);padding:10px 14px;border-radius:8px;font-size:12px;margin-bottom:0">
    <i class="ti ti-check"></i> {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="card-header">
        <div class="card-header-left">
            <div class="card-title"><i class="ti ti-question-mark"></i>Daftar Kuis Reguler <span style="font-size:11px;font-weight:400;color:#94a3b8;margin-left:4px">— {{ count($kuis) }} data</span></div>
        </div>
        <form action="{{ route('admin_kuis-reguler.index') }}" method="GET">
            <div class="search-box">
                <i class="ti ti-search"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Judul">
            </div>
        </form>
    </div>
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Gambar</th>
                    <th>Durasi (Menit)</th>
                    <th>Soal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kuis as $item)
                <tr>
                    <td class="name-cell">{{ $item->judul }}</td>
                    <td style="color:var(--color-muted);font-size:12px">{!! Str::limit($item->deskripsi, 50, '...') !!}</td>
                    <td><img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar" style="max-width:60px;max-height:60px;border-radius:6px"></td>
                    <td>{{ $item->durasi_menit }}</td>
                    <td>
                        <a href="{{ route('admin_soal-kuis-reguler.index', $item->id) }}" target="_blank" class="btn-edit-sm">Lihat Soal</a>
                    </td>
                    <td>
                        <div style="display:flex;gap:5px">
                            <a href="{{ route('admin_kuis-reguler.edit', $item->id) }}" class="btn-edit-sm"><i class="ti ti-edit"></i>Edit</a>
                            <form action="{{ route('admin_kuis-reguler.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')" style="margin:0">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-del-sm"><i class="ti ti-trash"></i>Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
                @if(count($kuis) == 0)
                <tr><td colspan="6" style="padding:40px;text-align:center;color:#94a3b8;font-size:13px">Belum ada kuis reguler</td></tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="footer-info">Menampilkan {{ count($kuis) }} data</div>
    </div>
</div>
@endsection