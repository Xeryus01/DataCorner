@extends('jadwal.layout')
@section('content')

{{-- Toast Notification --}}
@if(session('success'))
<div id="toast-success" style="position:fixed;top:20px;right:20px;z-index:9999;background:#EAF3DE;color:#27500A;padding:12px 20px;border-radius:10px;font-size:13px;font-weight:500;box-shadow:0 4px 12px rgba(0,0,0,.1);display:flex;align-items:center;gap:8px;animation:slideInRight .3s ease">
    <i class="ti ti-circle-check" style="font-size:16px;color:#3B6D11"></i> {{ session('success') }}
</div>
<script>setTimeout(function(){var e=document.getElementById('toast-success');if(e){e.style.animation='slideOutRight .3s ease';setTimeout(function(){e.remove()},300)}},4000)</script>
@endif
@if(session('error'))
<div id="toast-error" style="position:fixed;top:20px;right:20px;z-index:9999;background:#FCEBEB;color:#791F1F;padding:12px 20px;border-radius:10px;font-size:13px;font-weight:500;box-shadow:0 4px 12px rgba(0,0,0,.1);display:flex;align-items:center;gap:8px;animation:slideInRight .3s ease">
    <i class="ti ti-alert-circle" style="font-size:16px;color:#C21B1B"></i> {{ session('error') }}
</div>
<script>setTimeout(function(){var e=document.getElementById('toast-error');if(e){e.style.animation='slideOutRight .3s ease';setTimeout(function(){e.remove()},300)}},4000)</script>
@endif

<div class="page-header-row">
    <div>
        <h1 class="page-title">Data Janji Temu</h1>
        <p class="page-sub">Daftar janji temu yang dijadwalkan dengan Anda</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-header-left">
            <i class="ti ti-calendar"></i>
            <span class="card-title">Semua Janji Temu</span>
        </div>
    </div>
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nama User</th>
                    <th>No HP</th>
                    <th>Instansi/Lembaga</th>
                    <th>Layanan</th>
                    <th>Keperluan Data</th>
                    <th>Data Diminta</th>
                    <th>Tanggal & Jam</th>
                    <th>Jenis</th>
                    <th>Jumlah Orang</th>
                    <th>Status</th>
                    <th>Zoom</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jadwals as $item)
                    @php
                        $janji = $item->janjitemu;
                        $layananList = $janji && $janji->layanan_dibutuhkan
                            ? explode(', ', $janji->layanan_dibutuhkan)
                            : [];
                        $keperluanList = $janji && $janji->keperluan_data
                            ? explode(', ', $janji->keperluan_data)
                            : [];
                        $status = $janji->status ?? 'menunggu';
                    @endphp

                    <tr>
                        {{-- Nama User --}}
                        <td>
                            <div class="name-cell">{{ $janji->user->nama ?? '-' }}</div>
                            <div style="font-size:11px;color:var(--color-muted);margin-top:2px">{{ $janji->user->email ?? '-' }}</div>
                        </td>

                        {{-- No HP --}}
                        <td>{{ $janji->user->no_hp ?? '-' }}</td>

                        {{-- Instansi --}}
                        <td>{{ $janji->instansi_lembaga ?? '-' }}</td>

                        {{-- Layanan --}}
                        <td>
                            @if(count($layananList))
                                <div style="display:flex;flex-wrap:wrap;gap:4px">
                                    @foreach($layananList as $layanan)
                                        <span class="badge-status badge-active">{{ $layanan }}</span>
                                    @endforeach
                                </div>
                            @else
                                <span style="color:var(--color-muted)">-</span>
                            @endif
                        </td>

                        {{-- Keperluan Data --}}
                        <td>
                            @if(count($keperluanList))
                                <div style="display:flex;flex-wrap:wrap;gap:4px">
                                    @foreach($keperluanList as $keperluan)
                                        <span class="badge-status" style="background:var(--brand-blue-light);color:var(--brand-blue-dark);font-size:10px">{{ $keperluan }}</span>
                                    @endforeach
                                </div>
                            @else
                                <span style="color:var(--color-muted)">-</span>
                            @endif
                        </td>

                        {{-- Data Diminta --}}
                        <td>
                            <div style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap" title="{{ $janji->data_diminta ?? '' }}">
                                {{ $janji->data_diminta ?? '-' }}
                            </div>
                        </td>

                        {{-- Tanggal & Jam --}}
                        <td>
                            @if($janji && $janji->tanggal && $janji->jam)
                                <div class="name-cell">{{ \Carbon\Carbon::parse($janji->tanggal)->locale('id')->isoFormat('D MMMM Y') }}</div>
                                <div style="font-size:11px;color:var(--color-muted);margin-top:2px">
                                    Pukul {{ \Carbon\Carbon::parse($janji->jam)->format('H:i') }} WIB
                                </div>
                            @else
                                <span style="color:var(--color-muted);font-style:italic">Belum diatur</span>
                            @endif
                        </td>

                        {{-- Jenis --}}
                        <td>
                            <span class="badge-status {{ ($janji->jenis ?? '') === 'online' ? 'badge-active' : 'badge-inactive' }}">
                                {{ ucfirst($janji->jenis ?? '-') }}
                            </span>
                        </td>

                        {{-- Jumlah Orang --}}
                        <td style="text-align:center">{{ $janji->jumlah_orang ?? 1 }} orang</td>

                        {{-- Status --}}
                        <td>
                            @php
                                $statusClass = match($status) {
                                    'menunggu' => 'background:var(--amber-bg);color:var(--amber-dark)',
                                    'diterima' => 'background:var(--green-bg);color:var(--green-dark)',
                                    'ditolak' => 'background:var(--red-bg);color:var(--red-dark)',
                                    'batal' => 'background:var(--red-bg);color:var(--red-dark)',
                                    'selesai' => 'background:var(--brand-blue-light);color:var(--brand-blue-dark)',
                                    default => 'background:#f1f5f9;color:var(--color-muted)'
                                };
                            @endphp
                            <span class="badge-status" style="{{ $statusClass }}">
                                <span class="badge-dot" style="background:currentColor"></span>
                                {{ ucfirst($status) }}
                            </span>
                        </td>

                        {{-- Zoom --}}
                        <td>
                            @if(($janji->jenis ?? '') === 'online' && $janji->zoom_link)
                                <a href="{{ $janji->zoom_link }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="btn-primary" style="padding:4px 10px;font-size:11px">
                                    <i class="ti ti-video"></i> Buka Zoom
                                </a>
                            @elseif(($janji->jenis ?? '') === 'online')
                                <span style="color:var(--color-muted);font-size:11px">Belum ada link</span>
                            @else
                                <span style="color:var(--color-muted)">-</span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td>
                            <div style="display:flex;gap:4px;flex-wrap:wrap">
                                {{-- Tombol Lihat Detail --}}
                                <button onclick="openDetailModal('{{$janji->id}}')" style="display:inline-flex;align-items:center;gap:4px;padding:4px 8px;background:var(--brand-blue-light, #E6F1FB);color:var(--brand-blue-dark, #0C447C);border:1px solid #B5D4F4;border-radius:6px;font-size:10px;font-weight:500;cursor:pointer" title="Lihat Detail">
                                    <i class="ti ti-eye" style="font-size:11px"></i> Detail
                                </button>

                                {{-- Tombol Kirim Zoom (untuk diterima & online) --}}
                                @if($status === 'diterima' && ($janji->jenis ?? '') === 'online')
                                <button onclick="openZoomModal('{{$janji->id}}','{{$janji->zoom_link ?? ''}}','{{$janji->user->nama ?? 'User'}}','{{$janji->tanggal ? \Carbon\Carbon::parse($janji->tanggal)->isoFormat('D MMM Y') : '-'}}','{{$janji->jam ? \Carbon\Carbon::parse($janji->jam)->format('H:i') : '-'}}')" style="display:inline-flex;align-items:center;gap:4px;padding:4px 8px;background:#EAF3DE;color:#27500A;border:1px solid #B6D89B;border-radius:6px;font-size:10px;font-weight:500;cursor:pointer" title="Kirim Link Zoom">
                                    <i class="ti ti-video" style="font-size:11px"></i> Zoom
                                </button>
                                @endif

                                {{-- Tombol Tandai Selesai --}}
                                @if($status === 'diterima')
                                <form method="POST" action="{{ route('konsultan.selesai', $janji->id) }}" style="display:inline" onsubmit="return confirm('Tandai janji temu ini sebagai selesai?')">
                                    @csrf
                                    <button type="submit" style="display:inline-flex;align-items:center;gap:4px;padding:4px 8px;background:#F1F5F9;color:#3B6D11;border:1px solid #B6D89B;border-radius:6px;font-size:10px;font-weight:500;cursor:pointer" title="Tandai Selesai">
                                        <i class="ti ti-check" style="font-size:11px"></i> Selesai
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="13" style="text-align:center;padding:40px 16px;color:var(--color-muted);font-size:14px">
                            <i class="ti ti-calendar-off" style="font-size:24px;display:block;margin-bottom:8px"></i>
                            Belum ada jadwal tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="pagination-controls" style="display:flex;justify-content:center;gap:8px;margin-top:16px"></div>

{{-- ========== MODAL: Detail Janji Temu ========== --}}
<div id="detailModal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(15,23,42,.5);align-items:center;justify-content:center" onclick="if(event.target===this)closeDetailModal()">
    <div style="background:#fff;border-radius:16px;width:92%;max-width:560px;max-height:90vh;overflow-y:auto;box-shadow:0 20px 60px rgba(0,0,0,.15);animation:modalSlideUp .25s ease" onclick="event.stopPropagation()">
        <div style="padding:16px 20px;border-bottom:0.5px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between">
            <div style="font-size:15px;font-weight:700;color:#0f172a">Detail Janji Temu</div>
            <button onclick="closeDetailModal()" style="width:32px;height:32px;border-radius:50%;border:0.5px solid #e2e8f0;background:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:16px;color:#64748b">&times;</button>
        </div>
        <div id="detailContent" style="padding:20px;font-size:12px;color:#0f172a;line-height:1.8">
            <p style="color:#94a3b8;text-align:center">Memuat...</p>
        </div>
        <div style="padding:12px 20px;border-top:0.5px solid #e2e8f0;display:flex;justify-content:flex-end">
            <button onclick="closeDetailModal()" style="padding:6px 16px;background:#f1f5f9;color:#64748b;border:0.5px solid #e2e8f0;border-radius:8px;font-size:11px;font-weight:500;cursor:pointer">Tutup</button>
        </div>
    </div>
</div>

{{-- ========== MODAL: Kirim Zoom Link (Konsultan) ========== --}}
<div id="zoomModal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(15,23,42,.5);align-items:center;justify-content:center" onclick="if(event.target===this)closeZoomModal()">
    <div style="background:#fff;border-radius:16px;width:92%;max-width:500px;max-height:90vh;overflow-y:auto;box-shadow:0 20px 60px rgba(0,0,0,.15);animation:modalSlideUp .25s ease" onclick="event.stopPropagation()">
        <div style="padding:16px 20px;border-bottom:0.5px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between">
            <div>
                <div style="font-size:15px;font-weight:700;color:#0f172a">Kirim Link Zoom</div>
                <div style="font-size:11px;color:#94a3b8;margin-top:2px" id="zoomModalUserName">-</div>
            </div>
            <button onclick="closeZoomModal()" style="width:32px;height:32px;border-radius:50%;border:0.5px solid #e2e8f0;background:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:16px;color:#64748b">&times;</button>
        </div>
        <form id="zoomForm" method="POST" style="padding:20px">
            @csrf
            <input type="hidden" name="_method" value="POST">

            <div style="background:#f8fafc;border-radius:10px;padding:12px 14px;margin-bottom:16px;font-size:11px;color:#64748b">
                <div>📅 Tanggal: <span style="font-weight:500;color:#0f172a" id="zoomModalTanggal">-</span></div>
                <div>⏰ Jam: <span style="font-weight:500;color:#0f172a" id="zoomModalJam">-</span></div>
            </div>

            <div style="margin-bottom:20px">
                <label style="display:block;font-size:12px;font-weight:600;color:#0f172a;margin-bottom:6px">Link Zoom <span style="color:#ef4444">*</span></label>
                <input type="url" name="link_zoom" id="zoomLinkInput" required placeholder="https://zoom.us/j/xxxxxx" style="width:100%;padding:9px 12px;border:0.5px solid #e2e8f0;border-radius:8px;font-size:12px;color:#0f172a;background:#fff;outline:none" onfocus="this.style.borderColor='#1F6FD6';this.style.boxShadow='0 0 0 2px rgba(31,111,214,.1)'" onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
            </div>

            <div style="display:flex;gap:10px;justify-content:flex-end">
                <button type="button" onclick="closeZoomModal()" style="padding:8px 18px;background:#f1f5f9;color:#64748b;border:0.5px solid #e2e8f0;border-radius:8px;font-size:12px;font-weight:500;cursor:pointer">Batal</button>
                <button type="submit" style="padding:8px 18px;background:#1F6FD6;color:#fff;border:none;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:6px">
                    <i class="ti ti-send" style="font-size:13px"></i> Kirim Zoom
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Inline Styles --}}
<style>
    @keyframes modalSlideUp { from { opacity:0;transform:translateY(20px) scale(.97) } to { opacity:1;transform:translateY(0) scale(1) } }
    @keyframes slideInRight { from { opacity:0;transform:translateX(80px) } to { opacity:1;transform:translateX(0) } }
    @keyframes slideOutRight { from { opacity:1;transform:translateX(0) } to { opacity:0;transform:translateX(80px) } }
</style>

<script>
function openDetailModal(id) {
    document.getElementById('detailModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    document.getElementById('detailContent').innerHTML = '<p style="color:#94a3b8;text-align:center">Memuat...</p>';

    fetch("{{ url('/konsultan/janjitemu') }}/" + id + "/detail")
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (!data || data.error) {
                document.getElementById('detailContent').innerHTML = '<p style="color:#C21B1B;text-align:center">Gagal memuat data.</p>';
                return;
            }
            var layanan = (data.layanan_dibutuhkan || '').split(', ').filter(Boolean).map(function(l){return '<span style="display:inline-block;padding:2px 6px;background:#EAF3DE;color:#27500A;border-radius:4px;font-size:10px;margin:2px">'+l+'</span>'}).join(' ') || '-';
            var keperluan = (data.keperluan_data || '').split(', ').filter(Boolean).map(function(k){return '<span style="display:inline-block;padding:2px 6px;background:#E6F1FB;color:#0C447C;border-radius:4px;font-size:10px;margin:2px">'+k+'</span>'}).join(' ') || '-';
            var html = '<div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;font-size:12px">' +
                '<div><span style="color:#94a3b8">Nama User:</span><br><span style="font-weight:500">' + (data.user?.nama || '-') + '</span></div>' +
                '<div><span style="color:#94a3b8">Email:</span><br><span style="font-weight:500">' + (data.user?.email || '-') + '</span></div>' +
                '<div><span style="color:#94a3b8">No HP:</span><br><span style="font-weight:500">' + (data.user?.no_hp || '-') + '</span></div>' +
                '<div><span style="color:#94a3b8">Instansi:</span><br><span style="font-weight:500">' + (data.instansi_lembaga || '-') + '</span></div>' +
                '<div><span style="color:#94a3b8">Jenis:</span><br><span style="font-weight:500">' + ((data.jenis||'') === 'online' ? '🟢 Online' : '🏢 Offline') + '</span></div>' +
                '<div><span style="color:#94a3b8">Jumlah Orang:</span><br><span style="font-weight:500">' + (data.jumlah_orang || 1) + ' orang</span></div>' +
                '<div style="grid-column:1/-1"><span style="color:#94a3b8">Layanan:</span><br>' + layanan + '</div>' +
                '<div style="grid-column:1/-1"><span style="color:#94a3b8">Keperluan Data:</span><br>' + keperluan + '</div>' +
                '<div style="grid-column:1/-1"><span style="color:#94a3b8">Data Diminta:</span><br><span style="font-weight:500">' + (data.data_diminta || '-') + '</span></div>' +
                '<div style="grid-column:1/-1"><span style="color:#94a3b8">Status:</span><br><span style="font-weight:600">' + (data.status || '-') + '</span></div>';
            if (data.tanggal) {
                html += '<div><span style="color:#94a3b8">Tanggal:</span><br><span style="font-weight:500">' + data.tanggal + '</span></div>';
            }
            if (data.jam) {
                html += '<div><span style="color:#94a3b8">Jam:</span><br><span style="font-weight:500">' + data.jam.substring(0,5) + ' WIB</span></div>';
            }
            html += '</div>';
            document.getElementById('detailContent').innerHTML = html;
        })
        .catch(function() {
            document.getElementById('detailContent').innerHTML = '<p style="color:#C21B1B;text-align:center">Gagal memuat data.</p>';
        });
}
function closeDetailModal() {
    document.getElementById('detailModal').style.display = 'none';
    document.body.style.overflow = '';
}

function openZoomModal(id, currentLink, nama, tanggal, jam) {
    document.getElementById('zoomModalUserName').innerText = nama;
    document.getElementById('zoomModalTanggal').innerText = tanggal;
    document.getElementById('zoomModalJam').innerText = jam;
    document.getElementById('zoomLinkInput').value = currentLink || '';
    document.getElementById('zoomForm').action = "{{ url('/konsultan/janjitemu') }}/" + id + "/zoom";
    document.getElementById('zoomModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeZoomModal() {
    document.getElementById('zoomModal').style.display = 'none';
    document.body.style.overflow = '';
}
</script>

@endsection
