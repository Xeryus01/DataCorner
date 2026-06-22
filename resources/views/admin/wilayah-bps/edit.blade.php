@extends('admin.layout')
@section('content')
<x-admin.page-header title="Edit Wilayah BPS" subtitle="Perbarui data wilayah BPS" :breadcrumbs="['Datapedia','Master Data','Wilayah BPS','Edit']" />
<div class="card" style="max-width:560px">
    <div class="card-header"><div class="card-header-left"><div class="card-title"><i class="ti ti-map-pin"></i>Form Edit Wilayah</div></div></div>
    <div class="card-body">
        @if($errors->any())<div class="form-error">@foreach($errors->all() as $e)<div>• {{$e}}</div>@endforeach</div>@endif
        <form action="{{ route('admin_wilayah-bps.update', $wilayahBps->id) }}" method="POST">
            @csrf @method('PUT')
            <div style="margin-bottom:14px"><label class="form-label">Nama Wilayah*</label><input type="text" name="nama_wilayah" value="{{ old('nama_wilayah', $wilayahBps->nama_wilayah) }}" class="form-input" required></div>
            <div style="margin-bottom:14px"><label class="form-label">Kode Wilayah*</label><input type="text" name="kode_wilayah" value="{{ old('kode_wilayah', $wilayahBps->kode_wilayah) }}" class="form-input" required></div>
            <div style="margin-bottom:16px"><label class="form-label">Tingkat Wilayah*</label><select name="tingkat_wilayah" class="form-input form-select" required><option value="">-- Pilih --</option><option value="provinsi" {{ old('tingkat_wilayah', $wilayahBps->tingkat_wilayah)=='provinsi'?'selected':'' }}>Provinsi</option><option value="kabupaten" {{ old('tingkat_wilayah', $wilayahBps->tingkat_wilayah)=='kabupaten'?'selected':'' }}>Kabupaten</option><option value="kota" {{ old('tingkat_wilayah', $wilayahBps->tingkat_wilayah)=='kota'?'selected':'' }}>Kota</option></select></div>
            <div class="form-actions"><button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i>Simpan</button><a href="{{ route('admin_wilayah-bps.index') }}" class="btn-ghost">Batal</a></div>
        </form>
    </div>
</div>
@endsection