@extends('admin.layout')
@section('content')
<x-admin.page-header title="Tambah Maklumat" subtitle="Input data maklumat layanan" :breadcrumbs="['Datapedia','Layanan','Maklumat','Tambah']" />
<div class="card" style="max-width:560px">
    <div class="card-header"><div class="card-header-left"><div class="card-title"><i class="ti ti-file-text"></i>Form Tambah Maklumat</div></div></div>
    <div class="card-body">
        @if($errors->any())<div class="form-error">@foreach($errors->all() as $e)<div>• {{$e}}</div>@endforeach</div>@endif
        <form method="POST" action="{{route('maklumat.store')}}" enctype="multipart/form-data">@csrf
            <div style="margin-bottom:14px"><label class="form-label">Judul</label><input type="text" name="judul" value="{{old('judul')}}" class="form-input" required></div>
            <div style="margin-bottom:16px"><label class="form-label">File (Gambar)</label><input type="file" name="file" style="font-size:13px;width:100%" accept="image/*"></div>
            <div class="form-actions"><button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i>Simpan</button><a href="{{route('maklumat.index')}}" class="btn-ghost">Batal</a></div>
        </form>
    </div>
</div>
@endsection