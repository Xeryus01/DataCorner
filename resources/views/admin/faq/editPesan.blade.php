@extends('admin.layout')
@section('content')
<x-admin.page-header title="Edit Pesan WA" subtitle="Perbarui data pesan konsultasi WhatsApp" :breadcrumbs="['Datapedia','Pesan WA','Edit']" />
<div class="card" style="max-width:600px">
    <div class="card-header"><div class="card-header-left"><div class="card-title"><i class="ti ti-message"></i>Form Edit Pesan</div></div></div>
    <div class="card-body">
        @if($errors->any())<div class="form-error">@foreach($errors->all() as $e)<div>• {{$e}}</div>@endforeach</div>@endif
        <form method="POST" action="{{ route('faq.updatePesan', $pesan->id) }}">
            @csrf @method('PUT')
            <div class="form-grid" style="margin-bottom:14px">
                <div><label class="form-label">Nama</label><input type="text" name="nama" value="{{ old('nama',$pesan->nama) }}" class="form-input" placeholder="Nama pengguna"></div>
                <div><label class="form-label">No HP</label><input type="text" name="no_hp" value="{{ old('no_hp',$pesan->no_hp) }}" class="form-input" placeholder="08xxxxxx"></div>
            </div>
            <div class="form-grid" style="margin-bottom:14px">
                <div><label class="form-label">Jenis Kelamin</label><select name="jenis_kelamin" class="form-input form-select"><option value="">-- Pilih --</option><option value="laki-laki" {{ old('jenis_kelamin',$pesan->jenis_kelamin)=='laki-laki'?'selected':'' }}>Laki-laki</option><option value="perempuan" {{ old('jenis_kelamin',$pesan->jenis_kelamin)=='perempuan'?'selected':'' }}>Perempuan</option></select></div>
                <div><label class="form-label">Memiliki Akun</label><select name="memiliki_akun" class="form-input form-select"><option value="">-- Pilih --</option><option value="ya" {{ old('memiliki_akun',$pesan->memiliki_akun)=='ya'?'selected':'' }}>Ya</option><option value="tidak" {{ old('memiliki_akun',$pesan->memiliki_akun)=='tidak'?'selected':'' }}>Tidak</option></select></div>
            </div>
            <div style="margin-bottom:14px"><label class="form-label">Posisi*</label><select name="posisi" required class="form-input form-select"><option value="">-- Pilih Posisi --</option>@php $plist=['asn'=>'ASN','karyawan_swasta'=>'Karyawan Swasta','wiraswasta'=>'Wiraswasta','peneliti'=>'Peneliti','pelajar_mahasiswa'=>'Pelajar/Mahasiswa','lainnya'=>'Lainnya']; @endphp@foreach($plist as $v=>$l)<option value="{{$v}}" {{ old('posisi',$pesan->posisi)==$v?'selected':'' }}>{{$l}}</option>@endforeach</select></div>
            <div style="margin-bottom:14px"><label class="form-label">Instansi</label><input type="text" name="instansi" value="{{ old('instansi',$pesan->instansi) }}" class="form-input"></div>
            <div style="margin-bottom:14px"><label class="form-label">Keperluan Data</label><input type="text" name="keperluan_data" value="{{ old('keperluan_data',$pesan->keperluan_data) }}" class="form-input"></div>
            <div style="margin-bottom:16px"><label class="form-label">Data Diminta</label><input type="text" name="data_diminta" value="{{ old('data_diminta',$pesan->data_diminta) }}" class="form-input"></div>
            <div class="form-actions"><button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i>Update</button><a href="{{route('faq.pesan')}}" class="btn-ghost">Batal</a></div>
        </form>
    </div>
</div>
@endsection