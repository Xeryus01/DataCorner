@extends('admin.layout')
@section('content')
<x-admin.page-header title="Edit Konsultasi Statistik" subtitle="Ubah data pengunjung layanan konsultasi statistik" :breadcrumbs="['Datapedia','Statistik','Konsultasi','Edit']" />
@php [$tahun, $bulan] = explode('-', $data->periode); @endphp
<div class="card" style="max-width:600px">
    <div class="card-header"><div class="card-header-left"><div class="card-title"><i class="ti ti-handshake"></i>Form Edit Konsultasi</div></div></div>
    <div class="card-body">
        @if($errors->any())<div class="form-error">@foreach($errors->all() as $e)<div>• {{$e}}</div>@endforeach</div>@endif
        <form action="{{ route('statistik.konsultasi-statistik.update', $data->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-grid" style="margin-bottom:14px">
                <div>@php $months=['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember']; @endphp<label class="form-label">Bulan</label><select name="bulan" class="form-input form-select">@foreach($months as $val=>$label)<option value="{{$val}}" {{ old('bulan',$bulan)==$val?'selected':'' }}>{{$label}}</option>@endforeach</select></div>
                <div><label class="form-label">Tahun</label><select name="tahun" class="form-input form-select">@for($i=date('Y');$i>=date('Y')-5;$i--)<option value="{{$i}}" {{ old('tahun',$tahun)==$i?'selected':'' }}>{{$i}}</option>@endfor</select></div>
            </div>
            @php $fields=[['name'=>'konsultasi_online','label'=>'Konsultasi Online'],['name'=>'kunjungan_langsung','label'=>'Kunjungan Langsung'],['name'=>'datapedia','label'=>'Datapedia (WA/Telepon)'],['name'=>'surat','label'=>'Surat (Internal/Eksternal)']]; @endphp
            <div class="form-grid" style="margin-bottom:16px">@foreach($fields as $f)<div><label class="form-label">{{$f['label']}}</label><input type="number" name="{{$f['name']}}" value="{{ old($f['name'], $data->{$f['name']}) }}" class="form-input" min="0"></div>@endforeach</div>
            <div class="form-actions"><button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i>Update</button><a href="{{ route('statistik.konsultasi-statistik.index') }}" class="btn-ghost">Batal</a></div>
        </form>
    </div>
</div>
@endsection