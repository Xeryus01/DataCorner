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
                <h3 class="card-title">Edit Data Infografis</h3>
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
              <form method="POST" action="{{ route('admin_infografis.update', $infografi->id) }}"
                enctype="multipart/form-data">

                <div class="card-body">
                  @csrf
                  @method('PUT')
                  <div class="form-group">
                    <label for="subjek_materi">Subjek Materi</label>
                    <select name="subjek_materi_id" class="form-control" required>
                      @foreach ($subjek_materi as $item)
                        <option value="{{ $item->id }}"
                          {{ $infografi->subjek_materi_id == $item->id ? 'selected' : '' }}>
                          {{ $item->judul }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="judul_infogafis">Judul Infografis</label>
                    <input type="text" name="judul" class="form-control" id="judul_infogafis"
                      value="{{ $infografi->judul }}" placeholder="Masukkan Judul Infografis" required>
                  </div>
                  <div class="form-group">
                    <label for="deskripsi_infografis">Deskripsi</label>
                    <input type="text" name="deskripsi" class="form-control" id="deskripsi_infografis"
                      value="{{ $infografi->deskripsi }}" placeholder="Masukkan Deskripsi Infografis" required>
                  </div>
                  <div class="form-group">
                    <label for="gambar">Gambar</label>
                    <input type="file" name="gambar" class="form-control" id="gambar"
                      value="{{ $infografi->gambar }}" placeholder="Masukkan Gambar"
                      accept="image/jpg, image/jpeg, image/png">
                  </div>
                  <div class="form-group">
                    <label for="file_infografis">File Infografis (PDF, JPG, JPEG, PNG)</label>
                    <input type="file" name="file_infografis" class="form-control" id="file_infografis"
                      value="{{ $infografi->file_infografis }}" placeholder="Masukkan File Infografis">
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
