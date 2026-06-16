@extends('admin.layout')

@section('content')
  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Topik Kuis Tantangan Bulanan</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              @if ($errors->any())
                <div class="alert alert-danger">
                  <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif
              <form method="POST"
                action="{{ route('admin_kuis-tantangan-bulanan.update', $kuis_tantangan_bulanan->id) }}">

                <div class="card-body">
                  @csrf
                  @method('PUT')
                  <div class="form-group">
                    <label for="periode">Periode</label>
                    <select name="periode" class="form-control" required>
                      @foreach ($periode as $item)
                        <option value="{{ $item->id }}"
                          {{ $kuis_tantangan_bulanan->id_periode == $item->id ? 'selected' : '' }}>
                          {{ $item->periode }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="judul_kuis">Judul Kuis Tantangan Bulanan</label>
                    <input type="text" name="judul" class="form-control" id="judul_kuis"
                      value="{{ $kuis_tantangan_bulanan->judul }}" placeholder="Tantangan Bulanan Januari" required>
                  </div>
                  <div class="form-group">
                    <label for="deskripsi_kuis">Deskripsi</label>
                    <input type="text" name="deskripsi" class="form-control" id="deskripsi_kuis"
                      value="{{ $kuis_tantangan_bulanan->deskripsi }}" placeholder="Statistika dan Probabilitas"
                      required>
                  </div>
                  <div class="form-group">
                    <label for="tgl_mulai">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control" id="tgl_mulai"
                      value="{{ $kuis_tantangan_bulanan->tanggal_mulai }}" required>
                  </div>
                  <div class="form-group">
                    <label for="tgl_selesai">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="form-control" id="tgl_selesai"
                      value="{{ $kuis_tantangan_bulanan->tanggal_selesai }}" required>
                  </div>
                  <div class="form-group">
                    <label for="durasi_menit">Durasi Pengerjaan (menit)</label>
                    <input type="number" name="durasi_menit" id="durasi_menit" class="form-control"
                      value="{{ $kuis_tantangan_bulanan->durasi_menit }}" required
                      placeholder="Masukkan Durasi Pengerjaan">
                  </div>
                  <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" required>
                      <option value="" disabled selected>-- Update Status --</option>
                      <option value="aktif">Aktif</option>
                      <option value="nonaktif">Non-Aktif</option>
                    </select>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
  </div>
@endsection
