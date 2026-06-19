@extends('admin.layout')
@section('content')
<x-admin.page-header title="Buat FAQ" subtitle="Input data pertanyaan yang sering diajukan" :breadcrumbs="['Datapedia','FAQ','Tambah']" />
<div class="card" style="max-width:600px">
    <div class="card-header"><div class="card-header-left"><div class="card-title"><i class="ti ti-help"></i>Form Tambah FAQ</div></div></div>
    <div class="card-body">
        @if($errors->any())<div class="form-error">@foreach($errors->all() as $e)<div>• {{$e}}</div>@endforeach</div>@endif
        <form method="POST" action="{{ route('faq.store') }}">
            @csrf
            <div style="margin-bottom:14px"><label class="form-label">Judul FAQ*</label><input type="text" name="judul" value="{{old('judul')}}" class="form-input" required placeholder="Masukkan judul FAQ"></div>
            <div style="margin-bottom:16px"><label class="form-label">Deskripsi FAQ*</label><textarea id="deskripsi" name="deskripsi" class="form-textarea" rows="8">{{old('deskripsi')}}</textarea></div>
            <div class="form-actions"><button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i>Simpan</button><a href="{{route('faq.index')}}" class="btn-ghost">Batal</a></div>
        </form>
    </div>
</div>
<script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
<script>
tinymce.init({selector:'#deskripsi',license_key:'gpl',height:300,plugins:['lists','link','table','code'],toolbar:'undo redo | bold italic underline | bullist numlist | alignleft aligncenter alignright | link table | code',menubar:false,branding:false,content_style:'body{font-family:sans-serif;font-size:16px}ul{list-style-type:disc;margin-left:1.5rem}ol{list-style-type:decimal;margin-left:1.5rem}'});
document.querySelector('form').addEventListener('submit',function(){tinymce.triggerSave();});
</script>
@endsection