@extends('admin.layout')
@section('content')
<div class="page-header-row">
    <div>
        <div class="page-title">Data Pendaftar Kolaborasi Riset</div>
        <div class="page-sub">Kelola data pendaftaran kolaborasi riset</div>
    </div>
</div>

@if(session('success'))
<div style="background:var(--green-bg);border:1px solid #C0DD97;color:var(--green-dark);padding:10px 14px;border-radius:8px;font-size:12px;margin-bottom:0">
    <i class="ti ti-check"></i> {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="card-header">
        <div class="card-header-left">
            <div class="card-title"><i class="ti ti-file-signature"></i>Daftar Pendaftar <span style="font-size:11px;font-weight:400;color:#94a3b8;margin-left:4px">— {{ $pendaftaran->total() }} data</span></div>
        </div>
        <form action="{{ route('admin_daftar-riset.index-admin') }}" method="GET">
            <div class="search-box">
                <i class="ti ti-search"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama...">
            </div>
        </form>
    </div>
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Judul Riset</th>
                    <th>No. WhatsApp</th>
                    <th>CV</th>
                    <th>Surat Permohonan</th>
                    <th>Surat Motivasi</th>
                    <th>Tgl Mulai</th>
                    <th>Tgl Selesai</th>
                    <th>Status</th>
                    <th>Daftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendaftaran as $item)
                <tr>
                    <td class="name-cell">{{ $item->nama }}</td>
                    <td class="email-cell">{{ $item->email }}</td>
                    <td>{{ $item->judul_riset }}</td>
                    <td>{{ $item->no_hp }}</td>
                    <td><a href="{{ Storage::url($item->cv_file) }}" target="_blank" class="btn-edit-sm">Lihat CV</a></td>
                    <td><a href="{{ Storage::url($item->surat_permohonan) }}" target="_blank" class="btn-edit-sm">Lihat Surat</a></td>
                    <td>{{ $item->surat_motivasi ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d-m-Y') }}</td>
                    <td>
                        @if($item->status == 'diproses')
                        <span class="badge-status" style="background:#FAEEDA;color:#633806"><span class="badge-dot" style="background:#BA7517"></span>Diproses</span>
                        @elseif($item->status == 'diterima')
                        <span class="badge-status badge-active"><span class="badge-dot" style="background:#3B6D11"></span>Diterima</span>
                        @elseif($item->status == 'ditolak')
                        <span class="badge-status badge-inactive">Ditolak</span>
                        @else
                        <span class="badge-status" style="background:#E6F1FB;color:#0C447C">Selesai</span>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i') }}</td>
                    <td>
                        <div style="display:flex;gap:5px">
                            <a href="{{ route('admin_daftar-riset.edit', $item->id) }}" class="btn-edit-sm"><i class="ti ti-edit"></i>Edit</a>
                            <form action="{{ route('admin_daftar-riset.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')" style="margin:0">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-del-sm"><i class="ti ti-trash"></i>Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
                @if($pendaftaran->count() == 0)
                <tr><td colspan="12" style="padding:40px;text-align:center;color:#94a3b8;font-size:13px">Belum ada pendaftar</td></tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <div class="footer-info">Menampilkan {{ $pendaftaran->firstItem() ?? 0 }}–{{ $pendaftaran->lastItem() ?? 0 }} dari {{ $pendaftaran->total() }} data</div>
        {{ $pendaftaran->links() }}
    </div>
</div>
@endsection