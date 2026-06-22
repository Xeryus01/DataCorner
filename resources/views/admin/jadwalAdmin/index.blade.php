@extends('admin.layout')
@section('content')
<x-admin.page-header title="Data Jadwal Janji Temu" subtitle="Kelola jadwal konsultasi dan janji temu" :breadcrumbs="['Datapedia','Layanan','Jadwal']" />

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

<div class="card" style="background:#fff;border:0.5px solid #e2e8f0;border-radius:12px;overflow:hidden">
    <div style="padding:14px 18px;border-bottom:0.5px solid #e2e8f0">
        <div style="font-size:13px;font-weight:600;color:#0f172a;display:flex;align-items:center;gap:8px"><i class="ti ti-calendar" style="font-size:16px;color:#1F6FD6"></i>Daftar Jadwal <span style="font-size:11px;font-weight:400;color:#94a3b8;margin-left:4px">— {{count($janjiTemu??[])}} data</span></div>
    </div>
    <div style="overflow-x:auto">
        <table class="sortable-table" style="width:100%;border-collapse:collapse">
            <thead><tr style="background:#f8fafc">
                <th onclick="sortTable(0)" style="padding:10px 12px;text-align:center;width:40px;font-size:11px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase;cursor:pointer">No ▾</th>
                <th onclick="sortTable(1)" style="padding:10px 12px;font-size:11px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase;cursor:pointer">Konsultan ▾</th>
                <th onclick="sortTable(2)" style="padding:10px 12px;font-size:11px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase;cursor:pointer">User ▾</th>
                <th onclick="sortTable(3)" style="padding:10px 12px;font-size:11px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase;cursor:pointer">Tanggal ▾</th>
                <th style="padding:10px 12px;font-size:11px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase">Status</th>
                <th style="padding:10px 12px;font-size:11px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase;width:200px">Aksi</th>
            </tr></thead>
            <tbody>
                @forelse($janjiTemu??[] as $idx=>$i)
                @php $s=$i->status??''; @endphp
                <tr style="transition:background 100ms" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                    <td style="padding:10px 12px;font-size:11px;color:#94a3b8;border-bottom:0.5px solid #e2e8f0;text-align:center">{{$idx+1}}</td>
                    <td style="padding:10px 12px;font-size:12px;font-weight:600;color:#0f172a;border-bottom:0.5px solid #e2e8f0">
                        @if($i->jadwal && $i->jadwal->konsultan)
                            <span style="display:inline-flex;align-items:center;gap:6px">
                                <span style="width:24px;height:24px;border-radius:50%;background:var(--brand-blue-light, #E6F1FB);display:inline-flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;color:var(--brand-blue-dark, #0C447C)">K</span>
                                {{$i->jadwal->konsultan->nama}}
                            </span>
                        @else
                            <span style="color:#94a3b8;font-style:italic;font-size:11px">Belum ditugaskan</span>
                        @endif
                    </td>
                    <td style="padding:10px 12px;font-size:12px;color:#0f172a;border-bottom:0.5px solid #e2e8f0">
                        <div style="font-weight:500">{{$i->user->nama??'-'}}</div>
                        <div style="font-size:10px;color:#94a3b8;margin-top:1px">{{$i->instansi_lembaga??''}}</div>
                    </td>
                    <td style="padding:10px 12px;font-size:12px;color:#0f172a;border-bottom:0.5px solid #e2e8f0">
                        @if($i->tanggal)
                            <div>{{\Carbon\Carbon::parse($i->tanggal)->locale('id')->isoFormat('D MMM Y')}}</div>
                            <div style="font-size:10px;color:#94a3b8;margin-top:1px">{{$i->jam ? \Carbon\Carbon::parse($i->jam)->format('H:i').' WIB' : '-'}}</div>
                        @else
                            <span style="color:#94a3b8;font-style:italic;font-size:11px">Belum diatur</span>
                        @endif
                    </td>
                    <td style="padding:10px 12px;border-bottom:0.5px solid #e2e8f0">
                        @if($s=='diterima'||$s=='disetujui')<span style="display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:999px;font-size:10px;font-weight:500;background:#EAF3DE;color:#27500A"><span style="width:6px;height:6px;border-radius:50%;background:#3B6D11;display:inline-block"></span>Disetujui</span>
                        @elseif($s=='ditolak')<span style="display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:999px;font-size:10px;font-weight:500;background:#FCEBEB;color:#791F1F">Ditolak</span>
                        @elseif($s=='menunggu')<span style="display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:999px;font-size:10px;font-weight:500;background:#FAEEDA;color:#633806">Menunggu</span>
                        @else<span style="font-size:11px;color:#94a3b8">{{$s?:'-'}}</span>@endif
                    </td>
                    <td style="padding:10px 12px;border-bottom:0.5px solid #e2e8f0">
                        <div style="display:flex;gap:4px;flex-wrap:wrap">
                            {{-- Tombol Setujui & Jadwalkan (untuk status menunggu) --}}
                            @if($s=='menunggu')
                            <button onclick="openScheduleModal('{{$i->id}}','{{$i->user->nama??'User'}}','{{$i->instansi_lembaga??''}}','{{$i->jenis??''}}','{{$i->jumlah_orang??1}}','{{$i->layanan_dibutuhkan??''}}','{{$i->keperluan_data??''}}','{{$i->data_diminta??''}}')" style="display:inline-flex;align-items:center;gap:4px;padding:4px 8px;background:#EAF3DE;color:#27500A;border:1px solid #B6D89B;border-radius:6px;font-size:10px;font-weight:500;cursor:pointer" onmouseover="this.style.background='#D4ECBE'" onmouseout="this.style.background='#EAF3DE'" title="Setujui & Jadwalkan">
                                <i class="ti ti-check" style="font-size:11px"></i> Setujui
                            </button>
                            <form method="POST" action="{{route('jadwal.tolak',$i->id)}}" style="display:inline" onsubmit="return confirm('Yakin tolak janji temu ini?')">
                                @csrf
                                <button type="submit" style="display:inline-flex;align-items:center;gap:4px;padding:4px 8px;background:#FCEBEB;color:#791F1F;border:1px solid #F7C1C1;border-radius:6px;font-size:10px;font-weight:500;cursor:pointer" onmouseover="this.style.background='#F9D6D6'" onmouseout="this.style.background='#FCEBEB'" title="Tolak">
                                    <i class="ti ti-x" style="font-size:11px"></i> Tolak
                                </button>
                            </form>
                            @endif

                            {{-- Tombol Zoom (untuk status diterima & online) --}}
                            @if(($s=='diterima'||$s=='disetujui') && $i->jenis == 'online')
                            <a href="{{route('jadwal.zoom',$i->id)}}" style="display:inline-flex;align-items:center;gap:4px;padding:4px 8px;background:#E6F1FB;color:#0C447C;border:1px solid #B5D4F4;border-radius:6px;font-size:10px;font-weight:500;text-decoration:none" title="Kirim Link Zoom">
                                <i class="ti ti-video" style="font-size:11px"></i> Zoom
                            </a>
                            @endif

                            {{-- Tombol Batalkan (untuk status diterima/disetujui) --}}
                            @if($s=='diterima'||$s=='disetujui')
                                @if($i->jadwal)
                                <form method="POST" action="{{route('jadwal.batal',$i->jadwal->id)}}" style="display:inline" onsubmit="return confirm('Yakin batalkan jadwal ini? Status akan kembali menjadi menunggu.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="display:inline-flex;align-items:center;gap:4px;padding:4px 8px;background:#FEF3C7;color:#92400E;border:1px solid #FCD34D;border-radius:6px;font-size:10px;font-weight:500;cursor:pointer" title="Batalkan Jadwal">
                                        <i class="ti ti-arrow-back-up" style="font-size:11px"></i> Batal
                                    </button>
                                </form>
                                @endif
                            @endif

                            {{-- Tombol Hapus --}}
                            <form method="POST" action="{{route('jadwal.hapus',$i->id)}}" style="display:inline" onsubmit="return confirm('Yakin hapus permanen janji temu ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" style="display:inline-flex;align-items:center;gap:4px;padding:4px 8px;background:#F1F5F9;color:#64748B;border:1px solid #E2E8F0;border-radius:6px;font-size:10px;font-weight:500;cursor:pointer" title="Hapus Permanen">
                                    <i class="ti ti-trash" style="font-size:11px"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="padding:40px;text-align:center;color:#94a3b8;font-size:13px"><i class="ti ti-calendar-off" style="font-size:28px;display:block;margin-bottom:8px;color:#cbd5e1"></i>Belum ada data jadwal</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:10px 16px;border-top:0.5px solid #e2e8f0;display:flex;justify-content:space-between;align-items:center">
        <span style="font-size:11px;color:#64748b">Menampilkan {{count($janjiTemu??[])}} data</span>
        @if($janjiTemu instanceof \Illuminate\Pagination\LengthAwarePaginator)
            {{ $janjiTemu->links() }}
        @endif
    </div>
</div>

{{-- ========== MODAL: Setujui & Jadwalkan ========== --}}
<div id="scheduleModal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(15,23,42,.5);align-items:center;justify-content:center" onclick="if(event.target===this)closeScheduleModal()">
    <div style="background:#fff;border-radius:16px;width:92%;max-width:600px;max-height:90vh;overflow-y:auto;box-shadow:0 20px 60px rgba(0,0,0,.15);animation:modalSlideUp .25s ease" onclick="event.stopPropagation()">
        <div style="padding:16px 20px;border-bottom:0.5px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between">
            <div>
                <div style="font-size:15px;font-weight:700;color:#0f172a">Setujui & Jadwalkan Janji Temu</div>
                <div style="font-size:11px;color:#94a3b8;margin-top:2px" id="modalUserName">-</div>
            </div>
            <button onclick="closeScheduleModal()" style="width:32px;height:32px;border-radius:50%;border:0.5px solid #e2e8f0;background:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:16px;color:#64748b">&times;</button>
        </div>
        <form id="scheduleForm" method="POST" style="padding:20px">
            @csrf
            <input type="hidden" name="_method" value="POST">

            {{-- Detail Janji Temu --}}
            <div style="background:#f8fafc;border-radius:10px;padding:14px 16px;margin-bottom:20px;display:grid;grid-template-columns:1fr 1fr;gap:10px;font-size:11px">
                <div><span style="color:#94a3b8">Instansi:</span> <span style="font-weight:500;color:#0f172a" id="modalInstansi">-</span></div>
                <div><span style="color:#94a3b8">Jenis:</span> <span style="font-weight:500;color:#0f172a" id="modalJenis">-</span></div>
                <div><span style="color:#94a3b8">Jumlah Orang:</span> <span style="font-weight:500;color:#0f172a" id="modalJumlah">-</span></div>
                <div><span style="color:#94a3b8">Layanan:</span> <span style="font-weight:500;color:#0f172a" id="modalLayanan">-</span></div>
                <div style="grid-column:1/-1"><span style="color:#94a3b8">Keperluan:</span> <span style="font-weight:500;color:#0f172a" id="modalKeperluan">-</span></div>
                <div style="grid-column:1/-1"><span style="color:#94a3b8">Data Diminta:</span> <span style="font-weight:500;color:#0f172a" id="modalData">-</span></div>
            </div>

            {{-- Pilih Konsultan --}}
            <div style="margin-bottom:16px">
                <label style="display:block;font-size:12px;font-weight:600;color:#0f172a;margin-bottom:6px">Pilih Konsultan <span style="color:#ef4444">*</span></label>
                <select name="konsultan_id" required style="width:100%;padding:9px 12px;border:0.5px solid #e2e8f0;border-radius:8px;font-size:12px;color:#0f172a;background:#fff;outline:none" onfocus="this.style.borderColor='#1F6FD6';this.style.boxShadow='0 0 0 2px rgba(31,111,214,.1)'" onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                    <option value="">-- Pilih Konsultan --</option>
                    @foreach($konsultans as $k)
                    <option value="{{$k->id}}">{{$k->nama}} @if($k->posisi)({{$k->posisi}})@endif @if($k->keahlian)— {{$k->keahlian}}@endif</option>
                    @endforeach
                </select>
            </div>

            {{-- Tanggal --}}
            <div style="margin-bottom:16px">
                <label style="display:block;font-size:12px;font-weight:600;color:#0f172a;margin-bottom:6px">Tanggal Janji Temu <span style="color:#ef4444">*</span></label>
                <input type="date" name="tanggal" required min="{{ date('Y-m-d') }}" style="width:100%;padding:9px 12px;border:0.5px solid #e2e8f0;border-radius:8px;font-size:12px;color:#0f172a;background:#fff;outline:none" onfocus="this.style.borderColor='#1F6FD6';this.style.boxShadow='0 0 0 2px rgba(31,111,214,.1)'" onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
            </div>

            {{-- Jam --}}
            <div style="margin-bottom:20px">
                <label style="display:block;font-size:12px;font-weight:600;color:#0f172a;margin-bottom:6px">Jam <span style="color:#ef4444">*</span></label>
                <input type="time" name="jam" required style="width:100%;padding:9px 12px;border:0.5px solid #e2e8f0;border-radius:8px;font-size:12px;color:#0f172a;background:#fff;outline:none" onfocus="this.style.borderColor='#1F6FD6';this.style.boxShadow='0 0 0 2px rgba(31,111,214,.1)'" onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
            </div>

            {{-- Tombol --}}
            <div style="display:flex;gap:10px;justify-content:flex-end">
                <button type="button" onclick="closeScheduleModal()" style="padding:8px 18px;background:#f1f5f9;color:#64748b;border:0.5px solid #e2e8f0;border-radius:8px;font-size:12px;font-weight:500;cursor:pointer">Batal</button>
                <button type="submit" style="padding:8px 18px;background:#1F6FD6;color:#fff;border:none;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:6px" onmouseover="this.style.background='#1A5DB8'" onmouseout="this.style.background='#1F6FD6'">
                    <i class="ti ti-check" style="font-size:13px"></i> Setujui & Jadwalkan
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
function openScheduleModal(id, nama, instansi, jenis, jumlah, layanan, keperluan, dataDiminta) {
    document.getElementById('scheduleForm').action = "{{ url('admin/jadwal') }}/" + id + "/schedule";
    document.getElementById('modalUserName').innerText = nama;
    document.getElementById('modalInstansi').innerText = instansi || '-';
    document.getElementById('modalJenis').innerText = jenis || '-';
    document.getElementById('modalJumlah').innerText = (jumlah || '1') + ' orang';
    document.getElementById('modalLayanan').innerText = layanan || '-';
    document.getElementById('modalKeperluan').innerText = keperluan || '-';
    document.getElementById('modalData').innerText = dataDiminta || '-';
    document.getElementById('scheduleModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeScheduleModal() {
    document.getElementById('scheduleModal').style.display = 'none';
    document.body.style.overflow = '';
}
</script>
@endsection
