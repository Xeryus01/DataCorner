@extends('admin.layout')
@section('content')
<x-admin.page-header title="Edit Jam Operasional" subtitle="Perbarui data jam operasional" :breadcrumbs="['Datapedia','Layanan','Jam Operasional','Edit']" />
<div class="card" style="max-width:560px">
    <div class="card-header"><div class="card-header-left"><div class="card-title"><i class="ti ti-clock"></i>Form Edit Jam Operasional</div></div></div>
    <div class="card-body">
        @if($errors->any())<div class="form-error">@foreach($errors->all() as $e)<div>• {{$e}}</div>@endforeach</div>@endif
        <form method="POST" action="{{ route('jam-operasional.update', $jamOperasional->id) }}">
            @method('PUT')@csrf
            <div style="margin-bottom:14px"><label class="form-label">Keterangan Hari</label><input type="text" name="keterangan_hari" value="{{ old('keterangan_hari', $jamOperasional->keterangan_hari) }}" class="form-input" required></div>
            <div style="margin-bottom:14px"><label class="form-label">Jam Mulai</label><input type="time" name="jam_mulai" value="{{ old('jam_mulai', \Carbon\Carbon::parse($jamOperasional->jam_mulai)->format('H:i')) }}" class="form-input" required></div>
            <div style="margin-bottom:16px"><label class="form-label">Jam Selesai</label><input type="time" name="jam_selesai" value="{{ old('jam_selesai', \Carbon\Carbon::parse($jamOperasional->jam_selesai)->format('H:i')) }}" class="form-input" required></div>
            <div class="form-actions"><button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i>Simpan</button><a href="{{route('jam-operasional.index')}}" class="btn-ghost">Batal</a></div>
        </form>
    </div>
</div>
@endsection