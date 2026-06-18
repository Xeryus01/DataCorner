@extends('admin.layout')
@section('content')
<x-admin.page-header title="Edit Layanan 24 Jam" subtitle="Perbarui informasi layanan" :breadcrumbs="['Datapedia','Layanan','24 Jam','Edit']" />
<div class="card" style="max-width:560px">
    <div class="card-header">
        <div class="card-header-left">
            <div class="card-title"><i class="ti ti-bell"></i>Form Edit Layanan</div>
        </div>
    </div>
    <div class="card-body">
        @if($errors->any())
        <div class="form-error">
            @foreach($errors->all() as $e)<div>• {{$e}}</div>@endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('layanan.update', $layanan->id) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <div style="margin-bottom:14px">
                <label class="form-label">Gambar Layanan</label>
                @if($layanan->gambar)
                <img id="preview" src="{{ asset('storage/'.$layanan->gambar) }}" style="width:128px;height:128px;object-fit:cover;border-radius:8px;margin-bottom:8px;display:block" alt="preview">
                @else
                <img id="preview" style="width:128px;height:128px;object-fit:cover;border-radius:8px;margin-bottom:8px;display:none" alt="preview">
                @endif
                <input type="file" name="gambar" id="gambar" style="font-size:13px;width:100%" accept="image/*" onchange="document.getElementById('preview').src=window.URL.createObjectURL(this.files[0]);document.getElementById('preview').style.display='block'">
            </div>

            <div style="margin-bottom:14px">
                <label class="form-label">Judul Layanan</label>
                <input type="text" name="judul" value="{{ old('judul', $layanan->judul) }}" class="form-input" required>
            </div>
            <div style="margin-bottom:14px">
                <label class="form-label">Deskripsi Layanan</label>
                <input type="text" name="deskripsi" value="{{ old('deskripsi', $layanan->deskripsi) }}" class="form-input" required>
            </div>
            <div style="margin-bottom:16px">
                <label class="form-label">Link Layanan</label>
                <input type="text" name="link" value="{{ old('link', $layanan->link) }}" class="form-input" required placeholder="https://...">
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i>Simpan</button>
                <a href="{{route('layanan.index')}}" class="btn-ghost">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection