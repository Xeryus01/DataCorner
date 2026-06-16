@extends('admin.layout')
@section('content')
<div class="page-header-row">
    <div>
        <div class="page-title">Edit Admin</div>
        <div class="page-sub">Perbarui data administrator</div>
    </div>
</div>

<div class="card" style="max-width:560px">
    <div class="card-header">
        <div class="card-header-left">
            <div class="card-title"><i class="ti ti-user-edit"></i>Form Edit Admin</div>
        </div>
    </div>
    <div class="card-body">
        @if($errors->any())
        <div class="form-error">
            @foreach($errors->all() as $e)<div>• {{$e}}</div>@endforeach
        </div>
        @endif

        <form method="POST" action="{{route('admin_data-admin.update',$data_admin->id)}}">
            @csrf @method('PUT')
            <div style="margin-bottom:14px">
                <label class="form-label">Role</label>
                <select name="role" class="form-select" required>
                    @foreach($roles as $role)
                    <option value="{{$role->name}}" {{$data_admin->hasRole($role->name)?'selected':''}}>{{ucfirst($role->name)}}</option>
                    @endforeach
                </select>
            </div>
            <div style="margin-bottom:14px">
                <label class="form-label">Username</label>
                <input type="text" name="username" value="{{$data_admin->username}}" class="form-input" required>
            </div>
            <div style="margin-bottom:14px">
                <label class="form-label">Unit Kerja</label>
                <select name="wilayah_id" class="form-select" required>
                    <option value="">-- Pilih --</option>
                    @foreach($wilayah as $item)
                    <option value="{{$item->id}}" {{$data_admin->wilayah_id==$item->id?'selected':''}}>{{$item->nama_wilayah}}</option>
                    @endforeach
                </select>
            </div>
            <div style="margin-bottom:14px">
                <label class="form-label">Password Baru (kosongkan jika tidak diubah)</label>
                <input type="password" name="password" class="form-input" placeholder="••••••">
            </div>
            <div style="margin-bottom:20px">
                <label class="form-label">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="form-input" placeholder="••••••">
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i>Simpan</button>
                <a href="{{route('admin.index')}}" class="btn-ghost">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection