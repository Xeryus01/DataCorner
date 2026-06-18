vei @extends('admin.layout')
@section('content')
<x-admin.page-header title="Tambah Konsultasi Manual" subtitle="Input data konsultasi WhatsApp oleh admin" :breadcrumbs="['Datapedia','Konsultasi','Tambah']" />
<div class="card" style="max-width:600px">
    <div class="card-header">
        <div class="card-header-left">
            <div class="card-title"><i class="ti ti-plus"></i>Form Input Konsultasi WhatsApp</div>
        </div>
    </div>
    <div class="card-body">
        @if(session('error'))
        <div class="form-error">{{session('error')}}</div>
        @endif
        @if(session('success'))
        <div class="alert-success">{{session('success')}}</div>
        @endif
        <form method="POST" action="{{route('adminKonsultasi.store')}}">
            @csrf
            <div class="form-grid" style="margin-bottom:14px">
                <div><label class="form-label">Nama*</label><input type="text" name="nama" value="{{old('nama')}}" class="form-input" required placeholder="Nama pengguna"></div>
                <div><label class="form-label">No HP</label><input type="text" name="no_hp" value="{{old('no_hp')}}" class="form-input" placeholder="08xxxxxx"></div>
            </div>
            <div class="form-grid" style="margin-bottom:14px">
                <div><label class="form-label">Jenis Kelamin</label><select name="jenis_kelamin" class="form-input form-select"><option value="">-- Pilih --</option><option value="laki-laki" {{old('jenis_kelamin')=='laki-laki'?'selected':''}}>Laki-laki</option><option value="perempuan" {{old('jenis_kelamin')=='perempuan'?'selected':''}}>Perempuan</option></select></div>
                <div><label class="form-label">Memiliki Akun</label><select name="memiliki_akun" class="form-input form-select"><option value="">-- Pilih --</option><option value="ya" {{old('memiliki_akun')=='ya'?'selected':''}}>Ya</option><option value="tidak" {{old('memiliki_akun')=='tidak'?'selected':''}}>Tidak</option></select></div>
            </div>
            <div style="margin-bottom:14px"><label class="form-label">Posisi*</label>
                <select name="posisi" required class="form-input form-select">
                    <option value="">-- Pilih Posisi --</option>
                    <option value="asn" {{old('posisi')=='asn'?'selected':''}}>ASN</option>
                    <option value="karyawan_swasta" {{old('posisi')=='karyawan_swasta'?'selected':''}}>Karyawan Swasta</option>
                    <option value="wiraswasta" {{old('posisi')=='wiraswasta'?'selected':''}}>Wiraswasta</option>
                    <option value="peneliti" {{old('posisi')=='peneliti'?'selected':''}}>Peneliti</option>
                    <option value="pelajar_mahasiswa" {{old('posisi')=='pelajar_mahasiswa'?'selected':''}}>Pelajar/Mahasiswa</option>
                    <option value="lainnya" {{old('posisi')=='lainnya'?'selected':''}}>Lainnya</option>
                </select>
            </div>
            <div style="margin-bottom:14px"><label class="form-label">Instansi / Lembaga*</label><input type="text" name="instansi" value="{{old('instansi', 'Konsultasi via WhatsApp')}}" class="form-input" required></div>
            <div style="margin-bottom:14px"><label class="form-label">Keperluan Data</label><input type="text" name="keperluan_data" value="{{old('keperluan_data')}}" class="form-input" placeholder="Contoh: Data kemiskinan, inflasi, dll"></div>
            <div style="margin-bottom:14px"><label class="form-label">Data Diminta*</label><input type="text" name="data_diminta" value="{{old('data_diminta', 'Input manual oleh admin')}}" class="form-input" required></div>
            <div class="form-actions">
                <button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i>Simpan & Lihat WhatsApp</button>
                <a href="{{route('faq.pesan')}}" class="btn-ghost">Lihat Pesan WA</a>
            </div>
        </form>
    </div>
</div>
@endsection