@extends('admin.layout')
@section('content')

<div class="w-full p-6 bg-gray-100 min-h-screen">
    <div class="w-full  bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-blue-300 p-4">
            <h2 class="text-xl font-bold text-blue-800">Ubah Akun Admin</h2>
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

        <form method="POST" action="{{ route('admin.update',$admin->id) }}" class="p-6 needs-validation" novalidate>
            @method('PUT')
            @csrf

            @include('components.form.input', ['name' => 'email', 'label' => 'Email Admin', 'type' => 'email', 'value' => $admin->email])
            @include('components.form.input', ['name' => 'nama', 'label' => 'Nama Admin', 'type' => 'text', 'value' => $admin->nama])
            @include('components.form.input', ['name' => 'password', 'label' => 'Password', 'type' => 'password'])

            <div class="flex items-center justify-between">
                <button type="submit" class="px-6 py-2 bg-blue-300 hover:bg-blue-400 text-blue-800 font-medium rounded-lg">Ubah</button>

            </div>
        </form>
    </div>
</div>
@endsection
