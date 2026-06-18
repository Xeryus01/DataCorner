@extends('admin.layout')
@section('content')
<x-admin.page-header title="Edit Survei Layanan" subtitle="Perbarui link survei kepuasan layanan" :breadcrumbs="['Datapedia','Layanan','Survei','Edit']" />
<div class="card" style="max-width:560px">
    <div class="card-header"><div class="card-header-left"><div class="card-title"><i class="ti ti-poll"></i>Form Edit Survei</div></div></div>
    <div class="card-body">
        @if($errors->any())<div class="form-error">@foreach($errors->all() as $e)<div>• {{$e}}</div>@endforeach</div>@endif
        <form action="{{ route('survei-layanan.update', $surveiLayanan->id) }}" method="POST">
            @csrf @method('PUT')
            <div style="margin-bottom:14px"><label class="form-label">Tahun</label><input type="number" name="tahun" value="{{ old('tahun', $surveiLayanan->tahun) }}" class="form-input" required></div>
            <div style="margin-bottom:14px"><label class="form-label">Link Survei</label><input type="text" name="link" value="{{ old('link', $surveiLayanan->link) }}" class="form-input" required placeholder="https://..."></div>
            <div style="margin-bottom:16px"><label class="form-check"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $surveiLayanan->is_active) ? 'checked' : '' }}><span>Aktif</span></label></div>
            <div class="form-actions"><button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i>Update</button><a href="{{ route('survei-layanan.index') }}" class="btn-ghost">Batal</a></div>
        </form>
    </div>
</div>
@endsection