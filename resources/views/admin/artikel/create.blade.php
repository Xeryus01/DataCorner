@extends('admin.layout')
@section('content')
<div class="page-header-row">
    <div>
        <div class="page-title">Input Artikel</div>
        <div class="page-sub">Tambah konten artikel edukasi statistik</div>
    </div>
</div>

<div class="card" style="max-width:560px">
    <div class="card-header">
        <div class="card-header-left">
            <div class="card-title"><i class="ti ti-article"></i>Form Input Artikel</div>
        </div>
    </div>
    <div class="card-body">
        @if($errors->any())
        <div class="form-error">
            @foreach($errors->all() as $e)<div>• {{$e}}</div>@endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('admin_artikel.store') }}" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom:14px">
                <label class="form-label">Subjek Materi</label>
                <select name="subjek_materi" class="form-select" required>
                    <option value="">-- Pilih Subjek Materi --</option>
                    @foreach($subjek_materi as $item)
                    <option value="{{ $item->id }}" {{ old('subjek_materi') == $item->id ? 'selected' : '' }}>{{ $item->judul }}</option>
                    @endforeach
                </select>
            </div>
            <div style="margin-bottom:14px">
                <label class="form-label">Judul Artikel</label>
                <input type="text" name="judul" value="{{ old('judul') }}" class="form-input" placeholder="Masukkan Judul Artikel" required>
            </div>
            <div style="margin-bottom:14px">
                <label class="form-label">Deskripsi Artikel</label>
                <input type="text" name="deskripsi" value="{{ old('deskripsi') }}" class="form-input" placeholder="Masukkan Deskripsi Artikel" required>
            </div>
            <div style="margin-bottom:16px">
                <label class="form-label">Gambar Artikel</label>
                <input type="file" name="gambar" style="font-size:13px" accept="image/jpg, image/jpeg, image/png" required>
                @error('gambar') <p style="color:#E24B4A;font-size:11px;margin-top:4px">{{ $message }}</p> @enderror
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i>Tambah</button>
                <a href="{{ route('admin_artikel.index') }}" class="btn-ghost">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection