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
                <h3 class="card-title">Edit Subjudul Artikel {{ $subjudul_artikel->artikel->judul }}</h3>
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
              <form method="POST" action="{{ route('admin_subjudul-artikel.update', $subjudul_artikel->id) }}">
                <div class="card-body">
                  @csrf
                  @method('PUT')
                  <input type="hidden" name="id_artikel" value="{{ $subjudul_artikel->artikel->id }}">
                  <div class="form-group">
                    <label for="sub_judul">Sub Judul Artikel</label>
                    <input type="text" name="sub_judul" class="form-control" id="sub_judul"
                      value="{{ $subjudul_artikel->sub_judul }}" placeholder="Masukkan Sub Judul Artikel" required>
                  </div>
                  <div class="form-group">
                    <label for="urutan">Urutan</label>
                    <input type="number" name="urutan" class="form-control" id="Urutan"
                      value="{{ $subjudul_artikel->urutan }}" placeholder="Masukkan Urutan Sub Judul Artikel" required>
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
