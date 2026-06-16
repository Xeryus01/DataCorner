@extends('admin.layout')

@section('content')
  <div class="content-wrapper">
    <section class="content py-3">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-lg-8">

            <div class="card shadow-sm border-0">
              <div class="card-header bg-warning d-flex align-items-center">
                <i class="fas fa-edit mr-2"></i>
                <h3 class="card-title mb-0 text-dark font-weight-bold">
                  Edit Wilayah BPS
                </h3>
              </div>

              <form action="{{ route('admin_wilayah-bps.update', $wilayahBps->id) }}" method="POST" onsubmit="this.querySelector('button[type=submit]').disabled=true;">

                @csrf
                @method('PUT')

                <div class="card-body">
                  <div class="form-group">
                    <label class="font-weight-semibold">
                      Nama Wilayah <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="nama_wilayah" value="{{ old('nama_wilayah', $wilayahBps->nama_wilayah) }}" class="form-control @error('nama_wilayah') is-invalid @enderror" placeholder="Contoh: BPS Provinsi Kepulauan Bangka Belitung" autofocus>
                    <small class="text-muted">
                      Masukkan nama wilayah sesuai penamaan resmi BPS.
                    </small>
                    @error('nama_wilayah')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label class="font-weight-semibold">
                      Kode Wilayah <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="kode_wilayah" value="{{ old('kode_wilayah', $wilayahBps->kode_wilayah) }}" class="form-control @error('kode_wilayah') is-invalid @enderror" placeholder="Contoh: 1900">
                    <small class="text-muted">
                      Kode unik wilayah berdasarkan standar.
                    </small>
                    @error('kode_wilayah')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label class="font-weight-semibold">
                      Tingkat Wilayah <span class="text-danger">*</span>
                    </label>
                    <select name="tingkat_wilayah" class="form-control @error('tingkat_wilayah') is-invalid @enderror">
                      <option value="">-- Pilih Tingkat Wilayah --</option>
                      <option value="provinsi" {{ old('tingkat_wilayah', $wilayahBps->tingkat_wilayah) == 'provinsi' ? 'selected' : '' }}>
                        Provinsi
                      </option>
                      <option value="kabupaten" {{ old('tingkat_wilayah', $wilayahBps->tingkat_wilayah) == 'kabupaten' ? 'selected' : '' }}>
                        Kabupaten
                      </option>
                      <option value="kota" {{ old('tingkat_wilayah', $wilayahBps->tingkat_wilayah) == 'kota' ? 'selected' : '' }}>
                        Kota
                      </option>
                    </select>
                    <small class="text-muted">
                      Pilih level administrasi wilayah.
                    </small>
                    @error('tingkat_wilayah')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="card-footer d-flex justify-content-center">
                  <a href="{{ route('admin_wilayah-bps.index') }}" class="btn btn-outline-secondary mr-2">
                     <i class="fas fa-arrow-left mr-1"></i> Kembali
                  </a>
                  <button type="submit" class="btn btn-primary px-4 ml-2">                     
                    <i class="fas fa-save mr-1"></i> Simpan Perubahan
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