@extends('admin.layout')

@section('content')
  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Upload Sertifikat Pendaftar Kolaborasi Riset</h3>
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
          <form method="POST" action="{{ route('admin_daftar-riset.upload-sertifikat', $pendaftaran_riset->id) }}"
            enctype="multipart/form-data">
            <div class="card-body">
              @csrf
              @method('PUT')
              <div class="form-group">
                <label for="sertifikat_riset">Sertifikat Kolaborasi Riset (PDF, JPG, JPEG, PNG)</label>
                <input type="file" name="sertifikat_riset" class="form-control" id="sertifikat_riset"
                  accept="image/jpg, image/jpeg, image/png, application/pdf" required>
              </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Upload</button>
            </div>
          </form>
        </div>
        <!-- /.card -->
      </div><!-- /.container-fluid -->
    </section>
  </div>
@endsection
