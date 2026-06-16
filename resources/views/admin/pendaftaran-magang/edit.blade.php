@extends('admin.layout')

@section('content')
  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Edit Data Pendaftar Magang</h3>
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
              {{-- <input type="text" name="user_id" hidden id="user_id" value="{{ $pendaftaran_magang->user_id }}"
                required>
              <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" name="nama" class="form-control" id="nama"
                  value="{{ $pendaftaran_magang->nama }}" required readonly>
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email" class="form-control" id="email"
                  value="{{ $pendaftaran_magang->email }}" required readonly>
              </div>
              <div class="form-group">
                <label for="no_hp">Nomor WhatsApp</label>
                <input type="text" name="no_hp" class="form-control" id="no_hp"
                  value="{{ $pendaftaran_magang->no_hp }}" required readonly>
              </div>
              <div class="form-group">
                <label for="cv_file">CV Pendaftar</label>
                <input type="file" name="cv_file" class="form-control" id="cv_file"
                  value="{{ $pendaftaran_magang->cv_file }}" required disabled>
              </div>
              <div class="form-group">
                <label for="surat_motivasi">Surat Motivasi</label>
                <textarea name="surat_motivasi" class="form-control" id="surat_motivasi" cols="30" rows="10" required
                  readonly>{{ $pendaftaran_magang->surat_motivasi }}</textarea>
              </div> --}}
              <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control" required>
                  <option value="" disabled selected>-- Update Status --</option>
                  <option value="diterima">Diterima</option>
                  <option value="ditolak">Ditolak</option>
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
