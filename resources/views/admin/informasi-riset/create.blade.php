@extends('admin.layout')
@section('content')
<x-admin.page-header title="Tambah Informasi Riset" subtitle="Input data informasi program riset" :breadcrumbs="['Datapedia','Riset','Informasi','Tambah']" />
<div class="card" style="background:#fff;border:0.5px solid #e2e8f0;border-radius:12px;overflow:hidden;max-width:640px">
    <div style="padding:14px 20px;border-bottom:0.5px solid #e2e8f0"><div style="font-size:13px;font-weight:600;color:#0f172a;display:flex;align-items:center;gap:8px"><i class="ti ti-flask" style="font-size:16px;color:#1F6FD6"></i>Form Tambah Informasi Riset</div></div>
    <div style="padding:20px">
        @if($errors->any())
        <div style="background:#FCEBEB;border:1px solid #F7C1C1;color:#791F1F;padding:10px 14px;border-radius:8px;font-size:12px;margin-bottom:16px">@foreach($errors->all() as $e)<div>• {{$e}}</div>@endforeach</div>
        @endif
        <form method="POST" action="{{route('admin_informasi-riset.store')}}" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom:14px"><label style="display:block;font-size:12px;font-weight:600;color:#0f172a;margin-bottom:5px">Judul</label><input type="text" name="judul" value="{{old('judul')}}" required style="width:100%;height:40px;padding:0 12px;border:0.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none"></div>
            <div style="margin-bottom:14px"><label style="display:block;font-size:12px;font-weight:600;color:#0f172a;margin-bottom:5px">Deskripsi</label><textarea name="deskripsi" rows="4" required style="width:100%;padding:10px 12px;border:0.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none">{{old('deskripsi')}}</textarea></div>
            <div style="margin-bottom:14px"><label style="display:block;font-size:12px;font-weight:600;color:#0f172a;margin-bottom:5px">Persyaratan</label><textarea name="persyaratan" rows="4" required style="width:100%;padding:10px 12px;border:0.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none">{{old('persyaratan')}}</textarea></div>
            <div style="margin-bottom:14px"><label style="display:block;font-size:12px;font-weight:600;color:#0f172a;margin-bottom:5px">Benefit</label><textarea name="benefit" rows="3" style="width:100%;padding:10px 12px;border:0.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none">{{old('benefit')}}</textarea></div>
            <div style="margin-bottom:14px"><label style="display:block;font-size:12px;font-weight:600;color:#0f172a;margin-bottom:5px">Info Kontak</label><input type="text" name="info_kontak" value="{{old('info_kontak')}}" style="width:100%;height:40px;padding:0 12px;border:0.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none"></div>
            <div style="margin-bottom:20px"><label style="display:block;font-size:12px;font-weight:600;color:#0f172a;margin-bottom:5px">Status</label><select name="status" required style="width:100%;height:40px;padding:0 12px;border:0.5px solid #e2e8f0;border-radius:8px;background:#fff;font-size:13px;outline:none"><option value="aktif" {{old('status')=='aktif'?'selected':''}}>Aktif</option><option value="nonaktif" {{old('status')=='nonaktif'?'selected':''}}>Nonaktif</option></select></div>
            <div style="display:flex;gap:8px">
                <button type="submit" style="display:inline-flex;align-items:center;gap:6px;padding:8px 20px;background:#1F6FD6;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:500;cursor:pointer" onmouseover="this.style.background='#185FA5'" onmouseout="this.style.background='#1F6FD6'"><i class="ti ti-device-floppy" style="font-size:14px"></i>Simpan</button>
                <a href="{{route('admin_informasi-riset.index')}}" style="display:inline-flex;align-items:center;gap:6px;padding:8px 20px;background:#fff;color:#64748b;border:0.5px solid #e2e8f0;border-radius:8px;font-size:13px;font-weight:500;text-decoration:none">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection