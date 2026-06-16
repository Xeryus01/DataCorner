@extends('admin.layout')
@section('content')
<div class="w-full p-6 bg-gray-100 ">
    <div class="w-full bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-blue-400 p-4">
            <h2 class="text-xl font-bold text-blue-800">Data User BPS</h2>
        </div>

        <form method="POST" action="" class="p-6">
            @csrf
            <div class="mb-6 link-container">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-blue-300">
                            <th class="p-3 text-left text-blue-800 border border-blue-400">No</th>
                            <th class="p-3 text-left text-blue-800 border border-blue-400">Nama</th>
                            <th class="p-3 text-left text-blue-800 border border-blue-400">Nomor Handphone</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                            $no = 1;
                        ?>
                        @foreach ($user as  $index => $item)

                        <tr class="hover:bg-gray-50 layanan-item-row">
                            <td class="p-3 border border-gray-200 text-center">
                            {{ $index + 1 }}
                        </td>

                            <td class="p-3 border border-gray-200">
                                {{ $item->nama }}
                            </td>

                            <td class="p-3 border border-gray-200">
                                {{ $item->no_hp }}
                            </td>

                        </tr>
                        @endforeach

                    </tbody>
                </table>
                <div id="pagination-controls" class="flex justify-center mt-6 space-x-2"></div>
            </div>

        </form>
    </div>
</div>

<!-- Script untuk konfirmasi delete -->

@endsection
