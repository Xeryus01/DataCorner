@extends('jadwal.layout')
@section('content')

<div class="page-header-row">
    <div>
        <h1 class="page-title">Edit Jadwal Petugas</h1>
        <p class="page-sub">Perbarui tanggal tugas petugas mingguan</p>
    </div>
</div>

<div class="card" style="max-width:500px">
    <div class="card-header">
        <div class="card-header-left">
            <i class="ti ti-calendar-week"></i>
            <span class="card-title">Form Edit Jadwal</span>
        </div>
    </div>
    <div class="card-body">
        @if($errors->any())
        <div class="alert-error">
            @foreach($errors->all() as $e)
                <div>• {{ $e }}</div>
            @endforeach
        </div>
        @endif

        @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('mingguan.update', $petugas->id) }}">
            @csrf
            @method('PUT')
            <div style="margin-bottom:20px">
                <label class="form-label">Nama Petugas</label>
                <input type="text" value="{{ $petugas->konsultan->nama ?? '' }}" disabled class="form-input" style="background:#f8fafc;color:var(--color-muted)">
            </div>
            <div style="margin-bottom:20px">
                <label for="tanggal" class="form-label">Tanggal Tugas</label>
                <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', $petugas->tanggal) }}" required class="form-input">
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="ti ti-device-floppy"></i> Simpan Perubahan
                </button>
                <a href="{{ route('mingguan.index') }}" class="btn-ghost">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection