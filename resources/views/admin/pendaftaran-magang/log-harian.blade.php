@extends('admin.layout')

@section('content')
  <div class="content-wrapper">
    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif
    {{-- Tabel Data Daftar Hadir dan Log Harian --}}
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            @if ($verifikasi->count() > 0)
              <div class="card" style="margin-top: 1rem;">
                <div class="card-header">
                  <h3 class="card-title">Daftar Hadir & Log Harian Magang <span>{{ $pendaftaran->nama }}</span> Yang Harus Diverifikasi
                  </h3>
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                  <div class="table-responsive">
                    <table id="example1" class="table table-hover table-bordered align-middle">
                      <thead class="text-center bg-light">
                        <tr>
                          <th style="width:110px;">Tanggal</th>
                          <th style="width:90px;">Masuk</th>
                          <th style="width:90px;">Pulang</th>
                          <th>Uraian Kegiatan</th>
                          <th style="width:140px;">Kehadiran</th>
                          <th style="width:140px;">Verifikasi</th>
                          <th style="width:120px;">Aksi</th>
                        </tr>
                      </thead>

                      <tbody>
                        @foreach ($verifikasi as $log)
                          @php
                            $tanggal = \Carbon\Carbon::parse($log->tanggal)->format('Y-m-d');
                            $presensi = $presensis[$tanggal] ?? null;
                          @endphp
                          <tr>
                            <!-- Tanggal -->
                            <td class="text-center fw-semibold">
                              {{ \Carbon\Carbon::parse($log->tanggal)->format('d-m-Y') }}
                            </td>

                            <!-- Jam Masuk -->
                            <td class="text-center">
                              {{ $presensi?->jam_masuk 
                                  ? \Carbon\Carbon::parse($presensi->jam_masuk)->format('H:i') 
                                  : '-' }}
                            </td>

                            <!-- Jam Pulang -->
                            <td class="text-center">
                              {{ $presensi?->jam_pulang 
                                  ? \Carbon\Carbon::parse($presensi->jam_pulang)->format('H:i') 
                                  : '-' }}
                            </td>

                            <!-- Uraian -->
                            <td>
                              <div style="max-width:300px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"
                                  title="{{ strip_tags($log->uraian_kegiatan) }}">
                                  {{ strip_tags($log->uraian_kegiatan) }}
                              </div>
                            </td>

                            <!-- Status Kehadiran -->
                            <td class="text-center">
                              @php
                                $hadirBadge = [
                                  'hadir' => 'success',
                                  'tanpa_keterangan' => 'danger',
                                  'izin'  => 'warning'                                  
                                ];
                              @endphp
                              <span class="badge badge-{{ $hadirBadge[$log->status_kehadiran] ?? 'secondary' }}">
                                {{ ucfirst($log->status_kehadiran) }}
                              </span>
                            </td>

                            <!-- Status Verifikasi -->
                            <td class="text-center">
                              @php
                                $verifBadge = [
                                  'disetujui' => 'success',
                                  'ditolak'   => 'danger',
                                  'pending'  => 'secondary',
                                  'revisi'   => 'warning'
                                ];
                              @endphp
                              <span class="badge badge-{{ $verifBadge[$log->status_verifikasi] ?? 'secondary' }}">
                                {{ ucfirst($log->status_verifikasi) }}
                              </span>
                            </td>

                            <!-- Aksi -->
                            <td class="text-center">
                              <div class="btn-group" role="group">
                                <a href="{{ route('admin_daftar-magang.detailLog', $log->id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                  <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin_daftar-magang.verifikasiSetuju', $log->id) }}" method="POST" class="d-inline">
                                  @csrf
                                  <button class="btn btn-sm btn-success" title="Setujui">
                                    <i class="fas fa-check"></i>
                                  </button>
                                </form>
                                <form action="{{ route('admin_daftar-magang.verifikasiRevisi', $log->id) }}" method="POST" class="d-inline">
                                  @csrf
                                  <button class="btn btn-sm btn-warning" title="Revisi">
                                    <i class="fas fa-edit"></i>
                                  </button>
                                </form>
                                <form action="{{ route('admin_daftar-magang.verifikasiTolak', $log->id) }}" method="POST" class="d-inline">
                                  @csrf
                                  <button class="btn btn-sm btn-danger" title="Tolak">
                                    <i class="fas fa-times"></i>
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
            @endif
            <div class="card" style="margin-top: 1rem;">
              <div class="card-header">
                <h3 class="card-title">Data Log Harian Magang <span>{{ $pendaftaran->nama }}</span>
                </h3>
              </div>
              <!-- /.card-header -->

              <div class="card-body">
                <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead class="text-center">
                      <tr>
                        <th>Tanggal</th>
                        <th>Uraian Kegiatan</th>
                        <th>Catatan</th>
                        <th>Status Kehadiran</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($logs as $log)
                        <tr>
                          <td>{{ \Carbon\Carbon::parse($log->tanggal)->format('d-m-Y') }}</td>
                          <td>{!! $log->uraian_kegiatan !!}</td>
                          <td>{!! $log->catatan !!}</td>
                          <td class="text-center">
                            @if ($log->status_kehadiran == 'hadir')
                              <span class="badge badge-success">Hadir</span>
                            @elseif ($log->status_kehadiran == 'tanpa_keterangan')
                              <span class="badge badge-danger">Tanpa Keterangan</span>  
                            @else
                              <span class="badge badge-warning">Izin</span>
                            @endif
                          </td>
                          <td class="text-center">
                            <a href="{{ route('admin_daftar-magang.detailLog', $log->id) }}"
                              class="btn btn-sm btn-info" title="Lihat Detail">
                              <i class="fas fa-eye"></i>
                            </a>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                  {{ $logs->links() }}
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
