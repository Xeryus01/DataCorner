@extends('jadwal.layout')
@section('content')

<div class="page-header-row">
    <div>
        <h1 class="page-title">Jadwal Petugas Mingguan</h1>
        <p class="page-sub">Kelola jadwal tugas Anda sebagai petugas mingguan</p>
    </div>
    <a href="{{ route('mingguan.create') }}" class="btn-primary">
        <i class="ti ti-plus"></i> Tambah Jadwal
    </a>
</div>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert-error">{{ session('error') }}</div>
@endif

<div class="card">
    <div class="card-header">
        <div class="card-header-left">
            <i class="ti ti-calendar-week"></i>
            <span class="card-title">Daftar Jadwal Saya</span>
        </div>
    </div>
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="text-align:center;width:48px">No</th>
                    <th>Nama Petugas</th>
                    <th>Tanggal Tugas</th>
                    <th style="text-align:center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($petugasMingguan as $index => $petugas)
                    <tr>
                        <td class="num-cell">{{ $petugasMingguan->count() - $index }}</td>
                        <td class="name-cell">{{ $petugas->konsultan->nama ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($petugas->tanggal)->locale('id')->isoFormat('dddd, D MMMM Y') }}</td>
                        <td>
                            <div style="display:flex;gap:5px;justify-content:center">
                                <a href="{{ route('mingguan.edit', $petugas->id) }}" class="btn-edit-sm">
                                    <i class="ti ti-edit"></i> Edit
                                </a>
                                <form action="{{ route('mingguan.destroy', $petugas->id) }}" method="POST" style="margin:0">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus jadwal ini?')" class="btn-del-sm">
                                        <i class="ti ti-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center;padding:40px;color:var(--color-muted);font-size:14px">
                            <i class="ti ti-calendar-off" style="font-size:24px;display:block;margin-bottom:8px"></i>
                            Belum ada jadwal tugas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <span class="footer-info">Menampilkan {{ $petugasMingguan->count() }} jadwal</span>
    </div>
</div>

@endsection