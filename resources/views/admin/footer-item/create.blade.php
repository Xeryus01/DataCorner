@extends('admin.layout')
@section('content')
<div class="page-header-row">
    <div>
        <div class="page-title">Tambah Footer Website</div>
        <div class="page-sub">Tambahkan link, PDF, atau gambar untuk ditampilkan pada footer</div>
    </div>
</div>

<div class="card" style="max-width:560px">
    <div class="card-header">
        <div class="card-header-left">
            <div class="card-title"><i class="ti ti-link"></i>Form Tambah Footer Item</div>
        </div>
    </div>
    <div class="card-body">
        @if($errors->any())
        <div class="form-error">
            @foreach($errors->all() as $e)<div>• {{$e}}</div>@endforeach
        </div>
        @endif

        <form action="{{ route('footer-item.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom:14px">
                <label class="form-label">Section Footer</label>
                <select name="section" class="form-select" required>
                    <option value="">-- Pilih Section --</option>
                    <option value="tentang_kami" {{ old('section') == 'tentang_kami' ? 'selected' : '' }}>Tentang Kami</option>
                    <option value="magang" {{ old('section') == 'magang' ? 'selected' : '' }}>Magang</option>
                    <option value="akademi_statistik" {{ old('section') == 'akademi_statistik' ? 'selected' : '' }}>Akademi Statistik</option>
                    <option value="kontak_kami" {{ old('section') == 'kontak_kami' ? 'selected' : '' }}>Kontak Kami</option>
                </select>
            </div>
            <div style="margin-bottom:14px">
                <label class="form-label">Judul</label>
                <input type="text" name="title" value="{{ old('title') }}" class="form-input" placeholder="Contoh: Profil Lembaga" required>
            </div>
            <div style="margin-bottom:14px">
                <label class="form-label">Tipe Item</label>
                <select name="type" id="type" class="form-select" required>
                    <option value="link" {{ old('type') == 'link' ? 'selected' : '' }}>Link</option>
                    <option value="pdf" {{ old('type') == 'pdf' ? 'selected' : '' }}>PDF</option>
                    <option value="image" {{ old('type') == 'image' ? 'selected' : '' }}>Gambar</option>
                </select>
            </div>
            <div style="margin-bottom:14px" id="urlField">
                <label class="form-label">URL Link</label>
                <input type="text" name="url" value="{{ old('url') }}" class="form-input" placeholder="https://... atau /nama-halaman">
                <p style="font-size:11px;color:var(--color-muted);margin-top:4px">Diisi jika tipe item adalah Link.</p>
            </div>
            <div style="margin-bottom:14px" id="fileField">
                <label class="form-label">Upload File</label>
                <input type="file" name="file" style="font-size:13px" accept=".pdf,.jpg,.jpeg,.png,.webp">
                <p style="font-size:11px;color:var(--color-muted);margin-top:4px">Untuk PDF gunakan .pdf. Untuk gambar gunakan .jpg, .jpeg, .png, atau .webp.</p>
            </div>
            <div style="margin-bottom:14px">
                <label class="form-label">Urutan Tampil</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="form-input" min="0">
                <p style="font-size:11px;color:var(--color-muted);margin-top:4px">Semakin kecil angka, semakin atas item ditampilkan.</p>
            </div>
            <div style="margin-bottom:16px;display:flex;gap:16px">
                <label class="form-check">
                    <input type="checkbox" name="is_active" value="1" checked>
                    <span>Aktif</span>
                </label>
                <label class="form-check">
                    <input type="checkbox" name="open_new_tab" value="1" checked>
                    <span>Buka di tab baru</span>
                </label>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i>Simpan</button>
                <a href="{{ route('footer-item.index') }}" class="btn-ghost">Kembali</a>
            </div>
        </form>
    </div>
</div>

<script>
    const typeSelect = document.getElementById('type');
    const urlField = document.getElementById('urlField');
    const fileField = document.getElementById('fileField');
    function toggleField() {
        if (typeSelect.value === 'link') {
            urlField.style.display = 'block';
            fileField.style.display = 'none';
        } else {
            urlField.style.display = 'none';
            fileField.style.display = 'block';
        }
    }
    typeSelect.addEventListener('change', toggleField);
    toggleField();
</script>
@endsection