@extends('admin.layout')

@section('content')

<div class="w-full p-6 bg-gray-100 min-h-screen">

    <div class="w-full bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="bg-blue-300 px-6 py-5">
            <h2 class="text-2xl font-bold text-blue-900">
                Tambah Data Pengguna Layanan Rekomendasi Statistik
            </h2>
            <p class="text-sm text-blue-800 mt-1">
                Form input data pengguna layanan rekomendasi statistik.
            </p>
        </div>

        <form action="{{ route('statistik.rekomendasi.store') }}" method="POST" class="p-8"> 
            @csrf
            <div class="mb-10">
                <div class="flex items-center gap-2 mb-6">
                    <div class="w-1 h-6 bg-blue-400 rounded-full"></div>
                    <h3 class="text-lg font-semibold text-gray-800">Periode Statistik</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">
                            Bulan
                        </label>
                        <select name="bulan"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-blue-400 focus:ring-4 focus:ring-blue-50 transition-all duration-200 outline-none appearance-none"
                                required>
                            <option value="">-- Pilih Bulan --</option>
                            @php
                                $months = ['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
                            @endphp
                            @foreach($months as $val => $label)
                                <option value="{{ $val }}" {{ old('bulan') == $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('bulan') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">
                            Tahun
                        </label>
                        <select name="tahun"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-blue-400 focus:ring-4 focus:ring-blue-50 transition-all duration-200 outline-none"
                                required>
                            <option value="">-- Pilih Tahun --</option>
                            @php
                                $tahunSekarang = date('Y');
                                $tahunMinimal = $tahunSekarang - 2;
                            @endphp
                            @for($i = $tahunSekarang; $i >= $tahunMinimal; $i--)
                                <option value="{{ $i }}" {{ old('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                        @error('tahun') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <hr class="mb-10 border-gray-100">

            <div>
                <div class="flex items-center gap-2 mb-6">
                    <div class="w-1 h-6 bg-blue-400 rounded-full"></div>
                    <h3 class="text-lg font-semibold text-gray-800">Data Statistik</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @php
                        $fields = [
                            ['name' => 'survei', 'label' => 'Survei', 'class' => 'hitung-kunjungan'],
                            ['name' => 'kompromin', 'label' => 'Kompromin', 'class' => 'hitung-kunjungan'],
                            ['name' => 'opd', 'label' => 'OPD', 'class' => ''],
                            ['name' => 'instansi', 'label' => 'Instansi', 'class' => ''],                            
                        ];
                    @endphp

                    @foreach($fields as $field)
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">
                            {{ $field['label'] }}
                        </label>
                        <input type="number" name="{{ $field['name'] }}" value="{{ old($field['name'], 0) }}" min="0"
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-blue-400 focus:ring-4 focus:ring-blue-50 transition-all duration-200 outline-none {{ $field['class'] }}"
                               required>
                        @error($field['name']) <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                    </div>
                    @endforeach
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-1">
                            Jumlah Rekomendasi yang Terbit
                        </label>
                        <input type="number" id="jumlah" class="w-full px-4 py-3 bg-blue-50 border border-blue-100 rounded-xl text-blue-700 font-bold outline-none cursor-not-allowed" readonly>
                    </div>
                </div>
            </div>

            {{-- Tombol --}}
           <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-50">
                <a href="{{ route('statistik.rekomendasi.index') }}" 
                   class="px-6 py-3 text-gray-500 font-semibold hover:text-gray-700 transition">
                    Batal
                </a>
                <button type="submit" 
                    class="px-10 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-200 transition-all active:scale-95">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>


<script>
    const inputs = document.querySelectorAll('.hitung-kunjungan');
    const jumlah = document.getElementById('jumlah');

    function hitungJumlah() {
        let total = 0;
        inputs.forEach(input => {
            total += parseInt(input.value) || 0;
        });
        jumlah.value = total;
    }

    inputs.forEach(input => {
        input.addEventListener('input', hitungJumlah);
    });

    hitungJumlah();
</script>

<script>
    document.querySelectorAll('input[type=number]').forEach(input => {
        input.addEventListener('wheel', function() {
            this.blur();
        });
    });
</script>

@endsection