@extends('admin.layout')
@section('content')
<x-admin.page-header title="Tambah Petugas" subtitle="Input data petugas harian" :breadcrumbs="['Datapedia','Layanan','Petugas','Tambah']" />
<div class="card" style="background:#fff;border:0.5px solid #e2e8f0;border-radius:12px;overflow:hidden;max-width:520px">
    <div style="padding:14px 20px;border-bottom:0.5px solid #e2e8f0"><div style="font-size:13px;font-weight:600;color:#0f172a;display:flex;align-items:center;gap:8px"><i class="ti ti-calendar-week" style="font-size:16px;color:#1F6FD6"></i>Form Tambah Petugas</div></div>
    <div style="padding:20px">
        @if($errors->any())<div style="background:#FCEBEB;border:1px solid #F7C1C1;color:#791F1F;padding:10px 14px;border-radius:8px;font-size:12px;margin-bottom:16px">@foreach($errors->all() as $e)<div>• {{$e}}</div>@endforeach</div>@endif
        <form method="POST" action="{{route('petugas.store')}}">
            @csrf
            <div style="margin-bottom:14px"><label style="display:block;font-size:12px;font-weight:600;color:#0f172a;margin-bottom:5px">Konsultan</label><select name="konsultan_id" required style="width:100%;height:40px;padding:0 12px;border:0.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;background:#fff">@foreach($konsultan??[] as $k)<option value="{{$k->id}}">{{$k->nama}}</option>@endforeach</select></div>
            <div style="margin-bottom:20px"><label style="display:block;font-size:12px;font-weight:600;color:#0f172a;margin-bottom:5px">Tanggal</label><input type="date" name="tanggal" value="{{old('tanggal',date('Y-m-d'))}}" required style="width:100%;height:40px;padding:0 12px;border:0.5px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none"></div>
            <div style="display:flex;gap:8px"><button type="submit" style="display:inline-flex;align-items:center;gap:6px;padding:8px 20px;background:#1F6FD6;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:500;cursor:pointer" onmouseover="this.style.background='#185FA5'" onmouseout="this.style.background='#1F6FD6'"><i class="ti ti-device-floppy" style="font-size:14px"></i>Simpan</button><a href="{{route('petugas.index')}}" style="display:inline-flex;align-items:center;gap:6px;padding:8px 20px;background:#fff;color:#64748b;border:0.5px solid #e2e8f0;border-radius:8px;font-size:13px;font-weight:500;text-decoration:none">Batal</a></div>
        </form>
    </div>
</div>
@endsection