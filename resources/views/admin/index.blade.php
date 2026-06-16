@extends('admin.layout')

@section('content')
  <div class="content-wrapper">
    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif
    {{-- Tabel Data Artikel --}}
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card" style="margin-top: 1rem;">
              <div class="card-header">
                  <h3 class="card-title font-weight-bold" style="font-size: 30px;">
                      Data Admin
                  </h3>

                  <a href="{{ route('admin_data-admin.create') }}" 
                    class="btn btn-primary float-right">
                      <i class="fas fa-plus"></i> Tambah Admin
                  </a>
              </div>
              <!-- /.card-header -->

              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead class="text-center">
                    <tr>
                      <th>Username</th>
                      <th>Role</th>
                      <th>Unit Kerja</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($admins as $admin)
                      <tr>
                        <td>{{ $admin->username }}</td>
                        <td>{{ $admin->roles->pluck('name')->join(', ') }}</td>
                        <td>{{ optional($admin->wilayah)->nama_wilayah ?? '-' }}</td>
                        <td>
                          <div class="d-flex align-items-center justify-content-center" style="gap: 10px;">
                            <a href="{{ route('admin_data-admin.edit', $admin->id) }}" class="btn btn-warning"><span><i
                                  class="fas fa-edit"></i></span></a>
                            {{-- <form action="{{ route('admin_data-admin.destroy', $admin->id) }}" method="POST"
                              class="m-0">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                <span><i class="fas fa-trash"></i></span>
                              </button>
                            </form> --}}
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
    {{-- /.Tabel Data Artikel --}}
  </div>
@endsection
