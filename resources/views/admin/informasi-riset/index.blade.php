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
                <h3 class="card-title">Data Informasi Riset</h3>
              </div>
              <!-- /.card-header -->

              <div class="card-body">
                <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead class="text-center">
                      <tr>
                        <th>Deskripsi</th>
                        <th>Persyaratan</th>
                        <th>Benefit</th>
                        <th>Info Kontak</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($info as $item)
                        <tr>
                          <td>{!! Str::limit($item->deskripsi, 50, '...') !!}</td>
                          <td>{!! Str::limit($item->persyaratan, 50, '...') !!}</td>
                          <td>{!! Str::limit($item->benefit, 50, '...') !!}</td>
                          <td>{!! Str::limit($item->info_kontak, 50, '...') !!}</td>
                          <td>
                            <div class="d-flex align-items-center justify-content-center" style="gap: 10px;">
                              <a href="{{ route('admin_informasi-riset.edit', $item->id) }}"
                                class="btn btn-warning"><span><i class="fas fa-edit"></i></span></a>
                            </div>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
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
