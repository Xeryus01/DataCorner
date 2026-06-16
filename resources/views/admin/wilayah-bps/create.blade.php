@extends('admin.layout')
@section('content')
<div class="page-header-row">
    <div>
        <div class="page-title">Tambah Wilayah BPS</div>
        <div class="page-sub">Tambah data wilayah kerja BPS</div>
    </div>
</div>

<div class="card" style="max-width:560px">
    <div class="card-header">
        <div class="card-header-left">
            <div class="card-title"><i class="ti ti-map-pin"></i>Form Tambah Wilayah</div>
        </div>
    </div>
    <div class="card-body">
        @if($errors->any())
        <div class="form-error">
            @foreach($errors->all() as $e)<div>• {{$e}}</div>@endforeach
        </div>
        @endif

        <form action="{{ route('admin_wilayah-bps.store') }}" method="POST">
            @csrf
            <div style="margin-bottom:14px">
                <label class="form-label">Nama Wilayah <span style="color:#E24B4A">*</span></label>
                <input type="text" name="nama_wilayah" value="{{ old('nama_wilayah') }}" class="form-input @error('nama_wilayah') is-invalid @enderror" placeholder="Contoh: BPS Provinsi Kepulauan Bangka Belitung" required>
                @error('nama_wilayah') <p style="color:#E24B4A;font-size:11px;margin-top:4px">{{ $message }}</p> @enderror
            </div>
            <div style="margin-bottom:14px">
                <label class="form-label">Kode Wilayah <span style="color:#E24B4A">*</span></label>
                <input type="text" name="kode_wilayah" value="{{ old('kode_wilayah') }}" class="form-input @error('kode_wilayah') is-invalid @enderror" placeholder="Contoh: 1900" required>
                @error('kode_wilayah') <p style="color:#E24B4A;font-size:11px;margin-top:4px">{{ $message }}</p> @enderror
            </div>
            <div style="margin-bottom:16px">
                <label class="form-label">Tingkat Wilayah <span style="color:#E24B4A">*</span></label>
                <select name="tingkat_wilayah" class="form-select @error('tingkat_wilayah') is-invalid @enderror" required>
                    <option value="">-- Pilih Tingkat Wilayah --</option>
                    <option value="provinsi" {{ old('tingkat_wilayah') == 'provinsi' ? 'selected' : '' }}>Provinsi</option>
                    <option value="kabupaten" {{ old('tingkat_wilayah') == 'kabupaten' ? 'selected' : '' }}>Kabupaten</option>
                    <option value="kota" {{ old('tingkat_wilayah') == 'kota' ? 'selected' : '' }}>Kota</option>
                </select>
                @error('tingkat_wilayah') <p style="color:#E24B4A;font-size:11px;margin-top:4px">{{ $message }}</p> @enderror
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i>Simpan</button>
                <a href="{{ route('admin_wilayah-bps.index') }}" class="btn-ghost">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection