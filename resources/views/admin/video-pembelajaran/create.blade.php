@extends('admin.layout')
@section('content')
<div class="page-header-row">
    <div>
        <div class="page-title">Input Video Pembelajaran</div>
        <div class="page-sub">Tambah konten video pembelajaran edukasi statistik</div>
    </div>
</div>

<div class="card" style="max-width:560px">
    <div class="card-header">
        <div class="card-header-left">
            <div class="card-title"><i class="ti ti-video"></i>Form Input Video Pembelajaran</div>
        </div>
    </div>
    <div class="card-body">
        @if($errors->any())
        <div class="form-error">
            @foreach($errors->all() as $e)<div>• {{$e}}</div>@endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('admin_video-pembelajaran.store') }}">
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
                <label class="form-label">Judul Video</label>
                <input type="text" name="judul" value="{{ old('judul') }}" class="form-input" placeholder="Masukkan Judul Video" required>
            </div>
            <div style="margin-bottom:14px">
                <label class="form-label">Deskripsi</label>
                <input type="text" name="deskripsi" value="{{ old('deskripsi') }}" class="form-input" placeholder="Masukkan Deskripsi Video" required>
            </div>
            <div style="margin-bottom:16px">
                <label class="form-label">Link Video</label>
                <input type="text" name="link" value="{{ old('link') }}" class="form-input" placeholder="Masukkan Link Video" required>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i>Tambah</button>
                <a href="{{ route('admin_video-pembelajaran.index') }}" class="btn-ghost">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection