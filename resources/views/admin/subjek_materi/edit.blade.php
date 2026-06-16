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
                <h3 class="card-title">Edit Subjek Materi</h3>
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
              <form action="{{ route('admin_subjek-materi.update', $subjek_materi->id) }}" method="POST"
                enctype="multipart/form-data">
                <div class="card-body">
                  @csrf
                  @method('PUT')
                  <div class="form-group">
                    <label for="judul_subjek">Judul</label>
                    <input type="text" name="judul" class="form-control" id="judul_subjek"
                      value="{{ $subjek_materi->judul }}" placeholder="Masukkan Judul" required>
                  </div>
                  <div class="form-group">
                    <label for="deskripsi_subjek">Deskripsi</label>
                    <input type="text" name="deskripsi" class="form-control" id="deskripsi_subjek"
                      value="{{ $subjek_materi->deskripsi }}" placeholder="Masukkan Deskripsi" required>
                  </div>
                  <div class="form-group">
                    <label for="gambar">Gambar</label>
                    <input type="file" class="form-control" id="gambar" name="gambar"
                      accept="image/jpg, image/jpeg, image/png">
                    <small>Biarkan kosong jika tidak ingin menguabah file.</small>
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
