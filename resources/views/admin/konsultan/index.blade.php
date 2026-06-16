@extends('admin.layout')
@section('content')
<div class="w-full p-6 bg-gray-100 ">
                <div class="w-full bg-white rounded-lg shadow-md overflow-hidden">
                    @php
                use App\Models\Konsultan;
                use Illuminate\Support\Carbon;

                $notifikasiKonsultan = Konsultan::where('status', 'tidak tersedia')
                    ->whereNotNull('status_updated_at')
                    ->where('status_updated_at', '>=', Carbon::now()->subDays(30))
                    ->get();
            @endphp

            @if ($notifikasiKonsultan->count())
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-4 mb-6 rounded-lg">
                    <strong>Notifikasi:</strong> Ada <strong>{{ $notifikasiKonsultan->count() }}</strong> konsultan yang mengubah status menjadi
                    <span class="font-semibold text-red-600">tidak tersedia</span> dalam 30 hari terakhir:
                    <ul class="list-disc ml-6 mt-2 text-sm">
                        @foreach ($notifikasiKonsultan as $k)
                            <li>
                                {{ $k->nama }} –
                                {{ $k->status_updated_at ? \Carbon\Carbon::parse($k->status_updated_at)->translatedFormat('d F Y H:i') : 'tidak diketahui' }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

        {{-- Akhir notifikasi --}}

        <div class="bg-blue-400 p-4">
            <h2 class="text-xl font-bold text-blue-800">Data Konsultan</h2>
        </div>

        <div class="p-6">
                <a href="{{ route('konsultan.create') }}" class="px-4 py-2 bg-blue-300 hover:bg-blue-400 text-blue-800 rounded">Tambah Data</a>
            </div>

            <div class="p-6">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-blue-300">
                            <th class="p-3 text-left text-blue-800 border border-blue-400">No</th>
                            <th class="p-3 text-left text-blue-800 border border-blue-400">Email</th>
                            <th class="p-3 text-left text-blue-800 border border-blue-400">Nama</th>
                            <th class="p-3 text-left text-blue-800 border border-blue-400">Desain Name Desk</th>
                            <th class="p-3 text-left text-blue-800 border border-blue-400">Foto Petugas</th>
                            <th class="p-3 text-left text-blue-800 border border-blue-400">Posisi</th>
                            <th class="p-3 text-left text-blue-800 border border-blue-400">Keahlian</th>
                            <th class="p-3 text-left text-blue-800 border border-blue-400">Status</th>
                            <th class="p-3 text-left text-blue-800 border border-blue-400">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="layanan-body">
                        <!-- Loop data dari controller Laravel -->
                        <?php
                            $no = 1;
                        ?>
                        @foreach ($konsultan as $item)

                        <tr class="hover:bg-gray-50 layanan-item-row">
                            <td class="p-3 border border-gray-200">
                                {{ $no++ }}
                            </td>

                            <td class="p-3 border border-gray-200">
                                {{ $item->email }}
                            </td>

                            <td class="p-3 border border-gray-200">
                                {{ $item->nama }}
                            </td>

                            <td class="p-3 border border-gray-200">
                                <a href="{{ Storage::url($item->image) }}" target="_blank" class="px-4 py-2 bg-blue-300 hover:bg-blue-400 text-blue-800 font-medium rounded-lg">
                                    Lihat
                                </a>


                            </td>

                            <td class="p-3 border border-gray-200">
                                <a href="{{ Storage::url($item->gambar) }}" target="_blank" class="px-6 py-2 bg-blue-300 hover:bg-blue-400 text-blue-800 font-medium rounded-lg">
                                    Lihat
                                </a>
                            </td>

                            <td class="p-3 border border-gray-200">
                                {{ $item->posisi }}
                            </td>

                            <td class="p-3 border border-gray-200">
                                @if($item->bidangKeahlian->count())
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($item->bidangKeahlian as $bidang)
                                            <span class="inline-block px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded">
                                                {{ $bidang->nama_bidang }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </td>

                            <td class="p-3 border border-gray-200 align-top">
                                @if ($item->status == 'tersedia')
                                    <span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-800 text-sm font-medium rounded">
                                        ✅ Tersedia
                                    </span>
                                @elseif ($item->status == 'tidak tersedia')
                                    <div class="space-y-1">
                                        <span class="inline-flex items-center px-2 py-1 bg-red-100 text-red-800 text-sm font-medium rounded">
                                            ❌ Tidak Tersedia
                                        </span>
                                        <p class="text-sm text-gray-700"><strong>Alasan:</strong> {{ $item->alasan }}</p>
                                        <p class="text-sm text-gray-700"><strong>Dari:</strong> {{ \Carbon\Carbon::parse($item->tanggal_mulai_tidak_tersedia)->translatedFormat('d F Y') }}</p>
                                        <p class="text-sm text-gray-700"><strong>Sampai:</strong> {{ \Carbon\Carbon::parse($item->tanggal_selesai_tidak_tersedia)->translatedFormat('d F Y') }}</p>
                                    </div>
                                @else
                                    <span class="text-gray-500 italic text-sm">Belum diatur</span>
                                @endif
                            </td>


                                <td class="p-3 border border-gray-200">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('konsultan.edit', $item->id) }}" class="px-3 py-1 bg-blue-300 hover:bg-blue-400 text-blue-800 rounded">Edit</a>

                           <form action="{{ route('konsultan.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-300 hover:bg-red-400 text-red-800 rounded">Hapus</button>
                                    </form>
                                    </div>
                                </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
                <div id="pagination-controls" class="flex justify-center mt-6 space-x-2"></div>
            </div>
    </div>
</div>

<!-- Script untuk konfirmasi delete -->

@endsection
