@extends('jadwal.layout')
@section('content')

<div class="w-full p-6 bg-gray-100">
    <div class="w-full bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-blue-400 p-4">
            <h2 class="text-xl font-bold text-blue-800">Daftar Jadwal Petugas Mingguan</h2>
        </div>

        <div class="mb-6 overflow-x-auto">
            <table class="min-w-full border-collapse text-sm text-left">
                <thead>
                    <tr class="bg-blue-300 text-blue-900">
                        <th class="p-3 border border-blue-400 text-center">No</th>
                        <th class="p-3 border border-blue-400 text-center">Nama Petugas</th>
                        <th class="p-3 border border-blue-400 text-center">Tanggal Tugas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($petugasMingguan as $index => $petugas)
                        <tr class="bg-white hover:bg-gray-50 text-center">
                            <td class="p-3 border">{{ $index + 1 }}</td>
                            <td class="p-3 border">{{ $petugas->konsultan->nama }}</td>
                            <td class="p-3 border">
                                {{ \Carbon\Carbon::parse($petugas->tanggal)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center p-4 text-xl text-gray-500">Belum ada jadwal tersedia untuk minggu ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
