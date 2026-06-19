@extends('admin.layout')
@section('content')
<x-admin.page-header title="Edit Footer Item" subtitle="Perbarui data item footer" :breadcrumbs="['Datapedia','Konten','Footer','Edit']" />
<div class="card" style="max-width:560px">
    <div class="card-header"><div class="card-header-left"><div class="card-title"><i class="ti ti-link"></i>Form Edit Footer Item</div></div></div>
    <div class="card-body">
        @if($errors->any())<div class="form-error">@foreach($errors->all() as $e)<div>• {{$e}}</div>@endforeach</div>@endif
        <form action="{{ route('footer-item.update', $footerItem) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div style="margin-bottom:14px"><label class="form-label">Section Footer</label><select name="section" class="form-input form-select" required><option value="">-- Pilih Section --</option><option value="tentang_kami" {{ old('section',$footerItem->section)=='tentang_kami'?'selected':'' }}>Tentang Kami</option><option value="magang" {{ old('section',$footerItem->section)=='magang'?'selected':'' }}>Magang</option><option value="akademi_statistik" {{ old('section',$footerItem->section)=='akademi_statistik'?'selected':'' }}>Akademi Statistik</option><option value="kontak_kami" {{ old('section',$footerItem->section)=='kontak_kami'?'selected':'' }}>Kontak Kami</option></select></div>
            <div style="margin-bottom:14px"><label class="form-label">Judul</label><input type="text" name="title" value="{{ old('title',$footerItem->title) }}" class="form-input" required></div>
            <div style="margin-bottom:14px"><label class="form-label">Tipe Item</label><select name="type" id="type" class="form-input form-select" required><option value="link" {{ old('type',$footerItem->type)=='link'?'selected':'' }}>Link</option><option value="pdf" {{ old('type',$footerItem->type)=='pdf'?'selected':'' }}>PDF</option><option value="image" {{ old('type',$footerItem->type)=='image'?'selected':'' }}>Gambar</option></select></div>
            <div style="margin-bottom:14px" id="urlField"><label class="form-label">URL Link</label><input type="text" name="url" value="{{ old('url',$footerItem->url) }}" class="form-input" placeholder="https://..."></div>
            <div style="margin-bottom:14px" id="fileField"><label class="form-label">Upload File Baru</label><input type="file" name="file" style="font-size:13px;width:100%" accept=".pdf,.jpg,.jpeg,.png,.webp">@if($footerItem->file_path)<p style="font-size:11px;color:var(--color-muted);margin-top:4px">File saat ini: <a href="{{Storage::url($footerItem->file_path)}}" target="_blank" style="color:var(--brand-blue)">Lihat</a></p>@endif</div>
            <div style="margin-bottom:14px"><label class="form-label">Urutan Tampil</label><input type="number" name="sort_order" value="{{ old('sort_order',$footerItem->sort_order) }}" class="form-input" min="0"></div>
            <div style="margin-bottom:16px;display:flex;gap:16px"><label class="form-check"><input type="checkbox" name="is_active" value="1" {{ old('is_active',$footerItem->is_active)?'checked':'' }}><span>Aktif</span></label><label class="form-check"><input type="checkbox" name="open_new_tab" value="1" {{ old('open_new_tab',$footerItem->open_new_tab)?'checked':'' }}><span>Buka di tab baru</span></label></div>
            <div class="form-actions"><button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i>Update</button><a href="{{ route('footer-item.index') }}" class="btn-ghost">Batal</a></div>
        </form>
    </div>
</div>
<script>const typeSelect=document.getElementById('type'),urlField=document.getElementById('urlField'),fileField=document.getElementById('fileField');function toggleField(){if(typeSelect.value==='link'){urlField.style.display='block';fileField.style.display='none'}else{urlField.style.display='none';fileField.style.display='block'}}typeSelect.addEventListener('change',toggleField);toggleField();</script>
@endsection