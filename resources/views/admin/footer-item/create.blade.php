@extends('admin.layout')

@section('content')
<div class="w-full p-6 bg-gray-100">
    <div class="w-full bg-white rounded-lg shadow-md overflow-hidden">

        <div class="bg-blue-400 p-4">
            <h2 class="text-xl font-bold text-blue-800">Tambah Footer Website</h2>
            <p class="text-sm text-blue-900 mt-1">
                Tambahkan link, PDF, atau gambar untuk ditampilkan pada footer.
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

            <form action="{{ route('footer-item.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Section Footer
                    </label>

                    <select name="section"
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"
                            required>
                        <option value="">-- Pilih Section --</option>
                        <option value="tentang_kami" {{ old('section') == 'tentang_kami' ? 'selected' : '' }}>
                            Tentang Kami
                        </option>
                        <option value="magang" {{ old('section') == 'magang' ? 'selected' : '' }}>
                            Magang
                        </option>
                        <option value="akademi_statistik" {{ old('section') == 'akademi_statistik' ? 'selected' : '' }}>
                            Akademi Statistik
                        </option>
                        <option value="kontak_kami" {{ old('section') == 'kontak_kami' ? 'selected' : '' }}>
                            Kontak Kami
                        </option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Judul
                    </label>

                    <input type="text"
                           name="title"
                           value="{{ old('title') }}"
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"
                           placeholder="Contoh: Profil Lembaga"
                           required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Tipe Item
                    </label>

                    <select name="type"
                            id="type"
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"
                            required>
                        <option value="link" {{ old('type') == 'link' ? 'selected' : '' }}>
                            Link
                        </option>
                        <option value="pdf" {{ old('type') == 'pdf' ? 'selected' : '' }}>
                            PDF
                        </option>
                        <option value="image" {{ old('type') == 'image' ? 'selected' : '' }}>
                            Gambar
                        </option>
                    </select>
                </div>

                <div class="mb-4" id="urlField">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        URL Link
                    </label>

                    <input type="text"
                           name="url"
                           value="{{ old('url') }}"
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"
                           placeholder="https://... atau /nama-halaman">

                    <p class="text-xs text-gray-500 mt-1">
                        Diisi jika tipe item adalah Link.
                    </p>
                </div>

                <div class="mb-4" id="fileField">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Upload File
                    </label>

                    <input type="file"
                           name="file"
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"
                           accept=".pdf,.jpg,.jpeg,.png,.webp">

                    <p class="text-xs text-gray-500 mt-1">
                        Untuk PDF gunakan .pdf. Untuk gambar gunakan .jpg, .jpeg, .png, atau .webp.
                    </p>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Urutan Tampil
                    </label>

                    <input type="number"
                           name="sort_order"
                           value="{{ old('sort_order', 0) }}"
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"
                           min="0">

                    <p class="text-xs text-gray-500 mt-1">
                        Semakin kecil angka, semakin atas item ditampilkan.
                    </p>
                </div>

                <div class="mb-4 flex items-center space-x-6">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox"
                               name="is_active"
                               value="1"
                               class="rounded"
                               checked>
                        <span class="text-sm text-gray-700">Aktif</span>
                    </label>

                    <label class="flex items-center space-x-2">
                        <input type="checkbox"
                               name="open_new_tab"
                               value="1"
                               class="rounded"
                               checked>
                        <span class="text-sm text-gray-700">Buka di tab baru</span>
                    </label>
                </div>

                <div class="flex space-x-2 mt-6">
                    <button type="submit"
                            class="px-4 py-2 bg-blue-300 hover:bg-blue-400 text-blue-800 rounded font-semibold">
                        Simpan
                    </button>

                    <a href="{{ route('footer-item.index') }}"
                       class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded font-semibold">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const typeSelect = document.getElementById('type');
    const urlField = document.getElementById('urlField');
    const fileField = document.getElementById('fileField');

    function toggleField() {
        if (typeSelect.value === 'link') {
            urlField.style.display = 'block';
            fileField.style.display = 'none';
        } else {
            urlField.style.display = 'none';
            fileField.style.display = 'block';
        }
    }

    typeSelect.addEventListener('change', toggleField);
    toggleField();
</script>
@endsection