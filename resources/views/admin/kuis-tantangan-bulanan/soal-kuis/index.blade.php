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
                <h3 class="card-title">Data Soal {{ $kuis_tantangan_bulanan->judul }}</h3>
              </div>
              <!-- /.card-header -->

              <div class="card-body">
                <div class="mb-3 d-flex justify-content-between">
                  <form action="{{ route('admin_soal-kuis-tantangan-bulanan.index', $kuis_tantangan_bulanan->id) }}"
                    method="GET" class="form-inline">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control mr-2"
                      placeholder="Cari soal...">
                    <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i></button>
                  </form>
                  <a href="{{ route('admin_soal-kuis-tantangan-bulanan.create', $kuis_tantangan_bulanan->id) }}"
                    class="btn btn-primary">
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
                              <a href="{{ route('admin_soal-kuis-tantangan-bulanan.edit', $item->id) }}"
                                class="btn btn-warning"><span><i class="fas fa-edit"></i></span></a>
                              <form action="{{ route('admin_soal-kuis-tantangan-bulanan.destroy', $item->id) }}"
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
