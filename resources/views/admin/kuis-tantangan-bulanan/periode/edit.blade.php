@extends('admin.layout')
@section('content')
<x-admin.page-header title="Edit Periode Tantangan" subtitle="Perbarui periode tantangan bulanan" :breadcrumbs="['Datapedia','Kuis','Periode','Edit']" />
<div class="card" style="max-width:500px">
    <div class="card-header"><div class="card-header-left"><div class="card-title"><i class="ti ti-trophy"></i>Form Edit Periode</div></div></div>
    <div class="card-body">
        @if($errors->any())<div class="form-error">@foreach($errors->all() as $e)<div>• {{$e}}</div>@endforeach</div>@endif
        <form action="{{ route('admin_periode.update', $periode) }}" method="POST">
            @csrf @method('PUT')
            <div style="margin-bottom:16px"><label class="form-label">Periode</label><input type="number" name="periode" value="{{old('periode',$periode->periode)}}" class="form-input" required placeholder="Contoh: 202601"></div>
            <div class="form-actions"><button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i>Update</button><a href="{{route('admin_periode.index')}}" class="btn-ghost">Batal</a></div>
        </form>
    </div>
</div>
@endsection