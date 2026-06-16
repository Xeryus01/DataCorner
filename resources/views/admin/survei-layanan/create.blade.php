@extends('admin.layout')
@section('content')
<div class="page-header-row">
    <div>
        <div class="page-title">Tambah Survei Layanan</div>
        <div class="page-sub">Tambahkan link survei layanan berdasarkan tahun</div>
    </div>
</div>

<div class="card" style="max-width:560px">
    <div class="card-header">
        <div class="card-header-left">
            <div class="card-title"><i class="ti ti-poll"></i>Form Tambah Survei</div>
        </div>
    </div>
    <div class="card-body">
        @if($errors->any())
        <div class="form-error">
            @foreach($errors->all() as $e)<div>• {{$e}}</div>@endforeach
        </div>
        @endif

        <form action="{{ route('survei-layanan.store') }}" method="POST">
            @csrf
            <div style="margin-bottom:14px">
                <label class="form-label">Tahun</label>
                <input type="number" name="tahun" value="{{ old('tahun', date('Y')) }}" class="form-input" placeholder="Contoh: 2026" required>
                <p style="font-size:11px;color:var(--color-muted);margin-top:4px">Masukkan tahun survei, contoh: 2026.</p>
            </div>
            <div style="margin-bottom:14px">
                <label class="form-label">Link Survei</label>
                <input type="url" name="link" value="{{ old('link') }}" class="form-input" placeholder="https://forms.gle/..." required>
                <p style="font-size:11px;color:var(--color-muted);margin-top:4px">Masukkan link survei layanan, misalnya Google Form atau link survei resmi.</p>
            </div>
            <div style="margin-bottom:16px">
                <label class="form-check">
                    <input type="checkbox" name="is_active" value="1" checked>
                    <span>Aktif</span>
                </label>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i>Simpan</button>
                <a href="{{ route('survei-layanan.index') }}" class="btn-ghost">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection