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
            <span style="color:#0f172a;font-weight:600">Konsultan</span>
            <i class="ti ti-chevron-right" style="font-size:10px"></i>
            <span style="color:#0f172a;font-weight:600">Edit</span>
        </div>
        <div style="font-size:16px;font-weight:600;color:#0f172a">Edit Konsultan</div>
        <div style="font-size:12px;color:#64748b;margin-top:2px">Ubah data konsultan {{ $konsultan->nama }}</div>
    </div>
    <div>
        <a href="{{ route('konsultan.index') }}" class="btn-ghost">
            <i class="ti ti-arrow-left"></i> Kembali
        </a>
    </div>
</div>

{{-- FORM CARD --}}
<div class="card" style="background:#fff;border:0.5px solid #e2e8f0;border-radius:12px;overflow:hidden">

    {{-- Card Header --}}
    <div class="card-header">
        <div class="card-header-left">
            <div class="card-title"><i class="ti ti-tie"></i> Form Edit Konsultan</div>
        </div>
    </div>

    {{-- Card Body --}}
    <form method="POST" action="{{ route('konsultan.update', $konsultan->id) }}" class="card-body" style="padding:20px" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')

        @if ($errors->any())
        <div class="form-error">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
        @endif

        {{-- Informasi Akun --}}
        <div class="form-section-title">
            <i class="ti ti-user"></i> Informasi Akun
        </div>

        <div class="form-grid">
            <div>
                <label class="form-label" for="nama">Nama</label>
                <input type="text" id="nama" name="nama" class="form-input" placeholder="Masukkan nama konsultan" value="{{ old('nama', $konsultan->nama) }}" required>
            </div>
            <div>
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" name="email" class="form-input" placeholder="Masukkan email" value="{{ old('email', $konsultan->email) }}" required>
            </div>
        </div>

        <div class="form-divider"></div>

        {{-- Role / Posisi --}}
        <div class="form-section-title">
            <i class="ti ti-id-badge"></i> Posisi / Jabatan
        </div>

        <div class="form-grid">
            <div>
                <label class="form-label" for="posisi">Posisi</label>
                <select id="posisi" name="posisi" class="form-select" required>
                    <option value="">-- Pilih Posisi --</option>
                    @foreach($daftarPosisi as $kategori => $listPosisi)
                        <optgroup label="{{ $kategori }}">
                            @foreach($listPosisi as $pos)
                                <option value="{{ $pos }}" {{ old('posisi', $konsultan->posisi) == $pos ? 'selected' : '' }}>{{ $pos }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-divider"></div>

        {{-- Bidang Keahlian --}}
        <div class="form-section-title">
            <i class="ti ti-tags"></i> Bidang Keahlian
        </div>

        <div class="form-grid">
            <div>
                <label class="form-label">Pilih Bidang Keahlian</label>
                @php
                    $keahlianTerpilih = old(
                        'bidang_keahlian_id',
                        $konsultan->bidangKeahlian->pluck('id')->toArray()
                    );
                @endphp
                <div style="display:flex;flex-wrap:wrap;gap:8px;margin-top:4px">
                    @foreach($bidangKeahlian as $bidang)
                        <label class="form-check">
                            <input type="checkbox" name="bidang_keahlian_id[]" value="{{ $bidang->id }}"
                                {{ in_array($bidang->id, $keahlianTerpilih) ? 'checked' : '' }}>
                            {{ $bidang->nama_bidang }}
                        </label>
                    @endforeach
                </div>
                @if($bidangKeahlian->isEmpty())
                    <div style="font-size:12px;color:#94a3b8;margin-top:4px">Tidak ada bidang keahlian aktif. <a href="{{ route('bidang-keahlian.create') }}" style="color:#1F6FD6">Tambah bidang keahlian</a></div>
                @endif
            </div>
        </div>

        <div class="form-divider"></div>

        {{-- Foto --}}
        <div class="form-section-title">
            <i class="ti ti-camera"></i> Foto
        </div>

        <div class="form-grid">
            <div>
                <label class="form-label" for="gambar">Foto Profil</label>
                @if($konsultan->gambar)
                    <div style="margin-bottom:8px">
                        <img id="preview" src="{{ asset('storage/'.$konsultan->gambar) }}" class="w-32 h-32 object-cover rounded-lg border" alt="Foto konsultan">
                    </div>
                @else
                    <div style="margin-bottom:8px">
                        <img id="preview" class="w-32 h-32 object-cover rounded-lg border hidden" alt="Preview foto">
                    </div>
                @endif
                <input type="file" id="gambar" name="gambar" class="form-input" accept="image/jpeg,image/png,image/jpg,image/gif" style="padding:8px 12px">
                <div style="font-size:11px;color:#94a3b8;margin-top:4px">Format: JPG, PNG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto.</div>
            </div>
            <div>
                <label class="form-label" for="image">Desain Name Desk</label>
                @if($konsultan->image)
                    <div style="margin-bottom:8px">
                        <img id="previewImage" src="{{ asset('storage/'.$konsultan->image) }}" class="w-32 h-32 object-contain bg-white rounded-lg border" alt="Desain name desk">
                    </div>
                @else
                    <div style="margin-bottom:8px">
                        <img id="previewImage" class="w-32 h-32 object-contain bg-white rounded-lg border hidden" alt="Preview name desk">
                    </div>
                @endif
                <input type="file" id="image" name="image" class="form-input" accept="image/*" style="padding:8px 12px">
                <div style="font-size:11px;color:#94a3b8;margin-top:4px">Kosongkan jika tidak ingin mengubah.</div>
            </div>
        </div>

        <div class="form-divider"></div>

        {{-- Keamanan --}}
        <div class="form-section-title">
            <i class="ti ti-lock"></i> Keamanan
        </div>

        <div class="form-grid">
            <div>
                <label class="form-label" for="password">Password <span style="color:#94a3b8;font-weight:400">(opsional)</span></label>
                <input type="password" id="password" name="password" class="form-input" placeholder="Kosongkan jika tidak ingin mengubah password">
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">
                <i class="ti ti-check"></i> Simpan Perubahan
            </button>
            <a href="{{ route('konsultan.index') }}" class="btn-ghost">Batal</a>
        </div>
    </form>
</div>

<script>
    document.getElementById('gambar').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('preview');
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
        }
    });

    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('previewImage');
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
        }
    });
</script>

@endsection