@extends('admin.layout')

@section('content')
  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Input Topik Kuis Tantangan Bulanan</h3>
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
          <form method="POST" action="{{ route('admin_kuis-tantangan-bulanan.store') }}">
            <div class="card-body">
              @csrf
              <div class="form-group">
                <label for="periode">Periode</label>
                <select name="periode" class="form-control" required>
                  <option value="" disabled selected>-- Pilih Periode --</option>
                  @foreach ($periode as $item)
                    <option value="{{ $item->id }}">{{ $item->periode }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="judul_kuis">Judul Kuis Tantangan Bulanan</label>
                <input type="text" name="judul" class="form-control" id="judul_kuis"
                  placeholder="Tantangan Bulanan Januari" required>
              </div>
              <div class="form-group">
                <label for="deskripsi_kuis">Deskripsi</label>
                <input type="text" name="deskripsi" class="form-control" id="deskripsi_kuis"
                  placeholder="Statistika dan Probabilitas" required>
              </div>
              <div class="form-group">
                <label for="tgl_mulai">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" class="form-control" id="tgl_mulai" required>
              </div>
              <div class="form-group">
                <label for="tgl_selesai">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" class="form-control" id="tgl_selesai" required>
              </div>
              <div class="form-group">
                <label for="durasi_menit">Durasi Pengerjaan (menit)</label>
                <input type="number" name="durasi_menit" id="durasi_menit" class="form-control" required
                  placeholder="Masukkan Durasi Pengerjaan">
              </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
          </form>
        </div>
        <!-- /.card -->
      </div><!-- /.container-fluid -->
    </section>
  </div>
@endsection
