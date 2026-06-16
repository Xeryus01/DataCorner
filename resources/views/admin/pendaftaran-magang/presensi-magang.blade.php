@extends('admin.layout')

@section('content')
  <div class="content-wrapper">

    {{-- Alert --}}
    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            {{-- ================= RIWAYAT PRESENSI ================= --}}
            <div class="card mt-3">
              <div class="card-header">
                <h3 class="card-title">
                  Riwayat Presensi Magang
                  <span class="font-weight-bold">{{ $pendaftaran->nama }}</span>
                </h3>
              </div>

              <div class="card-body table-responsive">
                <table class="table table-bordered table-striped">
                  <thead class="text-center">
                    <tr>
                      <th>Tanggal</th>
                      <th>Jam Masuk</th>
                      <th>Jam Pulang</th>
                      <th>Lokasi Masuk</th>
                      <th>Lokasi Pulang</th>
                      <th>Status Presensi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($logs as $item)
                      <tr>
                        <td class="text-center">
                          {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}
                        </td>

                        <td class="text-center">
                          {{ $item->jam_masuk ?? '-' }}
                        </td>

                        <td class="text-center">
                          {{ $item->jam_pulang ?? '-' }}
                        </td>

                        <td class="text-center">
                          @if ($item->lat_masuk && $item->long_masuk)
                            {{ $item->lat_masuk }}, {{ $item->long_masuk }}
                          @else
                            -
                          @endif
                        </td>
                        <td class="text-center">
                          @if ($item->lat_pulang && $item->long_pulang)
                            {{ $item->lat_pulang }}, {{ $item->long_pulang }}
                          @else
                            -
                          @endif
                        </td>

                        @php
                        $statusMap = [
                            'hadir' => ['success', 'Hadir'],
                            'terlambat' => ['warning', 'Terlambat'],
                            'tidak hadir' => ['danger', 'Tidak Hadir'],
                        ];
                        $status = strtolower($item->status);
                        @endphp

                        <td class="text-center">
                            <span class="badge badge-{{ $statusMap[$status][0] ?? 'secondary' }}">
                                {{ $statusMap[$status][1] ?? 'Unknown' }}
                            </span>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="5" class="text-center text-muted">
                          Belum ada data presensi
                        </td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>

                {{-- Pagination --}}
                <div class="mt-3">
                  {{ $logs->links() }}
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>

  </div>
@endsection
