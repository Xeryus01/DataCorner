@extends('admin.layout')

@section('content')

<div class="w-full p-6 bg-gray-100 min-h-screen">
    <div class="w-full bg-white rounded-lg shadow-md overflow-hidden">

        <div class="bg-blue-300 p-4">
            <h2 class="text-xl font-bold text-blue-800">
                Edit Data Pengunjung Website BPS Provinsi Kepulauan Bangka Belitung
            </h2>
            <p class="text-sm text-blue-700 mt-1">
                Ubah data pengunjung Website BPS Provinsi Kepulauan Bangka Belitung
            </p>
        </div>

        @php
            [$tahun, $bulan] = explode('-', $data->periode);
        @endphp

        <form action="{{ route('statistik.website.update', $data->id) }}" method="POST" class="p-6">

            @csrf
            @method('PUT')

            <div class="mb-8">
                <h3 class="font-semibold text-gray-700 mb-4">Periode</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-gray-600">Bulan</label>
                        <select name="bulan" class="w-full mt-1 p-2 border rounded">
                            @php
                                $months = [
                                    '01'=>'Januari','02'=>'Februari','03'=>'Maret',
                                    '04'=>'April','05'=>'Mei','06'=>'Juni',
                                    '07'=>'Juli','08'=>'Agustus','09'=>'September',
                                    '10'=>'Oktober','11'=>'November','12'=>'Desember'
                                ];
                            @endphp

                            @foreach($months as $val => $label)
                                <option value="{{ $val }}"
                                    {{ old('bulan', $bulan) == $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('bulan') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Tahun</label>
                        <select name="tahun" class="w-full mt-1 p-2 border rounded">
                            @php
                                $tahunSekarang = date('Y');
                            @endphp

                            @for($i = $tahunSekarang; $i >= $tahunSekarang - 5; $i--)
                                <option value="{{ $i }}"
                                    {{ old('tahun', $tahun) == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                        @error('tahun') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Data Statistik --}}
            <div class="grid grid-cols-2 gap-4">

                @php
                    $fields = [ 
                        ['name' => 'active_users', 'label' => 'Active Users'],
                        ['name' => 'new_users', 'label' => 'New Users'],
                        ['name' => 'returning_users', 'label' => 'Returning Users'],
                        ['name' => 'total_users', 'label' => 'Total Users'],
                        ['name' => 'sessions', 'label' => 'Sessions'],
                        ['name' => 'bounce_rate', 'label' => 'Bounce Rate'],
                                                                                 
                    ];
                @endphp

                @foreach($fields as $field)
                <div>
                    <label class="text-sm text-gray-600">
                        {{ $field['label'] }}
                    </label>

                    <input type="number" name="{{ $field['name'] }}" value="{{ old($field['name'], $data->{$field['name']}) }}"
                           class="w-full mt-1 p-2 border rounded" min="0" step="any">
                    @error($field['name'])
                        <p class="text-red-500 text-xs">{{ $message }}</p>
                    @enderror
                </div>
                @endforeach

            </div>

            <div class="mt-6 flex justify-end gap-2">
                <a href="{{ route('statistik.website.index') }}"
                   class="px-4 py-2 bg-gray-200 rounded">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Update
                </button>
            </div>

        </form>

    </div>

</div>

@endsection