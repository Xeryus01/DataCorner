@extends('admin.layout')
@section('content')

<div class="w-full p-6 bg-gray-100 min-h-screen">
    <div class="w-full  bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-blue-300 p-4">
            <h2 class="text-xl font-bold text-blue-800">Ubah Maklumat Layanan</h2>
        </div>

         @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <strong>Terjadi kesalahan:</strong>
        <ul class="list-disc pl-5 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <form method="POST" action="{{ route('maklumat.update',$maklumat->id) }}" enctype="multipart/form-data" class="p-6">
            @method('PUT')
            @csrf

            <div class="mb-4">
                <label for="judul" class="block text-gray-700 font-medium mb-2">Judul Maklumat Layanan</label>
                <input type="text" name="judul" id="judul" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300" value="{{ $maklumat->judul }}">

                    <p class="text-red-500 text-sm mt-1"></p>

            </div>

            <div class="mb-4">
                <label for="file" class="block text-gray-700 font-medium mb-2">file</label>

                <div class="mb-4">
                    @if($maklumat->file)
                    <img id="preview" src="{{ asset('storage/'.$maklumat->file) }}" class="w-32 h-32 object-cover mb-2" alt="file">
                    @else
                    <img id="preview" class="w-32 h-32 object-cover mb-2 hidden" alt="preview">
                    @endif
            </div>

                <input type="file" name="file" id="file" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300" value="{{ $maklumat->file }}">

                   @error('file')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="px-6 py-2 bg-blue-300 hover:bg-blue-400 text-blue-800 font-medium rounded-lg">Ubah</button>

            </div>
        </form>
    </div>
</div>
@endsection
