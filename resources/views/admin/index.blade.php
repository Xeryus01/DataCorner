@extends('admin.layout')

@section('content')
@php
    $currentAdmin = Auth::guard('admin')->user();
    $totalAdmin = $admins->count();
    $operatorCount = $admins->filter(function($a) { return $a->roles->contains('name', 'operator') || $a->roles->contains('name', 'operator magang') || $a->roles->contains('name', 'operator kepegawaian'); })->count();
    $superAdminCount = $admins->filter(function($a) { return $a->roles->contains('name', 'admin'); })->count();
@endphp
<x-admin.page-header
    title="Data Admin"
    subtitle="Kelola akun administrator sistem Datapedia"
    :breadcrumbs="['Datapedia', 'Manajemen User', 'Admin']"
    addRoute="{{ route('admin.create') }}"
    addLabel="Tambah Admin" />

{{-- STATS ROW --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px">
    <div style="background:#fff;border:0.5px solid #e2e8f0;border-radius:10px;padding:14px 16px">
        <div style="font-size:11px;color:#64748b;margin-bottom:6px;display:flex;align-items:center;gap:6px"><i class="ti ti-shield-check" style="font-size:14px;color:#1F6FD6"></i>Total Admin</div>
        <div style="font-size:22px;font-weight:600;color:#0f172a">{{ $totalAdmin }}</div>
        <div style="font-size:11px;color:#64748b;margin-top:2px">Akun terdaftar</div>
    </div>
    <div style="background:#fff;border:0.5px solid #e2e8f0;border-radius:10px;padding:14px 16px">
        <div style="font-size:11px;color:#64748b;margin-bottom:6px;display:flex;align-items:center;gap:6px"><i class="ti ti-user-check" style="font-size:14px;color:#3B6D11"></i>Admin Aktif</div>
        <div style="font-size:22px;font-weight:600;color:#0f172a">{{ $totalAdmin }}</div>
        <div style="font-size:11px;color:#64748b;margin-top:2px">Aktif saat ini</div>
    </div>
    <div style="background:#fff;border:0.5px solid #e2e8f0;border-radius:10px;padding:14px 16px">
        <div style="font-size:11px;color:#64748b;margin-bottom:6px;display:flex;align-items:center;gap:6px"><i class="ti ti-settings" style="font-size:14px;color:#BA7517"></i>Operator</div>
        <div style="font-size:22px;font-weight:600;color:#0f172a">{{ $operatorCount }}</div>
        <div style="font-size:11px;color:#64748b;margin-top:2px">Operator konten</div>
    </div>
    <div style="background:#fff;border:0.5px solid #e2e8f0;border-radius:10px;padding:14px 16px">
        <div style="font-size:11px;color:#64748b;margin-bottom:6px;display:flex;align-items:center;gap:6px"><i class="ti ti-crown" style="font-size:14px;color:#A32D2D"></i>Super Admin</div>
        <div style="font-size:22px;font-weight:600;color:#0f172a">{{ $superAdminCount }}</div>
        <div style="font-size:11px;color:#64748b;margin-top:2px">Akses penuh</div>
    </div>
</div>

{{-- TABLE CARD --}}
<div class="card" style="background:#fff;border:0.5px solid #e2e8f0;border-radius:12px;overflow:hidden">
    <div style="padding:14px 18px;border-bottom:0.5px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between">
        <div style="font-size:13px;font-weight:600;color:#0f172a;display:flex;align-items:center;gap:8px"><i class="ti ti-shield-check" style="font-size:16px;color:#1F6FD6"></i>Daftar Administrator</div>
        <div style="display:flex;align-items:center;gap:8px;background:#f8fafc;border:0.5px solid #e2e8f0;border-radius:8px;padding:0 10px;height:32px">
            <i class="ti ti-search" style="font-size:14px;color:#94a3b8"></i>
            <input type="text" placeholder="Cari admin..." style="border:none;background:transparent;font-size:12px;color:#0f172a;outline:none;width:160px">
        </div>
    </div>
    <div style="overflow-x:auto">
        <table style="width:100%;border-collapse:collapse">
            <thead>
                <tr style="background:#f8fafc">
                    <th style="padding:10px 16px;text-align:left;font-size:11px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;white-space:nowrap;text-transform:uppercase;letter-spacing:0.04em;width:48px;text-align:center">No</th>
                    <th style="padding:10px 16px;text-align:left;font-size:11px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;white-space:nowrap;text-transform:uppercase;letter-spacing:0.04em">Nama</th>
                    <th style="padding:10px 16px;text-align:left;font-size:11px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;white-space:nowrap;text-transform:uppercase;letter-spacing:0.04em">Email</th>
                    <th style="padding:10px 16px;text-align:left;font-size:11px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;white-space:nowrap;text-transform:uppercase;letter-spacing:0.04em">Role</th>
                    <th style="padding:10px 16px;text-align:left;font-size:11px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;white-space:nowrap;text-transform:uppercase;letter-spacing:0.04em">Wilayah</th>
                    <th style="padding:10px 16px;text-align:left;font-size:11px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;white-space:nowrap;text-transform:uppercase;letter-spacing:0.04em">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $idx => $admin)
                <tr style="transition:background 100ms" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                    <td style="padding:12px 16px;font-size:11px;color:#94a3b8;border-bottom:0.5px solid #e2e8f0;text-align:center">{{ $idx + 1 }}</td>
                    <td style="padding:12px 16px;font-size:12px;font-weight:600;color:#0f172a;border-bottom:0.5px solid #e2e8f0">{{ $admin->nama }}</td>
                    <td style="padding:12px 16px;font-size:11px;color:#64748b;border-bottom:0.5px solid #e2e8f0;font-family:monospace">{{ $admin->email }}</td>
                    <td style="padding:12px 16px;border-bottom:0.5px solid #e2e8f0">
                        @php
                            $roles = $admin->roles->pluck('name');
                            $isSuper = $roles->contains('admin');
                        @endphp
                        @if($isSuper)
                            <span style="display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:999px;font-size:10px;font-weight:500;background:#EEEDFE;color:#3C3489"><i class="ti ti-crown" style="font-size:10px"></i>Super Admin</span>
                        @else
                            <span style="display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:999px;font-size:10px;font-weight:500;background:#EAF3DE;color:#27500A"><i class="ti ti-settings" style="font-size:10px"></i>Operator</span>
                        @endif
                    </td>
                    <td style="padding:12px 16px;font-size:12px;color:#0f172a;border-bottom:0.5px solid #e2e8f0">{{ optional($admin->wilayah)->nama_wilayah ?? '-' }}</td>
                    <td style="padding:12px 16px;border-bottom:0.5px solid #e2e8f0">
                        <div style="display:flex;gap:6px">
                            <a href="{{ route('admin_data-admin.edit', $admin->id) }}" style="display:inline-flex;align-items:center;gap:4px;padding:5px 10px;background:#E6F1FB;color:#0C447C;border-radius:6px;font-size:11px;font-weight:500;text-decoration:none;transition:background 120ms" onmouseover="this.style.background='#B5D4F4'" onmouseout="this.style.background='#E6F1FB'"><i class="ti ti-edit" style="font-size:13px"></i>Edit</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="padding:40px;text-align:center;font-size:13px;color:#94a3b8">Belum ada data admin</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:10px 16px;border-top:0.5px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between">
        <span style="font-size:11px;color:#64748b">Menampilkan {{ $admins->count() }} data</span>
    </div>
</div>
@endsection