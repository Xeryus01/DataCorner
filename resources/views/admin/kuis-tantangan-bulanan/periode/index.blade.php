@extends('admin.layout')
@section('content')
<div class="page-header-row">
    <div>
        <div class="page-title">Periode Tantangan</div>
        <div class="page-sub">Kelola periode kuis tantangan dan leaderboard</div>
    </div>
</div>

@if(session('success'))
<div style="background:var(--green-bg);border:1px solid #C0DD97;color:var(--green-dark);padding:10px 14px;border-radius:8px;font-size:12px;margin-bottom:0">
    <i class="ti ti-check"></i> {{ session('success') }}
</div>
@endif

<div class="card" style="max-width:480px">
    <div class="card-header">
        <div class="card-header-left">
            <div class="card-title"><i class="ti ti-calendar-plus"></i>Input Periode</div>
        </div>
    </div>
    <div class="card-body">
        @if($errors->any())
        <div class="form-error">
            @foreach($errors->all() as $e)<div>• {{$e}}</div>@endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('admin_periode.store') }}">
            @csrf
            <div style="margin-bottom:14px">
                <label class="form-label">Periode</label>
                <input type="number" name="periode" value="{{ old('periode') }}" class="form-input" placeholder="Masukkan Periode" required>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i>Tambah</button>
            </div>
        </form>
    </div>
</div>

<div class="card" style="margin-top:14px">
    <div class="card-header">
        <div class="card-header-left">
            <div class="card-title"><i class="ti ti-trophy"></i>Data Periode <span style="font-size:11px;font-weight:400;color:#94a3b8;margin-left:4px">— {{ count($periods) }} data</span></div>
        </div>
    </div>
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Periode</th>
                    <th>Status Leaderboard</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($periods as $periode)
                <tr>
                    <td class="name-cell">{{ $periode->periode }}</td>
                    <td>
                        @if($periode->status_leaderboard === 'aktif')
                        <span class="badge-status badge-active"><span class="badge-dot" style="background:#3B6D11"></span>Aktif</span>
                        @else
                        <span class="badge-status badge-inactive">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:5px;flex-wrap:wrap">
                            <a href="{{ route('admin_periode.edit', $periode->id) }}" class="btn-edit-sm"><i class="ti ti-edit"></i>Edit</a>
                            <form action="{{ route('admin_periode.destroy', $periode->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')" style="margin:0">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-del-sm"><i class="ti ti-trash"></i>Hapus</button>
                            </form>
                            @if($periode->status_leaderboard === 'aktif')
                            <form action="{{ route('admin_periode.nonaktifkanLeaderboard') }}" method="POST" style="margin:0">
                                @csrf
                                <button type="submit" class="btn-ghost" style="padding:4px 9px;font-size:11px">Nonaktifkan</button>
                            </form>
                            @else
                            <form action="{{ route('admin_periode.setLeaderboard', $periode->id) }}" method="POST" style="margin:0">
                                @csrf
                                <button type="submit" class="btn-primary" style="padding:4px 9px;font-size:11px"><i class="ti ti-check"></i>Aktifkan</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
                @if(count($periods) == 0)
                <tr><td colspan="3" style="padding:40px;text-align:center;color:#94a3b8;font-size:13px">Belum ada periode</td></tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="footer-info">Menampilkan {{ count($periods) }} data</div>
    </div>
</div>
@endsection