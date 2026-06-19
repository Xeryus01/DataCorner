@extends('admin.layout')
@section('content')
<x-admin.page-header title="Edit Kuis Tantangan" subtitle="Perbarui topik kuis tantangan bulanan" :breadcrumbs="['Datapedia','Kuis','Tantangan','Edit']" />
<div class="card" style="max-width:600px">
    <div class="card-header"><div class="card-header-left"><div class="card-title"><i class="ti ti-trophy"></i>Form Edit Tantangan</div></div></div>
    <div class="card-body">
        @if($errors->any())<div class="form-error">@foreach($errors->all() as $e)<div>• {{$e}}</div>@endforeach</div>@endif
        <form method="POST" action="{{ route('admin_kuis-tantangan-bulanan.update', $kuis_tantangan_bulanan) }}">
            @csrf @method('PUT')
            <div style="margin-bottom:14px"><label class="form-label">Periode</label><select name="periode" class="form-input form-select" required>@foreach($periode as $item)<option value="{{$item->id}}" {{old('periode',$kuis_tantangan_bulanan->id_periode)==$item->id?'selected':''}}>{{$item->periode}}</option>@endforeach</select></div>
            <div style="margin-bottom:14px"><label class="form-label">Judul</label><input type="text" name="judul" value="{{old('judul',$kuis_tantangan_bulanan->judul)}}" class="form-input" required></div>
            <div style="margin-bottom:14px"><label class="form-label">Deskripsi</label><input type="text" name="deskripsi" value="{{old('deskripsi',$kuis_tantangan_bulanan->deskripsi)}}" class="form-input" required></div>
            <div class="form-grid" style="margin-bottom:14px"><div><label class="form-label">Tanggal Mulai</label><input type="date" name="tanggal_mulai" value="{{old('tanggal_mulai',$kuis_tantangan_bulanan->tanggal_mulai)}}" class="form-input" required></div><div><label class="form-label">Tanggal Selesai</label><input type="date" name="tanggal_selesai" value="{{old('tanggal_selesai',$kuis_tantangan_bulanan->tanggal_selesai)}}" class="form-input" required></div></div>
            <div class="form-grid" style="margin-bottom:14px"><div><label class="form-label">Durasi (menit)</label><input type="number" name="durasi_menit" value="{{old('durasi_menit',$kuis_tantangan_bulanan->durasi_menit)}}" class="form-input" required></div><div><label class="form-label">Status</label><select name="status" class="form-input form-select" required><option value="">-- Pilih --</option><option value="aktif" {{old('status',$kuis_tantangan_bulanan->status)=='aktif'?'selected':''}}>Aktif</option><option value="nonaktif" {{old('status',$kuis_tantangan_bulanan->status)=='nonaktif'?'selected':''}}>Non-Aktif</option></select></div></div>
            <div class="form-actions"><button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i>Update</button><a href="{{route('admin_kuis-tantangan-bulanan.index')}}" class="btn-ghost">Batal</a></div>
        </form>
    </div>
</div>
@endsection