@extends('admin.layout')

@section('content')
  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card mt-3 shadow-sm">
              <div class="card-header">
                <h3 class="card-title mb-0">
                  <i class="fas fa-map-marker-alt mr-2"></i>
                  Tambah Wilayah BPS
                </h3>
              </div>
              <form action="{{ route('admin_wilayah-bps.store') }}" method="POST">
                @csrf

                <div class="card-body">
                  <div class="form-group">
                    <label for="nama_wilayah">
                      Nama Wilayah <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="nama_wilayah" id="nama_wilayah" value="{{ old('nama_wilayah') }}" class="form-control @error('nama_wilayah') is-invalid @enderror"
                      placeholder="Contoh: BPS Provinsi Kepulauan Bangka Belitung" required >
                    @error('nama_wilayah')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="kode_wilayah">
                      Kode Wilayah <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="kode_wilayah" id="kode_wilayah" value="{{ old('kode_wilayah') }}" class="form-control @error('kode_wilayah') is-invalid @enderror"
                      placeholder="Contoh: 1900" required>
                    @error('kode_wilayah')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="tingkat_wilayah">
                      Tingkat Wilayah <span class="text-danger">*</span>
                    </label>
                    <select name="tingkat_wilayah" id="tingkat_wilayah" class="form-control @error('tingkat_wilayah') is-invalid @enderror" required>
                      <option value="">-- Pilih Tingkat Wilayah --</option>
                      <option value="provinsi" {{ old('tingkat_wilayah') == 'provinsi' ? 'selected' : '' }}>Provinsi</option>
                      <option value="kabupaten" {{ old('tingkat_wilayah') == 'kabupaten' ? 'selected' : '' }}>Kabupaten</option>
                      <option value="kota" {{ old('tingkat_wilayah') == 'kota' ? 'selected' : '' }}>Kota</option>
                    </select>
                    @error('tingkat_wilayah')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                </div>
                <div class="card-footer d-flex justify-content-center">
                  <a href="{{ route('admin_wilayah-bps.index') }}" class="btn btn-secondary mr-2">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                  </a>

                  <button type="submit" class="btn btn-primary ml-2">
                    <i class="fas fa-save mr-1"></i> Simpan
                  </button>
                </div>

              </form>
            </div>

          </div>
        </div>
      </div>
    </section>
  </div>
@endsection