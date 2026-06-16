@extends('admin.layout')

@section('content')
  <div class="content-wrapper">
    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    {{-- Tabel Data Detail Sub Judul Artikel --}}
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card" style="margin-top: 1rem;">
              <div class="card-header">
                <h3 class="card-title">Data Detail Sub Judul {{ $subjudul->sub_judul }}</h3>
              </div>
              <!-- /.card-header -->

              <div class="card-body">
                <div class="mb-3 d-flex justify-content-between">
                  <form action="{{ route('admin_detail-subjudul-artikel.index', $subjudul->id) }}" method="GET"
                    class="form-inline">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control mr-2"
                      placeholder="Cari ...">
                    <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i></button>
                  </form>
                  <a href="{{ route('admin_detail-subjudul-artikel.create', $subjudul->id) }}" class="btn btn-primary">
                    <span><i class="fas fa-plus mr-2"></i></span>Tambah Data
                  </a>
                </div>
                <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-striped" style="min-width: 1000px;">
                    <thead class="text-center">
                      <tr>
                        <th>Konten Text</th>
                        <th>Link Embed</th>
                        <th>Gambar</th>
                        <th>Urutan</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($detail_subjuduls as $detail_subjudul)
                        <tr>
                          <td>{!! Str::limit($detail_subjudul->konten_text, 100, '...') !!}</td>
                          <td>{{ Str::limit($detail_subjudul->link_embed, 10, '...') }}</td>
                          <td>
                            @if ($detail_subjudul->gambar)
                              <img src="{{ asset('storage/' . $detail_subjudul->gambar) }}"
                                style="max-width: 100px; max-height: 100px;">
                            @else
                              -
                            @endif
                          </td>
                          <td>{{ $detail_subjudul->urutan }}</td>
                          <td>
                            <div class="d-flex align-items-center justify-content-center" style="gap: 10px;">
                              <a href="{{ route('admin_detail-subjudul-artikel.edit', $detail_subjudul->id) }}"
                                class="btn btn-warning"><span><i class="fas fa-edit"></i></span></a>
                              <form action="{{ route('admin_detail-subjudul-artikel.destroy', $detail_subjudul->id) }}"
                                method="POST" class="m-0">
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
                  {{ $detail_subjuduls->links() }}
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
    </section>
    {{-- /.Tabel Data Detail Sub Judul Artikel --}}
  </div>
@endsection
