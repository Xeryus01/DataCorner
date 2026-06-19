@extends('admin.layout')
@section('content')
<x-admin.page-header title="Buat Pengaturan Presensi" subtitle="Input data pengaturan presensi per wilayah" :breadcrumbs="['Datapedia','Program Magang','Presensi','Tambah']" />
<div class="card" style="max-width:600px">
    <div class="card-header"><div class="card-header-left"><div class="card-title"><i class="ti ti-cogs"></i>Form Presensi</div></div></div>
    <div class="card-body">
        @if($errors->any())<div class="form-error">@foreach($errors->all() as $e)<div>• {{$e}}</div>@endforeach</div>@endif
        <form action="{{ route('admin_pengaturan-presensi.store') }}" method="POST">
            @csrf
            <div style="margin-bottom:14px"><label class="form-label">Wilayah BPS</label><select name="wilayah_bps_id" class="form-input form-select" required><option value="">-- Pilih Wilayah --</option>@foreach($wilayahBps as $w)<option value="{{$w->id}}" {{ old('wilayah_bps_id')==$w->id?'selected':'' }}>{{$w->nama_wilayah}}</option>@endforeach</select></div>
            <div class="form-grid" style="margin-bottom:14px"><div><label class="form-label">Latitude Kantor</label><input type="text" name="lat_kantor" value="{{old('lat_kantor')}}" class="form-input" placeholder="-2.131432"></div><div><label class="form-label">Longitude Kantor</label><input type="text" name="long_kantor" value="{{old('long_kantor')}}" class="form-input" placeholder="106.116789"></div></div>
            <div class="form-grid" style="margin-bottom:14px"><div><label class="form-label">Jam Masuk Mulai</label><input type="time" name="jam_masuk_mulai" value="{{old('jam_masuk_mulai')}}" class="form-input" required></div><div><label class="form-label">Jam Masuk Selesai</label><input type="time" name="jam_masuk_selesai" value="{{old('jam_masuk_selesai')}}" class="form-input" required></div></div>
            <div class="form-grid" style="margin-bottom:14px"><div><label class="form-label">Jam Pulang Mulai</label><input type="time" name="jam_pulang_mulai" value="{{old('jam_pulang_mulai')}}" class="form-input" required></div><div><label class="form-label">Radius (meter)</label><input type="number" name="radius_kantor" value="{{old('radius_kantor',100)}}" class="form-input"></div></div>
            <div style="margin-bottom:16px"><label class="form-check"><input type="checkbox" name="is_active" value="1" checked><span>Aktifkan presensi</span></label></div>
            <div class="form-actions"><button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i>Simpan</button><a href="{{route('admin_pengaturan-presensi.index')}}" class="btn-ghost">Batal</a></div>
        </form>
    </div>
</div>
@endsection