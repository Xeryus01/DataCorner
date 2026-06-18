@extends('jadwal.layout')
@section('content')

<div class="page-header-row">
    <div>
        <h1 class="page-title">Status Ketersediaan Konsultan</h1>
        <p class="page-sub">Kelola status ketersediaan Anda untuk janji temu</p>
    </div>
</div>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header">
        <div class="card-header-left">
            <i class="ti ti-status-change"></i>
            <span class="card-title">Ubah Status</span>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('status.store') }}" method="POST">
            @csrf

            <div style="margin-bottom:16px">
                <label class="form-label">Pilih status Anda</label>
                <div style="display:flex;align-items:center;gap:24px">
                    <label class="form-check">
                        <input type="radio" name="status" value="tersedia" onclick="toggleFields(false)"
                            {{ old('status', $konsultan->status) == 'tersedia' ? 'checked' : '' }}>
                        <span>Tersedia</span>
                    </label>
                    <label class="form-check">
                        <input type="radio" name="status" value="tidak tersedia" onclick="toggleFields(true)"
                            {{ old('status', $konsultan->status) == 'tidak tersedia' ? 'checked' : '' }}>
                        <span>Tidak Tersedia</span>
                    </label>
                </div>
                @error('status')
                    <p style="color:var(--red-dark);font-size:12px;margin-top:4px">{{ $message }}</p>
                @enderror
            </div>

            <div id="tanggal-box" style="display:none">
                <div class="form-grid">
                    <div>
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai Tidak Tersedia</label>
                        <input type="date" name="tanggal_mulai_tidak_tersedia" id="tanggal_mulai"
                            class="form-input"
                            min="{{ now()->format('Y-m-d') }}"
                            value="{{ old('tanggal_mulai_tidak_tersedia', isset($konsultan->tanggal_mulai_tidak_tersedia) ? \Carbon\Carbon::parse($konsultan->tanggal_mulai_tidak_tersedia)->format('Y-m-d') : '') }}">
                        @error('tanggal_mulai_tidak_tersedia')
                            <p style="color:var(--red-dark);font-size:12px;margin-top:4px">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai Tidak Tersedia</label>
                        <input type="date" name="tanggal_selesai_tidak_tersedia" id="tanggal_selesai"
                            class="form-input"
                            min="{{ old('tanggal_mulai_tidak_tersedia', now()->format('Y-m-d')) }}"
                            value="{{ old('tanggal_selesai_tidak_tersedia', isset($konsultan->tanggal_selesai_tidak_tersedia) ? \Carbon\Carbon::parse($konsultan->tanggal_selesai_tidak_tersedia)->format('Y-m-d') : '') }}">
                        @error('tanggal_selesai_tidak_tersedia')
                            <p style="color:var(--red-dark);font-size:12px;margin-top:4px">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div id="alasan-box" style="display:none;margin-top:14px">
                <label for="alasan" class="form-label">Alasan</label>
                <textarea name="alasan" id="alasan" class="form-textarea" rows="3" placeholder="Tulis alasan tidak tersedia...">{{ old('alasan', $konsultan->alasan ?? '') }}</textarea>
                @error('alasan')
                    <p style="color:var(--red-dark);font-size:12px;margin-top:4px">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="ti ti-device-floppy"></i> Simpan Status
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-header-left">
            <i class="ti ti-info-circle"></i>
            <span class="card-title">Status Saat Ini</span>
        </div>
    </div>
    <div class="card-body">
        @php
            use Carbon\Carbon;
            $status = $konsultan->status ?? null;
            $mulai = $konsultan->tanggal_mulai_tidak_tersedia ?? null;
            $selesai = $konsultan->tanggal_selesai_tidak_tersedia ?? null;
        @endphp

        @if ($status === 'tersedia')
            <div class="status-card status-tersedia">
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px">
                    <svg width="18" height="18" viewBox="0 0 20 20" fill="var(--green-dark)">
                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1.707-6.707l5-5a1 1 0 111.414 1.414L9 15l-3.707-3.707a1 1 0 111.414-1.414z" />
                    </svg>
                    <span class="status-text-green">Konsultan tersedia untuk konsultasi.</span>
                </div>
            </div>
        @elseif ($status === 'tidak tersedia')
            <div class="status-card status-tidak-tersedia">
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px">
                    <svg width="18" height="18" viewBox="0 0 20 20" fill="var(--red-dark)">
                        <path d="M18 10A8 8 0 11.004 9.999 8 8 0 0118 10zM9 4a1 1 0 112 0v4a1 1 0 11-2 0V4zm1 6a1.5 1.5 0 110 3 1.5 1.5 0 010-3z" />
                    </svg>
                    <span class="status-text-red">Konsultan sedang tidak tersedia.</span>
                </div>
                <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:6px;font-size:12px;color:var(--color-text)">
                    @if($konsultan->alasan)
                        <li style="display:flex;gap:8px">
                            <span style="color:var(--color-muted);min-width:60px">Alasan:</span>
                            <span style="font-weight:500">{{ $konsultan->alasan }}</span>
                        </li>
                    @endif
                    <li style="display:flex;gap:8px">
                        <span style="color:var(--color-muted);min-width:60px">Dari:</span>
                        <span style="font-weight:500">{{ $mulai ? Carbon::parse($mulai)->translatedFormat('d F Y') : '-' }}</span>
                    </li>
                    <li style="display:flex;gap:8px">
                        <span style="color:var(--color-muted);min-width:60px">Sampai:</span>
                        <span style="font-weight:500">{{ $selesai ? Carbon::parse($selesai)->translatedFormat('d F Y') : '-' }}</span>
                    </li>
                </ul>
            </div>
        @else
            <p class="status-text-muted">Belum ada status yang ditentukan.</p>
        @endif
    </div>
</div>

<script>
    function toggleFields(show) {
        document.getElementById('alasan-box').style.display = show ? 'block' : 'none';
        document.getElementById('tanggal-box').style.display = show ? 'block' : 'none';
    }

    document.addEventListener("DOMContentLoaded", function () {
        const status = "{{ old('status', $konsultan->status) }}";
        if (status === 'tidak tersedia') {
            document.querySelector('input[value="tidak tersedia"]').checked = true;
            toggleFields(true);
        } else if (status === 'tersedia') {
            document.querySelector('input[value="tersedia"]').checked = true;
            toggleFields(false);
        }
    });
</script>
@endsection