@extends('admin.layout')
@section('content')
<x-admin.page-header title="Pesan Masuk WA" subtitle="Pesan konsultasi yang masuk melalui WhatsApp" :breadcrumbs="['Datapedia','Pesan WA']" />

@if(session('success'))
<div class="alert-success">{{session('success')}}</div>
@endif

<div class="card" style="background:#fff;border:0.5px solid #e2e8f0;border-radius:12px;overflow:hidden">
    <div style="padding:14px 18px;border-bottom:0.5px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between">
        <div style="font-size:13px;font-weight:600;color:#0f172a;display:flex;align-items:center;gap:8px"><i class="ti ti-message" style="font-size:16px;color:#1F6FD6"></i>Daftar Pesan <span style="font-size:11px;font-weight:400;color:#94a3b8;margin-left:4px">— {{count($faq)}} pesan</span></div>
        <a href="{{route('adminKonsultasi.create')}}" class="btn-primary" style="padding:5px 12px;font-size:11px"><i class="ti ti-plus"></i> Input Manual</a>
    </div>
    <div style="overflow-x:auto">
        <table class="sortable-table" style="width:100%;border-collapse:collapse;min-width:1300px">
            <thead><tr style="background:#f8fafc">
                <th onclick="sortTable(0)" style="padding:10px 6px;text-align:center;width:28px;font-size:10px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase;cursor:pointer">No ▾</th>
                <th onclick="sortTable(1)" style="padding:10px 6px;font-size:10px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase;cursor:pointer">Tanggal ▾</th>
                <th onclick="sortTable(2)" style="padding:10px 6px;font-size:10px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase;cursor:pointer">Nama ▾</th>
                <th onclick="sortTable(3)" style="padding:10px 6px;font-size:10px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase;cursor:pointer">No HP ▾</th>
                <th onclick="sortTable(4)" style="padding:10px 6px;font-size:10px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase;cursor:pointer">JK ▾</th>
                <th onclick="sortTable(5)" style="padding:10px 6px;font-size:10px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase;cursor:pointer">Instansi ▾</th>
                <th onclick="sortTable(6)" style="padding:10px 6px;font-size:10px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase;cursor:pointer">Posisi ▾</th>
                <th onclick="sortTable(7)" style="padding:10px 6px;font-size:10px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase;cursor:pointer">Keperluan ▾</th>
                <th onclick="sortTable(8)" style="padding:10px 6px;font-size:10px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase;cursor:pointer">Data Diminta ▾</th>
                <th style="padding:10px 6px;font-size:10px;font-weight:600;color:#64748b;border-bottom:0.5px solid #e2e8f0;text-transform:uppercase">Aksi</th>
            </tr></thead>
            <tbody>
                @forelse($faq as $idx=>$i)
                @php $nama = $i->nama ?: ($i->user->nama??'-'); $nohp = $i->no_hp ?: ($i->user->no_hp??'-'); @endphp
                <tr style="transition:background 100ms" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                    <td style="padding:8px 6px;font-size:11px;color:#94a3b8;border-bottom:0.5px solid #e2e8f0;text-align:center">{{$idx+1}}</td>
                    <td style="padding:8px 6px;font-size:11px;color:#0f172a;border-bottom:0.5px solid #e2e8f0;white-space:nowrap">{{$i->clicked_at ? \Carbon\Carbon::parse($i->clicked_at)->locale('id')->isoFormat('D MMM Y, HH:mm') : '-'}}</td>
                    <td style="padding:8px 6px;font-size:11px;font-weight:600;color:#0f172a;border-bottom:0.5px solid #e2e8f0;max-width:100px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{$nama}}</td>
                    <td style="padding:8px 6px;font-size:11px;color:#64748b;border-bottom:0.5px solid #e2e8f0;font-family:monospace;white-space:nowrap">{{$nohp}}</td>
                    <td style="padding:8px 6px;font-size:11px;color:#0f172a;border-bottom:0.5px solid #e2e8f0">{{$i->jenis_kelamin=='laki-laki'?'Laki-laki':($i->jenis_kelamin=='perempuan'?'Perempuan':'-')}}</td>
                    <td style="padding:8px 6px;font-size:11px;color:#0f172a;border-bottom:0.5px solid #e2e8f0;max-width:120px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{$i->instansi}}</td>
                    <td style="padding:8px 6px;font-size:11px;color:#0f172a;border-bottom:0.5px solid #e2e8f0">
                        @php $lp=['asn'=>'ASN','karyawan_swasta'=>'Karyawan','wiraswasta'=>'Wiraswasta','peneliti'=>'Peneliti','pelajar_mahasiswa'=>'Mahasiswa','lainnya'=>'Lainnya']; @endphp
                        <span style="display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:999px;font-size:10px;font-weight:500;background:var(--brand-blue-light);color:var(--brand-blue-dark)">{{$lp[$i->posisi]??$i->posisi}}</span>
                    </td>
                    <td style="padding:8px 6px;font-size:11px;color:#475569;border-bottom:0.5px solid #e2e8f0;max-width:120px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap" title="{{$i->keperluan_data}}">{{$i->keperluan_data ?: '-'}}</td>
                    <td style="padding:8px 6px;font-size:11px;color:#475569;border-bottom:0.5px solid #e2e8f0;max-width:130px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap" title="{{$i->data_diminta}}">{{Str::limit($i->data_diminta,35)}}</td>
                    <td style="padding:8px 6px;border-bottom:0.5px solid #e2e8f0">
                        <div style="display:flex;gap:5px"><a href="{{route('faq.editPesan',$i->id)}}" class="btn-edit-sm"><i class="ti ti-edit"></i>Edit</a><form action="{{route('faq.hapusPesan',$i->id)}}" method="POST" style="margin:0"><button type="submit" onclick="return confirm('Hapus?')" class="btn-del-sm"><i class="ti ti-trash"></i>Hapus</button>@csrf @method('DELETE')</form></div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="10" style="padding:40px;text-align:center;color:#94a3b8;font-size:13px"><i class="ti ti-message-off" style="font-size:24px;display:block;margin-bottom:8px"></i>Belum ada pesan konsultasi masuk</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:10px 16px;border-top:0.5px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between"><span style="font-size:11px;color:#64748b">Menampilkan {{count($faq)}} pesan</span><a href="{{route('adminKonsultasi.create')}}" class="btn-primary" style="padding:4px 10px;font-size:11px"><i class="ti ti-plus"></i> Input Manual</a></div>
</div>
@endsection