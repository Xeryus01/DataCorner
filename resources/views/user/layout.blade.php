@extends('layout.app')

@section('hero')
    @include('components.user.hero')
@endsection

@section('content')

    {{-- CONTENT --}}
    <section class="py-10">
        <div class="max-w-7xl mx-auto px-4">
            {{-- Content will be replaced by child views --}}
        </div>
    </section>

@endsection