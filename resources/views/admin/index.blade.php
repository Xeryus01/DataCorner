@extends('admin.layout')

@section('content')
@php
    $currentAdmin = Auth::guard('admin')->user();
    $totalAdmin = $admins->count();
@endphp

{{-- PAGE HEADER (from admin_panel_data_admin.html) --}}
<div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;gap:12px">
    <div>
        <div style="display:flex;align-items:center;gap:5px;font-size:11px;color:#64748b;margin-bottom:6px">
            <span>Datapedia</span>
            <i class="ti ti-chevron-right" style="font-size:10px"></i>
            <span>Manajemen User</span>
            <i class="ti ti-chevron-right" style="font-size:10px"></i>
            <span style="color:#0f172a;font-weight:500">Admin</span>
        </div>
        <div style="font-size:17px;font-weight:600;color:#0f172a">Data Admin</div>
        <div style="font-size:12px;color:#64748b;margin-top:3px">Kelola akun admin dan operator sistem</div>
    </div>
    <a href="{{ route('admin.create') }}" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;background:#1F6FD6;color:#fff;border:none;border-radius:8px;font-size:12px;font-weight:500;cursor:pointer;text-decoration:none;white-space:nowrap;transition:background 120ms" onmouseover="this.style.background='#185FA5'" onmouseout="this.style.background='#1F6FD6'">
        <i class="ti ti-plus" style="font-size:14px"></i> Tambah Admin
    </a>
</div>

{{-- TABLE CARD (from admin_panel_data_admin.html) --}}
<div style="background:#fff;border:0.5px solid #e2e8f0;border-radius:12px;overflow:hidden">
    {{-- Card Header --}}
    <div style="padding:14px 18px;border-bottom:0.5px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between">
        <div style="display:flex;align-items:center;gap:8px;font-size:13px;font-weight:600;color:#0f172a">
            <i class="ti ti-shield-check" style="font-size:16px;color:#1F6FD6"></i>
            Daftar Admin
            <span style="font-size:11px;font-weight:400;color:#94a3b8">— {{ $totalAdmin }} akun</span>
        </div>
        <div style="display:flex;align-items:center;gap:8px;background:#f8fafc;border:0.5px solid #e2e8f0;border-radius:8px;padding:0 10px;height:30px">
            <i class="ti ti-search" style="font-size:13px;color:#94a3b8"></i>
            <input placeholder="Cari admin..." style="border:none;background:transparent;font-size:12px;color:#0f172a;outline:none;width:140px">
        </div>
    </div>

    {{-- Table --}}
    <div style="overflow-x:auto">
        <table style="width:100%;border-collapse:collapse">
            <thead>
                <tr style="background:#f8fafc">
                    <th style="padding:10px 18px;text-align:center;font-size:10px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase;letter-spacing:0.06em;white-space:nowrap;width:48px">No</th>
                    <th style="padding:10px 18px;text-align:left;font-size:10px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase;letter-spacing:0.06em;white-space:nowrap">Nama</th>
                    <th style="padding:10px 18px;text-align:left;font-size:10px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase;letter-spacing:0.06em;white-space:nowrap">Email</th>
                    <th style="padding:10px 18px;text-align:left;font-size:10px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase;letter-spacing:0.06em;white-space:nowrap">Peran</th>
                    <th style="padding:10px 18px;text-align:left;font-size:10px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase;letter-spacing:0.06em;white-space:nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $idx => $admin)
                @php
                    $roles = $admin->roles->pluck('name');
                    $isSuper = $roles->contains('admin');
                    $inisial = strtoupper(substr($admin->nama ?? 'A', 0, 2));
                    if ($isSuper) {
                        $avBg = '#E6F1FB'; $avColor = '#185FA5'; $pillBg = '#E6F1FB'; $pillColor = '#0C447C'; $pillIcon = 'ti-shield-check';
                    } else {
                        $avBg = '#EAF3DE'; $avColor = '#3B6D11'; $pillBg = '#EAF3DE'; $pillColor = '#27500A'; $pillIcon = 'ti-user-check';
                    }
                @endphp
                <tr style="transition:background 100ms" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                    <td style="padding:13px 18px;text-align:center;width:48px;font-size:11px;color:#94a3b8;border-bottom:0.5px solid #e2e8f0">{{ $idx + 1 }}</td>
                    <td style="padding:13px 18px;font-size:12px;color:#0f172a;border-bottom:0.5px solid #e2e8f0">
                        <div style="display:flex;align-items:center;gap:10px">
                            <div style="width:28px;height:28px;border-radius:50%;background:{{$avBg}};display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:600;color:{{$avColor}};flex-shrink:0">{{ $inisial }}</div>
                            <span style="font-weight:600">{{ $admin->nama }}</span>
                        </div>
                    </td>
                    <td style="padding:13px 18px;font-size:11px;color:#64748b;border-bottom:0.5px solid #e2e8f0;font-family:monospace">{{ $admin->email }}</td>
                    <td style="padding:13px 18px;border-bottom:0.5px solid #e2e8f0">
                        <span style="display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:999px;font-size:10px;font-weight:500;background:{{$pillBg}};color:{{$pillColor}}">
                            <i class="ti {{$pillIcon}}" style="font-size:10px"></i> {{ $isSuper ? 'Super Admin' : 'Operator' }}
                        </span>
                    </td>
                    <td style="padding:13px 18px;border-bottom:0.5px solid #e2e8f0">
                        <div style="display:flex;align-items:center;gap:6px">
                            <a href="{{ route('admin_data-admin.edit', $admin->id) }}" style="display:inline-flex;align-items:center;gap:4px;padding:4px 10px;background:#E6F1FB;color:#0C447C;border:0.5px solid #B5D4F4;border-radius:6px;font-size:11px;font-weight:500;cursor:pointer;text-decoration:none;transition:filter 120ms" onmouseover="this.style.filter='brightness(0.94)'" onmouseout="this.style.filter='none'"><i class="ti ti-edit" style="font-size:12px"></i> Edit</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding:40px;text-align:center;font-size:13px;color:#94a3b8">Belum ada data admin</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Card Footer --}}
    <div style="padding:10px 18px;border-top:0.5px solid #e2e8f0;font-size:11px;color:#64748b">Menampilkan {{ $totalAdmin }} dari {{ $totalAdmin }} akun</div>
</div>
@endsection