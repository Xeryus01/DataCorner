@extends('admin.layout')
@section('content')
<x-admin.page-header title="Data Jadwal Janji Temu" subtitle="Kelola jadwal konsultasi dan janji temu" :breadcrumbs="['Datapedia','Layanan','Jadwal']" />
<div class="card" style="background:#fff;border:0.5px solid #e2e8f0;border-radius:12px;overflow:hidden">
    <div style="padding:14px 18px;border-bottom:0.5px solid #e2e8f0">
        <div style="font-size:13px;font-weight:600;color:#0f172a;display:flex;align-items:center;gap:8px"><i class="ti ti-calendar" style="font-size:16px;color:#1F6FD6"></i>Daftar Jadwal <span style="font-size:11px;font-weight:400;color:#94a3b8;margin-left:4px">— {{count($janjiTemu??[])}} data</span></div>
    </div>
    <div style="overflow-x:auto">
        <table class="sortable-table" style="width:100%;border-collapse:collapse">
            <thead><tr style="background:#f8fafc"><th onclick="sortTable(0)" style="padding:10px 12px;text-align:center;width:40px;font-size:11px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase;cursor:pointer">No ▾</th><th onclick="sortTable(1)" style="padding:10px 12px;font-size:11px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase;cursor:pointer">Konsultan ▾</th><th onclick="sortTable(2)" style="padding:10px 12px;font-size:11px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase;cursor:pointer">User ▾</th><th onclick="sortTable(3)" style="padding:10px 12px;font-size:11px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase;cursor:pointer">Tanggal ▾</th><th style="padding:10px 12px;font-size:11px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase">Status</th><th style="padding:10px 12px;font-size:11px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase">Aksi</th></tr></thead>
            <tbody>
                @forelse($janjiTemu??[] as $idx=>$i)
                @php $s=$i->status??''; @endphp
                <tr style="transition:background 100ms" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                    <td style="padding:10px 12px;font-size:11px;color:#94a3b8;border-bottom:0.5px solid #e2e8f0;text-align:center">{{$idx+1}}</td>
                    <td style="padding:10px 12px;font-size:12px;font-weight:600;color:#0f172a;border-bottom:0.5px solid #e2e8f0">{{$i->jadwal->konsultan->nama??($i->konsultan->nama??'-')}}</td>
                    <td style="padding:10px 12px;font-size:12px;color:#0f172a;border-bottom:0.5px solid #e2e8f0">{{$i->user->nama??'-'}}</td>
                    <td style="padding:10px 12px;font-size:12px;color:#0f172a;border-bottom:0.5px solid #e2e8f0">@if($i->tanggal){{\Carbon\Carbon::parse($i->tanggal)->locale('id')->isoFormat('D MMM Y')}}@else-@endif</td>
                    <td style="padding:10px 12px;border-bottom:0.5px solid #e2e8f0">
                        @if($s=='diterima'||$s=='disetujui')<span style="display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:999px;font-size:10px;font-weight:500;background:#EAF3DE;color:#27500A"><span style="width:6px;height:6px;border-radius:50%;background:#3B6D11;display:inline-block"></span>Disetujui</span>
                        @elseif($s=='ditolak')<span style="display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:999px;font-size:10px;font-weight:500;background:#FCEBEB;color:#791F1F">Ditolak</span>
                        @elseif($s=='menunggu')<span style="display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:999px;font-size:10px;font-weight:500;background:#FAEEDA;color:#633806">Menunggu</span>
                        @else<span style="font-size:11px;color:#94a3b8">{{$s?:'-'}}</span>@endif
                    </td>
                    <td style="padding:10px 12px;border-bottom:0.5px solid #e2e8f0"><div style="display:flex;gap:5px"><a href="{{route('jadwal.zoom',$i->id)}}" style="display:inline-flex;align-items:center;gap:4px;padding:4px 9px;background:#E6F1FB;color:#0C447C;border-radius:6px;font-size:11px;font-weight:500;text-decoration:none" onmouseover="this.style.background='#B5D4F4'" onmouseout="this.style.background='#E6F1FB'"><i class="ti ti-video" style="font-size:12px"></i>Zoom</a></div></td>
                </tr>
                @empty
                <tr><td colspan="6" style="padding:40px;text-align:center;color:#94a3b8;font-size:13px">Belum ada data jadwal</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:10px 16px;border-top:0.5px solid #e2e8f0"><span style="font-size:11px;color:#64748b">Menampilkan {{count($janjiTemu??[])}} data</span></div>
</div>
@endsection