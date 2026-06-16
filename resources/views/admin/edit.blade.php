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
                <h3 class="card-title">Edit Data Admin</h3>
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
              <form method="POST" action="{{ route('admin_data-admin.update', $data_admin->id) }}">

                <div class="card-body">
                  @csrf
                  @method('PUT')
                  <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role" class="form-control" required>
                      @foreach ($roles as $role)
                        <option value="{{ $role->name }}" {{ $data_admin->hasRole($role->name) ? 'selected' : '' }}>
                          {{ ucfirst($role->name) }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" class="form-control" id="username"
                      value="{{ $data_admin->username }}" placeholder="Masukkan Username" required>
                  </div>
                  <div class="form-group">
                    <label for="wilayah_id">Unit Kerja</label>
                    <select name="wilayah_id" class="form-control" required>
                        <option value="">-- Pilih Unit Kerja --</option>
                        @foreach($wilayah as $item)
                            <option value="{{ $item->id }}" {{ $data_admin->wilayah_id == $item->id ? 'selected' : '' }}>
                                {{ ucfirst($item->nama_wilayah) }}
                            </option>
                        @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="password">Password Baru (Jika ingin diubah)</label>
                    <input type="password" name="password" class="form-control" id="password">
                  </div>
                  <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
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
