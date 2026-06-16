@extends('admin.layout')
@section('content')
<div class="page-header-row">
    <div>
        <div class="page-title">Tambah Data Pengunjung Layanan Perpustakaan</div>
        <div class="page-sub">Form input data statistik layanan perpustakaan</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-header-left">
            <div class="card-title"><i class="ti ti-book"></i>Form Statistik Perpustakaan</div>
        </div>
    </div>
    <div class="card-body">
        @if($errors->any())
        <div class="form-error">
            @foreach($errors->all() as $e)<div>• {{$e}}</div>@endforeach
        </div>
        @endif

        <form action="{{ route('statistik.perpustakaan.store') }}" method="POST">
            @csrf

            <div class="form-section-title"><i class="ti ti-calendar"></i>Periode Statistik</div>
            <div class="form-grid" style="margin-bottom:6px">
                <div>
                    <label class="form-label">Bulan</label>
                    <select name="bulan" class="form-select" required>
                        <option value="">-- Pilih Bulan --</option>
                        @php $months = ['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember']; @endphp
                        @foreach($months as $val => $label)
                        <option value="{{ $val }}" {{ old('bulan') == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('bulan') <p style="color:#E24B4A;font-size:11px;margin-top:4px">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Tahun</label>
                    <select name="tahun" class="form-select" required>
                        <option value="">-- Pilih Tahun --</option>
                        @php $tahunSekarang = date('Y'); $tahunMinimal = $tahunSekarang - 2; @endphp
                        @for($i = $tahunSekarang; $i >= $tahunMinimal; $i--)
                        <option value="{{ $i }}" {{ old('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                    @error('tahun') <p style="color:#E24B4A;font-size:11px;margin-top:4px">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="form-divider"></div>

            <div class="form-section-title"><i class="ti ti-chart-bar"></i>Data Statistik</div>
            <div class="form-grid">
                @php
                    $fields = [
                        ['name' => 'pengunjung_unik', 'label' => 'Pengunjung Unik (Orang)', 'class' => ''],
                        ['name' => 'kunjungan', 'label' => 'Kunjungan (Kali)', 'class' => 'hitung-kunjungan'],
                        ['name' => 'rata_harian', 'label' => 'Rata-rata Pengunjung Harian', 'class' => ''],
                        ['name' => 'layanan_tercetak', 'label' => 'Penggunaan Layanan Tercetak', 'class' => ''],
                        ['name' => 'digilib_online', 'label' => 'Penggunaan Digilib Online', 'class' => 'hitung-kunjungan'],
                    ];
                @endphp
                @foreach($fields as $field)
                <div>
                    <label class="form-label">{{ $field['label'] }}</label>
                    <input type="number" name="{{ $field['name'] }}" value="{{ old($field['name'], 0) }}" min="0" class="form-input {{ $field['class'] }}" required>
                    @error($field['name']) <p style="color:#E24B4A;font-size:11px;margin-top:4px">{{ $message }}</p> @enderror
                </div>
                @endforeach
                <div>
                    <label class="form-label">Total Jumlah</label>
                    <input type="number" id="jumlah" class="form-input readonly" readonly>
                </div>
            </div>

            <div class="form-actions" style="justify-content:flex-end">
                <a href="{{ route('statistik.perpustakaan.index') }}" class="btn-ghost">Batal</a>
                <button type="submit" class="btn-primary"><i class="ti ti-device-floppy"></i>Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<script>
    const inputs = document.querySelectorAll('.hitung-kunjungan');
    const jumlah = document.getElementById('jumlah');
    function hitungJumlah() {
        let total = 0;
        inputs.forEach(input => { total += parseInt(input.value) || 0; });
        jumlah.value = total;
    }
    inputs.forEach(input => { input.addEventListener('input', hitungJumlah); });
    hitungJumlah();
    document.querySelectorAll('input[type=number]').forEach(input => { input.addEventListener('wheel', function(){ this.blur(); }); });
</script>
@endsection