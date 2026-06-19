@extends('admin.layout')
@section('content')
<x-admin.page-header title="Edit Kuis Reguler" subtitle="Perbarui topik kuis reguler" :breadcrumbs="['Datapedia','Kuis','Kuis Reguler','Edit']" />
<div class="card" style="max-width:600px">
    <div class="card-header"><div class="card-header-left"><div class="card-title"><i class="ti ti-question-mark"></i>Form Edit Kuis</div></div></div>
    <div class="card-body">
        @if($errors->any())<div class="form-error">@foreach($errors->all() as $e)<div>• {{$e}}</div>@endforeach</div>@endif
        <form method="POST" action="{{ route('admin_kuis-reguler.update', $kuis_reguler) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div style="margin-bottom:14px"><label class="form-label">Judul Kuis</label><input type="text" name="judul" value="{{old('judul',$kuis_reguler->judul)}}" class="form-input" required></div>
            <div style="margin-bottom:14px"><label class="form-label">Deskripsi</label><textarea name="deskripsi" id="editor" class="form-textarea" rows="6">{{old('deskripsi',$kuis_reguler->deskripsi)}}</textarea></div>
            <div style="margin-bottom:14px"><label class="form-label">Gambar</label><input type="file" name="gambar" style="font-size:13px;width:100%" accept="image/*"><p style="font-size:11px;color:var(--color-muted);margin-top:4px">Biarkan kosong jika tidak ingin mengubah.</p></div>
            <div style="margin-bottom:16px"><label class="form-label">Durasi (menit)</label><input type="number" name="durasi_menit" value="{{old('durasi_menit',$kuis_reguler->durasi_menit)}}" class="form-input" required></div>
            <div class="form-actions"><button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i>Update</button><a href="{{route('admin_kuis-reguler.index')}}" class="btn-ghost">Batal</a></div>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@35.3.0/build/ckeditor.js"></script><script>ClassicEditor.create(document.querySelector('#editor'),{toolbar:['heading','|','bold','italic','underline','strikethrough','|','fontColor','fontSize','|','link','bulletedList','numberedList','|','alignment','insertTable','|','undo','redo'],fontSize:{options:[9,11,13,'default',17,19,21]}}).catch(e=>console.error(e));</script>
@endsection