@extends('admin.layout')
@section('content')
<x-admin.page-header title="Edit Maklumat" subtitle="Perbarui data maklumat layanan" :breadcrumbs="['Datapedia','Layanan','Maklumat','Edit']" />
<div class="card" style="max-width:560px">
    <div class="card-header"><div class="card-header-left"><div class="card-title"><i class="ti ti-file-text"></i>Form Edit Maklumat</div></div></div>
    <div class="card-body">
        @if($errors->any())<div class="form-error">@foreach($errors->all() as $e)<div>• {{$e}}</div>@endforeach</div>@endif
        <form method="POST" action="{{ route('maklumat.update', $maklumat->id) }}" enctype="multipart/form-data">@method('PUT')@csrf
            <div style="margin-bottom:14px"><label class="form-label">File (Gambar)</label>
                @if($maklumat->file)<img id="preview" src="{{ asset('storage/'.$maklumat->file) }}" style="width:128px;height:128px;object-fit:cover;border-radius:8px;margin-bottom:8px;display:block" alt="preview">
                @else<img id="preview" style="width:128px;height:128px;object-fit:cover;border-radius:8px;margin-bottom:8px;display:none" alt="preview">@endif
                <input type="file" name="file" id="file" style="font-size:13px;width:100%" accept="image/*" onchange="document.getElementById('preview').src=window.URL.createObjectURL(this.files[0]);document.getElementById('preview').style.display='block'">
            </div>
            <div style="margin-bottom:16px"><label class="form-label">Judul</label><input type="text" name="judul" value="{{ old('judul', $maklumat->judul) }}" class="form-input" required></div>
            <div class="form-actions"><button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i>Simpan</button><a href="{{route('maklumat.index')}}" class="btn-ghost">Batal</a></div>
        </form>
    </div>
</div>
@endsection