@extends('admin.layout')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Input Periode</h3>
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
          <form method="POST" action="{{ route('admin_periode.store') }}">
            <div class="card-body">
              @csrf
              <div class="form-group">
                <label for="periode">Periode</label>
                <input type="number" name="periode" class="form-control" id="periode" placeholder="Masukkan Periode"
                  required>
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
                      <th>Periode</th>
                      <th>Status Leaderboard</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($periods as $periode)
                      <tr>
                        <td>{{ $periode->periode }}</td>
                        <td class="text-center">
                          @if ($periode->status_leaderboard === 'aktif')
                            <span class="badge badge-success">Aktif</span>
                          @else
                            <span class="badge badge-secondary">Nonaktif</span>
                          @endif
                        </td>
                        <td class="text-center">
                          <div class="d-flex align-items-center justify-content-center" style="gap: 10px;">
                            <!-- Tombol Edit -->
                            <a href="{{ route('admin_periode.edit', $periode->id) }}" class="btn btn-warning">
                              <i class="fas fa-edit"></i>
                            </a>

                            <!-- Form Hapus -->
                            <form action="{{ route('admin_periode.destroy', $periode->id) }}" method="POST"
                              class="m-0">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                <i class="fas fa-trash"></i>
                              </button>
                            </form>

                            <!-- Tombol Aktifkan Leaderboard -->
                            @if ($periode->status_leaderboard === 'aktif')
                              <!-- Jika sedang aktif, tampilkan tombol Nonaktifkan -->
                              <form action="{{ route('admin_periode.nonaktifkanLeaderboard') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-secondary" title="Nonaktifkan Leaderboard">
                                  <i class="fas fa-times"></i> Nonaktifkan
                                </button>
                              </form>
                            @else
                              <!-- Jika tidak aktif, tampilkan tombol Aktifkan -->
                              <form action="{{ route('admin_periode.setLeaderboard', $periode->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary" title="Aktifkan Leaderboard">
                                  <i class="fas fa-check"></i>
                                </button>
                              </form>
                            @endif

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
