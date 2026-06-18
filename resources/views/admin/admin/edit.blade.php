@extends('admin.layout')
@section('content')

{{-- PAGE HEADER --}}
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:4px">
    <div>
        <div style="display:flex;align-items:center;gap:5px;font-size:12px;color:#64748b;margin-bottom:4px">
            <span>Datapedia</span>
            <i class="ti ti-chevron-right" style="font-size:10px"></i>
            <span>Manajemen User</span>
            <i class="ti ti-chevron-right" style="font-size:10px"></i>
            <span style="color:#0f172a;font-weight:600">Admin</span>
            <i class="ti ti-chevron-right" style="font-size:10px"></i>
            <span style="color:#0f172a;font-weight:600">Edit</span>
        </div>
        <div style="font-size:16px;font-weight:600;color:#0f172a">Edit Admin</div>
        <div style="font-size:12px;color:#64748b;margin-top:2px">Ubah data akun admin atau operator</div>
    </div>
    <div>
        <a href="{{ route('admin.index') }}" class="btn-ghost">
            <i class="ti ti-arrow-left"></i> Kembali
        </a>
    </div>
</div>

{{-- FORM CARD --}}
<div class="card" style="background:#fff;border:0.5px solid #e2e8f0;border-radius:12px;overflow:hidden">

    {{-- Card Header --}}
    <div class="card-header">
        <div class="card-header-left">
            <div class="card-title"><i class="ti ti-user-edit"></i> Form Edit Admin</div>
        </div>
    </div>

    {{-- Card Body --}}
    <form method="POST" action="{{ route('admin.update', $admin->id) }}" class="card-body" style="padding:20px" novalidate>
        @method('PUT')
        @csrf

        @if ($errors->any())
        <div class="form-error">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
        @endif

        <div class="form-section-title">
            <i class="ti ti-user"></i> Informasi Akun
        </div>

        <div class="form-grid">
            <div>
                <label class="form-label" for="email">Email Admin</label>
                <input type="email" id="email" name="email" class="form-input" placeholder="Masukkan email" value="{{ old('email', $admin->email) }}" required>
            </div>
            <div>
                <label class="form-label" for="nama">Nama Admin</label>
                <input type="text" id="nama" name="nama" class="form-input" placeholder="Masukkan nama" value="{{ old('nama', $admin->nama) }}" required>
            </div>
        </div>

        <div class="form-divider"></div>

        <div class="form-section-title">
            <i class="ti ti-shield-check"></i> Role / Peran
        </div>

        <div class="form-grid">
            <div>
                <label class="form-label" for="role">Role</label>
                <select id="role" name="role" class="form-select" required>
                    <option value="">-- Pilih Role --</option>
                    @foreach($roles as $role)
                        @php
                            $currentRole = $admin->getRoleNames()->first();
                        @endphp
                        <option value="{{ $role->name }}" {{ old('role', $currentRole) == $role->name ? 'selected' : '' }}>
                            {{ ucwords($role->name) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-divider"></div>

        <div class="form-section-title">
            <i class="ti ti-lock"></i> Keamanan
        </div>

        <div class="form-grid">
            <div>
                <label class="form-label" for="password">Password <span style="font-weight:400;color:#94a3b8">(kosongkan jika tidak diubah)</span></label>
                <input type="password" id="password" name="password" class="form-input" placeholder="Masukkan password baru">
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">
                <i class="ti ti-check"></i> Simpan Perubahan
            </button>
            <a href="{{ route('admin.index') }}" class="btn-ghost">Batal</a>
        </div>
    </form>
</div>

@endsection