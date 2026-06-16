@extends('admin.layout')

@section('content')
  <div class="content-wrapper">

    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle mr-1"></i>
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>
    @endif

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card mt-3 shadow-xl rounded-[2rem] border border-slate-200 overflow-hidden">

              <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 bg-slate-50 border-b border-slate-200 py-4 px-4">
                <div>
                  <h3 class="card-title mb-1 text-xl font-bold">
                    <i class="fas fa-map-marker-alt mr-2"></i>
                    Data Pengaturan Presensi
                  </h3>
                  <p class="text-sm text-slate-500">Kelola konfigurasi lokasi dan jam presensi dengan tampilan yang lebih rapi dan mudah dibaca.</p>
                </div>

                <a href="{{ route('admin_pengaturan-presensi.create') }}" class="btn btn-primary btn-sm rounded-pill px-4 py-2">
                  <i class="fas fa-plus mr-1"></i>
                  Tambah Pengaturan
                </a>
              </div>

              <div class="card-body bg-white p-4">

                <div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                  <form action="{{ route('admin_pengaturan-presensi.index') }}" method="GET" class="form-inline mb-2 mb-md-0 w-full">
                    <div class="input-group w-full">
                      <input type="text" name="search" value="{{ request('search') }}" class="form-control rounded-pill border-slate-300" placeholder="Cari nama lokasi presensi...">
                      <div class="input-group-append">
                        <button class="btn btn-secondary rounded-pill ml-2 px-4" type="submit">
                          <i class="fas fa-search"></i>
                        </button>
                      </div>
                    </div>
                  </form>

                  <div class="text-sm text-slate-500">Total pengaturan: <span class="font-semibold">{{ $setting->count() }}</span></div>
                </div>

                <!-- Table -->
                <div class="table-responsive shadow-sm rounded-3xl overflow-hidden border border-slate-200">
                  <table class="table table-bordered table-hover table-striped text-nowrap mb-0">
                    <thead class="thead-light text-center bg-slate-100">
                      <tr>
                        <th>No.</th>
                        <th>Lokasi</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Radius (m)</th>
                        <th>Masuk</th>
                        <th>Selesai</th>
                        <th>Pulang</th>
                        <th>Status</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>

                    <tbody class="text-center">
                

                <!-- Table -->
                <div class="table-responsive">
                  <table class="table table-bordered table-hover text-nowrap">
                    <thead class="thead-light text-center">
                      <tr>
                        <th>No.</th>
                        <th>Lokasi</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Radius (m)</th>
                        <th>Masuk</th>
                        <th>Selesai</th>
                        <th>Pulang</th>
                        <th>Status</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>

                    <tbody class="text-center">
                      @foreach ($setting as $item)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-left font-weight-bold">
                          {{ $item->wilayahBps->nama_wilayah ?? '-' }}
                        </td>
                        <td>{{ $item->lat_kantor }}</td>
                        <td>{{ $item->long_kantor }}</td>
                        <td>{{ $item->radius_kantor }}</td>
                        <td>{{ $item->jam_masuk_mulai }}</td>
                        <td>{{ $item->jam_masuk_selesai }}</td>
                        <td>{{ $item->jam_pulang_mulai }}</td>
                        <td>
                          @if ($item->is_active)
                            <span class="badge badge-success rounded-pill px-3 py-2">Aktif</span>
                          @else
                            <span class="badge badge-danger rounded-pill px-3 py-2">Tidak Aktif</span>
                          @endif
                        </td>
                        <td>
                          <div class="btn-group" role="group">
                            <a href="{{ route('admin_pengaturan-presensi.edit', $item->id) }}" class="btn btn-sm btn-warning rounded-pill mr-2" title="Edit">
                              <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin_pengaturan-presensi.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengaturan ini?')">
                              @csrf
                              @method('DELETE')
                              <button class="btn btn-sm btn-danger rounded-pill" title="Hapus">
                                <i class="fas fa-trash"></i>
                              </button>
                            </form>
                          </div>
                        </td>
                      </tr>

                      @endforeach
                    </tbody>
                  </table>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </div>
@endsection