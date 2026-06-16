@extends('admin.layout')

@section('content')
  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Input Infografis</h3>
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
          <form method="POST" action="{{ route('admin_infografis.store') }}" enctype="multipart/form-data">
            <div class="card-body">
              @csrf
              <div class="form-group">
                <label for="subjek_materi">Subjek Materi</label>
                <select name="subjek_materi" class="form-control" required>
                  <option value="" disabled selected>-- Pilih Subjek --</option>
                  @foreach ($subjek_materi as $subjek)
                    <option value="{{ $subjek->id }}">{{ $subjek->judul }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="judul_infogafis">Judul Infografis</label>
                <input type="text" name="judul" class="form-control" id="judul_infogafis"
                  placeholder="Masukkan Judul Infografis" required>
              </div>
              <div class="form-group">
                <label for="deskripsi_infografis">Deskripsi</label>
                <input type="text" name="deskripsi" class="form-control" id="deskripsi_infografis"
                  placeholder="Masukkan Deskripsi Infografis" required>
              </div>
              <div class="form-group">
                <label for="gambar">Gambar</label>
                <input type="file" name="gambar" class="form-control" id="gambar" placeholder="Masukkan Gambar"
                  accept="image/jpg, image/jpeg, image/png" required>
              </div>
              <div class="form-group">
                <label for="file_infografis">File Infografis (PDF, JPG, JPEG, PNG)</label>
                <input type="file" name="file_infografis" class="form-control" id="file_infografis"
                  placeholder="Masukkan File Infografis" required>
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
