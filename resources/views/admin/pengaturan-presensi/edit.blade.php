@extends('admin.layout')

@section('content')
  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">

        {{-- Alert --}}
        @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <div class="row">
          <div class="col-md-8">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Pengaturan Presensi</h3>
              </div>

              <form action="{{ route('admin_pengaturan-presensi.update', $setting->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card-body">

                  <div class="form-group">
                    <label>Wilayah BPS</label>
                    <select name="wilayah_bps_id" 
                        class="form-control @error('wilayah_bps_id') is-invalid @enderror" 
                        required>

                        <option value="">-- Pilih Wilayah --</option>

                        @foreach($wilayahBps as $wilayah)
                            <option value="{{ $wilayah->id }}"
                                {{ old('wilayah_bps_id', $setting->wilayah_bps_id) == $wilayah->id ? 'selected' : '' }}>
                                {{ $wilayah->nama_wilayah }}
                            </option>
                        @endforeach

                    </select>

                    @error('wilayah_bps_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                  <div class="form-group">
                    <label>Latitude Kantor</label>
                    <input type="text" name="lat_kantor"
                      value="{{ old('lat_kantor', $setting->lat_kantor) }}"
                      class="form-control"
                      placeholder="Contoh: -2.157338">
                  </div>

                  <div class="form-group">
                    <label>Longitude Kantor</label>
                    <input type="text" name="long_kantor"
                      value="{{ old('long_kantor', $setting->long_kantor) }}"
                      class="form-control"
                      placeholder="Contoh: 106.165562">
                  </div>

                  <div class="form-group">
                    <label>Jam Masuk Mulai</label>
                    <input type="time" name="jam_masuk_mulai"
                      value="{{ old('jam_masuk_mulai', $setting->jam_masuk_mulai) }}"
                      class="form-control" required>
                  </div>

                  <div class="form-group">
                    <label>Jam Masuk Selesai</label>
                    <input type="time" name="jam_masuk_selesai"
                      value="{{ old('jam_masuk_selesai', $setting->jam_masuk_selesai) }}"
                      class="form-control" required>
                  </div>
                  <div class="form-group">
                    <label>Jam Pulang Mulai</label>
                    <input type="time" name="jam_pulang_mulai"
                      value="{{ old('jam_pulang_mulai', $setting->jam_pulang_mulai) }}"
                      class="form-control" required>
                  </div>

                  <div class="form-group">
                    <label>Radius Presensi (meter)</label>
                    <input type="number" name="radius_kantor"
                      value="{{ old('radius_kantor', $setting->radius_kantor) }}"
                      class="form-control" min="0">
                  </div>

                  <div class="form-group form-check">
                    <input type="checkbox"
                      class="form-check-input"
                      id="is_active"
                      name="is_active"
                      value="1"
                      {{ $setting->is_active ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">
                      Aktifkan pengaturan presensi
                    </label>
                  </div>

                </div>

                <div class="card-footer d-flex justify-content-center">
                  <a href="{{ route('admin_pengaturan-presensi.index') }}" class="btn btn-secondary mr-2">
                    Kembali
                  </a>
                  <button type="submit" class="btn btn-primary ml-2">
                     <i class="fas fa-save mr-1"></i >
                    Simpan Perubahan
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
