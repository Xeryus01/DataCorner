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
                <h3 class="card-title">Data Soal {{ $kuis_reguler->judul }}</h3>
              </div>
              <!-- /.card-header -->

              <div class="card-body">
                <div class="mb-3 d-flex justify-content-between">
                  <form action="{{ route('admin_soal-kuis-reguler.index', $kuis_reguler->id) }}" method="GET"
                    class="form-inline">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control mr-2"
                      placeholder="Cari soal...">
                    <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i></button>
                  </form>
                  <a href="{{ route('admin_soal-kuis-reguler.create', $kuis_reguler->id) }}" class="btn btn-primary">
                    <span><i class="fas fa-plus mr-2"></i></span>Tambah Data
                  </a>
                </div>
                <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead class="text-center">
                      <tr>
                        <th>Gambar</th>
                        <th>Soal</th>
                        <th>Tipe Soal</th>
                        <th>Jawaban</th>
                        <th>Opsi A</th>
                        <th>Opsi B</th>
                        <th>Opsi C</th>
                        <th>Opsi D</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody class="text-center">
                      @foreach ($soal as $item)
                        <tr>
                          <td>
                            @if ($item->gambar)
                              <img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar Subjek"
                                style="max-width: 100px; max-height: 100px;">
                            @else
                              <p>Gambar Tidak Tersedia</p>
                            @endif
                          </td>
                          <td>{!! $item->soal !!}</td>
                          <td>{{ $item->tipe_soal }}</td>
                          <td>{{ $item->jawaban }}</td>
                          {{-- Opsi A --}}
                          <td>{{ optional($item->opsi->firstWhere('label', 'A'))->teks_opsi ?? '-' }}</td>
                          {{-- Opsi B --}}
                          <td>{{ optional($item->opsi->firstWhere('label', 'B'))->teks_opsi ?? '-' }}</td>
                          {{-- Opsi C --}}
                          <td>{{ optional($item->opsi->firstWhere('label', 'C'))->teks_opsi ?? '-' }}</td>
                          {{-- Opsi D --}}
                          <td>{{ optional($item->opsi->firstWhere('label', 'D'))->teks_opsi ?? '-' }}</td>
                          <td>
                            <div class="d-flex align-items-center justify-content-center" style="gap: 10px;">
                              <a href="{{ route('admin_soal-kuis-reguler.edit', $item->id) }}"
                                class="btn btn-warning"><span><i class="fas fa-edit"></i></span></a>
                              <form action="{{ route('admin_soal-kuis-reguler.destroy', $item->id) }}" method="POST"
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
                {{ $soal->links() }}
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







{{-- @extends('admin.layout')

@section('content')
  <div class="content-wrapper">
    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card" style="margin-top: 1rem;">
              <div class="card-header">
                <h3 class="card-title">Data Soal Kuis Reguler</h3>
              </div>


              <div class="card-body">
                <div class="mb-3 d-flex justify-content-between">
                  <form action="{{ route('admin_soal-kuis-reguler.index') }}" method="GET" class="form-inline">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control mr-2"
                      placeholder="Cari soal...">
                    <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i></button>
                  </form>
                  <a href="{{ route('admin_soal-kuis-reguler.create') }}" class="btn btn-primary">
                    <span><i class="fas fa-plus mr-2"></i></span>Tambah Data
                  </a>
                </div>

                <table id="example1" class="table table-bordered table-striped">
                  <thead class="text-center">
                    <tr>
                      <th>Topik Kuis</th>
                      <th>File Soal</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($soal as $item)
                      <tr>
                        <td>{{ $item->kuis_reguler->judul }}</td>
                        <td>
                          <a href="{{ asset('storage/file_soal_kuis_reguler/' . $item->file_soal) }}"
                            class="btn btn-sm btn-success" download>
                            {{ $item->file_soal }}
                          </a>
                        </td>
                        <td>
                          <div class="d-flex align-items-center justify-content-center" style="gap: 10px;">
                            <a href="{{ route('admin_soal-kuis-reguler.edit-batch', ['batchId' => $item->upload_batch_id]) }}"
                              class="btn btn-warning"><span><i class="fas fa-edit"></i></span></a>
                            <form
                              action="{{ route('admin_soal-kuis-reguler.destroy-batch', ['batchId' => $item->upload_batch_id]) }}"
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
                {{ $soal->links() }}
              </div>

            </div>

          </div>
        </div>
      </div>
    </section>

  </div>
@endsection --}}
