<x-layout-web>
  <div class="py-8 mx-auto px-6 lg:px-8">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
      <h1 class="text-center text-3xl font-bold text-gray-900">Arsip Karya Magang</h1>
    </div>

    <!-- Filter dan Search -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
      <form method="GET" action="{{ route('program-magang.arsipKarya') }}">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
            <input type="text" name="search" value="{{ request('search') }}"
              class="w-full px-3 py-2 border rounded-md" placeholder="Cari Nama . . .">
          </div>
          <div class="flex items-end">
            <button type="submit"
              class="w-full bg-primary hover:bg-[#00295A] text-white py-2 rounded-lg font-medium transition-colors">
              Cari
            </button>
          </div>
        </div>
      </form>

    </div>

    <!-- Tabel Log Harian -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
      <div class="overflow-x-auto pb-10">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                No
              </th>
              <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                Nama
              </th>
              <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                Tanggal Mulai
              </th>
              <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                Tanggal Selesai
              </th>
              <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                Dokumen Laporan
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @php
              $no = $arsip->firstItem();
            @endphp
            @forelse($arsip as $item)
              <tr class="hover:bg-gray-50 transition-colors duration-150">
                <td class="text-sm text-gray-900 text-center font-semibold">
                  {{ $no++ }}
                </td>
                <td class="text-sm text-center text-gray-900 font-semibold">
                  {{ $item->nama }}
                </td>
                <td class="text-sm text-center text-gray-900 font-semibold">
                  {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d/m/Y') }}
                </td>
                <td class="text-sm text-center text-gray-900 font-semibold">
                  {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d/m/Y') }}
                </td>
                <td class="text-center py-3">
                  <a href="{{ Storage::url($item->laporan_magang) }}" target="_blank">
                    <button class="btn btn-info">Lihat Dokumen</button>
                  </a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                  <div class="flex flex-col items-center">
                    <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-lg font-medium">Tidak ada data.</p>
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
        {{ $arsip->links('vendor.pagination.custom') }}
      </div>
    </div>
  </div>
  <x-footer class="fill-[#EEF0F2]"></x-footer>
</x-layout-web>
