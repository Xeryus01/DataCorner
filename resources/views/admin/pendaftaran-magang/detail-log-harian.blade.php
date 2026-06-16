@extends('admin.layout')

@section('content')
  <div class="content-wrapper">

    <section class="content">
      <div class="container-fluid">

        <div class="card card-primary mt-3">

          <!-- Header -->
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-clipboard-check mr-1"></i>
              Detail Daftar Hadir & Log Harian Magang
            </h3>
          </div>

          <div class="card-body">

            <!-- Tanggal & Status -->
            <div class="row mb-3">

              <div class="col-md-6">
                <div class="card card-outline card-secondary mb-0">
                  <div class="card-body py-2">
                    <small class="text-muted">Tanggal</small>
                    <div class="font-weight-bold">
                      {{ $log->tanggal
                        ? \Carbon\Carbon::parse($log->tanggal)->translatedFormat('d F Y')
                        : '-' }}
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="card card-outline card-secondary mb-0">
                  <div class="card-body py-2">
                    <small class="text-muted">Status Kehadiran</small>
                    <div>
                      @if($log->jam_masuk && $log->jam_pulang)
                        <span class="badge badge-success px-3">Hadir</span>
                      @else
                        <span class="badge badge-warning px-3 text-capitalize">
                          {{ $log->status_kehadiran ?? '-' }}
                        </span>
                      @endif
                    </div>
                  </div>
                </div>
              </div>

            </div>

            <!-- Jam Presensi -->
            <h6 class="text-muted mb-2">
              <i class="fas fa-clock mr-1"></i> Waktu Presensi
            </h6>

            <div class="row mb-3">

              <div class="col-md-6">
                <div class="card card-outline card-info mb-0">
                  <div class="card-body py-2">
                    <strong>Masuk</strong>
                    <div class="d-flex justify-content-between align-items-center">
                      <span>
                        {{ $log->presensi?->jam_masuk
                          ? \Carbon\Carbon::parse($log->presensi->jam_masuk)->format('H:i')
                          : '-' }}
                      </span>
                      <span class="badge badge-info">
                        {{ $log->presensi?->status_masuk_label ?? '-' }}
                      </span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="card card-outline card-info mb-0">
                  <div class="card-body py-2">
                    <strong>Pulang</strong>
                    <div class="d-flex justify-content-between align-items-center">
                      <span>
                        {{ $log->presensi?->jam_pulang
                          ? \Carbon\Carbon::parse($log->presensi->jam_pulang)->format('H:i')
                          : '-' }}
                      </span>
                      <span class="badge badge-info">
                        {{ $log->presensi?->status_pulang_label ?? '-' }}
                      </span>
                    </div>
                  </div>
                </div>
              </div>

            </div>

            {{-- Bukti Izin --}}
            @if($log->status_kehadiran === 'izin' && $log->bukti_izin)
              <h6 class="text-muted mt-4 mb-2">
                <i class="fas fa-file-alt mr-1"></i> Bukti Izin
              </h6>

              <div class="border rounded p-3 bg-light d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                  <i class="fas fa-paperclip text-primary mr-2"></i>
                  <span class="font-weight-bold">
                    {{ basename($log->bukti_izin) }}
                  </span>
                </div>

                <div class="btn-group">
                  {{-- Lihat --}}
                  <a href="{{ asset('storage/' . $log->bukti_izin) }}"
                    target="_blank"
                    class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-eye"></i> Lihat
                  </a>

                  {{-- Download --}}
                  <a href="{{ asset('storage/' . $log->bukti_izin) }}"
                    download
                    class="btn btn-sm btn-outline-success">
                    <i class="fas fa-download"></i> Download
                  </a>
                </div>
              </div>
            @endif

            <!-- Keterangan -->
            <h6 class="text-muted mb-2">
              <i class="fas fa-info-circle mr-1"></i> Keterangan
            </h6>

            <div class="border rounded p-2 bg-light mb-3">
              <div>
                <strong class="text-primary">Masuk:</strong>
                {{ $log->presensi?->keterangan_masuk ?? '-' }}
              </div>
              <div>
                <strong class="text-success">Pulang:</strong>
                {{ $log->presensi?->keterangan_pulang ?? '-' }}
              </div>
            </div>

            <!-- Uraian -->
            <h6 class="text-muted mb-2">
              <i class="fas fa-tasks mr-1"></i> Uraian Kegiatan
            </h6>

            <div class="border rounded p-2 bg-light mb-3">
              {!! nl2br(e($log->uraian_kegiatan ?? '-')) !!}
            </div>

            <!-- Catatan -->
            <h6 class="text-muted mb-2">
              <i class="fas fa-sticky-note mr-1"></i> Catatan
            </h6>

            <div class="border rounded p-2 bg-light">
              {!! nl2br(e($log->catatan ?? '-')) !!}
            </div>

          </div>

          <!-- Footer -->
          <div class="card-footer text-center">
            <a href="{{ url()->previous() ?? route('admin.daftar-magang.logHarian') }}"
               class="btn btn-secondary btn-sm">
              <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
          </div>

        </div>

      </div>
    </section>

  </div>
@endsection