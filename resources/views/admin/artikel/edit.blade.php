@extends('admin.layout')
@section('content')
<x-admin.page-header title="Edit Artikel" subtitle="Perbarui data artikel" :breadcrumbs="['Datapedia','Edukasi','Artikel','Edit']" />
<div class="card" style="max-width:560px">
    <div class="card-header"><div class="card-header-left"><div class="card-title"><i class="ti ti-article"></i>Form Edit Artikel</div></div></div>
    <div class="card-body">
        @if($errors->any())<div class="form-error">@foreach($errors->all() as $e)<div>• {{$e}}</div>@endforeach</div>@endif
        <form method="POST" action="{{ route('admin_artikel.update', $artikel->id) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div style="margin-bottom:14px"><label class="form-label">Subjek Materi</label><select name="subjek_materi_id" class="form-input form-select" required>@foreach($subjek_materi??[] as $item)<option value="{{$item->id}}" {{ old('subjek_materi_id', $artikel->subjek_materi_id)==$item->id?'selected':'' }}>{{$item->judul}}</option>@endforeach</select></div>
            <div style="margin-bottom:14px"><label class="form-label">Judul Artikel</label><input type="text" name="judul" value="{{ old('judul', $artikel->judul) }}" class="form-input" required></div>
            <div style="margin-bottom:14px"><label class="form-label">Deskripsi</label><input type="text" name="deskripsi" value="{{ old('deskripsi', $artikel->deskripsi) }}" class="form-input" required></div>
            <div style="margin-bottom:16px"><label class="form-label">Gambar</label><input type="file" name="gambar" style="font-size:13px;width:100%" accept="image/*"><p style="font-size:11px;color:var(--color-muted);margin-top:4px">Biarkan kosong jika tidak ingin mengubah.</p></div>
            <div class="form-actions"><button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i>Update</button><a href="{{ route('admin_artikel.index') }}" class="btn-ghost">Batal</a></div>
        </form>
    </div>
</div>
@endsection