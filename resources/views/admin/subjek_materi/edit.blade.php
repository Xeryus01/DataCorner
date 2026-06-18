@extends('admin.layout')
@section('content')
<x-admin.page-header title="Edit Subjek Materi" subtitle="Perbarui data subjek materi" :breadcrumbs="['Datapedia','Edukasi','Subjek Materi','Edit']" />
<div class="card" style="max-width:560px">
    <div class="card-header"><div class="card-header-left"><div class="card-title"><i class="ti ti-stack"></i>Form Edit Subjek Materi</div></div></div>
    <div class="card-body">
        @if($errors->any())<div class="form-error">@foreach($errors->all() as $e)<div>• {{$e}}</div>@endforeach</div>@endif
        <form action="{{ route('admin_subjek-materi.update', $subjek_materi->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div style="margin-bottom:14px"><label class="form-label">Judul</label><input type="text" name="judul" value="{{ old('judul', $subjek_materi->judul) }}" class="form-input" required></div>
            <div style="margin-bottom:14px"><label class="form-label">Deskripsi</label><input type="text" name="deskripsi" value="{{ old('deskripsi', $subjek_materi->deskripsi) }}" class="form-input" required></div>
            <div style="margin-bottom:16px"><label class="form-label">Gambar</label><input type="file" name="gambar" style="font-size:13px;width:100%" accept="image/*"><p style="font-size:11px;color:var(--color-muted);margin-top:4px">Biarkan kosong jika tidak ingin mengubah.</p></div>
            <div class="form-actions"><button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i>Update</button><a href="{{ route('admin_subjek-materi.index') }}" class="btn-ghost">Batal</a></div>
        </form>
    </div>
</div>
@endsection