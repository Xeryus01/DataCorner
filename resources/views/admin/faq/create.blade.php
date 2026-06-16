@extends('admin.layout')
@section('content')

<div class="w-full p-6 bg-gray-100 min-h-screen">
    <div class="w-full  bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-blue-300 p-4">
            <h2 class="text-xl font-bold text-blue-800">Buat FAQ</h2>
        </div>

        <form method="POST" action="{{ route('faq.store') }}" class="p-6">
            @csrf

            <div class="mb-4">
                <label for="judul" class="block text-gray-700 font-medium mb-2">Judul FAQ</label>
                <input type="text" name="judul" placeholder="Masukkan judul" id="judul" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300" value="{{ old('judul') }}" required>

                      @error('judul')

                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

            </div>

            <div class="mb-4">
                <label for="deskripsi" class="block text-black font-medium mb-2">Deskripsi FAQ</label>
                <textarea id="deskripsi"
                    name="deskripsi"
                    class="w-full min-h-[200px]">
                    {{ old('deskripsi') }}
                </textarea>


                      @error('deskripsi')

                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="px-6 py-2 bg-blue-300 hover:bg-blue-400 text-blue-800 font-medium rounded-lg">Daftar</button>

            </div>
        </form>
    </div>
</div>
<script src="{{ asset('tinymce/tinymce.min.js') }}"></script>

{{-- <script src="https://cdn.tiny.cloud/1/x7k55ywys23h4znk6q665dt4ozxgzkkor7rbbx0t13pcsr86/tinymce/6/tinymce.min.js" referrerpolicy="origin">
</script> --}}

<script>
tinymce.init({
    selector: '#deskripsi',
    license_key: 'gpl', // ⭐ INI WAJIB

    height: 300,

    plugins: [
        'lists', 'link', 'table', 'code'
    ],

    toolbar: `
        undo redo |
        bold italic underline |
        bullist numlist |
        alignleft aligncenter alignright |
        link table | code
    `,

    menubar: false,
    branding: false,

    content_style: `
        body {
            font-family: ui-sans-serif, system-ui;
            font-size: 16px;
        }
        ul { list-style-type: disc; margin-left: 1.5rem; }
        ol { list-style-type: decimal; margin-left: 1.5rem; }
    `
});
</script>

<script>
document.querySelector('form').addEventListener('submit', function () {
    tinymce.triggerSave(); // WAJIB
});
</script>

@endsection
