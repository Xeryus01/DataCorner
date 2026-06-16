@extends('admin.layout')

@section('content')
<div class="w-full p-6 bg-gray-100 min-h-screen">
    <div class="w-full mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-blue-300 px-6 py-4">
            <h2 class="text-xl font-bold text-blue-800">Buat Jadwal Petugas Mingguan</h2>
        </div>

        <form method="POST" action="{{ route('petugas.store') }}" class="p-6 space-y-6 needs-validation" novalidate>
            @csrf

            @php
                use Carbon\Carbon;
                $startOfWeek = Carbon::now()->startOfWeek(Carbon::MONDAY);
            @endphp

            @for ($i = 0; $i < 5; $i++)
                @php
                    $tanggal = $startOfWeek->copy()->addDays($i);
                    $dayName = $tanggal->locale('id')->dayName; // Nama hari dalam Bahasa Indonesia
                @endphp

                <div class="border-b pb-4">
                    <h3 class="text-lg font-bold mt-4 mb-2">
                        {{ $dayName }}, {{ $tanggal->format('d M Y') }}
                    </h3>

                    <div>
                        <label class="block font-semibold mb-1 text-gray-700">Konsultan 1:</label>
                        <select name="jadwal[{{ $tanggal->toDateString() }}][0]" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
                            <option disabled selected value="">-- Pilih Konsultan --</option>
                            @foreach ($konsultan as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-4">
                        <label class="block font-semibold mb-1 text-gray-700">Konsultan 2:</label>
                        <select name="jadwal[{{ $tanggal->toDateString() }}][1]" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
                            <option disabled selected value="">-- Pilih Konsultan --</option>
                            @foreach ($konsultan as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endfor

            <div class="text-right mt-6">
                <button type="submit"
                        class="inline-block bg-blue-500 text-white font-semibold px-6 py-2 rounded-lg hover:bg-blue-600 transition duration-200">
                    Simpan Jadwal Mingguan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
