@extends('admin.layout')
@section('content')

<div class="w-full p-6 bg-gray-100 min-h-screen">
    <div class="w-full  bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-blue-300 p-4">
            <h2 class="text-xl font-bold text-blue-800">Buat Akun Admin</h2>
        </div>

        <form method="POST" action="{{ route('admin.store') }}" class="p-6 needs-validation" novalidate>
            @csrf

            @include('components.form.input', ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'placeholder' => 'Masukkan email', 'required' => true])
            @include('components.form.input', ['name' => 'nama', 'label' => 'Nama Admin', 'type' => 'text', 'placeholder' => 'Masukkan nama', 'required' => true])
            @include('components.form.input', ['name' => 'password', 'label' => 'Password', 'type' => 'password', 'placeholder' => 'Masukkan Password', 'required' => true])

            <div class="flex items-center justify-between">
                <button type="submit" class="px-6 py-2 bg-blue-300 hover:bg-blue-400 text-blue-800 font-medium rounded-lg">Daftar</button>

            </div>
        </form>
    </div>
</div>
@endsection
