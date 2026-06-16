@extends('admin.layout')

@section('content')
  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Tambah Data Admin</h3>
              </div>

              {{-- Error Validation --}}
              @if ($errors->any())
                <div class="alert alert-danger m-3">
                  <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif

              {{-- FORM --}}
              <form method="POST" action="{{ route('admin_data-admin.store') }}">
                @csrf

                <div class="card-body">

                  {{-- ROLE --}}
                  <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role" class="form-control" required>
                      <option value="">-- Pilih Role --</option>
                      @foreach ($roles as $role)
                        <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                          {{ ucfirst($role->name) }}
                        </option>
                      @endforeach
                    </select>
                  </div>

                  {{-- USERNAME --}}
                  <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" class="form-control"
                      value="{{ old('username') }}"
                      placeholder="Masukkan Username" required>
                  </div>

                  {{-- WILAYAH --}}
                  <div class="form-group">
                    <label for="wilayah_id">Unit Kerja</label>
                    <select name="wilayah_id" class="form-control" required>
                      <option value="">-- Pilih Unit Kerja --</option>
                      @foreach($wilayah as $item)
                        <option value="{{ $item->id }}" {{ old('wilayah_id') == $item->id ? 'selected' : '' }}>
                          {{ ucfirst($item->nama_wilayah) }}
                        </option>
                      @endforeach
                    </select>
                  </div>

                  {{-- PASSWORD --}}
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" required>
                  </div>

                  {{-- KONFIRMASI PASSWORD --}}
                  <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                  </div>

                </div>

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>

              </form>
            </div>

          </div>
        </div>
      </div>
    </section>
  </div>
@endsection