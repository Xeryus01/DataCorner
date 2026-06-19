@extends('admin.layout')
@section('content')
<x-admin.page-header title="Edit Pendaftar Riset" subtitle="Perbarui status pendaftaran riset" :breadcrumbs="['Datapedia','Program Riset','Pendaftar','Edit']" />
<div class="card" style="max-width:560px">
    <div class="card-header"><div class="card-header-left"><div class="card-title"><i class="ti ti-file-signature"></i>Form Edit Status</div></div></div>
    <div class="card-body">
        @if($errors->any())<div class="form-error">@foreach($errors->all() as $e)<div>• {{$e}}</div>@endforeach</div>@endif
        <form method="POST" action="{{ route('admin_daftar-riset.update', $pendaftaran_riset) }}">
            @csrf @method('PUT')
            <div style="margin-bottom:16px"><label class="form-label">Status</label><select name="status" class="form-input form-select" required><option value="">-- Pilih Status --</option><option value="diterima" {{ old('status',$pendaftaran_riset->status)=='diterima'?'selected':'' }}>Diterima</option><option value="ditolak" {{ old('status',$pendaftaran_riset->status)=='ditolak'?'selected':'' }}>Ditolak</option></select></div>
            <div class="form-actions"><button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i>Simpan</button><a href="{{route('admin_daftar-riset.index-admin')}}" class="btn-ghost">Batal</a></div>
        </form>
    </div>
</div>
@endsection