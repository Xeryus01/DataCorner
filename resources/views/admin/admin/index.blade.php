@extends('admin.layout')

@section('content')
@php
    $totalAdmin = $admin->count();
@endphp

{{-- PAGE HEADER --}}
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:4px">
    <div>
        <div style="display:flex;align-items:center;gap:5px;font-size:12px;color:#64748b;margin-bottom:4px">
            <span>Datapedia</span>
            <i class="ti ti-chevron-right" style="font-size:10px"></i>
            <span>Manajemen User</span>
            <i class="ti ti-chevron-right" style="font-size:10px"></i>
            <span style="color:#0f172a;font-weight:600">Admin</span>
        </div>
        <div style="font-size:16px;font-weight:600;color:#0f172a">Data Admin</div>
        <div style="font-size:12px;color:#64748b;margin-top:2px">Kelola akun admin dan operator yang dapat mengakses panel ini</div>
    </div>
    <div>
        <a href="{{ route('admin.create') }}" class="btn-primary">
            <i class="ti ti-plus"></i> Tambah Admin
        </a>
    </div>
</div>

{{-- TABLE CARD --}}
<div class="card" style="background:#fff;border:0.5px solid #e2e8f0;border-radius:12px;overflow:hidden">

    {{-- Card Header --}}
    <div style="padding:14px 18px;border-bottom:0.5px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between">
        <div style="font-size:13px;font-weight:600;color:#0f172a;display:flex;align-items:center;gap:8px">
            <i class="ti ti-shield-check" style="font-size:16px;color:#1F6FD6"></i>
            Daftar Admin
            <span style="font-size:11px;font-weight:400;color:#94a3b8;margin-left:4px">&mdash; {{ $totalAdmin }} data</span>
        </div>
        <div class="search-box">
            <i class="ti ti-search"></i>
            <input type="text" id="searchInput" placeholder="Cari nama atau email..." oninput="filterTable()">
        </div>
    </div>

    {{-- Table --}}
    <div style="overflow-x:auto">
        <table style="width:100%;border-collapse:collapse">
            <thead>
                <tr style="background:#f8fafc">
                    <th style="padding:10px 16px;text-align:center;width:48px;font-size:11px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase;letter-spacing:0.04em">No</th>
                    <th style="padding:10px 16px;font-size:11px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase;letter-spacing:0.04em">Nama</th>
                    <th style="padding:10px 16px;font-size:11px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase;letter-spacing:0.04em">Email</th>
                    <th style="padding:10px 16px;font-size:11px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase;letter-spacing:0.04em">Role</th>
                    <th style="padding:10px 16px;font-size:11px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase;letter-spacing:0.04em">Aksi</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @forelse($admin as $index => $admins)
                @php
                    $roleName = $admins->getRoleNames()->first() ?? 'admin';
                    $isSuper = $roleName === 'admin';
                    $roleLabel = $isSuper ? 'Superadmin' : ucwords($roleName);
                    $roleClass = $isSuper ? 'badge-super' : 'badge-operator-sm';
                @endphp
                <tr class="trow" style="transition:background 100ms" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                    <td style="padding:12px 16px;font-size:11px;color:#94a3b8;border-bottom:0.5px solid #e2e8f0;text-align:center">{{ $index + 1 }}</td>
                    <td style="padding:12px 16px;font-size:12px;font-weight:600;color:#0f172a;border-bottom:0.5px solid #e2e8f0">{{ $admins->nama }}</td>
                    <td style="padding:12px 16px;font-size:11px;color:#64748b;border-bottom:0.5px solid #e2e8f0;font-family:monospace">{{ $admins->email }}</td>
                    <td style="padding:12px 16px;border-bottom:0.5px solid #e2e8f0">
                        <span class="badge-status {{ $roleClass }}"><span class="badge-dot"></span> {{ $roleLabel }}</span>
                    </td>
                    <td style="padding:10px 16px;border-bottom:0.5px solid #e2e8f0">
                        <div style="display:flex;align-items:center;gap:6px">
                            <a href="{{ route('admin.edit', $admins->id) }}" class="btn-edit-sm"><i class="ti ti-pencil"></i> Edit</a>
                            <button type="button" class="btn-del-sm" onclick="confirmDelete(this,'{{ $admins->nama }}')"><i class="ti ti-trash"></i> Hapus</button>
                            <form action="{{ route('admin.destroy', $admins->id) }}" method="POST" style="display:none" class="delete-form">
                                @csrf
                                @method('DELETE')
                            </form>
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
    <div style="padding:10px 16px;border-top:0.5px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between">
        <span style="font-size:11px;color:#64748b" id="tableInfo">Menampilkan {{ $totalAdmin }} data</span>
    </div>

</div>

{{-- DELETE MODAL --}}
<div id="deleteModal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.4);align-items:center;justify-content:center" onclick="closeModal(event)">
    <div style="background:#fff;border-radius:14px;padding:28px 28px 20px;max-width:380px;width:90%;box-shadow:0 20px 60px rgba(0,0,0,.18)" onclick="event.stopPropagation()">
        <div style="width:44px;height:44px;background:var(--red-bg);border-radius:10px;display:flex;align-items:center;justify-content:center;margin-bottom:14px">
            <i class="ti ti-trash" style="font-size:20px;color:var(--red-dark)"></i>
        </div>
        <div style="font-size:15px;font-weight:700;color:var(--color-text);margin-bottom:6px">Hapus Data Admin?</div>
        <div style="font-size:13px;color:var(--color-muted);margin-bottom:20px" id="deleteModalName"></div>
        <div style="display:flex;gap:8px;justify-content:flex-end">
            <button onclick="cancelDelete()" class="btn-ghost" style="padding:7px 16px;font-size:12px">Batal</button>
            <button onclick="doDelete()" class="btn-del-sm" style="padding:8px 16px;font-size:12px;border-radius:8px">
                <i class="ti ti-trash"></i> Ya, Hapus
            </button>
        </div>
    </div>
</div>

<script>
function filterTable(){
    var q = document.getElementById('searchInput').value.toLowerCase();
    var rows = document.querySelectorAll('#tableBody .trow');
    var visible = 0;
    rows.forEach(function(r){
        var match = r.innerText.toLowerCase().includes(q);
        r.style.display = match ? '' : 'none';
        if(match) visible++;
    });
    document.getElementById('tableInfo').textContent = 'Menampilkan ' + visible + ' data';
}

var pendingDeleteBtn = null;
function confirmDelete(btn, name){
    pendingDeleteBtn = btn;
    document.getElementById('deleteModalName').textContent = 'Hapus akun "' + name + '"? Tindakan ini tidak dapat dibatalkan.';
    document.getElementById('deleteModal').style.display = 'flex';
}
function cancelDelete(){
    pendingDeleteBtn = null;
    document.getElementById('deleteModal').style.display = 'none';
}
function doDelete(){
    if(pendingDeleteBtn) pendingDeleteBtn.closest('div').querySelector('.delete-form').submit();
    document.getElementById('deleteModal').style.display = 'none';
}
function closeModal(e){
    if(e.target === document.getElementById('deleteModal')) cancelDelete();
}
</script>
@endsection