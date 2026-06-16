@extends('admin.layout')

@section('content')
  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card mt-3">

              <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">
                  <i class="fas fa-map-marker-alt mr-1"></i>
                  Data Wilayah BPS
                </h3>
              </div>

              {{-- Alert --}}
              @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                  <i class="fas fa-check-circle mr-1"></i>
                  {{ session('success') }}
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
              @endif

              <div class="card shadow-sm">
                <div class="card-body">

                  {{-- Search + Tambah --}}
                  <div class="row mb-3 align-items-center">
                    <div class="col-md-6">
                      <form action="{{ route('admin_wilayah-bps.index') }}" method="GET">
                        <div class="input-group">
                          <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama atau kode wilayah...">
                          <div class="input-group-append">
                            <button class="btn btn-secondary">
                              <i class="fas fa-search"></i>
                            </button>
                          </div>
                        </div>
                      </form>
                    </div>

                    <div class="col-md-6 text-right">
                      <a href="{{ route('admin_wilayah-bps.create') }}"
                        class="btn btn-primary">
                        <i class="fas fa-plus mr-1"></i> Tambah Wilayah
                      </a>
                    </div>
                  </div>

                  {{-- Table --}}
                  <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                      <thead class="thead-light text-center">
                        <tr>
                          <th>Nama Wilayah</th>
                          <th>Kode Wilayah</th>
                          <th>Tingkat Wilayah</th>
                          <th width="120">Aksi</th>
                        </tr>
                      </thead>
                      <tbody class="text-center">
                        @forelse ($wilayahBps as $item)
                          <tr>
                            <td class="text-left">{{ $item->nama_wilayah }}</td>
                            <td>{{ $item->kode_wilayah }}</td>
                            <td>
                              <span class="badge badge-info">
                                {{ ucfirst($item->tingkat_wilayah) }}
                              </span>
                            </td>
                            <td>
                              <div class="btn-group">
                                <a href="{{ route('admin_wilayah-bps.edit', $item->id) }}" class="btn btn-sm btn-warning mr-2" title="Edit">
                                  <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admin_wilayah-bps.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus wilayah ini?')">
                                  @csrf
                                  @method('DELETE')
                                  <button class="btn btn-sm btn-danger mr-2" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                  </button>
                                </form>
                              </div>
                            </td>
                          </tr>
                        @empty
                          <tr>
                            <td colspan="4" class="text-muted py-4">
                              <i class="fas fa-info-circle mr-1"></i>
                              Data wilayah belum tersedia
                            </td>
                          </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection