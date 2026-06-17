@extends('admin.layout')
@section('content')
<x-admin.page-header title="Jam Operasional" subtitle="Kelola jam operasional layanan" :breadcrumbs="['Datapedia','Layanan','Jam Operasional']" addRoute="{{route('jam-operasional.create')}}" addLabel="Tambah Jam" />
@php $data=$jamOperasionals??[] @endphp
<div class="card" style="background:#fff;border:0.5px solid #e2e8f0;border-radius:12px;overflow:hidden">
    <div style="padding:14px 18px;border-bottom:0.5px solid #e2e8f0">
        <div style="font-size:13px;font-weight:600;color:#0f172a;display:flex;align-items:center;gap:8px"><i class="ti ti-clock" style="font-size:16px;color:#1F6FD6"></i>Daftar Jam Operasional <span style="font-size:11px;font-weight:400;color:#94a3b8;margin-left:4px">— {{count($data)}} data</span></div>
    </div>
    <div style="overflow-x:auto">
        <table style="width:100%;border-collapse:collapse">
            <thead><tr style="background:#f8fafc"><th style="padding:10px 16px;text-align:center;width:48px;font-size:11px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase">No</th><th style="padding:10px 16px;font-size:11px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase">Hari</th><th style="padding:10px 16px;font-size:11px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase">Jam Mulai</th><th style="padding:10px 16px;font-size:11px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase">Jam Selesai</th><th style="padding:10px 16px;font-size:11px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase">Aksi</th></tr></thead>
            <tbody>
                @forelse($data as $i)
                <tr style="transition:background 100ms" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                    <td style="padding:12px 16px;font-size:11px;color:#94a3b8;border-bottom:0.5px solid #e2e8f0;text-align:center">{{$loop->iteration}}</td>
                    <td style="padding:12px 16px;font-size:12px;font-weight:600;color:#0f172a;border-bottom:0.5px solid #e2e8f0">{{$i->keterangan_hari}}</td>
                    <td style="padding:12px 16px;font-size:12px;color:#0f172a;border-bottom:0.5px solid #e2e8f0">
                        @if($i->isTutup()) Tutup @else {{\Carbon\Carbon::parse($i->jam_mulai)->format('H:i')}} WIB @endif
                    </td>
                    <td style="padding:12px 16px;font-size:12px;color:#0f172a;border-bottom:0.5px solid #e2e8f0">
                        @if($i->isTutup()) Tutup @else {{\Carbon\Carbon::parse($i->jam_selesai)->format('H:i')}} WIB @endif
                    </td>
                    <td style="padding:12px 16px;border-bottom:0.5px solid #e2e8f0">
                        <div style="display:flex;gap:5px"><a href="{{route('jam-operasional.edit',$i->id)}}" style="display:inline-flex;align-items:center;gap:4px;padding:4px 9px;background:#E6F1FB;color:#0C447C;border-radius:6px;font-size:11px;font-weight:500;text-decoration:none" onmouseover="this.style.background='#B5D4F4'" onmouseout="this.style.background='#E6F1FB'"><i class="ti ti-edit" style="font-size:12px"></i>Edit</a><form action="{{route('jam-operasional.destroy',$i->id)}}" method="POST" style="margin:0"><button type="submit" onclick="return confirm('Hapus?')" style="display:inline-flex;align-items:center;gap:4px;padding:4px 9px;background:#FCEBEB;color:#791F1F;border:none;border-radius:6px;font-size:11px;font-weight:500;cursor:pointer" onmouseover="this.style.background='#F7C1C1'" onmouseout="this.style.background='#FCEBEB'"><i class="ti ti-trash" style="font-size:12px"></i>Hapus</button>@csrf @method('DELETE')</form></div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="padding:40px;text-align:center;color:#94a3b8;font-size:13px">Belum ada data jam operasional</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:10px 16px;border-top:0.5px solid #e2e8f0"><span style="font-size:11px;color:#64748b">Menampilkan {{count($data)}} data</span></div>
</div>
@endsection