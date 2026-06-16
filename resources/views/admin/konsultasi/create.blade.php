@extends('admin.layout')
@section('content')
<x-admin.page-header title="Tambah Konsultasi Manual" subtitle="Input data konsultasi WhatsApp oleh admin" :breadcrumbs="['Datapedia','Konsultasi','Tambah']" />
<div class="card" style="background:#fff;border:0.5px solid #e2e8f0;border-radius:12px;overflow:hidden;max-width:500px">
    <div style="padding:14px 20px;border-bottom:0.5px solid #e2e8f0">
        <div style="font-size:13px;font-weight:600;color:#0f172a;display:flex;align-items:center;gap:8px">
            <i class="ti ti-plus" style="font-size:16px;color:#1F6FD6"></i>Form Input Konsultasi
        </div>
    </div>
    <div style="padding:20px">
        @if(session('error'))
        <div style="background:#FCEBEB;border:1px solid #F7C1C1;color:#791F1F;padding:10px 14px;border-radius:8px;font-size:12px;margin-bottom:14px">{{session('error')}}</div>
        @endif
        @if(session('success'))
        <div style="background:#f0fdf4;border:1px solid #bbf7d0;color:#16a34a;padding:10px 14px;border-radius:8px;font-size:12px;margin-bottom:14px">{{session('success')}}</div>
        @endif
        <form method="POST" action="{{route('adminKonsultasi.store')}}">
            @csrf
            <div style="margin-bottom:16px">
                <label style="display:block;font-size:12px;font-weight:600;color:#0f172a;margin-bottom:5px">Posisi</label>
                <select name="posisi" required style="width:100%;height:40px;padding:0 12px;border:0.5px solid #e2e8f0;border-radius:8px;background:#fff;font-size:13px;outline:none">
                    <option value="">-- Pilih --</option>
                    <option value="asn">ASN</option>
                    <option value="karyawan_swasta">Karyawan Swasta</option>
                    <option value="wiraswasta">Wiraswasta</option>
                    <option value="peneliti">Peneliti</option>
                    <option value="pelajar_mahasiswa">Pelajar/Mahasiswa</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>
            <button type="submit" style="display:inline-flex;align-items:center;gap:6px;padding:8px 20px;background:#1F6FD6;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:500;cursor:pointer" onmouseover="this.style.background='#185FA5'" onmouseout="this.style.background='#1F6FD6'">
                <i class="ti ti-device-floppy" style="font-size:14px"></i>Simpan
            </button>
        </form>
    </div>
</div>
@endsection