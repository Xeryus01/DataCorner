@extends('admin.layout')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    {{-- <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div> --}}
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Input Subjek Materi</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          @if (session('success'))
            <div class="alert alert-success">
              {{ session('success') }}
            </div>
          @endif
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          <form method="POST" action="{{ route('admin_subjek-materi.store') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="card-body">
              @csrf
              @include('components.form.input', ['name' => 'judul', 'label' => 'Judul', 'type' => 'text', 'placeholder' => 'Masukkan Judul', 'required' => true])
              @include('components.form.input', ['name' => 'deskripsi', 'label' => 'Deskripsi', 'type' => 'text', 'placeholder' => 'Masukkan Deskripsi', 'required' => true])
              <div class="form-group">
                <label for="gambar">Gambar</label>
                <input type="file" class="form-control" id="gambar" name="gambar" accept="image/jpg, image/jpeg, image/png" required>
                @error('gambar')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@else<p class="text-red-500 text-sm mt-1 form-error" aria-live="polite"></p>@enderror
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
    <!-- /.content -->

    {{-- Tabel Data --}}
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Subjek Materi</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead class="text-center">
                    <tr>
                      <th>No</th>
                      <th>Judul Subjek</th>
                      <th>Deskripsi Subjek</th>
                      <th>Gambar Subjek</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                      $no = 1;
                    @endphp
                    @foreach ($subjek as $item)
                      <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->judul }}</td>
                        <td>{{ $item->deskripsi }}</td>
                        <td><img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar Subjek"
                            style="max-width: 100px; max-height: 100px;"></td>
                        <td>
                          <div class="d-flex align-items-center justify-content-center" style="gap: 10px;">
                            <!-- Tombol Edit -->
                            <a href="{{ route('admin_subjek-materi.edit', $item->id) }}" class="btn btn-warning">
                              <span><i class="fas fa-edit"></i></span>
                            </a>

                            <!-- Form Hapus -->
                            <form action="{{ route('admin_subjek-materi.destroy', $item->id) }}" method="POST"
                              class="m-0">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                <span><i class="fas fa-trash"></i></span>
                              </button>
                            </form>
                          </div>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
    </section>
    {{-- /.Tabel Data --}}
  </div>
  <!-- /.content-wrapper -->
@endsection
