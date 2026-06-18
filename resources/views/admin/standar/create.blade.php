@extends('admin.layout')
@section('content')
<x-admin.page-header title="Tambah Standar Pelayanan" subtitle="Input data standar pelayanan" :breadcrumbs="['Datapedia','Layanan','Standar','Tambah']" />
<div class="card" style="max-width:560px">
    <div class="card-header"><div class="card-header-left"><div class="card-title"><i class="ti ti-clipboard-check"></i>Form Tambah Standar</div></div></div>
    <div class="card-body">
        @if($errors->any())<div class="form-error">@foreach($errors->all() as $e)<div>• {{$e}}</div>@endforeach</div>@endif
        <form method="POST" action="{{route('standar.store')}}" enctype="multipart/form-data">@csrf
            <div style="margin-bottom:14px"><label class="form-label">Judul</label><input type="text" name="judul" value="{{old('judul')}}" class="form-input" required></div>
            <div style="margin-bottom:16px"><label class="form-label">Gambar</label><input type="file" name="gambar" style="font-size:13px;width:100%" accept="image/*"></div>
            <div class="form-actions"><button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i>Simpan</button><a href="{{route('standar.index')}}" class="btn-ghost">Batal</a></div>
        </form>
    </div>
</div>
@endsection