@extends('admin.layout')

@section('content')
  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Edit Data Pendaftar Magang yang Diterima</h3>
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
          <form method="POST" action="{{ route('admin_daftar-magang.update', $pendaftaran_magang->id) }}">
            <div class="card-body">
              @csrf
              @method('PUT')
              <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control" required>
                  <option value="" disabled selected>-- Update Status --</option>
                  <option value="selesai">Selesai</option>
                </select>
              </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Ubah</button>
            </div>
          </form>
        </div>
        <!-- /.card -->
      </div><!-- /.container-fluid -->
    </section>
  </div>
@endsection
