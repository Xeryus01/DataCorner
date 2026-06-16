@extends('admin.layout')
@section('content')
<x-admin.page-header title="Data User" subtitle="Daftar pengguna terdaftar di Datapedia" :breadcrumbs="['Datapedia', 'Manajemen User', 'User']" />
<div class="card" style="background:#fff;border:0.5px solid #e2e8f0;border-radius:12px;overflow:hidden">
    <div style="padding:14px 18px;border-bottom:0.5px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between">
        <div style="font-size:13px;font-weight:600;color:#0f172a;display:flex;align-items:center;gap:8px"><i class="ti ti-users" style="font-size:16px;color:#1F6FD6"></i>Daftar Pengguna <span style="font-size:11px;font-weight:400;color:#94a3b8;margin-left:4px">— {{count($user)}} data</span></div>
    </div>
    <div style="overflow-x:auto">
        <table style="width:100%;border-collapse:collapse">
            <thead><tr style="background:#f8fafc"><th style="padding:10px 16px;text-align:center;width:48px;font-size:11px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase;letter-spacing:0.04em">No</th><th style="padding:10px 16px;font-size:11px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase;letter-spacing:0.04em">Nama</th>
            <th style="padding:10px 16px;font-size:11px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase;letter-spacing:0.04em">No HP</th><th style="padding:10px 16px;font-size:11px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase;letter-spacing:0.04em">Email</th></tr></thead>
            <tbody>@forelse($user as $idx => $item)<tr style="transition:background 100ms" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''"><td style="padding:12px 16px;font-size:11px;color:#94a3b8;border-bottom:0.5px solid #e2e8f0;text-align:center">{{$idx+1}}</td><td style="padding:12px 16px;font-size:12px;font-weight:600;color:#0f172a;border-bottom:0.5px solid #e2e8f0">{{$item->nama}}</td><td style="padding:12px 16px;font-size:12px;color:#0f172a;border-bottom:0.5px solid #e2e8f0;font-family:monospace">{{$item->no_hp}}</td><td style="padding:12px 16px;font-size:11px;color:#64748b;border-bottom:0.5px solid #e2e8f0;font-family:monospace">{{$item->email??'-'}}</td></tr>@empty<tr><td colspan="4" style="padding:40px;text-align:center;color:#94a3b8;font-size:13px">Belum ada data user</td></tr>@endforelse</tbody>
        </table>
    </div>
    <div style="padding:10px 16px;border-top:0.5px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between"><span style="font-size:11px;color:#64748b">Menampilkan {{count($user)}} data</span></div>
</div>
@endsection