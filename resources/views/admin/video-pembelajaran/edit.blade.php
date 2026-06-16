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
                <h3 class="card-title">Edit Data Video Pembelajaran</h3>
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
              <form method="POST" action="{{ route('admin_video-pembelajaran.update', $video_pembelajaran->id) }}">

                <div class="card-body">
                  @csrf
                  @method('PUT')
                  <div class="form-group">
                    <label for="subjek_materi">Subjek Materi</label>
                    <select name="subjek_materi_id" class="form-control" required>
                      @foreach ($subjek_materi as $item)
                        <option value="{{ $item->id }}"
                          {{ $video_pembelajaran->subjek_materi_id == $item->id ? 'selected' : '' }}>
                          {{ $item->judul }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="judul_video">Judul Video</label>
                    <input type="text" name="judul" class="form-control" id="judul_video"
                      value="{{ $video_pembelajaran->judul }}" placeholder="Masukkan Judul Video" required>
                  </div>
                  <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <input type="text" name="deskripsi" class="form-control" id="deskripsi"
                      value="{{ $video_pembelajaran->deskripsi }}" placeholder="Masukkan Deskripsi Video" required>
                  </div>
                  <div class="form-group">
                    <label for="link">Link Video</label>
                    <input type="text" name="link" class="form-control" id="link"
                      value="{{ $video_pembelajaran->link }}" placeholder="Masukkan Link Video">
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
