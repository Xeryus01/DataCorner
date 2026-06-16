@extends('admin.layout')
@section('content')
<div class="page-header-row">
    <div>
        <div class="page-title">Tambah Admin</div>
        <div class="page-sub">Buat akun administrator baru untuk sistem Datapedia</div>
    </div>
</div>

<div class="card" style="max-width:560px">
    <div class="card-header">
        <div class="card-header-left">
            <div class="card-title"><i class="ti ti-user-plus"></i>Form Tambah Admin</div>
        </div>
    </div>
    <div class="card-body">
        @if($errors->any())
        <div class="form-error">
            @foreach($errors->all() as $e)<div>• {{$e}}</div>@endforeach
        </div>
        @endif

        <form method="POST" action="{{route('admin.store')}}">
            @csrf
            <div style="margin-bottom:14px">
                <label class="form-label">Role</label>
                <select name="role" class="form-select" required>
                    @foreach($roles as $role)
                    <option value="{{$role->name}}" {{old('role')==$role->name?'selected':''}}>{{ucfirst($role->name)}}</option>
                    @endforeach
                </select>
            </div>
            <div style="margin-bottom:14px">
                <label class="form-label">Username</label>
                <input type="text" name="username" value="{{old('username')}}" class="form-input" required>
            </div>
            <div style="margin-bottom:14px">
                <label class="form-label">Unit Kerja</label>
                <select name="wilayah_id" class="form-select" required>
                    @foreach($wilayah as $w)
                    <option value="{{$w->id}}" {{old('wilayah_id')==$w->id?'selected':''}}>{{$w->nama_wilayah}}</option>
                    @endforeach
                </select>
            </div>
            <div style="margin-bottom:14px">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-input" required>
            </div>
            <div style="margin-bottom:16px">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-input" required>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i>Simpan</button>
                <a href="{{route('admin.index')}}" class="btn-ghost">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection