@extends('admin.layout')

@section('content')
<div class="w-full p-6 bg-gray-100">
    <div class="w-full bg-white rounded-lg shadow-md overflow-hidden">

        <div class="bg-blue-400 p-4">
            <h2 class="text-xl font-bold text-blue-800">Edit Survei Layanan</h2>
            <p class="text-sm text-blue-900 mt-1">
                Perbarui link survei layanan berdasarkan tahun.
            </p>
        </div>

        <div class="p-6">
            @if ($errors->any())
                <div class="mb-5 p-3 bg-red-100 border border-red-300 text-red-800 rounded">
                    <ul class="list-disc pl-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('survei-layanan.update', $surveiLayanan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Tahun
                    </label>

                    <input type="number"
                           name="tahun"
                           value="{{ old('tahun', $surveiLayanan->tahun) }}"
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"
                           required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Link Survei
                    </label>

                    <input type="url"
                           name="link"
                           value="{{ old('link', $surveiLayanan->link) }}"
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"
                           required>
                </div>

                <div class="mb-4">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox"
                               name="is_active"
                               value="1"
                               class="rounded"
                               {{ old('is_active', $surveiLayanan->is_active) ? 'checked' : '' }}>
                        <span class="text-sm text-gray-700">Aktif</span>
                    </label>
                </div>

                <div class="flex space-x-2 mt-6">
                    <button type="submit"
                            class="px-4 py-2 bg-blue-300 hover:bg-blue-400 text-blue-800 rounded font-semibold">
                        Update
                    </button>

                    <a href="{{ route('survei-layanan.index') }}"
                       class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded font-semibold">
                        Kembali
                    </a>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection