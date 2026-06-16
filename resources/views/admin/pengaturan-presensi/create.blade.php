@extends('admin.layout')

@section('content')
  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card mt-3">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-cogs mr-2"></i>
                  Buat Pengaturan Presensi
                </h3>
              </div>

              <form action="{{ route('admin_pengaturan-presensi.store') }}" method="POST">
                @csrf

                <div class="card-body">

                  <div class="form-group">
                      <label>Wilayah BPS</label>
                      <select name="wilayah_bps_id" class="form-control @error('wilayah_bps_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Wilayah --</option>
                          @foreach($wilayahBps as $wilayah)
                            <option value="{{ $wilayah->id }}"
                              {{ old('wilayah_bps_id') == $wilayah->id ? 'selected' : '' }}>
                              {{ $wilayah->nama_wilayah }}
                            </option>
                          @endforeach
                      </select>
                      @error('wilayah_bps_id')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>

                  {{-- Latitude --}}
                  <div class="form-group">
                    <label>Latitude Kantor</label>
                    <input type="text" name="lat_kantor" value="{{ old('lat_kantor') }}" class="form-control @error('lat_kantor') is-invalid @enderror" placeholder="Contoh: -2.131432">
                    @error('lat_kantor')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  {{-- Longitude --}}
                  <div class="form-group">
                    <label>Longitude Kantor</label>
                    <input type="text" name="long_kantor" value="{{ old('long_kantor') }}" class="form-control @error('long_kantor') is-invalid @enderror" placeholder="Contoh: 106.116789">
                    @error('long_kantor')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  {{-- Jam Masuk --}}
                  <div class="form-group">
                    <label>Jam Masuk Mulai</label>
                    <input type="time" name="jam_masuk_mulai" value="{{ old('jam_masuk_mulai') }}" class="form-control @error('jam_masuk_mulai') is-invalid @enderror" required>
                    @error('jam_masuk_mulai')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label>Jam Masuk Selesai</label>
                    <input type="time" name="jam_masuk_selesai" value="{{ old('jam_masuk_selesai') }}" class="form-control @error('jam_masuk_selesai') is-invalid @enderror" required>
                    @error('jam_masuk_selesai')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  {{-- Jam Pulang --}}
                  <div class="form-group">
                    <label>Jam Pulang Mulai</label>
                    <input type="time" name="jam_pulang_mulai" value="{{ old('jam_pulang_mulai') }}" class="form-control @error('jam_pulang_mulai') is-invalid @enderror" required>                    
                    @error('jam_pulang_mulai')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  {{-- Radius --}}
                  <div class="form-group">
                    <label>Radius Presensi (meter)</label>
                    <input type="number" name="radius_kantor" value="{{ old('radius_kantor', 100) }}" class="form-control @error('radius_kantor') is-invalid @enderror">
                    @error('radius_kantor')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  {{-- Status Aktif --}}
                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="is_active">
                      Aktifkan pengaturan presensi
                    </label>
                    </div>
                  </div>

                </div>

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Simpan
                  </button>
                  <a href="{{ route('admin_pengaturan-presensi.index') }}" class="btn btn-secondary">
                    Batal
                  </a>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
