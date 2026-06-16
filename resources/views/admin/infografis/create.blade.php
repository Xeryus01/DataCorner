@extends('admin.layout')
@section('content')
<div class="page-header-row">
    <div>
        <div class="page-title">Input Infografis</div>
        <div class="page-sub">Tambah konten infografis edukasi statistik</div>
    </div>
</div>

<div class="card" style="max-width:560px">
    <div class="card-header">
        <div class="card-header-left">
            <div class="card-title"><i class="ti ti-photo"></i>Form Input Infografis</div>
        </div>
    </div>
    <div class="card-body">
        @if($errors->any())
        <div class="form-error">
            @foreach($errors->all() as $e)<div>• {{$e}}</div>@endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('admin_infografis.store') }}" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom:14px">
                <label class="form-label">Subjek Materi</label>
                <select name="subjek_materi" class="form-select" required>
                    <option value="" disabled selected>-- Pilih Subjek --</option>
                    @foreach ($subjek_materi as $subjek)
                    <option value="{{ $subjek->id }}">{{ $subjek->judul }}</option>
                    @endforeach
                </select>
            </div>
            <div style="margin-bottom:14px">
                <label class="form-label">Judul Infografis</label>
                <input type="text" name="judul" value="{{ old('judul') }}" class="form-input" placeholder="Masukkan Judul Infografis" required>
            </div>
            <div style="margin-bottom:14px">
                <label class="form-label">Deskripsi</label>
                <input type="text" name="deskripsi" value="{{ old('deskripsi') }}" class="form-input" placeholder="Masukkan Deskripsi Infografis" required>
            </div>
            <div style="margin-bottom:14px">
                <label class="form-label">Gambar</label>
                <input type="file" name="gambar" style="font-size:13px" accept="image/jpg, image/jpeg, image/png" required>
            </div>
            <div style="margin-bottom:16px">
                <label class="form-label">File Infografis (PDF, JPG, JPEG, PNG)</label>
                <input type="file" name="file_infografis" style="font-size:13px" required>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i>Tambah</button>
                <a href="{{ route('admin_infografis.index') }}" class="btn-ghost">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection