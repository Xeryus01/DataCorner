@extends('admin.layout')
@section('content')
<x-admin.page-header title="Tambah Admin" subtitle="Buat akun administrator baru untuk sistem Datapedia" :breadcrumbs="['Datapedia', 'Manajemen User', 'Admin', 'Tambah']" />
<div class="card" style="background:#fff;border:0.5px solid #e2e8f0;border-radius:12px;overflow:hidden;max-width:640px">
    <div style="padding:14px 20px;border-bottom:0.5px solid #e2e8f0">
        <div style="font-size:13px;font-weight:600;color:#0f172a;display:flex;align-items:center;gap:8px"><i class="ti ti-user-plus" style="font-size:16px;color:#1F6FD6"></i>Form Tambah Admin</div>
    </div>
    <div style="padding:20px">
        @if($errors->any())
        <div style="background:#FCEBEB;border:1px solid #F7C1C1;color:#791F1F;padding:10px 14px;border-radius:8px;font-size:12px;margin-bottom:16px">
            @foreach($errors->all() as $e)<div>• {{$e}}</div>@endforeach
        </div>
        @endif

        <form method="POST" action="{{route('admin.store')}}">
            @csrf
            <div style="margin-bottom:14px">
                <label style="display:block;font-size:12px;font-weight:600;color:#0f172a;margin-bottom:5px">Role</label>
                <select name="role" required style="width:100%;height:40px;padding:0 12px;border:0.5px solid #e2e8f0;border-radius:8px;background:#fff;font-size:13px;color:#0f172a;outline:none">
                    @foreach($roles as $role)
                    <option value="{{$role->name}}" {{old('role')==$role->name?'selected':''}}>{{ucfirst($role->name)}}</option>
                    @endforeach
                </select>
            </div>
            <div style="margin-bottom:14px">
                <label style="display:block;font-size:12px;font-weight:600;color:#0f172a;margin-bottom:5px">Username</label>
                <input type="text" name="username" value="{{old('username')}}" placeholder="Masukkan username" required style="width:100%;height:40px;padding:0 12px;border:0.5px solid #e2e8f0;border-radius:8px;font-size:13px;color:#0f172a;outline:none;background:#fff">
            </div>
            <div style="margin-bottom:14px">
                <label style="display:block;font-size:12px;font-weight:600;color:#0f172a;margin-bottom:5px">Unit Kerja</label>
                <select name="wilayah_id" required style="width:100%;height:40px;padding:0 12px;border:0.5px solid #e2e8f0;border-radius:8px;background:#fff;font-size:13px;color:#0f172a;outline:none">
                    @foreach($wilayah as $w)
                    <option value="{{$w->id}}" {{old('wilayah_id')==$w->id?'selected':''}}>{{$w->nama_wilayah}}</option>
                    @endforeach
                </select>
            </div>
            <div style="margin-bottom:14px">
                <label style="display:block;font-size:12px;font-weight:600;color:#0f172a;margin-bottom:5px">Password</label>
                <input type="password" name="password" placeholder="Minimal 5 karakter" required style="width:100%;height:40px;padding:0 12px;border:0.5px solid #e2e8f0;border-radius:8px;font-size:13px;color:#0f172a;outline:none;background:#fff">
            </div>
            <div style="margin-bottom:20px">
                <label style="display:block;font-size:12px;font-weight:600;color:#0f172a;margin-bottom:5px">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" placeholder="Ulangi password" required style="width:100%;height:40px;padding:0 12px;border:0.5px solid #e2e8f0;border-radius:8px;font-size:13px;color:#0f172a;outline:none;background:#fff">
            </div>
            <div style="display:flex;gap:8px">
                <button type="submit" style="display:inline-flex;align-items:center;gap:6px;padding:8px 20px;background:#1F6FD6;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:500;cursor:pointer;transition:background 120ms" onmouseover="this.style.background='#185FA5'" onmouseout="this.style.background='#1F6FD6'"><i class="ti ti-device-floppy" style="font-size:14px"></i>Simpan</button>
                <a href="{{route('admin.index')}}" style="display:inline-flex;align-items:center;gap:6px;padding:8px 20px;background:#fff;color:#64748b;border:0.5px solid #e2e8f0;border-radius:8px;font-size:13px;font-weight:500;text-decoration:none;transition:background 120ms">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection