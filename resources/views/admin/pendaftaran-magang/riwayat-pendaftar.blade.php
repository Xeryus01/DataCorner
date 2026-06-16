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
                <h3 class="card-title">Riwayat Pendaftar Magang</h3>
              </div>
              <!-- /.card-header -->

              <div class="card-body">
                <div class="mb-3 d-flex justify-content-between">
                  <form action="{{ route('admin_daftar-magang.riwayatMagang') }}" method="GET" class="form-inline">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control mr-2"
                      placeholder="Cari Nama...">
                    <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i></button>
                  </form>
                </div>
                <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-striped"
                    style="table-layout: auto; width: auto; white-space: nowrap;">
                    <thead class="text-center">
                      <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Nomor WhatsApp</th>
                        <th>CV Pendaftar</th>
                        <th>Surat Permohonan Sekolah/Kampus</th>
                        <th>Surat Motivasi</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Laporan Magang</th>
                        <th>Sertifikat Magang</th>
                        <th>Status</th>
                        <th>Daftar pada Tanggal</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody class="text-center">
                      @foreach ($pendaftaran as $item)
                        <tr>
                          <td>{{ $item->nama }}</td>
                          <td>{{ $item->email }}</td>
                          <td>{{ $item->no_hp }}</td>
                          <td>
                            <a href="{{ Storage::url($item->cv_file) }}" target="_blank">
                              <button class="btn btn-info">Lihat CV Pendaftar</button>
                            </a>
                          </td>
                          <td>
                            <a href="{{ Storage::url($item->surat_permohonan) }}" target="_blank">
                              <button class="btn btn-info">Lihat Surat Permohonan</button>
                            </a>
                          </td>
                          <td>
                            @if ($item->surat_motivasi)
                              {{ $item->surat_motivasi }}
                            @else
                              -
                            @endif
                          </td>
                          <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d-m-Y') }}</td>
                          <td>{{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d-m-Y') }}</td>
                          <td>
                            @if ($item->laporan_magang)
                              <a href="{{ Storage::url($item->laporan_magang) }}" target="_blank">
                                <button class="btn btn-info">Lihat Laporan Magang</button>
                              </a>
                            @else
                              <span class="badge badge-danger">Belum Tersedia</span>
                            @endif
                          </td>
                          <td>
                            @if ($item->sertifikat_magang)
                              <a href="{{ Storage::url($item->sertifikat_magang) }}" target="_blank">
                                <button class="btn btn-info">Lihat Sertifikat Magang</button>
                              </a>
                            @else
                              <span class="badge badge-danger">Belum Tersedia</span>
                            @endif
                          </td>
                          <td>
                            @if ($item->status == 'diproses')
                              <span class="badge badge-warning">Diproses</span>
                            @elseif ($item->status == 'diterima')
                              <span class="badge badge-success">Diterima</span>
                            @elseif ($item->status == 'ditolak')
                              <span class="badge badge-danger">Ditolak</span>
                            @else
                              <span class="badge badge-info">Selesai</span>
                            @endif
                          </td>
                          <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i') }}</td>
                          <td>
                            <div class="d-flex align-items-center justify-content-center" style="gap: 10px;">
                              <a href="{{ route('admin_daftar-magang.editSertifikat', $item->id) }}"
                                class="btn btn-warning"><span><i class="fas fa-edit"></i></span></a>
                              <form action="{{ route('admin_daftar-magang.destroy', $item->id) }}" method="POST"
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
                  {{ $pendaftaran->links() }}
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
