@extends('admin.layout')
@section('content')

<div class="w-full p-6 bg-gray-100 min-h-screen">
    <div class="w-full  bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-blue-300 p-4">
            <h2 class="text-xl font-bold text-blue-800">Buat Jam Operasional</h2>
        </div>

        <form method="POST" action="{{ route('jam-operasional.store') }}" class="p-6 needs-validation" novalidate>
            @csrf
            @include('components.form.input', ['name' => 'keterangan_hari', 'label' => 'Keterangan Hari', 'type' => 'text', 'placeholder' => 'Masukkan keterangan_hari', 'required' => true])
            @include('components.form.input', ['name' => 'jam_mulai', 'label' => 'Jam Mulai', 'type' => 'time', 'placeholder' => 'Masukkan jam_mulai', 'required' => true])
            @include('components.form.input', ['name' => 'jam_selesai', 'label' => 'Jam Selesai', 'type' => 'time', 'placeholder' => 'Masukkan jam_selesai Layanan', 'required' => true])
            <div class="flex items-center justify-between">
                <button type="submit" class="px-6 py-2 bg-blue-300 hover:bg-blue-400 text-blue-800 font-medium rounded-lg">Buat</button>

            </div>
        </form>
    </div>
</div>
@endsection
