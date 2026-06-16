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
                <h3 class="card-title">Topik Kuis Tantangan Bulanan</h3>
              </div>
              <!-- /.card-header -->

              <div class="card-body">
                <div class="mb-3 d-flex justify-content-between">
                  <form method="GET" action="{{ route('admin_kuis-tantangan-bulanan.index') }}" class="form-inline">
                    <label for="periode" class="font-weight-bold mr-2">Filter Periode:</label>
                    <div class="form-group mr-2 mb-0">
                      <select name="periode" id="periode" class="form-control">
                        <option value="">Semua</option>
                        @foreach ($listPeriode as $periode)
                          <option value="{{ $periode->id }}"
                            {{ request('periode') == $periode->id ? 'selected' : '' }}>
                            {{ $periode->periode }}
                          </option>
                        @endforeach
                      </select>
                    </div>
                    <button type="submit" class="btn btn-secondary">Terapkan</button>
                  </form>

                  <a href="{{ route('admin_kuis-tantangan-bulanan.create') }}" class="btn btn-primary"><span><i
                        class="fas fa-plus mr-2"></i></span>Tambah Data</a>
                </div>
                <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-striped"
                    style="table-layout: auto; width: auto; white-space: nowrap;">
                    <thead class="text-center">
                      <tr>
                        <th>Periode</th>
                        <th>Judul Tantangan</th>
                        <th>Deskripsi</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Durasi (Menit)</th>
                        <th>Status</th>
                        <th>Soal</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody class="text-center">
                      @foreach ($kuis as $item)
                        <tr>
                          <td>{{ $item->periode->periode }}</td>
                          <td>{{ $item->judul }}</td>
                          <td>{{ Str::limit($item->deskripsi, 50, '...') }}</td>
                          <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d-m-Y') }}</td>
                          <td>{{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d-m-Y') }}</td>
                          <td>{{ $item->durasi_menit }}</td>
                          <td>
                            @if ($item->status == 'aktif')
                              <span class="badge badge-success">Aktif</span>
                            @else
                              <span class="badge badge-danger">Non-Aktif</span>
                            @endif
                          </td>
                          <td>
                            <a href="{{ route('admin_soal-kuis-tantangan-bulanan.index', $item->id) }}"
                              target="_blank">
                              <button class="btn btn-info">Lihat Soal</button>
                            </a>
                          </td>
                          <td>
                            <div class="d-flex align-items-center justify-content-center" style="gap: 10px;">
                              <a href="{{ route('admin_kuis-tantangan-bulanan.edit', $item->id) }}"
                                class="btn btn-warning"><span><i class="fas fa-edit"></i></span></a>
                              <form action="{{ route('admin_kuis-tantangan-bulanan.destroy', $item->id) }}"
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
