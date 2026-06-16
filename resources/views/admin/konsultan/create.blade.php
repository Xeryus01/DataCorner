@extends('admin.layout')
@section('content')
<x-admin.page-header title="Tambah Konsultan" subtitle="Buat data konsultan baru" :breadcrumbs="['Datapedia','Manajemen','Konsultan','Tambah']" />
<div class="card" style="background:#fff;border:0.5px solid #e2e8f0;border-radius:12px;overflow:hidden;max-width:640px">
    <div style="padding:14px 20px;border-bottom:0.5px solid #e2e8f0"><div style="font-size:13px;font-weight:600;color:#0f172a;display:flex;align-items:center;gap:8px"><i class="ti ti-tie" style="font-size:16px;color:#1F6FD6"></i>Form Tambah Konsultan</div></div>
    <div style="padding:20px">
        @if($errors->any())<div style="background:#FCEBEB;border:1px solid #F7C1C1;color:#791F1F;padding:10px 14px;border-radius:8px;font-size:12px;margin-bottom:16px">@foreach($errors->all() as $e)<div>• {{$e}}</div>@endforeach</div>@endif
        <form method="POST" action="{{route('konsultan.store')}}" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom:14px"><label style="display:block;font-size:12px;font-weight:600;color:#0f172a;margin-bottom:5px">Nama</label><input type="text" name="nama" value="{{old('nama')}}" required style="width:100%;height:40px;padding:0 12px;border:0.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none"></div>
            <div style="margin-bottom:14px"><label style="display:block;font-size:12px;font-weight:600;color:#0f172a;margin-bottom:5px">Email</label><input type="email" name="email" value="{{old('email')}}" required style="width:100%;height:40px;padding:0 12px;border:0.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none"></div>
            <div style="margin-bottom:20px"><label style="display:block;font-size:12px;font-weight:600;color:#0f172a;margin-bottom:5px">Password</label><input type="password" name="password" required style="width:100%;height:40px;padding:0 12px;border:0.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none"></div>
            <div style="display:flex;gap:8px"><button type="submit" style="display:inline-flex;align-items:center;gap:6px;padding:8px 20px;background:#1F6FD6;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:500;cursor:pointer" onmouseover="this.style.background='#185FA5'" onmouseout="this.style.background='#1F6FD6'"><i class="ti ti-device-floppy" style="font-size:14px"></i>Simpan</button><a href="{{route('konsultan.index')}}" style="display:inline-flex;align-items:center;gap:6px;padding:8px 20px;background:#fff;color:#64748b;border:0.5px solid #e2e8f0;border-radius:8px;font-size:13px;font-weight:500;text-decoration:none">Batal</a></div>
        </form>
    </div>
</div>
@endsection